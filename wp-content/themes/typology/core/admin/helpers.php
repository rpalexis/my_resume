<?php

/**
 * Get the list of available layouts
 *
 * @return array List of available options
 * @since  1.0
 */

if ( !function_exists( 'typology_get_main_layouts' ) ):
	function typology_get_main_layouts( ) {

		$layouts = array();

		$layouts['a'] = array( 'title' => esc_html__( 'Layout A', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/layout_a.png');
		$layouts['b'] = array( 'title' => esc_html__( 'Layout B', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/layout_b.png');
		$layouts['c'] = array( 'title' => esc_html__( 'Layout C', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/layout_c.png');

		$layouts = apply_filters('typology_modify_main_layouts', $layouts ); //Allow child themes or plugins to modify
		
		return $layouts;
		
	}
endif;


/**
 * Get the list of available pagination types
 *
 * @return array List of available options
 * @since  1.0
 */

if ( !function_exists( 'typology_get_pagination_layouts' ) ):
	function typology_get_pagination_layouts() {

		$layouts = array();

		$layouts['numeric'] = array( 'title' => esc_html__( 'Numeric pagination links', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/pag_numeric.png' );
		$layouts['prev-next'] = array( 'title' => esc_html__( 'Prev/Next page links', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/pag_prev_next.png' );
		$layouts['load-more'] = array( 'title' => esc_html__( 'Load more button', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/pag_load_more.png' );
		$layouts['infinite-scroll'] = array( 'title' => esc_html__( 'Infinite scroll', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/pag_infinite.png' );

		$layouts = apply_filters('typology_modify_pagination_layouts', $layouts );
		
		return $layouts;
	}
endif;


/**
 * Get the list of header layouts
 *
 * @return array List of available options
 * @since  1.0
 */

if ( !function_exists( 'typology_get_header_layouts' ) ):
	function typology_get_header_layouts() {

		$layouts = array();

		$layouts['1'] = array( 'title' => esc_html__( 'Layout 1', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/header_layout_1.png');
		$layouts['2'] = array( 'title' => esc_html__( 'Layout 2', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/header_layout_2.png');
		$layouts['3'] = array( 'title' => esc_html__( 'Layout 3', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/header_layout_3.png');
		$layouts['4'] = array( 'title' => esc_html__( 'Layout 4', 'typology' ), 'img' => get_template_directory_uri() . '/assets/img/admin/header_layout_4.png');

		$layouts = apply_filters('typology_modify_header_layouts', $layouts ); //Allow child themes or plugins to modify
		
		return $layouts;
		
	}
endif;

/**
 * Get the list of available options for post ordering
 *
 * @return array List of available options
 * @since  1.0
 */

if ( !function_exists( 'typology_get_post_order_opts' ) ) :
	function typology_get_post_order_opts() {

		$options = array(
			'date' => esc_html__( 'Date', 'typology' ),
			'comment_count' => esc_html__( 'Number of comments', 'typology' ),
			'title'	=> esc_html__( 'Title (alphabetically)', 'typology' ),
			'rand' => esc_html__( 'Random', 'typology' ),
		);

		$options = apply_filters('typology_modify_post_order_opts', $options );

		return $options;
	}
endif;


/**
 * Get meta options
 *
 * @param   array $default Enable defaults i.e. array('date', 'comments')
 * @return array List of available options
 * @since  1.0
 */

if ( !function_exists( 'typology_get_meta_opts' ) ):
	function typology_get_meta_opts( $default = array() ) {

		$options = array();

		$options['author'] = esc_html__( 'Author', 'typology' );
		$options['category'] = esc_html__( 'Category', 'typology' );
		$options['date'] = esc_html__( 'Date', 'typology' );
		$options['rtime'] = esc_html__( 'Reading time', 'typology' );
		$options['comments'] = esc_html__( 'Comments', 'typology' );

		if(!empty($default)){
			foreach($options as $key => $option){
				if(in_array( $key, $default)){
					$options[$key] = 1;
				} else {
					$options[$key] = 0;
				}
			}
		}

		$options = apply_filters('typology_modify_meta_opts', $options ); //Allow child themes or plugins to modify

		return $options;
	}
endif;


/**
 * Get button options
 *
 * @param   array $default Enable defaults i.e. array('rm', 'rl')
 * @return array List of available options
 * @since  1.0
 */

if ( !function_exists( 'typology_get_button_opts' ) ):
	function typology_get_button_opts( $default = array() ) {

		$options = array();

		$options['rm'] = esc_html__( 'Read on', 'typology' );
		$options['rl'] = esc_html__( 'Read later', 'typology' );
		$options['comments'] = esc_html__( 'Comments', 'typology' );

		if(!empty($default)){
			foreach($options as $key => $option){
				if(in_array( $key, $default)){
					$options[$key] = 1;
				} else {
					$options[$key] = 0;
				}
			}
		}

		$options = apply_filters('typology_modify_button_opts', $options ); //Allow child themes or plugins to modify

		return $options;
	}
endif;


/**
 * Get the list of time limit options
 *
 * @return array List of available options
 * @since  1.0
 */

if ( !function_exists( 'typology_get_time_diff_opts' ) ) :
	function typology_get_time_diff_opts() {

		$options = array(
			'-1 day' => esc_html__( '1 Day', 'typology' ),
			'-3 days' => esc_html__( '3 Days', 'typology' ),
			'-1 week' => esc_html__( '1 Week', 'typology' ),
			'-1 month' => esc_html__( '1 Month', 'typology' ),
			'-3 months' => esc_html__( '3 Months', 'typology' ),
			'-6 months' => esc_html__( '6 Months', 'typology' ),
			'-1 year' => esc_html__( '1 Year', 'typology' ),
			'0' => esc_html__( 'All time', 'typology' )
		);

		$options = apply_filters('typology_modify_time_diff_opts', $options ); //Allow child themes or plugins to modify

		return $options;
	}
endif;


?>