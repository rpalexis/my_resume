<?php

/**
 * Include the TGM_Plugin_Activation class.
 */

require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

/**
 * Register the required plugins for this theme.
 *
 */

add_action( 'tgmpa_register', 'typology_register_required_plugins' );

function typology_register_required_plugins() {

	/**
	 * Array of plugin params
	 */
	$plugins = array(
		array(
			'name'   => 'Meks Flexible Shortcodes',
			'slug'   => 'meks-flexible-shortcodes',
			'required'  => false,
		),
		array(
			'name'   => 'Meks Easy Ads Widget',
			'slug'   => 'meks-easy-ads-widget',
			'required'  => false,
		),
		array(
			'name'   => 'Meks Smart Social Widget',
			'slug'   => 'meks-smart-social-widget',
			'required'  => false,
		),
		array(
			'name'   => 'Meks Smart Author Widget',
			'slug'   => 'meks-smart-author-widget',
			'required'  => false,
		),
		array(
			'name'   => 'Meks Simple Flickr Widget',
			'slug'   => 'meks-simple-flickr-widget',
			'required'  => false,
		),

		array(
			'name'   => 'Meks ThemeForest Smart Widget',
			'slug'   => 'meks-themeforest-smart-widget',
			'required'  => false,
		),

		array(
			'name'   => 'Contact Form 7',
			'slug'   => 'contact-form-7',
			'required'  => false,
		),
		array(
			'name'   => 'Force Regenerate Thumbnails',
			'slug'   => 'force-regenerate-thumbnails',
			'required'  => false,
		)

	);


	/**
	 * Array of configuration settings.
	 */
	$config = array(
		'domain'         => 'typology',
		'default_path'   => '',
		'menu'           => 'install-required-plugins',
		'has_notices'       => false,
		'is_automatic'     => true,
		'message'    => '',
		'strings'        => array(
			'page_title'                          => esc_html__( 'Install Recommended Plugins', 'typology' ),
			'menu_title'                          => esc_html__( 'Typology Plugins', 'typology' ),
			'installing'                          => esc_html__( 'Installing Plugin: %s', 'typology' ), // %1$s = plugin name
			'oops'                                => esc_html__( 'Something went wrong with the plugin API.', 'typology' ),
			'notice_can_install_required'        => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'typology' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'   => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'typology' ), // %1$s = plugin name(s)
			'notice_cannot_install'       => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'typology' ), // %1$s = plugin name(s)
			'notice_can_activate_required'       => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'typology' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'   => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'typology' ), // %1$s = plugin name(s)
			'notice_cannot_activate'      => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'typology' ), // %1$s = plugin name(s)
			'notice_ask_to_update'       => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'typology' ), // %1$s = plugin name(s)
			'notice_cannot_update'       => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'typology' ), // %1$s = plugin name(s)
			'install_link'           => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'typology' ),
			'activate_link'          => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'typology' ),
			'return'                              => esc_html__( 'Return to Required Plugins Installer', 'typology' ),
			'plugin_activated'                    => esc_html__( 'Plugin activated successfully.', 'typology' ),
			'complete'          => esc_html__( 'All plugins installed and activated successfully. %s', 'typology' ),
			'nag_type'         => 'updated'
		)
	);

	tgmpa( $plugins, $config );

}

?>