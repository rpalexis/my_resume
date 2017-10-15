<?php

/**
 * Wrapper function for __()
 *
 * It checks if specific text is translated via options panel
 * If option is set, it returns translated text from theme options
 * If option is not set, it returns default translation string (from language file)
 *
 * @param string  $string_key Key name (id) of translation option
 * @return string Returns translated string
 * @since  1.0
 */

if ( !function_exists( '__typology' ) ):
	function __typology( $string_key ) {
		if ( ( $translated_string = typology_get_option( 'tr_'.$string_key ) ) && typology_get_option( 'enable_translate' ) ) {

			if ( $translated_string == '-1' ) {
				return '';
			}

			return wp_kses_post( $translated_string );

		} else {
			$translate = typology_get_translate_options();
			return wp_kses_post( $translate[$string_key]['text'] );
		}
	}
endif;




/**
 * Get meta data
 *
 * Function outputs meta data HTML
 *
 * @param array   $meta_data
 * @return string HTML output of meta data
 * @since  1.0
 */

if ( !function_exists( 'typology_get_meta_data' ) ):
	function typology_get_meta_data( $meta_data = array() ) {

		$output = '';

		if ( empty( $meta_data ) ) {
			return $output;
		}


		foreach ( $meta_data as $mkey ) {


			$meta = '';

			switch ( $mkey ) {

			case 'date':
				$meta = '<span class="updated">'.get_the_date().'</span>';
				break;

			case 'author':
				$author_id = get_post_field( 'post_author', get_the_ID() );
				$meta = __typology( 'by' ) . ' <span class="vcard author"><span class="fn"><a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) ).'">'.get_the_author_meta( 'display_name', $author_id ).'</a></span></span>';
				break;

			case 'rtime':
				$meta = typology_read_time( get_post_field( 'post_content', get_the_ID() ) );
				if ( !empty( $meta ) ) {
					$meta .= ' '.__typology( 'min_read' );
				}
				break;

			case 'comments':
				if ( comments_open() || get_comments_number() ) {
					ob_start();
					comments_popup_link( __typology( 'no_comments' ), __typology( 'one_comment' ), __typology( 'multiple_comments' ) );
					$meta = ob_get_contents();
					ob_end_clean();
				} else {
					$meta = '';
				}
				break;

			case 'category':
				$cats = get_the_category_list( ', ' );
				if ( !empty( $cats ) ) {
					$meta = __typology( 'in' ) . ' ' . $cats;
				}
				break;

			default:
				break;
			}

			if ( !empty( $meta ) ) {
				$output .= '<div class="meta-item meta-'.$mkey.'">'.$meta.'</div>';
			}
		}


		return wp_kses_post( $output );

	}
endif;


/**
 * Get buttons data
 *
 * Function outputs buttons data HTML
 *
 * @param array   $meta_data
 * @return string HTML output of meta data
 * @since  1.0
 */

if ( !function_exists( 'typology_get_buttons_data' ) ):
	function typology_get_buttons_data( $meta_data = array()  ) {

		$output = '';

		if ( empty( $meta_data ) ) {
			return $output;
		}

		foreach ( $meta_data as $mkey ) {


			$meta = '';

			switch ( $mkey ) {

			
			case 'rm':
				$meta = '<a href="'.esc_url( get_permalink() ).'" class="typology-button">'.__typology('read_on').'</a>';
				break;

			case 'rl':
				$meta ='<a href="javascript:void(0);" class="typology-button button-invert typology-rl pocket" data-url="https://getpocket.com/edit?url='.urlencode(esc_url(get_permalink())).'"><i class="fa fa-bookmark-o"></i>'.__typology('read_later').'</a>';
				break;

			case 'comments':
				if ( comments_open() || get_comments_number() ) {
					ob_start();
					comments_popup_link( '<i class="fa fa-comment-o"></i>'.__typology( 'no_comments' ), '<i class="fa fa-comment-o"></i>'.__typology( 'one_comment' ), '<i class="fa fa-comments-o"></i>'.__typology( 'multiple_comments' ), 'typology-button button-invert' );
					$meta = ob_get_contents();
					ob_end_clean();
				} else {
					$meta = '';
				}
				break;

			default:
				break;
			}

			if ( !empty( $meta ) ) {
				$output .= $meta;
			}
		}


		return $output;

	}
endif;

/**
 * Get post excerpt
 *
 * Function outputs post excerpt for specific layout
 *
 * @param int     $limit Number of characters to limit excerpt
 * @return string HTML output of category links
 * @since  1.0
 */

