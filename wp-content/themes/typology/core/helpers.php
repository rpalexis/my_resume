<?php



/**
 * Debug (log) function
 *
 * Outputs any content into log file in theme root directory
 *
 * @param mixed   $mixed Content to output
 * @since  1.0
 */

if ( !function_exists( 'typology_log' ) ):
	function typology_log( $mixed ) {

		WP_Filesystem();

		global $wp_filesystem;

		if ( is_array( $mixed ) ) {
			$mixed = print_r( $mixed, 1 );
		} else if ( is_object( $mixed ) ) {
				ob_start();
				var_dump( $mixed );
				$mixed = ob_get_clean();
			}

		$old = $wp_filesystem->get_contents( get_template_directory() . '/log' );
		$wp_filesystem->put_contents( get_template_directory() . '/log', $old.$mixed . PHP_EOL, FS_CHMOD_FILE );
	}
endif;



/**
 * Get option value from theme options
 *
 * A wrapper function for WordPress native get_option()
 * which gets an option from specific option key (set in theme options panel)
 *
 * @param string  $option Name of the option
 * @return mixed Specific option value or "false" (if option is not found)
 * @since  1.0
 */

if ( !function_exists( 'typology_get_option' ) ):
	function typology_get_option( $option ) {

		global $typology_settings;

		if ( empty( $typology_settings ) ) {
			$typology_settings = get_option( 'typology_settings' );
		}

		if ( isset( $typology_settings[$option] ) ) {
			return is_array( $typology_settings[$option] ) && isset( $typology_settings[$option]['url'] ) ? $typology_settings[$option]['url'] : $typology_settings[$option];
		} else {
			return false;
		}

	}
endif;



/**
 * Check if RTL mode is enabled
 *
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'typology_is_rtl' ) ):
	function typology_is_rtl() {

		if ( typology_get_option( 'rtl_mode' ) ) {
			$rtl = true;
			//Check if current language is excluded from RTL
			$rtl_lang_skip = explode( ",", typology_get_option( 'rtl_lang_skip' ) );
			if ( !empty( $rtl_lang_skip )  ) {
				$locale = get_locale();
				if ( in_array( $locale, $rtl_lang_skip ) ) {
					$rtl = false;
				}
			}
		} else {
			$rtl = false;
		}

		return $rtl;
	}
endif;


/**
 * Generate dynamic css
 *
 * Function parses theme options and generates css code dynamically
 *
 * @return string Generated css code
 * @since  1.0
 */

if ( !function_exists( 'typology_generate_dynamic_css' ) ):
	function typology_generate_dynamic_css() {
		ob_start();
		get_template_part( 'assets/css/dynamic-css' );
		$output = ob_get_contents();
		ob_end_clean();
		return typology_compress_css_code( $output );
	}
endif;



/**
 * Get JS settings
 *
 * Function creates list of settings from thme options to pass
 * them to global JS variable so we can use it in JS files
 *
 * @return array List of JS settings
 * @since  1.0
 */

if ( !function_exists( 'typology_get_js_settings' ) ):
	function typology_get_js_settings() {
		$js_settings = array();

		$js_settings['rtl_mode'] = typology_is_rtl() ? true : false;
		$js_settings['header_sticky'] = typology_get_option( 'header_sticky' ) ? true : false;
		$js_settings['logo'] = typology_get_option( 'logo' );
		$js_settings['logo_retina'] = typology_get_option( 'logo_retina' );
		$js_settings['use_gallery'] = typology_get_option( 'use_gallery' ) ? true : false;
		

		return $js_settings;
	}
endif;


/**
 * Get all translation options
 *
 * @return array Returns list of all translation strings available in theme options panel
 * @since  1.0
 */

if ( !function_exists( 'typology_get_translate_options' ) ):
	function typology_get_translate_options() {
		global $typology_translate;
		get_template_part( 'core/translate' );
		$translate = apply_filters( 'typology_modify_translate_options', $typology_translate );
		return $translate;
	}
