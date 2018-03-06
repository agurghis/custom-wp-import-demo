<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://themesdojo.com
 * @since      1.0.0
 *
 * @package    ThemesDojo_Demo_Import
 * @subpackage ThemesDojo_Demo_Import/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    ThemesDojo_Demo_Import
 * @subpackage ThemesDojo_Demo_Import/admin
 * @author     Your Name <email@example.com>
 */
class ThemesDojo_Demo_Import_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $ThemesDojo_Demo_Import    The ID of this plugin.
	 */
	private $ThemesDojo_Demo_Import;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $ThemesDojo_Demo_Import       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $ThemesDojo_Demo_Import, $version ) {

		$this->ThemesDojo_Demo_Import = $ThemesDojo_Demo_Import;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ThemesDojo_Demo_Import_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ThemesDojo_Demo_Import_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->ThemesDojo_Demo_Import, plugin_dir_url( __FILE__ ) . 'css/td-demo-import-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ThemesDojo_Demo_Import_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ThemesDojo_Demo_Import_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->ThemesDojo_Demo_Import, plugin_dir_url( __FILE__ ) . 'js/td-demo-import-admin.js', array( 'jquery' ), $this->version, false );

		$settings = array(
			'td_ajaxurl' => esc_url( admin_url('admin-ajax.php', 'relative') ),
		);
		wp_localize_script( $this->ThemesDojo_Demo_Import, 'tdSettings', apply_filters( $this->ThemesDojo_Demo_Import, $settings ) );

	}

	

}