if ( !function_exists( 'typology_get_excerpt' ) ):
	function typology_get_excerpt( $limit = 250 ) {

		$manual_excerpt = false;

		if ( has_excerpt() ) {
			$content =  get_the_excerpt();
			$manual_excerpt = true;
		} else {
			$text = get_the_content( '' );
			$text = strip_shortcodes( $text );
			$text = apply_filters( 'the_content', $text );
			$content = str_replace( ']]>', ']]&gt;', $text );
		}

		if ( !empty( $content ) ) {
			if ( !empty( $limit ) || !$manual_excerpt ) {
				$more = typology_get_option( 'more_string' );
				$content = wp_strip_all_tags( $content );
				$content = preg_replace( '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content );
				$content = typology_trim_chars( $content, $limit, $more );
			}
			return wp_kses_post( wpautop( $content ) );
		}

		return '';

	}
endif;

/**
 * Get first letter
 *
 * Function gets first letter of a string,
 * if string is not provided it gets first letter from current post title
 *
 * @param string  $string String from which to get letter
 * @return string First letter of a string
 * @since  1.0
 */

if ( !function_exists( 'typology_get_letter' ) ):
	function typology_get_letter( $string = '' ) {

		$string = empty( $string ) ? wp_strip_all_tags( get_the_title() ) : $string;

		if ( empty( $string ) ) {
			return '';
		}

		return typology_trim_chars( $string, 2, '');

	}
endif;



/**
 * Get archive heading
 *
 * Function gets title and description for current archive template
 *
 * @return array Args
 * @since  1.0
 */

if ( !function_exists( 'typology_get_archive_heading' ) ):
	function typology_get_archive_heading() {

		$defaults = array(
			'pre' => '',
			'title' => '',
			'desc' => '',
			'avatar' =>''
		);

		$args = array();

		if ( is_category() ) {

			$obj = get_queried_object();
			$args['pre'] = __typology( 'category' );
			$args['title'] = single_cat_title( '', false );
			$args['desc'] = category_description();

		} else if ( is_author() ) {

				$obj = get_queried_object();

				if ( empty( $obj ) ) {
					global $author;
					$obj = isset( $_GET['author_name'] ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );
				}

				$args['pre'] = __typology( 'author' );
				$args['title'] = $obj->display_name;
				$args['avatar'] = typology_get_option('use_author_image') ? get_avatar( $obj->ID, 100) : '';


			} else if ( is_tax() ) {

				$args['title'] = single_term_title( '', false );

			} else if ( is_home() && ( $posts_page = get_option( 'page_for_posts' ) ) && !is_page_template( 'template-home.php' ) ) {

				$args['title'] = get_the_title( $posts_page );

			} else if ( is_search() ) {

				$args['pre'] = __typology( 'search_results_for' );
				$args['title'] = get_search_query();

			} else if ( is_tag() ) {

				$args['pre'] = __typology( 'tag' );
				$args['title'] = single_tag_title( '', false );
				$args['desc'] = tag_description();

			} else if ( is_day() ) {

				$args['pre'] = __typology( 'archive' );
				$args['title'] = get_the_date();

			} else if ( is_month() ) {
				$args['pre'] = __typology( 'archive' );
				$args['title'] = get_the_date( 'F Y' );
			} else if ( is_year() ) {
				$args['pre'] = __typology( 'archive' );
				$args['title'] = get_the_date( 'Y' );
			} else if ( is_home() ) {
				$args['title'] = __typology( 'latest_stories' );
			}

		return wp_parse_args( $args, $defaults );
	}
endif;


/**
 * Get social share
 *
 * Checks social share options to generate sharing buttons
 *
 * @return array List of HTML sharing links
 * @since  1.0
 */

if ( !function_exists( 'typology_get_social_share' ) ):
	function typology_get_social_share() {

		$share_options = array_keys( array_filter( typology_get_option( 'social_share' ) ) );

		if ( empty( $share_options ) ) {
			return false;
		}

		$share = array();
		$share['facebook'] = '<a href="javascript:void(0);" class="typology-facebook typology-share-item hover-on" data-url="http://www.facebook.com/sharer/sharer.php?u='.urlencode( esc_url( get_permalink() ) ).'&amp;t='.urlencode( esc_attr( get_the_title() ) ).'"><i class="fa fa-facebook"></i></a>';
		$share['twitter'] = '<a href="javascript:void(0);" class="typology-twitter typology-share-item hover-on" data-url="http://twitter.com/intent/tweet?url='.urlencode( esc_url( get_permalink() ) ).'&amp;text='.urlencode( esc_attr( get_the_title() ) ).'"><i class="fa fa-twitter"></i></a>';
		$share['gplus'] = '<a href="javascript:void(0);"  class="typology-gplus typology-share-item hover-on" data-url="https://plus.google.com/share?url='.urlencode( esc_url( get_permalink() ) ).'"><i class="fa fa-google-plus"></i></a>';
		$pin_img = has_post_thumbnail() ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) : '';
		$pin_img = isset( $pin_img[0] ) ? $pin_img[0] : '';
		$share['pinterest'] = '<a href="javascript:void(0);"  class="typology-pinterest typology-share-item hover-on" data-url="http://pinterest.com/pin/create/button/?url='.urlencode( esc_url( get_permalink() ) ).'&amp;media='.urlencode( esc_attr( $pin_img ) ).'&amp;description='.urlencode( esc_attr( get_the_title() ) ).'"><i class="fa fa-pinterest-p"></i></a>';
		$share['linkedin'] = '<a href="javascript:void(0);"  class="typology-linkedin typology-share-item hover-on" data-url="http://www.linkedin.com/shareArticle?mini=true&amp;url='.esc_url( get_permalink() ).'&amp;title='.esc_attr( get_the_title() ).'"><i class="fa fa-linkedin"></i></a>';
		$share['reddit'] = '<a href="javascript:void(0);"  class="typology-reddit typology-share-item hover-on" data-url="http://www.reddit.com/submit?url='.urlencode( esc_url( get_permalink() ) ).'&amp;title='.urlencode( esc_attr( get_the_title() ) ).'"><i class="fa fa-reddit-alien"></i></a>';
		$share['email'] = '<a href="mailto:?subject='.urlencode( esc_attr( get_the_title() ) ).'&amp;body='.urlencode( esc_url( get_permalink() ) ).'" class="typology-mailto hover-on"><i class="fa fa-envelope-o"></i></a>';
		$share['stumbleupon'] = '<a href="javascript:void(0);"  class="typology-stumbleupon typology-share-item hover-on" data-url="http://www.stumbleupon.com/badge?url='.urlencode( esc_url( get_permalink() ) ).'&amp;title='.urlencode( esc_attr( get_the_title() ) ).'"><i class="fa fa-stumbleupon"></i></a>';

		$output = array();
		foreach ( $share_options as $social ) {
			$output[] = $share[$social];
		}

		$output = apply_filters( 'typology_modify_social_share', $output );

		return $output;


	}
