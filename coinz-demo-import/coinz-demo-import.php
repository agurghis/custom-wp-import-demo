<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://themesdojo.com
 * @since             1.0.0
 * @package           ThemesDojo_Demo_Import
 *
 * @wordpress-plugin
 * Plugin Name:       ThemesDojo Demo Import
 * Plugin URI:        http://themesdojo.com
 * Description:       ThemesDojo custom demo import plugin
 * Version:           1.0.0
 * Author:            Themes Dojo
 * Author URI:        http://themesdojo.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       td-demo-import
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ThemesDojo_Demo_Import_VERSION', '1.0.0' );

// Define constants
define( 'TD_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'TD_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-td-demo-import-activator.php
 */
function activate_ThemesDojo_Demo_Import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-td-demo-import-activator.php';
	ThemesDojo_Demo_Import_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-td-demo-import-deactivator.php
 */
function deactivate_ThemesDojo_Demo_Import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-td-demo-import-deactivator.php';
	ThemesDojo_Demo_Import_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ThemesDojo_Demo_Import' );
register_deactivation_hook( __FILE__, 'deactivate_ThemesDojo_Demo_Import' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-td-demo-import.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ThemesDojo_Demo_Import() {

	$plugin = new ThemesDojo_Demo_Import();
	$plugin->run();

}

run_ThemesDojo_Demo_Import();