endif;


/**
 * Generate fonts link
 *
 * Function creates font link from fonts selected in theme options
 *
 * @return string
 * @since  1.0
 */

if ( !function_exists( 'typology_generate_fonts_link' ) ):
	function typology_generate_fonts_link() {

		$fonts = array();
		$fonts[] = typology_get_option( 'main_font' );
		$fonts[] = typology_get_option( 'h_font' );
		$fonts[] = typology_get_option( 'nav_font' );
		$unique = array(); //do not add same font links
		$native = typology_get_native_fonts();
		$protocol = is_ssl() ? 'https://' : 'http://';
		$link = array();

		foreach ( $fonts as $font ) {
			if ( !in_array( $font['font-family'], $native ) ) {
				$temp = array();
				if ( isset( $font['font-style'] ) ) {
					$temp['font-style'] = $font['font-style'];
				}
				if ( isset( $font['subsets'] ) ) {
					$temp['subsets'] = $font['subsets'];
				}
				if ( isset( $font['font-weight'] ) ) {
					$temp['font-weight'] = $font['font-weight'];
				}
				$unique[$font['font-family']][] = $temp;
			}
		}

		$subsets = array( 'latin' ); //latin as default

		foreach ( $unique as $family => $items ) {

			$link[$family] = $family;

			$weight = array( '400' );

			foreach ( $items as $item ) {

				//Check weight and style
				if ( isset( $item['font-weight'] ) && !empty( $item['font-weight'] ) ) {
					$temp = $item['font-weight'];
					if ( isset( $item['font-style'] ) && empty( $item['font-style'] ) ) {
						$temp .= $item['font-style'];
					}

					if ( !in_array( $temp, $weight ) ) {
						$weight[] = $temp;
					}
				}

				//Check subsets
				if ( isset( $item['subsets'] ) && !empty( $item['subsets'] ) ) {
					if ( !in_array( $item['subsets'], $subsets ) ) {
						$subsets[] = $item['subsets'];
					}
				}
			}

			$link[$family] .= ':'.implode( ",", $weight );
			//$link[$family] .= '&subset='.implode( ",", $subsets );
		}

		if ( !empty( $link ) ) {

			$query_args = array(
				'family' => urlencode( implode( '|', $link ) ),
				'subset' => urlencode( implode( ',', $subsets ) )
			);


			$fonts_url = add_query_arg( $query_args, $protocol.'fonts.googleapis.com/css' );

			return esc_url_raw( $fonts_url );
		}

		return '';

	}
endif;


/**
 * Get native fonts
 *
 *
 * @return array List of native fonts
 * @since  1.0
 */

if ( !function_exists( 'typology_get_native_fonts' ) ):
	function typology_get_native_fonts() {

		$fonts = array(
			"Arial, Helvetica, sans-serif",
			"'Arial Black', Gadget, sans-serif",
			"'Bookman Old Style', serif",
			"'Comic Sans MS', cursive",
			"Courier, monospace",
			"Garamond, serif",
			"Georgia, serif",
			"Impact, Charcoal, sans-serif",
			"'Lucida Console', Monaco, monospace",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"'MS Serif', 'New York', sans-serif",
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"Tahoma,Geneva, sans-serif",
			"'Times New Roman', Times,serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif"
		);

		return $fonts;
	}
endif;


/**
 * Get font option
 *
 * @return string Font-family
 * @since  1.0
 */

if ( !function_exists( 'typology_get_font_option' ) ):
	function typology_get_font_option( $option = false ) {

		$font = typology_get_option( $option );
		$native_fonts = typology_get_native_fonts();
		if ( !in_array( $font['font-family'], $native_fonts ) ) {
			$font['font-family'] = "'".$font['font-family']."'";
		}

		return $font;
	}
endif;


/**
 * Get background
 *
 * @return string background CSS
 * @since  1.0
 */