endif;


/**
 * Get author social links
 *
 * @param int     $author_id ID of an author/user
 * @return string HTML output of social links
 * @since  1.0
 */

if ( !function_exists( 'typology_get_author_links' ) ):
	function typology_get_author_links( $author_id ) {

		$output = '';

		if ( is_singular() ) {

			$output .= '<a class="typology-button-social hover-on" href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) ).'">'.__typology( 'view_all' ).'</a>';
		}


		if ( $url = get_the_author_meta( 'url', $author_id ) ) {
			$output .= '<a href="'.esc_url( $url ).'" target="_blank" class="typology-icon-social hover-on fa fa-link"></a>';
		}

		$social = typology_get_social();

		if ( !empty( $social ) ) {
			foreach ( $social as $id => $name ) {
				if ( $social_url = get_the_author_meta( $id,  $author_id ) ) {

					if ( $id == 'twitter' ) {
						$pos = strpos( $social_url, '@' );
						$social_url = 'https://twitter.com/'.substr( $social_url, $pos, strlen( $social_url ) );
					}

					$output .=  '<a href="'.esc_url( $social_url ).'" target="_blank" class="typology-icon-social hover-on fa fa-'.esc_attr( $id ).'"></a>';
				}
			}
		}

		return wp_kses_post( $output );
	}
endif;


/**
 * Header display element
 *
 * Checks is specific header element should be displayed based on theme options
 *
 * @param string  $element ID of an element to check
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'typology_header_display' ) ):
	function typology_header_display( $element ) {

		$elements = typology_get_option( 'header_elements' );

		if ( isset( $elements[$element] ) &&  $elements[$element] ) {
			return true;
		}

		return false;

	}
endif;

/**
 * Meta display
 *
 * Checks what meta elements to display based on specific Layout
 *
 * @param string  $Layout ID
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'typology_meta_display' ) ):
	function typology_meta_display( $layout ) {

		$meta =  array_keys( array_filter( typology_get_option( 'layout_'.$layout.'_meta' ) ) );
		return $meta;

	}
endif;

/**
 * Action buttons display
 *
 * Checks what action button elements to display based on specific Layout
 *
 * @param string  $Layout ID
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'typology_buttons_display' ) ):
	function typology_buttons_display( $layout ) {

		$meta =  array_keys( array_filter( typology_get_option( 'layout_'.$layout.'_buttons' ) ) );
		return $meta;

	}
endif;


/**
 * Get branding
 *
 * Returns HTML of logo or website title based on theme options
 *
 * @param string  $element ID of an element to check
 * @return string HTML
 * @since  1.0
 */

