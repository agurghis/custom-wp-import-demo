<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://themesdojo.com
 * @since      1.0.0
 *
 * @package    ThemesDojo_Demo_Import
 * @subpackage ThemesDojo_Demo_Import/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    ThemesDojo_Demo_Import
 * @subpackage ThemesDojo_Demo_Import/includes
 * @author     Your Name <email@example.com>
 */
class ThemesDojo_Demo_Import_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'td-demo-import',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