if ( !function_exists( 'typology_get_bg_option' ) ):
	function typology_get_bg_option( $option = false ) {

		$style = typology_get_option( $option );
		$css = '';

		if ( ! empty( $style ) && is_array( $style ) ) {
			foreach ( $style as $key => $value ) {
				if ( ! empty( $value ) && $key != "media" ) {
					if ( $key == "background-image" ) {
						$css .= $key . ":url('" . $value . "');";
					} else {
						$css .= $key . ":" . $value . ";";
					}
				}
			}
		}

		return $css;
	}
endif;


/**
 * Get list of image sizes
 *
 * @return array
 * @since  1.0
 */

if ( !function_exists( 'typology_get_image_sizes' ) ):
	function typology_get_image_sizes() {

		$sizes = array(
			'typology-cover' => array( 'title' => esc_html__('Cover', 'typology'), 'w' => 1920, 'h' => 9999, 'crop' => false ),
			'typology-a' => array( 'title' => esc_html__('Layout A', 'typology'), 'w' => 720, 'h' => 9999, 'crop' => false ),
			'typology-b' => array( 'title' => esc_html__( 'Layout B', 'typology' ), 'w' => 580, 'h' => 9999, 'crop' => false ),
			'typology-c' => array( 'title' => esc_html__( 'Layout C', 'typology' ), 'w' => 320, 'h' => 9999, 'crop' => false ),
		);

		$disable_img_sizes = typology_get_option( 'disable_img_sizes' ); 

		if(!empty( $disable_img_sizes )){
			$disable_img_sizes = array_keys( array_filter( $disable_img_sizes ) );
		}

		if(!empty($disable_img_sizes) ){
			foreach($disable_img_sizes as $size_id ){
				unset( $sizes['typology-'.$size_id]);
			}
		}

		$sizes = apply_filters( 'typology_modify_image_sizes', $sizes );

		return $sizes;
	}
endif;

 
/**
 * Get query for front page posts
 *
 * @param int     $post_id
 * @return object WP_Query
 * @since  1.0
 */

if ( !function_exists( 'typology_get_front_page_posts' ) ):
	function typology_get_front_page_posts( ) {

		global $typology_unique_front_page_posts, $paged;

		$args['ignore_sticky_posts'] = 1;

		if ( typology_get_option('front_page_posts') == 'manual' ) {

			$ids = array_map('absint', explode( ',', typology_get_option( 'front_page_posts_manual' ) ) );
			$args['posts_per_page'] = absint( count( $ids ) );
			$args['orderby'] =  'post__in';
			$args['post__in'] =  $ids;
			$args['post_type'] = array_keys( get_post_types( array( 'public' => true ) ) );

		} else {

			$args['post_type'] = 'post';
			$args['orderby'] = typology_get_option('front_page_posts');
			$args['posts_per_page'] = typology_get_option( 'front_page_posts_ppp' ) == 'custom' ? absint( typology_get_option( 'front_page_posts_num' ) ) : get_option( 'posts_per_page' );

			$cat = typology_get_option( 'front_page_posts_cat' );
			if ( !empty( $cat ) ) {
				$args['category__in'] = $cat;
			}

			$tag = typology_get_option( 'front_page_posts_tag' );
			if ( !empty( $tag ) ) {
				$args['tag__in'] = $tag;
			}

			$paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged') ;
			$args['paged'] = $paged;
			
			if( !empty( $typology_unique_front_page_posts ) ){
				$args['post__not_in'] = $typology_unique_front_page_posts;
			}
		}

		
		//print_r( $args );
		

		$query = new WP_Query( $args );

		
		return $query;
	}
endif;



/**
 * Get query for front page cover posts
 *
 * @param int     $post_id
 * @return object WP_Query
 * @since  1.0
 */