if ( !function_exists( 'typology_get_branding' ) ):
	function typology_get_branding() {

		global $typology_h1_used;

		$logo = typology_get_option( 'logo' );
		$brand = !empty( $logo ) ? '<img class="typology-logo" src="'.esc_url( $logo ).'" alt="'.esc_attr( get_bloginfo( 'name' ) ).'" >' : get_bloginfo( 'name' );
		$element = is_front_page() && empty( $typology_h1_used ) ? 'h1' : 'span';
		$url = typology_get_option('logo_custom_url') ? typology_get_option('logo_custom_url') : home_url( '/' );

		$output = '<'.$element.' class="site-title h4"><a href="'. esc_url( $url ) .'" rel="home">'.wp_kses_post( $brand ).'</a></'.esc_attr( $element ).'>';

		$typology_h1_used = true;

		return $output;

	}
endif;

/**
 * Display section head
 *
 * Outputs section heading HTML based on passed arguments
 *
 * @param array   $args
 * @return string HTML
 * @since  1.0
 */

if ( !function_exists( 'typology_section_heading' ) ):
	function typology_section_heading( $args ) {

		$defaults = array(
			'title' => '',
			'pre' => '',
			'element' => 'h3',
			'avatar' => ''
		);

		$args = typology_parse_args( $args, $defaults );
				
		$output = '';

		if ( !empty( $args['title'] ) ) {

			$output .= '<div class="section-head">';
			$output .=  !empty($args['avatar']) ? '<div class="section-avatar">'. $args['avatar'] .'</div>' : '' ;
			$output .= '<'.esc_attr( $args['element'] ).' class="section-title h6">';
			$output .= !empty( $args['pre'] ) ? '<span class="typology-archive-title">'.esc_html( $args['pre'] ).'</span>' : '';
			$output .= esc_html( $args['title'] ).'</'.esc_attr( $args['element'] ).'>';
			$output .= '</div>';

		}


		echo wp_kses_post( $output );

	}
endif;


/**
 * Check if image or video is selected to be displayed in cover
 *
 * @return array
 * @since  1.2
 */

if ( !function_exists( 'typology_cover_media' ) ):
	function typology_cover_media($object = '') {
		
		$media = array();

		if( typology_get_option('cover_bg_media') == 'image' && typology_get_option('cover_bg_img') ){
			$media = array( 'src' => typology_get_option('cover_bg_img'), 'type' => 'image' );
		} else if(typology_get_option('cover_bg_media') == 'video' && typology_get_option('cover_bg_video') ){
			$media = array( 'src' => typology_get_option('cover_bg_video'), 'type' => 'video' );
		}

		if ( is_single() && typology_get_option('single_fimg') == 'cover' && has_post_thumbnail() ) {
			$media = array( 'src' =>  get_the_post_thumbnail_url( get_the_ID(), 'typology-cover'), 'type' => 'image' );
		}

		if ( !is_front_page() && is_page() && typology_get_option('page_fimg') == 'cover' && has_post_thumbnail() ) {
			$media = array( 'src' =>  get_the_post_thumbnail_url( get_the_ID(), 'typology-cover'), 'type' => 'image' );  
		}
		
		return $media;
	}
endif;

/**
 * Output image or video
 *
 * @return string HTML
 * @since  1.2
 */

if ( !function_exists( 'typology_display_media' ) ):
	function typology_display_media( $args = array() ) {
		
		$defaults = array( 'type' => 'image', 'src' => '');
		$args = wp_parse_args( $args, $defaults); 

		$output = '';
		if ($args['type'] == 'image') {
			$output = '<img src="' . esc_url( $args['src'] ) .'"/>';
		} else if ($args['type'] == 'video'){
			$output = '<video autoplay loop>
						<source src="'. esc_url( $args['src'] ) .'">
						Your browser does not support the video tag.
					</video>';
		}
		echo  $output ;
	}
endif;

?>