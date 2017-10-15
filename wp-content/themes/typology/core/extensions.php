<?php

/**
 * body_class callback
 *
 * Checks for specific options and applies additional class to body element
 *
 * @since  1.0
 */

add_filter( 'body_class', 'typology_body_class' );

if ( !function_exists( 'typology_body_class' ) ):
	function typology_body_class( $classes ) {	

		if( typology_get_option( 'style') == 'flat') {
			$classes[] = 'typology-flat';
		}

		if( typology_get_option( 'header_orientation') == 'wide') {
			$classes[] = 'typology-header-wide';
		}

		return $classes;
	}
endif;



/**
 * wp_head callback
 *
 * Outputs additional CSS code from theme options
 *
 * @since  1.0
 */

add_action( 'wp_head', 'typology_wp_head', 99 );

if ( !function_exists( 'typology_wp_head' ) ):
	function typology_wp_head() {

		//Additional CSS (if user adds his custom css inside theme options)
		$additional_css = trim( preg_replace( '/\s+/', ' ', typology_get_option( 'additional_css' ) ) );
		if ( !empty( $additional_css ) ) {
			echo '<style type="text/css">'.$additional_css.'</style>';
		}

	}
endif;



/**
 * wp_footer callback
 *
 * Outputs additional JavaScript code from theme options
 *
 * @since  1.0
 */

add_action( 'wp_footer', 'typology_wp_footer', 99 );

if ( !function_exists( 'typology_wp_footer' ) ):
	function typology_wp_footer() {

		//Additional JS
		$additional_js = trim( preg_replace( '/\s+/', ' ', typology_get_option( 'additional_js' ) ) );
		if ( !empty( $additional_js ) ) {
			echo '<script type="text/javascript">
				/* <![CDATA[ */
					'.$additional_js.'
				/* ]]> */
				</script>';
		}

	}
endif;



/**
 * Prevent redirect issue that may brake home page pagination caused by some plugins
 *
 * @since  1.0
 */

add_filter( 'redirect_canonical', 'typology_disable_redirect_canonical' );

function typology_disable_redirect_canonical( $redirect_url ) {
	if ( is_page_template( 'template-home.php' ) && is_paged() ) {
		$redirect_url = false;
	}
	return $redirect_url;
}


/**
 * pre_get_posts filter callback
 *
 * If a user select custom number of posts per specific archive
 * template, override default post per page value
 *
 * @since  1.0
 */

add_action( 'pre_get_posts', 'typology_pre_get_posts' );

if ( !function_exists( 'typology_pre_get_posts' ) ):
	function typology_pre_get_posts( $query ) {

		if ( !is_admin() && $query->is_main_query() && ( $query->is_archive() || $query->is_search() ) && !$query->is_feed() ) {

			//Get posts per page
			$ppp = typology_get_option( 'archive_ppp' ) == 'custom' ? typology_get_option( 'archive_ppp_num' ) : get_option( 'posts_per_page' );
			$query->set( 'posts_per_page', absint( $ppp ) );

		}

	}
endif;


/**
 * frontpage_template filter callback
 *
 * Use front-page.php template only if a user selected "static page" 
 * in reading settings. This will ensure that "latest posts" option will always load index.php
 *
 * @since  1.0
 */

add_filter( 'frontpage_template',  'typology_front_page_template' );

if ( !function_exists( 'typology_front_page_template' ) ):
function typology_front_page_template( $template ) {

	$template = is_home() ? '' : $template;

	return $template;
}

endif;


/**
 * Add class to gallery images to enable pop-up and change image sizes
 *
 * @since  1.0
 */

add_filter( 'shortcode_atts_gallery', 'typology_gallery_atts', 10, 3 );

if ( !function_exists( 'typology_gallery_atts' ) ):
	function typology_gallery_atts( $output, $pairs, $atts ) {

		if( typology_get_option('use_gallery') ){
			$atts['link'] = 'file';
			$output['link'] = 'file';
			$output['size'] = 'typology-a';
			add_filter( 'wp_get_attachment_link', 'typology_add_class_attachment_link', 10, 1 );
		}

		return $output;
	}
endif;

if ( !function_exists( 'typology_add_class_attachment_link' ) ):
	function typology_add_class_attachment_link( $link ) {
		$link = str_replace( '<a', '<a class="typology-popup"', $link );
		return $link;
	}
endif;

/**
 * Modify WooCommerce wrappers
 *
 * Provide support for WooCommerce pages to match theme HTML markup
 *
 * @return HTML output
 * @since  1.2
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'typology_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'typology_woocommerce_wrapper_end', 10 );

if ( !function_exists( 'typology_woocommerce_wrapper_start' ) ):
	function typology_woocommerce_wrapper_start() {
		echo '<div id="typology-cover" class="typology-cover typology-cover-empty"></div><div class="typology-fake-bg"><div class="typology-section"><div class="section-content">';
	}
endif;

if ( !function_exists( 'typology_woocommerce_wrapper_end' ) ):
	function typology_woocommerce_wrapper_end() {
		echo '</div></div></div>';
	}
endif;

add_action( 'typology_before_end_content', 'typology_woocommerce_close_wrap' );

if ( !function_exists( 'typology_woocommerce_close_wrap' ) ):
	function typology_woocommerce_close_wrap() {
		if ( typology_is_woocommerce_active() && typology_is_woocommerce_page() ) {
			echo '</div>';
		}
	}
endif;


?>