if ( !function_exists( 'typology_get_front_page_cover_posts' ) ):
	function typology_get_front_page_cover_posts( ) {

		global $typology_unique_front_page_posts, $paged;

		$args['ignore_sticky_posts'] = 1;

		if ( typology_get_option('front_page_cover_posts') == 'manual' ) {

			$ids = array_map('absint', explode( ',', typology_get_option( 'front_page_cover_posts_manual' ) ) );
			$args['posts_per_page'] = absint( count( $ids ) );
			$args['orderby'] =  'post__in';
			$args['post__in'] =  $ids;
			$args['post_type'] = array_keys( get_post_types( array( 'public' => true ) ) );

		} else {

			$args['post_type'] = 'post';
			$args['orderby'] = typology_get_option('front_page_cover_posts');
			$args['posts_per_page'] =  absint( typology_get_option( 'front_page_cover_posts_num' ) );

			$cat = typology_get_option( 'front_page_cover_posts_cat' );
			if ( !empty( $cat ) ) {
				$args['category__in'] = $cat;
			}

			$tag = typology_get_option( 'front_page_cover_posts_tag' );
			if ( !empty( $tag ) ) {
				$args['tag__in'] = $tag;
			}

			
		}

		
		//print_r( $args );

		$query = new WP_Query( $args );

		if ( typology_get_option('front_page_cover_posts_unique')  && !is_wp_error( $query ) && !empty( $query ) ) {
			$typology_unique_front_page_posts = wp_list_pluck( $query->posts, 'ID' );
		}

		return $query;
	}
endif;

/**
 * Get front page cover class
 * 
 * @return string 
 * @since  1.0
 */

if ( !function_exists( 'typology_get_front_page_cover_class' ) ):
	function typology_get_front_page_cover_class( ) {

		$cover = typology_get_option( 'front_page_cover' );

		$class = array();

		$class[] = empty($cover) ? 'typology-cover-empty' : '';
		$class[] = $cover == 'posts' && typology_get_option( 'front_page_cover_posts_num' ) > 1 ? 'typology-cover-slider owl-carousel' : '';

		return implode(' ', $class );
	}
endif;

/**
 * Get related posts for particular post
 *
 * @param int     $post_id
 * @return object WP_Query
 * @since  1.0
 */

if ( !function_exists( 'typology_get_related_posts' ) ):
	function typology_get_related_posts( $post_id = false ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$args['post_type'] = 'post';

		//Exclude current post from query
		$args['post__not_in'] = array( $post_id );

		//If previuos next posts active exclude them too
		if ( typology_get_option( 'single_prevnext' ) ) {

			$prev_next = typology_get_prev_next_posts();

			if ( !empty( $prev_next['prev'] ) ) {
				$args['post__not_in'][] = $prev_next['prev']->ID;
			}

			if ( !empty( $prev_next['next'] ) ) {
				$args['post__not_in'][] = $prev_next['next']->ID;
			}
		}

		$num_posts = absint( typology_get_option( 'related_limit' ) );

		if ( $num_posts > 100 ) {
			$num_posts = 100;
		}

		$args['posts_per_page'] = $num_posts;


		$args['orderby'] = typology_get_option( 'related_order' );

		if ( $type = typology_get_option( 'related_type' ) ) {

			switch ( $type ) {

			case 'cat':
				$cats = get_the_category( $post_id );
				$cat_args = array();
				if ( !empty( $cats ) ) {
					foreach ( $cats as $k => $cat ) {
						$cat_args[] = $cat->term_id;
					}
				}
				$args['category__in'] = $cat_args;
				break;

			case 'tag':
				$tags = get_the_tags( $post_id );
				$tag_args = array();
				if ( !empty( $tags ) ) {
					foreach ( $tags as $tag ) {
						$tag_args[] = $tag->term_id;
					}
				}
				$args['tag__in'] = $tag_args;
				break;

			case 'cat_and_tag':
				$cats = get_the_category( $post_id );
				$cat_args = array();
				if ( !empty( $cats ) ) {
					foreach ( $cats as $k => $cat ) {
						$cat_args[] = $cat->term_id;
					}
				}
				$tags = get_the_tags( $post_id );
				$tag_args = array();
				if ( !empty( $tags ) ) {
					foreach ( $tags as $tag ) {
						$tag_args[] = $tag->term_id;
					}
				}
				$args['tax_query'] = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'category',
						'field'    => 'id',
						'terms'    => $cat_args,
					),
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'id',
						'terms'    => $tag_args,
					)
				);
				break;

			case 'cat_or_tag':
				$cats = get_the_category( $post_id );
				$cat_args = array();
				if ( !empty( $cats ) ) {
					foreach ( $cats as $k => $cat ) {
						$cat_args[] = $cat->term_id;
					}
				}
				$tags = get_the_tags( $post_id );
				$tag_args = array();
				if ( !empty( $tags ) ) {
					foreach ( $tags as $tag ) {
						$tag_args[] = $tag->term_id;
					}
				}
				$args['tax_query'] = array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field'    => 'id',
						'terms'    => $cat_args,
					),
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'id',
						'terms'    => $tag_args,
					)
				);
				break;

			case 'author':
				global $post;
				$author_id = isset( $post->post_author ) ? $post->post_author : 0;
				$args['author'] = $author_id;
				break;

			case 'default':
				break;
			}
		}


		$query = new WP_Query( $args );

		return $query;
	}
