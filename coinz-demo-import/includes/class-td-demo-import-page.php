<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CarDojo_Install
 */
class ThemesDojo_Demo_Import_Page {

	/**
	 * Install CarDojo
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'td_demo_import_admin_add_custom_menu' ), 0 );

		// Try to update PHP memory limit (so that it does not run out of it).
		ini_set( 'memory_limit', apply_filters( 'pt-ocdi/import_memory_limit', '350M' ) );

	}

	/**
	 * td_demo_import_admin_add_custom_menu function.
	 *
	 * @access public
	 * @return void
	 */
	public function td_demo_import_admin_add_custom_menu(){    

	    $this->plugin_page_setup = apply_filters( 'td-demo-import/plugin_page_setup', array(
			'parent_slug' => 'themes.php',
			'page_title'  => esc_html__( 'CoinZ Demo Import' , 'td-demo-import' ),
			'menu_title'  => esc_html__( 'CoinZ Demo Import' , 'td-demo-import' ),
			'capability'  => 'import',
			'menu_slug'   => 'td-demo-import',
		) );

		$this->plugin_page = add_submenu_page(
			$this->plugin_page_setup['parent_slug'],
			$this->plugin_page_setup['page_title'],
			$this->plugin_page_setup['menu_title'],
			$this->plugin_page_setup['capability'],
			$this->plugin_page_setup['menu_slug'],
			apply_filters( 'pt-ocdi/plugin_page_display_callback_function', array( $this, 'display_plugin_page' ) )
		);

		register_importer( $this->plugin_page_setup['menu_slug'], $this->plugin_page_setup['page_title'], $this->plugin_page_setup['menu_title'], apply_filters( 'td-demo-import/plugin_page_display_callback_function', array( $this, 'display_plugin_page' ) ) );

	}

	/**
	 * Plugin page display.
	 * Output (HTML) is in another file.
	 */
	public function display_plugin_page() {
		require_once plugin_dir_path( __FILE__ ) . 'plugin-page.php';
	}

}