endif;



/**
 * Get previous/next posts
 *
 * @return array Previous and next post ids
 * @since  1.0
 */

if ( !function_exists( 'typology_get_prev_next_posts' ) ):
	function typology_get_prev_next_posts() {

		$prev = get_adjacent_post( true, '', false, 'category' );
		$next = get_adjacent_post( true, '', true, 'category' );

		return array( 'prev' => $prev, 'next' => $next );

	}
endif;


/**
 * Get list of social options
 *
 * Used for user social profiles
 *
 * @return array
 * @since  1.0
 */

if ( !function_exists( 'typology_get_social' ) ) :
	function typology_get_social() {
		$social = array(
			'behance' => 'Behance',
			'delicious' => 'Delicious',
			'deviantart' => 'DeviantArt',
			'digg' => 'Digg',
			'dribbble' => 'Dribbble',
			'facebook' => 'Facebook',
			'flickr' => 'Flickr',
			'github' => 'Github',
			'google' => 'GooglePlus',
			'instagram' => 'Instagram',
			'linkedin' => 'LinkedIN',
			'pinterest' => 'Pinterest',
			'reddit' => 'ReddIT',
			'rss' => 'Rss',
			'skype' => 'Skype',
			'snapchat' => 'Snapchat',
			'slack' => 'Slack',
			'stumbleupon' => 'StumbleUpon',
			'soundcloud' => 'SoundCloud',
			'spotify' => 'Spotify',
			'tumblr' => 'Tumblr',
			'twitter' => 'Twitter',
			'vimeo-square' => 'Vimeo',
			'vk' => 'vKontakte',
			'vine' => 'Vine',
			'weibo' => 'Weibo',
			'wordpress' => 'WordPress',
			'xing' => 'Xing' ,
			'yahoo' => 'Yahoo',
			'youtube' => 'Youtube'
		);

		return $social;
	}
endif;

/**
 * Get image ID from URL
 *
 * It gets image/attachment ID based on URL
 *
 * @param string  $image_url URL of image/attachment
 * @return int|bool Attachment ID or "false" if not found
 * @since  1.0
 */

if ( !function_exists( 'typology_get_image_id_by_url' ) ):
	function typology_get_image_id_by_url( $image_url ) {
		global $wpdb;

		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

		if ( isset( $attachment[0] ) ) {
			return $attachment[0];
		}

		return false;
	}
endif;

/**
 * Calculate reading time by content length
 *
 * @param string  $text Content to calculate
 * @return int Number of minutes
 * @since  1.0
 */

if ( !function_exists( 'typology_read_time' ) ):
	function typology_read_time( $text ) {

		$words = count( preg_split( "/[\n\r\t ]+/", wp_strip_all_tags( $text ) ) );

		if ( !empty( $words ) ) {
			$time_in_minutes = ceil( $words / 200 );
			return $time_in_minutes;
		}

		return false;
	}
endif;


/**
 * Trim chars of a string
 *
 * @param string  $string Content to trim
 * @param int     $limit  Number of characters to limit
 * @param string  $more   Chars to append after trimed string
 * @return string Trimmed part of the string
 * @since  1.0
 */

if ( !function_exists( 'typology_trim_chars' ) ):
	function typology_trim_chars( $string, $limit, $more = '...' ) {

		if ( !empty( $limit ) ) {

			$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $string ), ' ' );
			preg_match_all( '/./u', $text, $chars );
			$chars = $chars[0];
			$count = count( $chars );

			if ( $count > $limit ) {

				$chars = array_slice( $chars, 0, $limit );

				for ( $i = ( $limit -1 ); $i >= 0; $i-- ) {
					if ( in_array( $chars[$i], array( '.', ' ', '-', '?', '!' ) ) ) {
						break;
					}
				}

				$chars =  array_slice( $chars, 0, $i );
				$string = implode( '', $chars );
				$string = rtrim( $string, ".,-?!" );
				$string.= $more;
			}

		}

		return $string;
	}
endif;


/**
 * Parse args ( merge arrays )
 *
 * Similar to wp_parse_args() but extended to also merge multidimensional arrays
 *
 * @param array   $a - set of values to merge
 * @param array   $b - set of default values
 * @return array Merged set of elements
 * @since  1.0
 */

if ( !function_exists( 'typology_parse_args' ) ):
	function typology_parse_args( &$a, $b ) {
		$a = (array) $a;
		$b = (array) $b;
		$r = $b;
		foreach ( $a as $k => &$v ) {
			if ( is_array( $v ) && isset( $r[ $k ] ) ) {
				$r[ $k ] = typology_parse_args( $v, $r[ $k ] );
			} else {
				$r[ $k ] = $v;
			}
		}
		return $r;
	}
endif;


/**
 * Compare two values
 *
 * Fucntion compares two values and sanitazes 0
 *
 * @param mixed   $a
 * @param mixed   $b
 * @return bool Returns true if equal
 * @since  1.0
 */

if ( !function_exists( 'typology_compare' ) ):
	function typology_compare( $a, $b ) {
		return (string) $a === (string) $b;
	}
endif;



/**
 * Hex 2 rgba
 *
 * Convert hexadecimal color to rgba
 *
 * @param string  $color   Hexadecimal color value
 * @param float   $opacity Opacity value
 * @return string RGBA color value
 * @since  1.0
 */

if ( !function_exists( 'typology_hex2rgba' ) ):
	function typology_hex2rgba( $color, $opacity = false ) {
		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if ( empty( $color ) )
			return $default;

		//Sanitize $color if "#" is provided
		if ( $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		//Check if color has 6 or 3 characters and get values
		if ( strlen( $color ) == 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		//Convert hexadec to rgb
		$rgb =  array_map( 'hexdec', $hex );

		//Check if opacity is set(rgba or rgb)
		if ( $opacity ) {
			if ( abs( $opacity ) > 1 ) { $opacity = 1.0; }
			$output = 'rgba('.implode( ",", $rgb ).','.$opacity.')';
		} else {
			$output = 'rgb('.implode( ",", $rgb ).')';
		}

		//Return rgb(a) color string
		return $output;
	}
endif;


/**
 * Compress CSS Code
 *
 * @param string  $code Uncompressed css code
 * @return string Compressed css code
 * @since  1.0
 */

if ( !function_exists( 'typology_compress_css_code' ) ) :
	function typology_compress_css_code( $code ) {

		// Remove Comments
		$code = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $code );

		// Remove tabs, spaces, newlines, etc.
		$code = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $code );

		return $code;
	}
endif;



/**
 * Sort option items
 *
 * Use this function to properly order sortable options
 *
 * @param unknown $items    Array of items
 * @param unknown $selected Array of IDs of currently selected items
 * @return array ordered items
 * @since  1.0
 */

if ( !function_exists( 'typology_sort_option_items' ) ):
	function typology_sort_option_items( $items, $selected, $field = 'term_id' ) {

		if ( empty( $selected ) ) {
			return $items;
		}

		$new_items = array();
		$temp_items = array();
		$temp_items_ids = array();

		foreach ( $selected as $selected_item_id ) {

			foreach ( $items as $item ) {
				if ( $selected_item_id == $item->$field ) {
					$new_items[] = $item;
				} else {
					if ( !in_array( $item->$field, $selected ) && !in_array( $item->$field, $temp_items_ids ) ) {
						$temp_items[] = $item;
						$temp_items_ids[] = $item->$field;
					}
				}
			}

		}

		$new_items = array_merge( $new_items, $temp_items );

		return $new_items;
	}
endif;

/**
 * Get term IDs by term names for specific taxonomy
 *
 * @param array   $names List of term names
 * @param string  $tax   Taxonomy name
 * @return array List of term IDs
 * @since  1.0
 */

if ( !function_exists( 'typology_get_tax_term_id_by_name' ) ):
	function typology_get_tax_term_id_by_name( $names, $tax = 'post_tag' ) {

		if ( empty( $names ) ) {
			return '';
		}

		if(!is_array($names)){
			$names = explode(",", $names );
		}

		$ids = array();

		foreach ( $names as $name ) {
			$tag = get_term_by( 'name', trim( $name ), $tax);
			if ( !empty( $tag ) && isset( $tag->term_id ) ) {
				$ids[] = $tag->term_id;
			}
		}
		
		return $ids;

	}
endif;

/**
 * Get term names by term id for specific taxonomy
 *
 * @param array   $names List of term ids
 * @param string  $tax   Taxonomy name
 * @return array List of term names
 * @since  1.0
 */

if ( !function_exists( 'typology_get_tax_term_name_by_id' ) ):
	function typology_get_tax_term_name_by_id( $ids, $tax = 'post_tag' ) {

		if ( empty( $ids ) ) {
			return '';
		}

		$names = array();

		foreach ( $ids as $id ) {
			$tag = get_term_by( 'id', trim( $id ), $tax);
			if ( !empty( $tag ) && isset( $tag->name ) ) {
				$names[] = $tag->name;
			}
		}

		$names = implode(',', $names);

		return $names;

	}
endif;

/**
 * Check if WooCommerce is active
 *
 * @return bool
 * @since  1.2
 */

if ( !function_exists( 'typology_is_woocommerce_active' ) ):
	function typology_is_woocommerce_active() {

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check if we are on WooCommerce page
 *
 * @return bool
 * @since  1.2
 */

if ( !function_exists( 'typology_is_woocommerce_page' ) ):
	function typology_is_woocommerce_page() {

		return is_singular( 'product' ) || is_tax( 'product_cat' ) || is_post_type_archive( 'product' );
	}
endif;


/**
 * Check which sidebar to display
 *
 * @return string
 * @since  1.2
 */

if ( !function_exists( 'typology_sidebar' ) ):
	function typology_sidebar() {

		$sidebar = 'typology_default_sidebar';
		
		if ( typology_is_woocommerce_active() && is_active_sidebar('typology_woocommerce_sidebar') && ( typology_is_woocommerce_page() || is_cart() || is_checkout() ) ){
			$sidebar = 'typology_woocommerce_sidebar';
		}

		return $sidebar;
	}
endif;
?>