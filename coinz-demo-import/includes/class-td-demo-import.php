<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://themesdojo.com
 * @since      1.0.0
 *
 * @package    ThemesDojo_Demo_Import
 * @subpackage ThemesDojo_Demo_Import/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    ThemesDojo_Demo_Import
 * @subpackage ThemesDojo_Demo_Import/includes
 * @author     Your Name <email@example.com>
 */
class ThemesDojo_Demo_Import {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      ThemesDojo_Demo_Import_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $ThemesDojo_Demo_Import    The string used to uniquely identify this plugin.
	 */
	protected $ThemesDojo_Demo_Import;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ThemesDojo_Demo_Import_VERSION' ) ) {
			$this->version = ThemesDojo_Demo_Import_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->ThemesDojo_Demo_Import = 'td-demo-import';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		//
		$this->demo_import_admin_page();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - ThemesDojo_Demo_Import_Loader. Orchestrates the hooks of the plugin.
	 * - ThemesDojo_Demo_Import_i18n. Defines internationalization functionality.
	 * - ThemesDojo_Demo_Import_Admin. Defines all hooks for the admin area.
	 * - ThemesDojo_Demo_Import_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-td-demo-import-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-td-demo-import-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-td-demo-import-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-td-demo-import-public.php';

		$this->loader = new ThemesDojo_Demo_Import_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the ThemesDojo_Demo_Import_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new ThemesDojo_Demo_Import_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new ThemesDojo_Demo_Import_Admin( $this->get_ThemesDojo_Demo_Import(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Import Images
		add_action( 'wp_ajax_import_demo_images', array( $this, 'import_demo_images' ) );
		add_action( 'wp_ajax_nopriv_import_demo_images', array( $this, 'import_demo_images' ) );

		// Import Work Custom Post Type
		add_action( 'wp_ajax_import_demo_work', array( $this, 'import_demo_work' ) );
		add_action( 'wp_ajax_nopriv_import_demo_work', array( $this, 'import_demo_work' ) );

		// Import Testimonials Custom Post Type
		add_action( 'wp_ajax_import_demo_testimonials', array( $this, 'import_demo_testimonials' ) );
		add_action( 'wp_ajax_nopriv_import_demo_testimonials', array( $this, 'import_demo_testimonials' ) );

		// Import Team Custom Post Type
		add_action( 'wp_ajax_import_demo_team', array( $this, 'import_demo_team' ) );
		add_action( 'wp_ajax_nopriv_import_demo_team', array( $this, 'import_demo_team' ) );

		// Import Partners Custom Post Type
		add_action( 'wp_ajax_import_demo_partners', array( $this, 'import_demo_partners' ) );
		add_action( 'wp_ajax_nopriv_import_demo_partners', array( $this, 'import_demo_partners' ) );

		// Import Partners Custom Post Type
		add_action( 'wp_ajax_import_demo_posts', array( $this, 'import_demo_posts' ) );
		add_action( 'wp_ajax_nopriv_import_demo_posts', array( $this, 'import_demo_posts' ) );

		// Import Pages and Create Menus
		add_action( 'wp_ajax_import_demo_pages', array( $this, 'import_demo_pages' ) );
		add_action( 'wp_ajax_nopriv_import_demo_pages', array( $this, 'import_demo_pages' ) );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new ThemesDojo_Demo_Import_Public( $this->get_ThemesDojo_Demo_Import(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function demo_import_admin_page() {

		// Includes
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-td-demo-import-page.php';

		// Init classes
		$this->demo_import_menu = new ThemesDojo_Demo_Import_Page();

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_ThemesDojo_Demo_Import() {
		return $this->ThemesDojo_Demo_Import;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    ThemesDojo_Demo_Import_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Create properties that the plugin relies on, storing property IDs in variables.
	 */
	public static function import_demo_images() {

		$response['status'] = 'success';
		$response['html'] = '';

		ob_start();

        // Import Work Images
		$files_images = array(
            'image_1' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/work/work-cover-1.jpg',
            ),
            'image_2' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/work/work-cover-2.jpg',
            ),
            'image_3' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/work/work-cover-3.jpg',
            ),
            'image_4' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/work/work-cover-4.jpg',
            ),
            'image_5' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/work/work-cover-5.jpg',
            ),
            'image_6' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/work/work-cover-6.jpg',
            ),
        );

        $current = 0;
        foreach ( $files_images as $key => $file_o ) {
        	$current++;
            $parent_post_id = 0;
            $file = $file_o['url'];
            $filename = basename($file);
            $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
            if (!$upload_file['error']) {
                $wp_filetype = wp_check_filetype($filename, null );
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_parent' => $parent_post_id,
                    'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
                if (!is_wp_error($attachment_id)) {
                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                    wp_update_attachment_metadata( $attachment_id,  $attachment_data );
                    update_option( 'work_images_'.$current, $attachment_id );
                }
            }
        }
        // End import work images

        // Import Teams Images
		$files_images = array(
            'image_1' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/team/team-1.jpg',
            ),
            'image_2' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/team/team-2.jpg',
            ),
            'image_3' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/team/team-3.jpg',
            ),
            'image_4' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/team/team-4.jpg',
            ),
            'image_5' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/team/team-5.jpg',
            ),
            'image_6' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/team/team-6.jpg',
            ),
        );

        $current = 0;
        foreach ( $files_images as $key => $file_o ) {
        	$current++;
            $parent_post_id = 0;
            $file = $file_o['url'];
            $filename = basename($file);
            $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
            if (!$upload_file['error']) {
                $wp_filetype = wp_check_filetype($filename, null );
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_parent' => $parent_post_id,
                    'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
                if (!is_wp_error($attachment_id)) {
                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                    wp_update_attachment_metadata( $attachment_id,  $attachment_data );
                    update_option( 'team_images_'.$current, $attachment_id );
                }
            }
        }
        // End import team images

        // Import Partners Images
		$files_images = array(
            'image_1' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/partners/partner-1.png',
            ),
            'image_2' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/partners/partner-2.png',
            ),
            'image_3' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/partners/partner-3.png',
            ),
            'image_4' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/partners/partner-4.png',
            ),
            'image_5' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/partners/partner-5.png',
            ),
            'image_6' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/partners/partner-6.png',
            ),
            'image_7' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/partners/partner-7.png',
            ),
            'image_8' => array(
                'url'  => TD_PLUGIN_URL . '/includes/images/partners/partner-8.png',
            ),
        );

        $current = 0;
        foreach ( $files_images as $key => $file_o ) {
        	$current++;
            $parent_post_id = 0;
            $file = $file_o['url'];
            $filename = basename($file);
            $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
            if (!$upload_file['error']) {
                $wp_filetype = wp_check_filetype($filename, null );
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_parent' => $parent_post_id,
                    'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
                if (!is_wp_error($attachment_id)) {
                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                    wp_update_attachment_metadata( $attachment_id,  $attachment_data );
                    update_option( 'partners_images_'.$current, $attachment_id );
                }
            }
        }

        $response['html'] = ob_get_clean();
	  	echo json_encode($response);
		exit;
        // End import partners images
	}

	/**
	 * Create properties that the plugin relies on, storing property IDs in variables.
	 */
	public static function import_demo_work() {

		$response['status'] = 'success';
		$response['html'] = '';
		ob_start();

		$work_1_content = '[vc_row full_width="stretch_row" parallax="content-moving" parallax_image="1245" parallax_speed_bg="2.5" css=".vc_custom_1518208065626{padding-top: 60px !important;padding-bottom: 60px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-2.jpg?id=1245) !important;background-position: center;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text css_animation="bounceIn" css=".vc_custom_1518208222233{margin-top: 60px !important;margin-bottom: 60px !important;}"]
<h2 style="text-align: center; color: #fff;">BiTrust</h2>
[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1518210048527{padding-top: 60px !important;padding-bottom: 60px !important;}"][vc_column width="1/2" offset="vc_hidden-sm vc_hidden-xs"][vc_column_text]
<h3>Overview</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. <strong>In nisi neque</strong>, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. <strong>Nullam mollis</strong>. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.
<blockquote>Praesent dapibus, neque id cursus faucibus, <strong>tortor neque egestas</strong> auguae, eu vulputate magna eros eu erat. Aliquam erat volutpat.</blockquote>
Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.[/vc_column_text][/vc_column][vc_column width="1/2" css=".vc_custom_1518208783476{padding-top: 90px !important;padding-bottom: 60px !important;}"][coinz_video_player image="1327"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518210167632{border-top-width: 1px !important;border-bottom-width: 1px !important;padding-top: 60px !important;padding-bottom: 60px !important;background-color: #ececec !important;border-top-color: #e4e4eb !important;border-top-style: solid !important;border-bottom-color: #e4e4eb !important;border-bottom-style: solid !important;}"][vc_column][vc_row_inner][vc_column_inner width="1/3"][vc_line_chart type="line" legend="" values="%5B%7B%22title%22%3A%22One%22%2C%22y_values%22%3A%2210%3B%2015%3B%2020%3B%2025%3B%2027%3B%2025%3B%2023%3B%2025%22%2C%22color%22%3A%22blue%22%7D%2C%7B%22title%22%3A%22Two%22%2C%22y_values%22%3A%2225%3B%2018%3B%2016%3B%2017%3B%2020%3B%2025%3B%2030%3B%2035%22%2C%22color%22%3A%22pink%22%7D%5D" animation="easeOutBounce"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]
<h3>Praesent dapibus neque id</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. <strong>In nisi neque</strong>, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. <strong>Nullam mollis</strong>. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.

Praesent dapibus, neque id cursus faucibus, <strong>tortor neque egestas</strong> auguae, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.
<ul>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
 	<li><strong>Integer vitae libero ac risus egestas placerat.</strong></li>
</ul>
[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row][vc_column width="1/4" offset="vc_hidden-sm vc_hidden-xs"][/vc_column][vc_column width="1/2"][/vc_column][vc_column width="1/4" offset="vc_hidden-sm vc_hidden-xs"][/vc_column][/vc_row][vc_row css=".vc_custom_1518210244191{padding-top: 60px !important;padding-bottom: 120px !important;}"][vc_column][vc_column_text css=".vc_custom_1518209272928{margin-bottom: 0px !important;}"]
<h2 style="color: #f53e82; text-align: center; float: none;">Work Progress</h2>
[/vc_column_text][coinz_devider align="centered"][vc_row_inner][vc_column_inner width="1/3"][coinz_progress_circle title="Design" stroke_width="5" stroke_color="#f53e82" percentage="90"][/vc_column_inner][vc_column_inner width="1/3"][coinz_progress_circle title="Legal Process" stroke_width="5" stroke_color="#f53e82" percentage="70"][/vc_column_inner][vc_column_inner width="1/3"][coinz_progress_circle title="Coin Development" stroke_width="5" stroke_color="#f53e82" percentage="60"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row][vc_column][coinz_slider height_style="custom" height="670"][coinz_slider_item image="1334"][/coinz_slider_item][coinz_slider_item image="1330"][/coinz_slider_item][coinz_slider_item image="1327"][/coinz_slider_item][/coinz_slider][/vc_column][/vc_row]';

		$work_2_content = '[vc_row css=".vc_custom_1518208041283{padding-top: 60px !important;}"][vc_column width="3/4"][vc_row_inner css=".vc_custom_1518173289282{margin-bottom: 20px !important;}"][vc_column_inner width="1/3"][vc_column_text css=".vc_custom_1518173091061{border-left-width: 1px !important;padding-left: 30px !important;border-left-color: #e4e4eb !important;border-left-style: solid !important;}"]
<h4 style="color: #f53e82;">Project</h4>
LoanZ[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][vc_column_text css=".vc_custom_1518173113611{border-left-width: 1px !important;padding-left: 30px !important;border-left-color: #e4e4eb !important;border-left-style: solid !important;}"]
<h4 style="color: #f53e82;">Client</h4>
LoanZ Inc[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][vc_column_text css=".vc_custom_1518173133850{border-left-width: 1px !important;padding-left: 30px !important;border-left-color: #e4e4eb !important;border-left-style: solid !important;}"]
<h4 style="color: #f53e82;">What We Did</h4>
Research, Code, Interface[/vc_column_text][/vc_column_inner][/vc_row_inner][coinz_slider height_style="custom" height="560"][coinz_slider_item image="1334"][/coinz_slider_item][coinz_slider_item image="1330"][/coinz_slider_item][coinz_slider_item image="1327"][/coinz_slider_item][/coinz_slider][vc_column_text]
<h4 style="color: #f53e82;">Overview</h4>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
<ul>
 	<li><strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</strong></li>
 	<li><strong>Aliquam tincidunt mauris eu risus.</strong></li>
 	<li><strong>Vestibulum auctor dapibus neque.</strong></li>
 	<li><strong>Nunc dignissim risus id metus.</strong></li>
 	<li><strong>Cras ornare tristique elit.</strong></li>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
</ul>
Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor.Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.
<blockquote>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</blockquote>
Praesent dapibus, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.[/vc_column_text][vc_row_inner][vc_column_inner css=".vc_custom_1518137468686{margin-bottom: 30px !important;}"][coinz_progress_bar title="Strategy" percentage="80" animated_bg="true"][coinz_progress_bar title="Coding" percentage="95" stroke_color="#fcbe44" animated_bg="true"][coinz_progress_bar title="UI/UX Design" percentage="90" stroke_color="#333744" animated_bg="true"][/vc_column_inner][/vc_row_inner][tabs tabs_style="horizontal_2"][tab title="Challenge" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-fire"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. <strong>Aenean massa. Cum sociis natoque</strong> penatibus et magnis dis parturient montes, nascetur ridiculus mus.

Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. <em>In enim justo</em>, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. <strong><em>Integer tincidunt</em></strong>. Cras dapibus. Vivamus elementum semper nisi.[/tab][tab title="Solution" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-bulb"]<strong>Praesent dapibus</strong>, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat. <strong>Aliquam erat volutpat</strong>.

Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.
<ul>
 	<li>Vivamus vestibulum ntulla nec ante.</li>
 	<li>Praesent placerat risus quis eros.</li>
 	<li>Fusce pellentesque suscipit nibh.</li>
 	<li>Integer vitae libero ac risus egestas placerat.</li>
</ul>
Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. <strong>Nam nulla quam, gravida non</strong>, commodo a, sodales sit amet, nisi.[/tab][tab title="Results" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-star"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. <strong>Aenean massa. </strong>

<strong>Cum sociis natoque</strong> penatibus et magnis dis parturient montes, nascetur ridiculus mus.
<ul>
 	<li><strong>Aliquam tincidunt mauris eu risus.</strong></li>
 	<li><strong>Vestibulum auctor dapibus neque.</strong></li>
 	<li><strong>Nunc dignissim risus id metus.</strong></li>
 	<li><strong>Cras ornare tristique elit.</strong></li>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
 	<li><strong>Integer vitae libero ac risus egestas placerat.</strong></li>
</ul>
Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. <em>In enim justo</em>, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. <strong><em>Integer tincidunt</em></strong>. Cras dapibus. Vivamus elementum semper nisi.[/tab][tab title="Rewards" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-diamond"]

Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<strong> Aenean commod</strong>o ligula eget dolor.

<strong>Aenean massa. Cum sociis natoque</strong> penatibus et magnis dis parturient montes, nascetur ridiculus mus.
<ul>
 	<li><strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</strong></li>
 	<li><strong>Aliquam tincidunt mauris eu risus.</strong></li>
 	<li><strong>Vestibulum auctor dapibus neque.</strong></li>
 	<li><strong>Nunc dignissim risus id metus.</strong></li>
 	<li><strong>Cras ornare tristique elit.</strong></li>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
 	<li><strong>Integer vitae libero ac risus egestas placerat.</strong></li>
 	<li><strong>Vestibulum commodo felis quis tortor.</strong></li>
 	<li><strong>Ut aliquam sollicitudin leo.</strong></li>
 	<li><strong>Cras iaculis ultricies nulla.</strong></li>
 	<li><strong>Donec quis dui at dolor tempor interdum.</strong></li>
</ul>
[/tab][/tabs][/vc_column][vc_column width="1/4"][vc_row_inner][vc_column_inner][vc_wp_custommenu nav_menu="16"][/vc_column_inner][/vc_row_inner][coinz_subscribe css=".vc_custom_1518137079275{margin-bottom: 30px !important;}"]
<h3>Newsletter!</h3>
Subscribe and get <a href="#"><strong>Introduction in Cryptocurrency</strong></a> course for free.[/coinz_subscribe][vcw_container title="Converter" vcw_container_style="style_2"][vcw-converter symbol2="USD"][/vcw_container][/vc_column][/vc_row]';

		$work_3_content = '[vc_row full_width="stretch_row" parallax="content-moving" parallax_image="1245" parallax_speed_bg="2.5" css=".vc_custom_1518208065626{padding-top: 60px !important;padding-bottom: 60px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-2.jpg?id=1245) !important;background-position: center;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text css_animation="bounceIn" css=".vc_custom_1518208222233{margin-top: 60px !important;margin-bottom: 60px !important;}"]
<h2 style="text-align: center; color: #fff;">BiTrust</h2>
[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1518210048527{padding-top: 60px !important;padding-bottom: 60px !important;}"][vc_column width="1/2" offset="vc_hidden-sm vc_hidden-xs"][vc_column_text]
<h3>Overview</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. <strong>In nisi neque</strong>, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. <strong>Nullam mollis</strong>. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.
<blockquote>Praesent dapibus, neque id cursus faucibus, <strong>tortor neque egestas</strong> auguae, eu vulputate magna eros eu erat. Aliquam erat volutpat.</blockquote>
Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.[/vc_column_text][/vc_column][vc_column width="1/2" css=".vc_custom_1518208783476{padding-top: 90px !important;padding-bottom: 60px !important;}"][coinz_video_player image="1327"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518210167632{border-top-width: 1px !important;border-bottom-width: 1px !important;padding-top: 60px !important;padding-bottom: 60px !important;background-color: #ececec !important;border-top-color: #e4e4eb !important;border-top-style: solid !important;border-bottom-color: #e4e4eb !important;border-bottom-style: solid !important;}"][vc_column][vc_row_inner][vc_column_inner width="1/3"][vc_line_chart type="line" legend="" values="%5B%7B%22title%22%3A%22One%22%2C%22y_values%22%3A%2210%3B%2015%3B%2020%3B%2025%3B%2027%3B%2025%3B%2023%3B%2025%22%2C%22color%22%3A%22blue%22%7D%2C%7B%22title%22%3A%22Two%22%2C%22y_values%22%3A%2225%3B%2018%3B%2016%3B%2017%3B%2020%3B%2025%3B%2030%3B%2035%22%2C%22color%22%3A%22pink%22%7D%5D" animation="easeOutBounce"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]
<h3>Praesent dapibus neque id</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. <strong>In nisi neque</strong>, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. <strong>Nullam mollis</strong>. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.

Praesent dapibus, neque id cursus faucibus, <strong>tortor neque egestas</strong> auguae, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.
<ul>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
 	<li><strong>Integer vitae libero ac risus egestas placerat.</strong></li>
</ul>
[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row][vc_column width="1/4" offset="vc_hidden-sm vc_hidden-xs"][/vc_column][vc_column width="1/2"][/vc_column][vc_column width="1/4" offset="vc_hidden-sm vc_hidden-xs"][/vc_column][/vc_row][vc_row css=".vc_custom_1518210244191{padding-top: 60px !important;padding-bottom: 120px !important;}"][vc_column][vc_column_text css=".vc_custom_1518209272928{margin-bottom: 0px !important;}"]
<h2 style="color: #f53e82; text-align: center; float: none;">Work Progress</h2>
[/vc_column_text][coinz_devider align="centered"][vc_row_inner][vc_column_inner width="1/3"][coinz_progress_circle title="Design" stroke_width="5" stroke_color="#f53e82" percentage="90"][/vc_column_inner][vc_column_inner width="1/3"][coinz_progress_circle title="Legal Process" stroke_width="5" stroke_color="#f53e82" percentage="70"][/vc_column_inner][vc_column_inner width="1/3"][coinz_progress_circle title="Coin Development" stroke_width="5" stroke_color="#f53e82" percentage="60"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row][vc_column][coinz_slider height_style="custom" height="670"][coinz_slider_item image="1334"][/coinz_slider_item][coinz_slider_item image="1330"][/coinz_slider_item][coinz_slider_item image="1327"][/coinz_slider_item][/coinz_slider][/vc_column][/vc_row]';

		$work_4_content = '[vc_row css=".vc_custom_1518208041283{padding-top: 60px !important;}"][vc_column width="3/4"][vc_row_inner css=".vc_custom_1518173289282{margin-bottom: 20px !important;}"][vc_column_inner width="1/3"][vc_column_text css=".vc_custom_1518173091061{border-left-width: 1px !important;padding-left: 30px !important;border-left-color: #e4e4eb !important;border-left-style: solid !important;}"]
<h4 style="color: #f53e82;">Project</h4>
LoanZ[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][vc_column_text css=".vc_custom_1518173113611{border-left-width: 1px !important;padding-left: 30px !important;border-left-color: #e4e4eb !important;border-left-style: solid !important;}"]
<h4 style="color: #f53e82;">Client</h4>
LoanZ Inc[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][vc_column_text css=".vc_custom_1518173133850{border-left-width: 1px !important;padding-left: 30px !important;border-left-color: #e4e4eb !important;border-left-style: solid !important;}"]
<h4 style="color: #f53e82;">What We Did</h4>
Research, Code, Interface[/vc_column_text][/vc_column_inner][/vc_row_inner][coinz_slider height_style="custom" height="560"][coinz_slider_item image="1334"][/coinz_slider_item][coinz_slider_item image="1330"][/coinz_slider_item][coinz_slider_item image="1327"][/coinz_slider_item][/coinz_slider][vc_column_text]
<h4 style="color: #f53e82;">Overview</h4>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
<ul>
 	<li><strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</strong></li>
 	<li><strong>Aliquam tincidunt mauris eu risus.</strong></li>
 	<li><strong>Vestibulum auctor dapibus neque.</strong></li>
 	<li><strong>Nunc dignissim risus id metus.</strong></li>
 	<li><strong>Cras ornare tristique elit.</strong></li>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
</ul>
Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor.Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.
<blockquote>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</blockquote>
Praesent dapibus, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.[/vc_column_text][vc_row_inner][vc_column_inner css=".vc_custom_1518137468686{margin-bottom: 30px !important;}"][coinz_progress_bar title="Strategy" percentage="80" animated_bg="true"][coinz_progress_bar title="Coding" percentage="95" stroke_color="#fcbe44" animated_bg="true"][coinz_progress_bar title="UI/UX Design" percentage="90" stroke_color="#333744" animated_bg="true"][/vc_column_inner][/vc_row_inner][tabs tabs_style="horizontal_2"][tab title="Challenge" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-fire"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. <strong>Aenean massa. Cum sociis natoque</strong> penatibus et magnis dis parturient montes, nascetur ridiculus mus.

Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. <em>In enim justo</em>, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. <strong><em>Integer tincidunt</em></strong>. Cras dapibus. Vivamus elementum semper nisi.[/tab][tab title="Solution" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-bulb"]<strong>Praesent dapibus</strong>, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat. <strong>Aliquam erat volutpat</strong>.

Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.
<ul>
 	<li>Vivamus vestibulum ntulla nec ante.</li>
 	<li>Praesent placerat risus quis eros.</li>
 	<li>Fusce pellentesque suscipit nibh.</li>
 	<li>Integer vitae libero ac risus egestas placerat.</li>
</ul>
Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. <strong>Nam nulla quam, gravida non</strong>, commodo a, sodales sit amet, nisi.[/tab][tab title="Results" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-star"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. <strong>Aenean massa. </strong>

<strong>Cum sociis natoque</strong> penatibus et magnis dis parturient montes, nascetur ridiculus mus.
<ul>
 	<li><strong>Aliquam tincidunt mauris eu risus.</strong></li>
 	<li><strong>Vestibulum auctor dapibus neque.</strong></li>
 	<li><strong>Nunc dignissim risus id metus.</strong></li>
 	<li><strong>Cras ornare tristique elit.</strong></li>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
 	<li><strong>Integer vitae libero ac risus egestas placerat.</strong></li>
</ul>
Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. <em>In enim justo</em>, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. <strong><em>Integer tincidunt</em></strong>. Cras dapibus. Vivamus elementum semper nisi.[/tab][tab title="Rewards" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-diamond"]

Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<strong> Aenean commod</strong>o ligula eget dolor.

<strong>Aenean massa. Cum sociis natoque</strong> penatibus et magnis dis parturient montes, nascetur ridiculus mus.
<ul>
 	<li><strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</strong></li>
 	<li><strong>Aliquam tincidunt mauris eu risus.</strong></li>
 	<li><strong>Vestibulum auctor dapibus neque.</strong></li>
 	<li><strong>Nunc dignissim risus id metus.</strong></li>
 	<li><strong>Cras ornare tristique elit.</strong></li>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
 	<li><strong>Integer vitae libero ac risus egestas placerat.</strong></li>
 	<li><strong>Vestibulum commodo felis quis tortor.</strong></li>
 	<li><strong>Ut aliquam sollicitudin leo.</strong></li>
 	<li><strong>Cras iaculis ultricies nulla.</strong></li>
 	<li><strong>Donec quis dui at dolor tempor interdum.</strong></li>
</ul>
[/tab][/tabs][/vc_column][vc_column width="1/4"][vc_row_inner][vc_column_inner][vc_wp_custommenu nav_menu="16"][/vc_column_inner][/vc_row_inner][coinz_subscribe css=".vc_custom_1518137079275{margin-bottom: 30px !important;}"]
<h3>Newsletter!</h3>
Subscribe and get <a href="#"><strong>Introduction in Cryptocurrency</strong></a> course for free.[/coinz_subscribe][vcw_container title="Converter" vcw_container_style="style_2"][vcw-converter symbol2="USD"][/vcw_container][/vc_column][/vc_row]';

		$work_5_content = '[vc_row css=".vc_custom_1518208041283{padding-top: 60px !important;}"][vc_column width="3/4"][vc_row_inner css=".vc_custom_1518173289282{margin-bottom: 20px !important;}"][vc_column_inner width="1/3"][vc_column_text css=".vc_custom_1518173091061{border-left-width: 1px !important;padding-left: 30px !important;border-left-color: #e4e4eb !important;border-left-style: solid !important;}"]
<h4 style="color: #f53e82;">Project</h4>
LoanZ[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][vc_column_text css=".vc_custom_1518173113611{border-left-width: 1px !important;padding-left: 30px !important;border-left-color: #e4e4eb !important;border-left-style: solid !important;}"]
<h4 style="color: #f53e82;">Client</h4>
LoanZ Inc[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][vc_column_text css=".vc_custom_1518173133850{border-left-width: 1px !important;padding-left: 30px !important;border-left-color: #e4e4eb !important;border-left-style: solid !important;}"]
<h4 style="color: #f53e82;">What We Did</h4>
Research, Code, Interface[/vc_column_text][/vc_column_inner][/vc_row_inner][coinz_slider height_style="custom" height="560"][coinz_slider_item image="1334"][/coinz_slider_item][coinz_slider_item image="1330"][/coinz_slider_item][coinz_slider_item image="1327"][/coinz_slider_item][/coinz_slider][vc_column_text]
<h4 style="color: #f53e82;">Overview</h4>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
<ul>
 	<li><strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</strong></li>
 	<li><strong>Aliquam tincidunt mauris eu risus.</strong></li>
 	<li><strong>Vestibulum auctor dapibus neque.</strong></li>
 	<li><strong>Nunc dignissim risus id metus.</strong></li>
 	<li><strong>Cras ornare tristique elit.</strong></li>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
</ul>
Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor.Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.
<blockquote>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</blockquote>
Praesent dapibus, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.[/vc_column_text][vc_row_inner][vc_column_inner css=".vc_custom_1518137468686{margin-bottom: 30px !important;}"][coinz_progress_bar title="Strategy" percentage="80" animated_bg="true"][coinz_progress_bar title="Coding" percentage="95" stroke_color="#fcbe44" animated_bg="true"][coinz_progress_bar title="UI/UX Design" percentage="90" stroke_color="#333744" animated_bg="true"][/vc_column_inner][/vc_row_inner][tabs tabs_style="horizontal_2"][tab title="Challenge" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-fire"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. <strong>Aenean massa. Cum sociis natoque</strong> penatibus et magnis dis parturient montes, nascetur ridiculus mus.

Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. <em>In enim justo</em>, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. <strong><em>Integer tincidunt</em></strong>. Cras dapibus. Vivamus elementum semper nisi.[/tab][tab title="Solution" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-bulb"]<strong>Praesent dapibus</strong>, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat. <strong>Aliquam erat volutpat</strong>.

Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.
<ul>
 	<li>Vivamus vestibulum ntulla nec ante.</li>
 	<li>Praesent placerat risus quis eros.</li>
 	<li>Fusce pellentesque suscipit nibh.</li>
 	<li>Integer vitae libero ac risus egestas placerat.</li>
</ul>
Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. <strong>Nam nulla quam, gravida non</strong>, commodo a, sodales sit amet, nisi.[/tab][tab title="Results" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-star"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. <strong>Aenean massa. </strong>

<strong>Cum sociis natoque</strong> penatibus et magnis dis parturient montes, nascetur ridiculus mus.
<ul>
 	<li><strong>Aliquam tincidunt mauris eu risus.</strong></li>
 	<li><strong>Vestibulum auctor dapibus neque.</strong></li>
 	<li><strong>Nunc dignissim risus id metus.</strong></li>
 	<li><strong>Cras ornare tristique elit.</strong></li>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
 	<li><strong>Integer vitae libero ac risus egestas placerat.</strong></li>
</ul>
Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. <em>In enim justo</em>, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. <strong><em>Integer tincidunt</em></strong>. Cras dapibus. Vivamus elementum semper nisi.[/tab][tab title="Rewards" icon_type="linecons" add_icon="true" icon_linecons="vc_li vc_li-diamond"]

Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<strong> Aenean commod</strong>o ligula eget dolor.

<strong>Aenean massa. Cum sociis natoque</strong> penatibus et magnis dis parturient montes, nascetur ridiculus mus.
<ul>
 	<li><strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</strong></li>
 	<li><strong>Aliquam tincidunt mauris eu risus.</strong></li>
 	<li><strong>Vestibulum auctor dapibus neque.</strong></li>
 	<li><strong>Nunc dignissim risus id metus.</strong></li>
 	<li><strong>Cras ornare tristique elit.</strong></li>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
 	<li><strong>Integer vitae libero ac risus egestas placerat.</strong></li>
 	<li><strong>Vestibulum commodo felis quis tortor.</strong></li>
 	<li><strong>Ut aliquam sollicitudin leo.</strong></li>
 	<li><strong>Cras iaculis ultricies nulla.</strong></li>
 	<li><strong>Donec quis dui at dolor tempor interdum.</strong></li>
</ul>
[/tab][/tabs][/vc_column][vc_column width="1/4"][vc_row_inner][vc_column_inner][vc_wp_custommenu nav_menu="16"][/vc_column_inner][/vc_row_inner][coinz_subscribe css=".vc_custom_1518137079275{margin-bottom: 30px !important;}"]
<h3>Newsletter!</h3>
Subscribe and get <a href="#"><strong>Introduction in Cryptocurrency</strong></a> course for free.[/coinz_subscribe][vcw_container title="Converter" vcw_container_style="style_2"][vcw-converter symbol2="USD"][/vcw_container][/vc_column][/vc_row]';

		$work_6_content = '[vc_row full_width="stretch_row" parallax="content-moving" parallax_image="1245" parallax_speed_bg="2.5" css=".vc_custom_1518208065626{padding-top: 60px !important;padding-bottom: 60px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-2.jpg?id=1245) !important;background-position: center;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text css_animation="bounceIn" css=".vc_custom_1518208222233{margin-top: 60px !important;margin-bottom: 60px !important;}"]
<h2 style="text-align: center; color: #fff;">BiTrust</h2>
[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1518210048527{padding-top: 60px !important;padding-bottom: 60px !important;}"][vc_column width="1/2" offset="vc_hidden-sm vc_hidden-xs"][vc_column_text]
<h3>Overview</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. <strong>In nisi neque</strong>, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. <strong>Nullam mollis</strong>. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.
<blockquote>Praesent dapibus, neque id cursus faucibus, <strong>tortor neque egestas</strong> auguae, eu vulputate magna eros eu erat. Aliquam erat volutpat.</blockquote>
Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.[/vc_column_text][/vc_column][vc_column width="1/2" css=".vc_custom_1518208783476{padding-top: 90px !important;padding-bottom: 60px !important;}"][coinz_video_player image="1327"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518210167632{border-top-width: 1px !important;border-bottom-width: 1px !important;padding-top: 60px !important;padding-bottom: 60px !important;background-color: #ececec !important;border-top-color: #e4e4eb !important;border-top-style: solid !important;border-bottom-color: #e4e4eb !important;border-bottom-style: solid !important;}"][vc_column][vc_row_inner][vc_column_inner width="1/3"][vc_line_chart type="line" legend="" values="%5B%7B%22title%22%3A%22One%22%2C%22y_values%22%3A%2210%3B%2015%3B%2020%3B%2025%3B%2027%3B%2025%3B%2023%3B%2025%22%2C%22color%22%3A%22blue%22%7D%2C%7B%22title%22%3A%22Two%22%2C%22y_values%22%3A%2225%3B%2018%3B%2016%3B%2017%3B%2020%3B%2025%3B%2030%3B%2035%22%2C%22color%22%3A%22pink%22%7D%5D" animation="easeOutBounce"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text]
<h3>Praesent dapibus neque id</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. <strong>In nisi neque</strong>, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. <strong>Nullam mollis</strong>. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.

Praesent dapibus, neque id cursus faucibus, <strong>tortor neque egestas</strong> auguae, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.
<ul>
 	<li><strong>Vivamus vestibulum ntulla nec ante.</strong></li>
 	<li><strong>Praesent placerat risus quis eros.</strong></li>
 	<li><strong>Fusce pellentesque suscipit nibh.</strong></li>
 	<li><strong>Integer vitae libero ac risus egestas placerat.</strong></li>
</ul>
[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row][vc_column width="1/4" offset="vc_hidden-sm vc_hidden-xs"][/vc_column][vc_column width="1/2"][/vc_column][vc_column width="1/4" offset="vc_hidden-sm vc_hidden-xs"][/vc_column][/vc_row][vc_row css=".vc_custom_1518210244191{padding-top: 60px !important;padding-bottom: 120px !important;}"][vc_column][vc_column_text css=".vc_custom_1518209272928{margin-bottom: 0px !important;}"]
<h2 style="color: #f53e82; text-align: center; float: none;">Work Progress</h2>
[/vc_column_text][coinz_devider align="centered"][vc_row_inner][vc_column_inner width="1/3"][coinz_progress_circle title="Design" stroke_width="5" stroke_color="#f53e82" percentage="90"][/vc_column_inner][vc_column_inner width="1/3"][coinz_progress_circle title="Legal Process" stroke_width="5" stroke_color="#f53e82" percentage="70"][/vc_column_inner][vc_column_inner width="1/3"][coinz_progress_circle title="Coin Development" stroke_width="5" stroke_color="#f53e82" percentage="60"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row][vc_column][coinz_slider height_style="custom" height="670"][coinz_slider_item image="1334"][/coinz_slider_item][coinz_slider_item image="1330"][/coinz_slider_item][coinz_slider_item image="1327"][/coinz_slider_item][/coinz_slider][/vc_column][/vc_row]';

		$works = apply_filters( 'td_import_demo_works', array(
			'work_1' => array(
				'name'       => 'bitrust',
				'title'      => 'BiTrust',
				'content'    => $work_1_content,
				'meta'       => array(
					'coinz_project_description' => 'Identity verification using smart contracts',
					'coinz_project_link_type' => 'project',
					'coinz_project_link_text' => 'Read More',
					'coinz_gallery_cover' => get_option( 'work_images_1' ),
				),
			),
			'work_2' => array(
				'name'       => 'bitsters',
				'title'      => 'BitSters',
				'content'    => $work_2_content,
				'meta'       => array(
					'coinz_project_description' => 'Decentralised music platform built on Ethereum.',
					'coinz_project_link_type' => 'project',
					'coinz_project_link_text' => 'Read More',
					'coinz_gallery_cover' => get_option( 'work_images_2' ),
				),
			),
			'work_3' => array(
				'name'       => 'coinz-wallet',
				'title'      => 'CoinZ Wallet',
				'content'    => $work_3_content,
				'meta'       => array(
					'coinz_project_description' => 'Multi-cryptocurrency wallet back-end and infrastructure.',
					'coinz_project_link_type' => 'project',
					'coinz_project_link_text' => 'Read More',
					'coinz_gallery_cover' => get_option( 'work_images_3' ),
				),
			),
			'work_4' => array(
				'name'       => 'loanz',
				'title'      => 'LoanZ',
				'content'    => $work_4_content,
				'meta'       => array(
					'coinz_project_description' => 'Peer-to-peer Lending.',
					'coinz_project_link_type' => 'project',
					'coinz_project_link_text' => 'Read More',
					'coinz_gallery_cover' => get_option( 'work_images_4' ),
				),
			),
			'work_5' => array(
				'name'       => 'mycoinz',
				'title'      => 'MyCoinZ',
				'content'    => $work_5_content,
				'meta'       => array(
					'coinz_project_description' => 'Cloud mining, a new concept in which you receive income without big risks when investing, extracting crypto currency on equipment installed remotely.',
					'coinz_project_link_type' => 'project',
					'coinz_project_link_text' => 'Read More',
					'coinz_gallery_cover' => get_option( 'work_images_5' ),
				),
			),
			'work_6' => array(
				'name'       => 'znioc',
				'title'      => 'ZnioC',
				'content'    => $work_6_content,
				'meta'       => array(
					'coinz_project_description' => 'Anti-fraud detection using multi-signature wallets.',
					'coinz_project_link_type' => 'project',
					'coinz_project_link_text' => 'Read More',
					'coinz_gallery_cover' => get_option( 'work_images_6' ),
				),
			),
		) );

		$work_num = 0;
		foreach ( $works as $key => $work ) {

			$work_num++;
			
			$post_data = array(
				'post_status'    => 'publish',
				'post_type'      => 'work',
				'post_content'   => $work['content'],
				'post_name'      => $work['name'],
				'post_title'     => $work['title'],
				'comment_status' => 'closed',
			);
			$post_id = wp_insert_post( $post_data );

			$meta = $work['meta'];

			if( !empty($meta) ) {

				foreach( $meta as $key => $meta_item ) {

					update_post_meta( $post_id, $key, $meta_item );

				}

			}

		}

		$response['html'] = ob_get_clean();
	  	echo json_encode($response);
		exit;
        // End import work

	}

	/**
	 * Create properties that the plugin relies on, storing property IDs in variables.
	 */
	public static function import_demo_testimonials() {

		$testimonials = apply_filters( 'coinz_create_demo_testimonials', array(
			'testimonial_1' => array(
				'testimonial_num'  => '1',
				'name'       => _x( 'alan-poe', 'Page slug', 'coinz' ),
				'title'      => _x( 'Alan Poe', 'Page title', 'coinz' ),
				'content'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eleifend nunc sem, sit amet luctus tellus tempus tempor. Interdum et malesuada fames ac ante ipsum primis in faucibus.',
				'coinz_testimonial_position' => 'CEO Tesla Motors',
			),
			'testimonial_2' => array(
				'testimonial_num'  => '2',
				'name'       => _x( 'chris-derosa', 'Page slug', 'coinz' ),
				'title'      => _x( 'Chris DeRosa', 'Page title', 'coinz' ),
				'content'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eleifend nunc sem, sit amet luctus tellus tempus tempor. Interdum et malesuada fames ac ante ipsum primis in faucibus.',
				'coinz_testimonial_position' => 'CEO Microsoft',
			),
			'testimonial_3' => array(
				'testimonial_num'  => '3',
				'name'       => _x( 'helen-mcdonald', 'Page slug', 'coinz' ),
				'title'      => _x( 'Helen McDonald', 'Page title', 'coinz' ),
				'content'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eleifend nunc sem, sit amet luctus tellus tempus tempor. Interdum et malesuada fames ac ante ipsum primis in faucibus.',
				'coinz_testimonial_position' => 'CEO Google',
			),
		) );

		foreach ( $testimonials as $key => $testimonial ) {
			
			$post_data = array(
				'post_status'    => 'publish',
				'post_type'      => 'testimonial',
				'post_content'   => $testimonial['content'],
				'post_author'    => 1,
				'post_name'      => $testimonial['name'],
				'post_title'     => $testimonial['title'],
				'comment_status' => 'closed',
			);
			$post_id = wp_insert_post( $post_data );

			if( !empty($testimonial['coinz_testimonial_position']) ) {

				update_post_meta( $post_id, 'coinz_testimonial_position', $testimonial['coinz_testimonial_position'] );

			}

		}

	}

	/**
	 * Create properties that the plugin relies on, storing property IDs in variables.
	 */
	public static function import_demo_team() {

		$team_1_content = '[vc_row css=".vc_custom_1517353986668{margin-top: 30px !important;}"][vc_column width="3/4"][vc_row_inner equal_height="yes" content_placement="bottom"][vc_column_inner width="1/3"][vc_single_image image="931" img_size="400x260"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css=".vc_custom_1517354130810{padding-bottom: 35px !important;}"]
<h2 class="coinz-single-team-title">Maria Bush</h2>
<div class="coinz-alt-devider"></div>
<div class="coinz-team-member-position">Founder &amp; CEO</div>
[/vc_column_text][/vc_column_inner][/vc_row_inner][coinz_devider version="version_3" align="left" css=".vc_custom_1517354229244{margin-bottom: 20px !important;}"][vc_column_text]
<h3>Biography</h3>
[/vc_column_text][vc_column_text]Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
<blockquote>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</blockquote>
Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.[/vc_column_text][coinz_devider version="version_3" align="left" css=".vc_custom_1517354229244{margin-bottom: 20px !important;}"][vc_column_text]
<h3>Education</h3>
[/vc_column_text][vc_column_text]
<ul>
 	<li>MBA, University of Phoenix</li>
 	<li>BS, engineering, Technical University of Cambridge</li>
 	<li>Master Degree in Business Administration</li>
 	<li>Certification from Institute of Certified Professional Managers</li>
</ul>
[/vc_column_text][coinz_devider version="version_3" align="left" css=".vc_custom_1517354229244{margin-bottom: 20px !important;}"][vc_column_text]
<h3>Work Experience</h3>
[/vc_column_text][vc_column_text]
<ul>
 	<li><strong>2006 - 2008</strong> - Pellentesque accumsan sodales posuere sit amet volutpat dictum</li>
 	<li><strong>2008 - 2010</strong> - Aliquam nisi nisl, scelerisque eu finibus id sit amet dictum volutpat</li>
 	<li><strong>2010 - 2015</strong> - Fusce rhoncus erat quis elementum tincidunt Interdum masuada</li>
 	<li><strong>2015 - Present</strong> - Suspendisse non ullamcorper quam Interdum et malesuada fames</li>
</ul>
[/vc_column_text][coinz_devider version="version_3" align="left" css=".vc_custom_1517354229244{margin-bottom: 20px !important;}"][vc_column_text]
<h3>Contact Info</h3>
[/vc_column_text][vc_column_text]
<ul>
 	<li><strong>Office</strong> (123) 1234 77 999</li>
 	<li><strong>Cell</strong> (123) 1234 77 888</li>
 	<li><strong>E-mail</strong> info@yourcompany.com</li>
</ul>
[/vc_column_text][vc_row_inner css=".vc_custom_1517353514124{padding-top: 10px !important;padding-right: 30px !important;padding-bottom: 10px !important;padding-left: 30px !important;background-color: #ececec !important;}"][vc_column_inner][contact-form-7 id="4"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/4"][coinz_subscribe css=".vc_custom_1517430463292{margin-bottom: 30px !important;}"]
<h3>Newsletter!</h3>
Subscribe and get <a href="#"><strong>Introduction in Cryptocurrency</strong></a> course for free.[/coinz_subscribe][vcw_container title="Converter" vcw_container_style="style_2"][vcw-converter symbol2="USD"][/vcw_container][/vc_column][/vc_row]';

		$team_2_content = '[vc_row][vc_column][vc_column_text]
<h3>Biography</h3>
[/vc_column_text][vc_column_text]Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
<blockquote>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</blockquote>
Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.[/vc_column_text][vc_column_text]
<h3>Education</h3>
[/vc_column_text][vc_column_text]

MBA, University of Phoenix
BS, engineering, Technical University of Cambridge
Master Degree in Business Administration
Certification from Institute of Certified Professional Managers

[/vc_column_text][vc_column_text]
<h3>Work Experience</h3>
[/vc_column_text][vc_column_text]

2006 - 2008 - Pellentesque accumsan sodales posuere sit amet volutpat dictum
2008 - 2010 - Aliquam nisi nisl, scelerisque eu finibus id sit amet dictum volutpat
2010 - 2015 - Fusce rhoncus erat quis elementum tincidunt Interdum masuada
2015 - Present - Suspendisse non ullamcorper quam Interdum et malesuada fames
[/vc_column_text][vc_column_text]
<h3>Contact Info</h3>
[/vc_column_text][vc_column_text]

Office (123) 1234 77 999
Cell (123) 1234 77 888
Email info@yourcompany.com
[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1517332415171{padding-top: 10px !important;padding-right: 30px !important;padding-bottom: 10px !important;padding-left: 30px !important;background-color: #ececec !important;}"][vc_column][contact-form-7 id="4"][/vc_column][/vc_row]';

		$team_3_content = '[vc_row][vc_column][vc_column_text]
<h3 class="vc_custom_heading no_stripe remove_padding vc_custom_1456308478646 text_align_left">Biography</h3>
[/vc_column_text][vc_column_text]Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
<blockquote>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</blockquote>
Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.[/vc_column_text][vc_column_text]
<div class="vc_custom_heading no_stripe remove_padding vc_custom_1456308478646 text_align_left">
<h3>Education</h3>
</div>
[/vc_column_text][vc_column_text]
<div class="vc_custom_heading no_stripe remove_padding vc_custom_1456308478646 text_align_left">
<ul>
 	<li>MBA, University of Phoenix</li>
 	<li>BS, engineering, Technical University of Cambridge</li>
 	<li>Master Degree in Business Administration</li>
 	<li>Certification from Institute of Certified Professional Managers</li>
</ul>
</div>
<div class="wpb_text_column wpb_content_element ">
<div class="wpb_wrapper"></div>
<div class="vc_custom_heading no_stripe remove_padding vc_custom_1456308478646 text_align_left"></div>
<div class="wpb_text_column wpb_content_element "></div>
</div>
[/vc_column_text][vc_column_text]
<div class="wpb_text_column wpb_content_element ">
<div class="vc_custom_heading no_stripe remove_padding vc_custom_1456308478646 text_align_left">
<h3>Work Experience</h3>
</div>
</div>
[/vc_column_text][vc_column_text]
<div class="wpb_text_column wpb_content_element ">
<div class="wpb_wrapper">
<ul class="small_margin">
 	<li><strong>2006 - 2008</strong> - Pellentesque accumsan sodales posuere sit amet volutpat dictum</li>
 	<li><strong>2008 - 2010</strong> - Aliquam nisi nisl, scelerisque eu finibus id sit amet dictum volutpat</li>
 	<li><strong>2010 - 2015</strong> - Fusce rhoncus erat quis elementum tincidunt Interdum masuada</li>
 	<li><strong>2015 - Present</strong> - Suspendisse non ullamcorper quam Interdum et malesuada fames</li>
</ul>
</div>
</div>
[/vc_column_text][vc_column_text]
<h3 class="vc_custom_heading no_stripe remove_padding vc_custom_1456308478646 text_align_left">Contact Info</h3>
[/vc_column_text][vc_column_text]
<div class="wpb_text_column wpb_content_element ">
<div class="wpb_wrapper">
<ul>
 	<li><strong>Office</strong> (123) 1234 77 999</li>
 	<li><strong>Cell</strong> (123) 1234 77 888</li>
 	<li><strong>Email</strong> info@yourcompany.com</li>
</ul>
</div>
</div>
[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1517332415171{padding-top: 10px !important;padding-right: 30px !important;padding-bottom: 10px !important;padding-left: 30px !important;background-color: #ececec !important;}"][vc_column][contact-form-7 id="4"][/vc_column][/vc_row]';

		$team_4_content = '[vc_row][vc_column][vc_column_text]
<h3>Biography</h3>
[/vc_column_text][vc_column_text]Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
<blockquote>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</blockquote>
Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.[/vc_column_text][vc_column_text]
<h3>Education</h3>
[/vc_column_text][vc_column_text]

MBA, University of Phoenix
BS, engineering, Technical University of Cambridge
Master Degree in Business Administration
Certification from Institute of Certified Professional Managers

[/vc_column_text][vc_column_text]
<h3>Work Experience</h3>
[/vc_column_text][vc_column_text]

2006 - 2008 - Pellentesque accumsan sodales posuere sit amet volutpat dictum
2008 - 2010 - Aliquam nisi nisl, scelerisque eu finibus id sit amet dictum volutpat
2010 - 2015 - Fusce rhoncus erat quis elementum tincidunt Interdum masuada
2015 - Present - Suspendisse non ullamcorper quam Interdum et malesuada fames
[/vc_column_text][vc_column_text]
<h3>Contact Info</h3>
[/vc_column_text][vc_column_text]

Office (123) 1234 77 999
Cell (123) 1234 77 888
Email info@yourcompany.com
[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1517332415171{padding-top: 10px !important;padding-right: 30px !important;padding-bottom: 10px !important;padding-left: 30px !important;background-color: #ececec !important;}"][vc_column][contact-form-7 id="4"][/vc_column][/vc_row]';

		$team_5_content = '[vc_row][vc_column][vc_column_text]
<h3>Biography</h3>
[/vc_column_text][vc_column_text]Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
<blockquote>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</blockquote>
Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.[/vc_column_text][vc_column_text]
<h3>Education</h3>
[/vc_column_text][vc_column_text]

MBA, University of Phoenix
BS, engineering, Technical University of Cambridge
Master Degree in Business Administration
Certification from Institute of Certified Professional Managers

[/vc_column_text][vc_column_text]
<h3>Work Experience</h3>
[/vc_column_text][vc_column_text]

2006 - 2008 - Pellentesque accumsan sodales posuere sit amet volutpat dictum
2008 - 2010 - Aliquam nisi nisl, scelerisque eu finibus id sit amet dictum volutpat
2010 - 2015 - Fusce rhoncus erat quis elementum tincidunt Interdum masuada
2015 - Present - Suspendisse non ullamcorper quam Interdum et malesuada fames
[/vc_column_text][vc_column_text]
<h3>Contact Info</h3>
[/vc_column_text][vc_column_text]

Office (123) 1234 77 999
Cell (123) 1234 77 888
Email info@yourcompany.com
[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1517332415171{padding-top: 10px !important;padding-right: 30px !important;padding-bottom: 10px !important;padding-left: 30px !important;background-color: #ececec !important;}"][vc_column][contact-form-7 id="4"][/vc_column][/vc_row]';

		$team_6_content = '[vc_row][vc_column][vc_column_text]
<h3>Biography</h3>
[/vc_column_text][vc_column_text]Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
<blockquote>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</blockquote>
Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.[/vc_column_text][vc_column_text]
<h3>Education</h3>
[/vc_column_text][vc_column_text]

MBA, University of Phoenix
BS, engineering, Technical University of Cambridge
Master Degree in Business Administration
Certification from Institute of Certified Professional Managers

[/vc_column_text][vc_column_text]
<h3>Work Experience</h3>
[/vc_column_text][vc_column_text]

2006 - 2008 - Pellentesque accumsan sodales posuere sit amet volutpat dictum
2008 - 2010 - Aliquam nisi nisl, scelerisque eu finibus id sit amet dictum volutpat
2010 - 2015 - Fusce rhoncus erat quis elementum tincidunt Interdum masuada
2015 - Present - Suspendisse non ullamcorper quam Interdum et malesuada fames
[/vc_column_text][vc_column_text]
<h3>Contact Info</h3>
[/vc_column_text][vc_column_text]

Office (123) 1234 77 999
Cell (123) 1234 77 888
Email info@yourcompany.com
[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1517332415171{padding-top: 10px !important;padding-right: 30px !important;padding-bottom: 10px !important;padding-left: 30px !important;background-color: #ececec !important;}"][vc_column][contact-form-7 id="4"][/vc_column][/vc_row]';

		$teams = apply_filters( 'coinz_create_demo_team', array(
			'team_1' => array(
				'name'       => _x( 'maria-bush', 'Page slug', 'coinz' ),
				'title'      => _x( 'Maria Bush', 'Page title', 'coinz' ),
				'content'    => $team_1_content,
				'image'      => get_option( 'team_images_1' ),
				'meta'       => array(
					'coinz_position' => 'Founder & CEO',
					'coinz_facebook_url' => '#',
					'coinz_twitter_url' => '#',
					'coinz_google_plus_url' => '#',
					'coinz_linked_in_url' => '#',
				),
			),
			'team_2' => array(
				'name'       => _x( 'helen-lopez', 'Page slug', 'coinz' ),
				'title'      => _x( 'Helen Lopez', 'Page title', 'coinz' ),
				'content'    => $team_2_content,
				'image'      => get_option( 'team_images_2' ),
				'meta'       => array(
					'coinz_position' => 'CFO',
					'coinz_facebook_url' => '#',
					'coinz_twitter_url' => '#',
					'coinz_google_plus_url' => '#',
					'coinz_linked_in_url' => '#',
				),
			),
			'team_3' => array(
				'name'       => _x( 'alex-friedman', 'Page slug', 'coinz' ),
				'title'      => _x( 'Alex Friedman', 'Page title', 'coinz' ),
				'content'    => $team_3_content,
				'image'      => get_option( 'team_images_3' ),
				'meta'       => array(
					'coinz_position' => 'Sales and Marketing',
					'coinz_facebook_url' => '#',
					'coinz_twitter_url' => '#',
					'coinz_google_plus_url' => '#',
					'coinz_linked_in_url' => '#',
				),
			),
			'team_4' => array(
				'name'       => _x( 'john-stanley', 'Page slug', 'coinz' ),
				'title'      => _x( 'John Stanley', 'Page title', 'coinz' ),
				'content'    => $team_4_content,
				'image'      => get_option( 'team_images_4' ),
				'meta'       => array(
					'coinz_position' => 'Cryptocurrency Consultant',
					'coinz_facebook_url' => '#',
					'coinz_twitter_url' => '#',
					'coinz_google_plus_url' => '#',
					'coinz_linked_in_url' => '#',
				),
			),
			'team_5' => array(
				'name'       => _x( 'berry-allen', 'Page slug', 'coinz' ),
				'title'      => _x( 'Berry Allen', 'Page title', 'coinz' ),
				'content'    => $team_5_content,
				'image'      => get_option( 'team_images_5' ),
				'meta'       => array(
					'coinz_position' => 'Blockchain Expert',
					'coinz_facebook_url' => '#',
					'coinz_twitter_url' => '#',
					'coinz_google_plus_url' => '#',
					'coinz_linked_in_url' => '#',
				),
			),
			'team_6' => array(
				'name'       => _x( 'bruce-wayne', 'Page slug', 'coinz' ),
				'title'      => _x( 'Bruce Wayne', 'Page title', 'coinz' ),
				'content'    => $team_6_content,
				'image'      => get_option( 'team_images_6' ),
				'meta'       => array(
					'coinz_position' => 'Security Expert',
					'coinz_facebook_url' => '#',
					'coinz_twitter_url' => '#',
					'coinz_google_plus_url' => '#',
					'coinz_linked_in_url' => '#',
				),
			),
		) );

		foreach ( $teams as $key => $team ) {
			
			$post_data = array(
				'post_status'    => 'publish',
				'post_type'      => 'team',
				'post_content'   => $team['content'],
				'post_author'    => 1,
				'post_name'      => $team['name'],
				'post_title'     => $team['title'],
				'comment_status' => 'closed',
			);
			$post_id = wp_insert_post( $post_data );

			if( !empty($team['image']) ) {
				set_post_thumbnail( $post_id, $team['image'] );
			}

			$meta = $team['meta'];
			if( !empty($meta) ) {
				foreach( $meta as $key => $meta_item ) {
					update_post_meta( $post_id, $key, $meta_item );
				}
			}

		}

	}

	/**
	 * Create properties that the plugin relies on, storing property IDs in variables.
	 */
	public static function import_demo_partners() {

		$partners = apply_filters( 'coinz_create_demo_partners', array(
			'partner_1' => array(
				'name'      => _x( 'partner-1', 'Page slug', 'coinz' ),
				'title'     => _x( 'Partner #1', 'Page title', 'coinz' ),
				'url'   	=> '#',
				'image'  	=> get_option( 'partners_images_1' ),
			),
			'partner_2' => array(
				'name'      => _x( 'partner-2', 'Page slug', 'coinz' ),
				'title'     => _x( 'Partner #2', 'Page title', 'coinz' ),
				'url'   	=> '#',
				'image'  	=> get_option( 'partners_images_2' ),
			),
			'partner_3' => array(
				'name'      => _x( 'partner-3', 'Page slug', 'coinz' ),
				'title'     => _x( 'Partner #3', 'Page title', 'coinz' ),
				'url'   	=> '#',
				'image'  	=> get_option( 'partners_images_3' ),
			),
			'partner_4' => array(
				'name'      => _x( 'partner-4', 'Page slug', 'coinz' ),
				'title'     => _x( 'Partner #4', 'Page title', 'coinz' ),
				'url'   	=> '#',
				'image'  	=> get_option( 'partners_images_4' ),
			),
			'partner_5' => array(
				'name'      => _x( 'partner-5', 'Page slug', 'coinz' ),
				'title'     => _x( 'Partner #5', 'Page title', 'coinz' ),
				'url'   	=> '#',
				'image'  	=> get_option( 'partners_images_5' ),
			),
			'partner_6' => array(
				'name'      => _x( 'partner-6', 'Page slug', 'coinz' ),
				'title'     => _x( 'Partner #6', 'Page title', 'coinz' ),
				'url'   	=> '#',
				'image'  	=> get_option( 'partners_images_6' ),
			),
			'partner_7' => array(
				'name'      => _x( 'partner-7', 'Page slug', 'coinz' ),
				'title'     => _x( 'Partner #7', 'Page title', 'coinz' ),
				'url'   	=> '#',
				'image'  	=> get_option( 'partners_images_7' ),
			),
			'partner_8' => array(
				'name'      => _x( 'partner-8', 'Page slug', 'coinz' ),
				'title'     => _x( 'Partner #8', 'Page title', 'coinz' ),
				'url'   	=> '#',
				'image'  	=> get_option( 'partners_images_8' ),
			),
		) );

		foreach ( $partners as $key => $partner ) {
			
			$post_data = array(
				'post_status'    => 'publish',
				'post_type'      => 'partners',
				'post_author'    => 1,
				'post_name'      => $partner['name'],
				'post_title'     => $partner['title'],
				'comment_status' => 'closed',
			);
			$post_id = wp_insert_post( $post_data );

			if( !empty($partner['url']) ) {
				update_post_meta( $post_id, 'coinz_partner_url', $partner['url'] );
			}

			if( !empty($partner['image']) ) {
				set_post_thumbnail( $post_id, $partner['image'] );
			}

		}

	}

	/**
	 * Create properties that the plugin relies on, storing property IDs in variables.
	 */
	public static function import_demo_posts() { 

		$post_content = '<b>Sed residamus, inquit, si placet.</b> Sed quae tandem ista ratio est? Alterum significari idem, ut si diceretur, officia media omnia aut pleraque servantem vivere. Cur tantas regiones barbarorum pedibus obiit, tot maria transmisit? Quid autem habent admirationis, cum prope accesseris? <a href="http://loripsum.net/" target="_blank" rel="noopener">Sed haec omittamus;</a>

Deinde prima illa, quae in congressu solemus: Quid tu, inquit, huc? Est enim tanti philosophi tamque nobilis audacter sua decreta defendere. Quis animo aequo videt eum, quem inpure ac flagitiose putet vivere? Neminem videbis ita laudatum, ut artifex callidus comparandarum voluptatum diceretur. <a href="http://loripsum.net/" target="_blank" rel="noopener">Quam nemo umquam voluptatem appellavit, appellat;</a> <b>Egone quaeris, inquit, quid sentiam?</b> Si quae forte-possumus. Quae similitudo in genere etiam humano apparet.

<iframe src="https://www.youtube.com/embed/J8wWvY4c0dc" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe>

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Omnia contraria, quos etiam insanos esse vultis. Si verbum sequimur, primum longius verbum praepositum quam bonum. <b>Proclivi currit oratio.</b> Non autem hoc: igitur ne illud quidem. Neque enim civitas in seditione beata esse potest nec in discordia dominorum domus; Duo Reges: constructio interrete. Quamquam id quidem, infinitum est in hac urbe; Tollenda est atque extrahenda radicitus. Ab his oratores, ab his imperatores ac rerum publicarum principes extiterunt. Ac ne plura complectar-sunt enim innumerabilia-, bene laudata virtus voluptatis aditus intercludat necesse est. An ea, quae per vinitorem antea consequebatur, per se ipsa curabit?

<a href="http://alexgurghis.com/themes/eclassy/wp-content/uploads/2016/01/photo-1444881421460-d838c3b98f95-1.jpeg" rel="attachment wp-att-59"><img class="alignnone size-full wp-image-59" src="http://alexgurghis.com/themes/eclassy/wp-content/uploads/2016/01/photo-1444881421460-d838c3b98f95-1.jpeg" alt="Brooklyn Bridge" width="2241" height="1681" /></a>

Nam his libris eum malo quam reliquo ornatu villae delectari. Quod autem in homine praestantissimum atque optimum est, id deseruit. Quid, si etiam iucunda memoria est praeteritorum malorum? Respondent extrema primis, media utrisque, omnia omnibus. <b>Sed residamus, inquit, si placet.</b> Sed quae tandem ista ratio est? Alterum significari idem, ut si diceretur, officia media omnia aut pleraque servantem vivere. Cur tantas regiones barbarorum pedibus obiit, tot maria transmisit? Quid autem habent admirationis, cum prope accesseris? <a href="http://loripsum.net/" target="_blank" rel="noopener">Sed haec omittamus;</a>

Eam tum adesse, cum dolor omnis absit; Et quidem iure fortasse, sed tamen non gravissimum est testimonium multitudinis. Callipho ad virtutem nihil adiunxit nisi voluptatem, Diodorus vacuitatem doloris. <mark>Sint modo partes vitae beatae.</mark> Iam in altera philosophiae parte. Apud ceteros autem philosophos, qui quaesivit aliquid, tacet; Conferam tecum, quam cuique verso rem subicias; Ita enim vivunt quidam, ut eorum vita refellatur oratio. Ergo adhuc, quantum equidem intellego, causa non videtur fuisse mutandi nominis.
<blockquote cite="http://loripsum.net/">Si vero id etiam explanare velles apertiusque diceres nihil eum fecisse nisi voluptatis causa, quo modo eum tandem laturum fuisse existimas?</blockquote>
Nummus in Croesi divitiis obscuratur, pars est tamen divitiarum. Tum mihi Piso: Quid ergo? Ita fit cum gravior, tum etiam splendidior oratio. Fortitudinis quaedam praecepta sunt ac paene leges, quae effeminari virum vetant in dolore.';

		$posts = apply_filters( 'coinz_create_demo_posts', array(
			'post_1' => array(
				'name'       		=> _x( 'crypto-fund-says-bitcoin-will-be-the-biggest-bubble-ever', 'Page slug', 'coinz' ),
				'title'      		=> _x( 'Crypto Fund Says Bitcoin Will Be the Biggest Bubble Ever', 'Page title', 'coinz' ),
				'image'      		=> get_option( 'work_images_1' ),
				'content'    		=> $post_content,
				'editors_pick_post' => 'off',
			),
			'post_2' => array(
				'name'       		=> _x( 'time-to-stop-chasing-trends-and-start-building', 'Page slug', 'coinz' ),
				'title'      		=> _x( 'Time to Stop Chasing Trends and Start Building', 'Page title', 'coinz' ),
				'image'      		=> get_option( 'work_images_2' ),
				'content'    		=> $post_content,
				'editors_pick_post' => 'off',
			),
			'post_3' => array(
				'name'       		=> _x( 'sweden-settles-debt-via-bitcoin', 'Page slug', 'coinz' ),
				'title'      		=> _x( 'Sweden Settles Debt via Bitcoin', 'Page title', 'coinz' ),
				'image'      		=> get_option( 'work_images_3' ),
				'content'    		=> $post_content,
				'editors_pick_post' => 'on',
			),
			'post_4' => array(
				'name'       		=> _x( 'nvidia-ceo-says-cryptocurrency-is-not-going-to-go-away', 'Page slug', 'coinz' ),
				'title'      		=> _x( "Nvidia CEO Says Cryptocurrency Is 'Not Going to Go Away'", 'Page title', 'coinz' ),
				'image'      		=> get_option( 'work_images_4' ),
				'content'    		=> $post_content,
				'editors_pick_post' => 'on',
			),
			'post_5' => array(
				'name'       		=> _x( 'everything-you-need-to-know-about-bitcoin', 'Page slug', 'coinz' ),
				'title'      		=> _x( "Everything you need to know about bitcoin", 'Page title', 'coinz' ),
				'image'      		=> get_option( 'work_images_5' ),
				'content'    		=> $post_content,
				'editors_pick_post' => 'off',
			),
			'post_6' => array(
				'name'       		=> _x( 'russian-scientists-arrested-for-crypto-mining-at-nuclear-lab', 'Page slug', 'coinz' ),
				'title'      		=> _x( "Russian Scientists Arrested for Crypto Mining at Nuclear Lab", 'Page title', 'coinz' ),
				'image'      		=> get_option( 'work_images_6' ),
				'content'    		=> $post_content,
				'editors_pick_post' => 'off',
			),
			'post_7' => array(
				'name'       		=> _x( 'arizona-moves-one-step-closer-to-accepting-bitcoin-for-taxes', 'Page slug', 'coinz' ),
				'title'      		=> _x( "Arizona Moves One Step Closer to Accepting Bitcoin for Taxes", 'Page title', 'coinz' ),
				'image'      		=> get_option( 'work_images_1' ),
				'content'    		=> $post_content,
				'editors_pick_post' => 'on',
			),
			'post_8' => array(
				'name'       		=> _x( 'korean-exchange-bithumb-is-accepting-new-users-again', 'Page slug', 'coinz' ),
				'title'      		=> _x( "Korean Exchange Bithumb Is Accepting New Users Again", 'Page title', 'coinz' ),
				'image'      		=> get_option( 'work_images_2' ),
				'content'    		=> $post_content,
				'editors_pick_post' => 'on',
			),
			'post_9' => array(
				'name'       		=> _x( 'binance-resumes-services-as-system-upgrade-completes', 'Page slug', 'coinz' ),
				'title'      		=> _x( "Binance Resumes Services as System Upgrade Completes", 'Page title', 'coinz' ),
				'image'      		=> get_option( 'work_images_3' ),
				'content'    		=> $post_content,
				'editors_pick_post' => 'on',
			),
			'post_10' => array(
				'name'       		=> _x( 'maxwell-eyes-bitcoin-smart-contracts-after-blockstream', 'Page slug', 'coinz' ),
				'title'      		=> _x( "Maxwell Eyes Bitcoin Smart Contracts After Blockstream", 'Page title', 'coinz' ),
				'image'      		=> get_option( 'work_images_4' ),
				'content'    		=> $post_content,
				'editors_pick_post' => 'on',
			),
		) );

		foreach ( $posts as $key => $post ) {
			
			$post_data = array(
				'post_status'    => 'publish',
				'post_type'      => 'post',
				'post_content'   => $post['content'],
				'post_author'    => 1,
				'post_name'      => $post['name'],
				'post_title'     => $post['title'],
			);
			$post_id = wp_insert_post( $post_data );

			set_post_thumbnail( $post_id, $post['image'] );
			update_post_meta( $post_id, 'editors_pick_post', $post['editors_pick_post'] );

		}

	}

	//
	public static function coinz_create_primary_menu( $slug, $page_id, $page_title, $parent_name, $is_parent, $menu_badge, $type, $url ) {

		$name = 'CoinZ Main Menu';
		$menu_id = wp_create_nav_menu($name);

		$menu = get_term_by( 'name', $name, 'nav_menu' );

		if( !empty($parent_name) ) {
			$parent_id = get_option( $parent_name.'_id' );
		} else {
			$parent = '';
			$parent_id = '';
		}

		if( $type == "custom" ) {
			$menuitem_id = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' => $page_title,
				'menu-item-object-id' => $page_id,
				'menu-item-db-id' => 0,
				'menu-item-parent-id' => $parent_id,
				'menu-item-url' => $url,
				'menu-item-status' => 'publish',
				'menu-item-type' => 'custom',
			));
		} else {
			$page_name = get_the_title( $page_id );
			$menuitem_id = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' => $page_name,
				'menu-item-object-id' => $page_id,
				'menu-item-db-id' => 0,
				'menu-item-parent-id' => $parent_id,
				'menu-item-object' => 'page',
				'menu-item-status' => 'publish',
				'menu-item-type' => 'post_type',
			));
		}

		if( $is_parent ) {
			update_option( $slug.'_id', $menuitem_id );
		}
		if( $menu_badge ) {
			update_post_meta( $menuitem_id, '_menu_item_'.$menu_badge, $menu_badge );
		}

		//then you set the wanted theme location
		$locations = get_theme_mod('nav_menu_locations');
		$locations['primary'] = $menu->term_id;
		set_theme_mod( 'nav_menu_locations', $locations );

	}

	public static function coinz_create_demo_page( $slug, $option = '', $page_title = '', $page_content = '', $is_parent = 0, $post_parent = 0, $template = '', $theme_mod = '', $homepage = 0, $hide_title = 0, $menu_badge = 0, $type = '', $url = '#' ) {
		global $wpdb;

		$page_id = '';

		if( $type == 'page' ) {

			if( $post_parent ) {
				$page = get_page_by_path($post_parent);
				if ($page) {
			        $post_parent_id = $page->ID;
			        $post_parent_name = get_the_title($post_parent_id);
			    } else {
			        $post_parent_id = '';
			        $post_parent_name = '';
			    }
			} else {
				$post_parent_id = '';
				$post_parent_name = '';
			}

			$page_data = array(
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_author'    => 1,
				'post_name'      => $slug,
				'post_title'     => $page_title,
				'post_content'   => $page_content,
				'post_parent'    => $post_parent_id,
				'comment_status' => 'closed',
			);
			$page_id = wp_insert_post( $page_data );

			if ( $option ) {
				update_option( $option, $page_id );
			}

			if( $template ) {
				update_post_meta( $page_id, '_wp_page_template', $template );
			}

			if( $theme_mod ) {
				set_theme_mod($theme_mod, $page_id);
			}

			if( $homepage ) {
				update_option( 'page_on_front', $page_id );
				update_option( 'show_on_front', 'page' );
			}

			if( $hide_title ) {
				update_post_meta( $page_id, 'page_title', $hide_title );
			}

			self::coinz_create_primary_menu( $slug, $page_id, $page_title, $post_parent, $is_parent, $menu_badge, $type, $url );

			return $page_id;

		} elseif( $type == 'custom' ){

			self::coinz_create_primary_menu( $slug, $page_id, $page_title, $post_parent, $is_parent, $menu_badge, $type, $url );

		}

	}

	/**
	 * Create properties that the plugin relies on, storing property IDs in variables.
	 */
	public static function import_demo_pages() { 

		$homepage = '[vc_row full_width="stretch_row" full_height="yes" parallax="content-moving" parallax_image="1250" css=".vc_custom_1520013070186{padding-top: 140px !important;padding-bottom: 140px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-4.jpg?id=1250) !important;background-position: center;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_single_image image="1209" img_size="302x100" alignment="center" css_animation="bounceIn"][vc_column_text css=".vc_custom_1517964564250{margin-top: 30px !important;margin-bottom: 30px !important;}"]
<h2 style="color: #ffffff; text-align: center;">Blockchain Technologies,
FinTech and Digital Currencies Investments</h2>
<p style="color: #ffffff; text-align: center;">Our company specializes in Cryptocurrency, FinTech and Blockchain software development services,
Initial Coin Offering (ICO) and Digital Currencies Investments</p>
[/vc_column_text][coinz_button title="Learn MORE" align="center" google_fonts="font_family:Arvo%3Aregular%2Citalic%2C700%2C700italic|font_style:700%20bold%20regular%3A700%3Anormal" i_align="right" icon_fontawesome="fa fa-chevron-right" button_size="small" add_icon="true" link="url:%23|||"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1520013276013{padding-top: 60px !important;padding-bottom: 60px !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner css=".vc_custom_1517150043628{padding-bottom: 20px !important;}"][vc_column_inner][vc_column_text el_class="coinz-section-title"]
<h2 style="text-align: center;">Our Services</h2>
[/vc_column_text][coinz_devider version="version_3" css=".vc_custom_1517246816416{margin-bottom: 30px !important;}"][vc_column_text]
<p style="text-align: center;"><span style="color: #64666b;">We have more than 20 years of experience building and reviewing security applications,
and have active in the cryptocurrency field. We have designed new bitcoin-related cryptocurrency protocols and discovered
and reported various security vulnerabilities.</span></p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][coinz_icon_box title="Smart Contracts" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-like"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Smart Contracts Audit" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-bulb"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Blockchain Development" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-data"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][coinz_icon_box title="Exchanges" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_fontawesome="fa fa-exchange"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Training" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-user"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Wallets" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-vallet"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1517955645066{padding-top: 60px !important;padding-bottom: 60px !important;background: #ececec url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-6.jpg?id=1265) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="45" prenumber=" $" afternumber="M" title="Transactions" custom_color="#ffffff" custom_title_color="#f53e82"][/vc_column_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="45700" afternumber="" title="CoinZ Wallets" custom_color="#ffffff" custom_title_color="#f53e82"][/vc_column_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="240" afternumber="+" title="Online Experts" custom_color="#ffffff" custom_title_color="#f53e82"][/vc_column_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="20" afternumber="+" title="Years of Experience" custom_color="#ffffff" custom_title_color="#f53e82"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1517950338822{padding-top: 120px !important;padding-bottom: 120px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-2.jpg?id=1245) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_column_text el_class="coinz-section-title"]
<h2 style="text-align: center; color: #fff;">Why CoinZ Factory</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered" devider_color="#ffffff" css=".vc_custom_1517959408704{margin-bottom: 30px !important;}"][vc_row_inner equal_height="yes" content_placement="middle" css=".vc_custom_1517957867353{padding-top: 30px !important;padding-bottom: 30px !important;}"][vc_column_inner width="1/2"][vc_column_text]
<h3 style="color: #fff;">Technical Expertise in Cryptocurrencies and Blockchain Development</h3>
[/vc_column_text][vc_column_text]
<p style="color: #f4f4f4;">Our reputation is based on our work for many top blockchain influencers.</p>
[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_single_image image="1280" img_size="320x320" alignment="center" el_class="coinz-svg-image"][/vc_column_inner][/vc_row_inner][coinz_devider version="version_3" align="centered" devider_color="#ffffff" css=".vc_custom_1517959799860{margin-bottom: 30px !important;}"][vc_row_inner equal_height="yes" content_placement="middle" css=".vc_custom_1517961309149{padding-top: 30px !important;padding-bottom: 30px !important;}"][vc_column_inner width="1/2"][vc_single_image image="1277" img_size="full" alignment="center" el_class="coinz-svg-image"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text]
<h3 style="color: #fff;">Fast Responders</h3>
[/vc_column_text][vc_column_text]
<p style="color: #f4f4f4;">We understand the time pressures of technology implementations and software development. Our team can efficiently integrate with yours to reach your goals.</p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][coinz_devider version="version_3" align="centered" devider_color="#ffffff" css=".vc_custom_1517959809676{margin-bottom: 30px !important;}"][vc_row_inner equal_height="yes" content_placement="middle" css=".vc_custom_1517961302537{padding-top: 30px !important;padding-bottom: 30px !important;}"][vc_column_inner width="1/2"][vc_column_text]
<h3 style="color: #fff;">Customizable Solutions</h3>
[/vc_column_text][vc_column_text]
<p style="color: #f4f4f4;">The market does not offer software to fit every business’ needs. We can work with you to find the best way to do what you need done. Our thorough knowledge of currently available technology allows us to write your solution on top of existing software when designing something from scratch is unnecessary.</p>
[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_single_image image="1287" img_size="full" alignment="center" el_class="coinz-svg-image"][/vc_column_inner][/vc_row_inner][coinz_devider version="version_3" align="centered" devider_color="#ffffff" css=".vc_custom_1517959820509{margin-bottom: 30px !important;}"][vc_row_inner equal_height="yes" content_placement="middle" css=".vc_custom_1517961293618{padding-top: 30px !important;padding-bottom: 30px !important;}"][vc_column_inner width="1/2"][vc_single_image image="1289" img_size="full" alignment="center" el_class="coinz-svg-image"][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text]
<h3 style="color: #fff;">Security Experts</h3>
[/vc_column_text][vc_column_text]
<p style="color: #f4f4f4;">CoinZ Factory founders come from the software security industry. All team members are familiar with security threats and know how to develop secure Smart Contracts and secure code in general. We take pride in our carefully written code.</p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][coinz_devider version="version_3" align="centered" devider_color="#ffffff" css=".vc_custom_1517959832459{margin-bottom: 30px !important;}"][vc_row_inner equal_height="yes" content_placement="middle" css=".vc_custom_1517961285963{padding-top: 30px !important;padding-bottom: 30px !important;}"][vc_column_inner width="1/2"][vc_column_text]
<h3 style="color: #fff;">Cryptocurrency Supporters</h3>
[/vc_column_text][vc_column_text]
<p style="color: #f4f4f4;">We have been playing with and working on blockchain development from the early stages. We use and accept Bitcoins. We believe in blockchain technology’s capacity to disrupt FinTech.</p>
[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_single_image image="1290" img_size="full" alignment="center" el_class="coinz-svg-image"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518042314214{padding-top: 90px !important;padding-bottom: 150px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-7.jpg?id=1296) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text el_class="coinz-section-title"]
<h2 style="text-align: center; color: #fff;">Case Studies</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered" css=".vc_custom_1518042706332{margin-bottom: 30px !important;}"][coinz_work align="centered"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1517963813659{padding-top: 90px !important;padding-bottom: 60px !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_column_text el_class="coinz-section-title"]
<h2 style="text-align: center;">Our Team</h2>
[/vc_column_text][coinz_devider version="version_3" css=".vc_custom_1517246816416{margin-bottom: 30px !important;}"][coinz_team][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518215560883{padding-top: 90px !important;padding-bottom: 120px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/01/bg-6.jpg?id=1369) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text]
<h2 style="text-align: center; color: #fff;">Testimonials</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered"][coinz_testimonial style="version_3" background="dark"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1517964996971{padding-top: 60px !important;padding-bottom: 60px !important;background-color: #ececec !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][coinz_partners style="version_3"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';

		$ico = '[vc_row full_width="stretch_row" full_height="yes" parallax="content-moving" parallax_image="1370" css_animation="none" css=".vc_custom_1518886283958{padding-top: 60px !important;padding-right: 30px !important;padding-bottom: 60px !important;padding-left: 30px !important;background: #202125 url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/01/bg-4.jpg?id=1370);}"][vc_column][vc_column_text css=".vc_custom_1517436242986{margin-bottom: 0px !important;}"]
<h2 style="text-align: center;"><span style="color: #ffffff;">Time Until ICO Close</span></h2>
[/vc_column_text][coinz_devider version="version_3" align="centered" css=".vc_custom_1517428860496{padding-bottom: 30px !important;}"][vc_column_text]
<h4 style="text-align: center;"><span style="color: #64666b;">PURCHASE 100 COINS <span class="amp">&amp;</span> GET 20% OFF.</span></h4>
[/vc_column_text][coinz_flipclock end_date="2018/05/03 12:25:10" background="dark" css=".vc_custom_1517421086530{margin-top: 30px !important;margin-bottom: 30px !important;}"][vc_column_text]
<h1 style="text-align: center;"><span style="color: #ffffff;">$123,456,789</span></h1>
<h5 style="text-align: center;"><span style="color: #64666b;">WORTH OF TOKENS BOUGHT</span></h5>
[/vc_column_text][coinz_button title="Buy Coins" align="center" google_fonts="font_family:Arvo%3Aregular%2Citalic%2C700%2C700italic|font_style:700%20bold%20regular%3A700%3Anormal" icon_fontawesome="fa fa-btc" button_size="small" add_icon="true" link="url:%23|||"][/vc_column][/vc_row][vc_row css=".vc_custom_1518720132554{margin-bottom: 60px !important;padding-top: 60px !important;}"][vc_column css_animation="none"][vc_column_text el_class="coinz-section-title"]
<h2 style="text-align: center;">Featured In</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered"][coinz_partners style="version_2" css=".vc_custom_1518720137979{border-bottom-width: 1px !important;padding-bottom: 60px !important;border-bottom-color: #e4e4eb !important;border-bottom-style: solid !important;}"][/vc_column][/vc_row][vc_row equal_height="yes"][vc_column][vc_row_inner equal_height="yes" content_placement="middle" css=".vc_custom_1518719799223{border-bottom-width: 1px !important;padding-bottom: 60px !important;border-bottom-color: #e4e4eb !important;border-bottom-style: solid !important;}"][vc_column_inner width="1/2" css=".vc_custom_1518820146753{background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bitcoin.jpg?id=1403) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" offset="vc_hidden-sm vc_hidden-xs"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1518719649490{padding: 60px !important;}"][vc_column_text css=".vc_custom_1518650371103{margin-bottom: 0px !important;}" el_class="coinz-section-title"]
<h2>About CoinZ</h2>
[/vc_column_text][coinz_devider version="version_3" align="left"][vc_column_text]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
<ul>
 	<li><strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</strong></li>
 	<li><strong>Aliquam tincidunt mauris eu risus.</strong></li>
 	<li><strong>Vestibulum auctor dapibus neque.</strong></li>
 	<li><strong>Nunc dignissim risus id metus.</strong></li>
 	<li><strong>Cras ornare tristique elit.</strong></li>
</ul>
Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est.[/vc_column_text][coinz_button title="Learn More" align="left" google_fonts="font_family:Arvo%3Aregular%2Citalic%2C700%2C700italic|font_style:700%20bold%20regular%3A700%3Anormal" i_align="right" icon_fontawesome="fa fa-chevron-right" button_size="small" add_icon="true" link="url:%23|||"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row equal_height="yes" css=".vc_custom_1518726956098{padding-top: 60px !important;}"][vc_column][vc_row_inner equal_height="yes" content_placement="middle" css=".vc_custom_1518719799223{border-bottom-width: 1px !important;padding-bottom: 60px !important;border-bottom-color: #e4e4eb !important;border-bottom-style: solid !important;}"][vc_column_inner width="1/2" css=".vc_custom_1518726790706{padding: 60px !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column_text css=".vc_custom_1518727016294{margin-bottom: 0px !important;}" el_class="coinz-section-title"]
<h2>Technology</h2>
[/vc_column_text][coinz_devider version="version_3" align="left"][vc_column_text]<strong>Praesent dapibus</strong>, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat. <strong>Aliquam erat volutpat</strong>.

Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.
<ul>
 	<li>Vivamus vestibulum ntulla nec ante.</li>
 	<li>Praesent placerat risus quis eros.</li>
 	<li>Fusce pellentesque suscipit nibh.</li>
 	<li>Integer vitae libero ac risus egestas placerat.</li>
</ul>
Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. <strong>Nam nulla quam, gravida non</strong>, commodo a, sodales sit amet, nisi.[/vc_column_text][coinz_button title="Learn More" align="left" google_fonts="font_family:Arvo%3Aregular%2Citalic%2C700%2C700italic|font_style:700%20bold%20regular%3A700%3Anormal" i_align="right" icon_fontawesome="fa fa-chevron-right" button_size="small" add_icon="true" link="url:%23|||"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1518820138861{background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2017/01/post-2.jpg?id=1511) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" offset="vc_hidden-sm vc_hidden-xs"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1518727964208{padding-top: 90px !important;padding-bottom: 90px !important;}"][vc_column][vc_row_inner css=".vc_custom_1517150043628{padding-bottom: 20px !important;}"][vc_column_inner][vc_column_text css=".vc_custom_1518727849790{margin-bottom: 0px !important;}" el_class="coinz-section-title"]
<h2 style="text-align: center;">Benefits</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][coinz_icon_box title="Free" style="icon_top_center" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-banknote"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Transparent" style="icon_top_center" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-search"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Democratic" style="icon_top_center" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-like"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][coinz_icon_box title="Uncensorable" style="icon_top_center" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-megaphone"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Cross-platform" style="icon_top_center" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-world"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Risk Free" style="icon_top_center" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-fire"]
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
[/coinz_icon_box][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518734995114{padding-top: 90px !important;padding-bottom: 60px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/01/bg-2.jpg?id=1371) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner css=".vc_custom_1518740190096{padding-bottom: 60px !important;}"][vc_column_inner][vc_column_text css=".vc_custom_1518734790939{margin-bottom: 0px !important;}" el_class="coinz-section-title"]
<h2 style="text-align: center; color: #fff;">Key Dates</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered" devider_color="#ffffff"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner][timeline_container][timeline_item title="Early Registration Starts" year="2017" month="March"]Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. <strong>Nam nulla quam, gravida non</strong>, commodo a, sodales sit amet, nisi.[/timeline_item][timeline_item title="Early Access Sale Starts" year="2017" month="March"]Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. <strong>Nam nulla quam, gravida non</strong>, commodo a, sodales sit amet, nisi.[/timeline_item][timeline_item title="Public Sale Starts" year="2017" month="April"]Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. <strong>Nam nulla quam, gravida non</strong>, commodo a, sodales sit amet, nisi.[/timeline_item][timeline_item title="Token Sale Ends" year="2017" month="May"]Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. <strong>Nam nulla quam, gravida non</strong>, commodo a, sodales sit amet, nisi.[/timeline_item][timeline_item title="Final Report on Token Sale" year="2017" month="May"]Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. <strong>Nam nulla quam, gravida non</strong>, commodo a, sodales sit amet, nisi.[/timeline_item][timeline_item title="Bonus Tokens Distribution" year="2017" month="June"]Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. <strong>Nam nulla quam, gravida non</strong>, commodo a, sodales sit amet, nisi.[/timeline_item][/timeline_container][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row][vc_column][vc_row_inner css=".vc_custom_1518824108756{padding-top: 60px !important;}"][vc_column_inner][vc_column_text el_class="coinz-section-title"]
<h2 style="text-align: center;">Token Allocation</h2>
[/vc_column_text][coinz_devider version="version_3" style="version_2" css=".vc_custom_1517247899673{margin-bottom: 30px !important;}"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row][vc_column width="1/2"][vc_row_inner][vc_column_inner width="1/3"][coinz_progress_circle stroke_width="8" percentage="25"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css=".vc_custom_1518823862625{margin-top: 40px !important;}"]
<h3>Token Sale</h3>
Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][coinz_progress_circle stroke_width="8" percentage="39"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css=".vc_custom_1518823924094{margin-top: 40px !important;}"]
<h3 class="header-title">Accelerator Program</h3>
Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/2"][vc_row_inner][vc_column_inner width="1/3"][coinz_progress_circle stroke_width="8" stroke_color="#fa0e30" percentage="10"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css=".vc_custom_1518823878272{margin-top: 40px !important;}"]
<h3 class="header-title">Advisors</h3>
Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][coinz_progress_circle stroke_width="8" stroke_color="#fa0e30" percentage="10"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text css=".vc_custom_1518823936422{margin-top: 40px !important;}"]
<h3 class="header-title">Early Backers</h3>
Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1518824282348{padding-top: 60px !important;padding-bottom: 60px !important;}"][vc_column][vc_row_inner css=".vc_custom_1518824308086{margin-top: 30px !important;border-top-width: 1px !important;padding-top: 60px !important;padding-bottom: 20px !important;border-top-color: #e4e4eb !important;border-top-style: solid !important;}"][vc_column_inner][vc_column_text el_class="coinz-section-title"]
<h2 style="text-align: center;">Our Team</h2>
[/vc_column_text][coinz_devider version="version_3" style="version_2" css=".vc_custom_1517247899673{margin-bottom: 30px !important;}"][coinz_team version="version_2"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';

		$crypto_wallet = '[vc_row full_width="stretch_row" full_height="yes" parallax="content-moving" parallax_image="1250" css=".vc_custom_1518214503015{padding-top: 60px !important;padding-bottom: 60px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-4.jpg?id=1250) !important;background-position: center;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_single_image image="38" img_size="140x140" alignment="center" css_animation="bounceIn"][vc_row_inner][vc_column_inner][vc_column_text css=".vc_custom_1518272286675{margin-top: 30px !important;margin-bottom: 60px !important;}"]
<h1 style="color: #ffffff; text-align: center;">COINZ
SECURE CRYPTO WALLET</h1>
<h4 style="color: #f53e82; text-align: center; letter-spacing: 2px;">MULTYCURRENCY CRYPTO WALLET</h4>
[/vc_column_text][coinz_button title="Create your Account" align="center" google_fonts="font_family:Arvo%3Aregular%2Citalic%2C700%2C700italic|font_style:700%20bold%20regular%3A700%3Anormal" i_align="right" icon_fontawesome="fa fa-chevron-right" button_size="small" add_icon="true" link="url:%23|||"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518271569425{border-top-width: 1px !important;border-bottom-width: 1px !important;padding-top: 60px !important;padding-bottom: 60px !important;background-color: #ececec !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;border-top-color: #e4e4eb !important;border-top-style: solid !important;border-bottom-color: #e4e4eb !important;border-bottom-style: solid !important;}"][vc_column][vc_row_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="20" afternumber="" title="Coins Supported" custom_color="#131325" custom_title_color="#f53e82"][/vc_column_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="250000" afternumber="+" title="Transactions" custom_color="#131325" custom_title_color="#f53e82"][/vc_column_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="95000" afternumber="+" title="Wallets" custom_color="#131325" custom_title_color="#f53e82"][/vc_column_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="67" afternumber="" title="Countries" custom_color="#131325" custom_title_color="#f53e82"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518267596166{padding-top: 60px !important;padding-bottom: 200px !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner css=".vc_custom_1517150043628{padding-bottom: 20px !important;}"][vc_column_inner][vc_column_text css=".vc_custom_1518271426006{margin-bottom: 10px !important;}"]
<h2 style="text-align: center;">Single wallet for all your crypto currencies</h2>
[/vc_column_text][vc_column_text]
<p style="text-align: center;"><span style="color: #64666b;">CoinZ allows you to send, receive, exchange and even earn crypto coins</span></p>
[/vc_column_text][coinz_devider version="version_3" css=".vc_custom_1517246816416{margin-bottom: 30px !important;}"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner][scc_container][scc_item image="1440"][scc_item title="Ethereum" image="1443"][scc_item title="Litecoin" image="1446"][scc_item title="Ripple" image="1447"][scc_item title="Namecoin" image="1448"][scc_item title="Dogecoin" image="1449"][scc_item title="Dash" image="1450"][scc_item title="Monero" image="1451"][scc_item title="Emercoin" image="1454"][scc_item title="Omni" image="1455"][scc_item title="Primecoin" image="1456"][scc_item title="Auroracoin" image="1457"][scc_item title="BlackCoin" image="1458"][scc_item title="Burstcoin" image="1459"][scc_item title="Tether" image="1461"][scc_item title="Titcoin" image="1462"][scc_item title="Zcash" image="1463"][scc_item title="Ubiq" image="1465"][scc_item title="Electroneum" image="1466"][scc_item title="Komodo" image="1467"][/scc_container][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518266897109{padding-top: 60px !important;padding-bottom: 90px !important;background-color: #ececec !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" el_class="coinz-overflow-visible"][vc_column][vc_row_inner][vc_column_inner width="1/2" css=".vc_custom_1518267567055{margin-top: -200px !important;}"][vc_single_image image="931" img_size="full" css_animation="fadeInUp" el_class="coinz-rounded-image"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1518220295029{padding-left: 30px !important;}"][vc_column_text css=".vc_custom_1518268454622{margin-bottom: 0px !important;}"]
<h2>How it Works</h2>
[/vc_column_text][coinz_devider version="version_3" align="left" css=".vc_custom_1518267659547{margin-bottom: 10px !important;}"][vc_column_text]
<ul>
 	<li>
<h4><strong>01. Register Your Account</strong></h4>
<div>

Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.

&nbsp;

</div></li>
 	<li>
<h4><strong>02. Open a New Crypto Currency Wallet</strong></h4>
<div>

Praesent dapibus, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat.

&nbsp;

</div></li>
 	<li>
<h4><strong>03. Start Receiving  and Sending Crypto Currencies</strong></h4>
<div>

Praesent dapibus, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat.

</div></li>
</ul>
[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518271099221{padding-top: 90px !important;padding-bottom: 60px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-8.jpg?id=1485) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner offset="vc_hidden-sm vc_hidden-xs"][vc_column_text css=".vc_custom_1518270023892{margin-bottom: 20px !important;}"]
<h2 style="color: #ffffff; text-align: center;">Why CoinZ Wallet</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1518270606005{padding-top: 60px !important;}"][vc_column_inner width="1/3"][coinz_icon_box title="Instant Exchange" style="icon_top_center_alt_2" icon_title_color="#ffffff" box_style="color_bg_1" add_icon="true" icon_fontawesome="fa fa-refresh"]
<p style="text-align: left; color: #9e9e9e;">Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</p>
[/coinz_icon_box][coinz_icon_box title="Recurring Buying" style="icon_top_center_alt_2" icon_title_color="#ffffff" box_style="color_bg_1" add_icon="true" icon_fontawesome="fa fa-superpowers"]
<p style="text-align: left; color: #9e9e9e;">Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</p>
[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Mobile Wallet App" style="icon_top_center_alt_2" icon_title_color="#ffffff" box_style="color_bg_1" add_icon="true" icon_fontawesome="fa fa-btc"]
<p style="text-align: left; color: #9e9e9e;">Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</p>
[/coinz_icon_box][coinz_icon_box title="Covered by Insurance" style="icon_top_center_alt_2" icon_title_color="#ffffff" box_style="color_bg_1" add_icon="true" icon_fontawesome="fa fa-handshake-o"]
<p style="text-align: left; color: #9e9e9e;">Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</p>
[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Security Focus" style="icon_top_center_alt_2" icon_title_color="#ffffff" box_style="color_bg_1" add_icon="true" icon_fontawesome="fa fa-lock"]
<p style="text-align: left; color: #9e9e9e;">Praesent dapibus, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat.</p>
[/coinz_icon_box][coinz_icon_box title="Loyalty Program" style="icon_top_center_alt_2" icon_title_color="#ffffff" box_style="color_bg_1" add_icon="true" icon_fontawesome="fa fa-usd"]
<p style="text-align: left; color: #9e9e9e;">Praesent dapibus, neque id cursus faucibus, tortor neque egestas auguae, eu vulputate magna eros eu erat.</p>
[/coinz_icon_box][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1518221385663{padding-top: 60px !important;padding-bottom: 130px !important;}"][vc_column][vc_row_inner css=".vc_custom_1518218927293{margin-bottom: 60px !important;}"][vc_column_inner][vc_column_text]
<h2 style="text-align: center;">Cryptocurrency Calculator</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518221262958{padding-bottom: 60px !important;background-color: #ececec !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" el_class="coinz-overflow-visible"][vc_column][vc_row_inner css=".vc_custom_1518221271065{padding-bottom: 60px !important;}"][vc_column_inner width="1/4" offset="vc_hidden-sm vc_hidden-xs"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1518221553726{margin-top: -200px !important;}"][vcw_container title="Converter" vcw_container_style="style_2" css=".vc_custom_1518221635482{margin-bottom: 60px !important;padding-top: 60px !important;padding-bottom: 60px !important;}"][vcw-converter symbol2="USD"][/vcw_container][/vc_column_inner][vc_column_inner width="1/4" offset="vc_hidden-sm vc_hidden-xs"][/vc_column_inner][/vc_row_inner][vc_column_text css=".vc_custom_1518226580279{margin-bottom: 20px !important;}"]
<h2 style="text-align: center;">Cryptocurrency Prices</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered"][vcw_container title="" vcw_container_style="default_style"][vcw-table symbols="BTC,ETH,XRP,LTC,XMR,BCH,DASH,USDT,ZEC,TRX"][/vcw_container][vc_row_inner][vc_column_inner][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518221914791{padding-top: 90px !important;padding-bottom: 90px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/01/bg-2.jpg?id=1371) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_column_text el_class="coinz-section-title"]
<h2 style="text-align: center; color: #fff;">Our Experts</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered" devider_color="#ffffff" css=".vc_custom_1518221935536{margin-bottom: 30px !important;}"][coinz_team][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518216441363{padding-top: 60px !important;padding-bottom: 60px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/01/bg-6.jpg?id=1369) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text]
<h2 style="text-align: center; color: #fff;">Testimonials</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered"][coinz_testimonial style="version_3" background="dark"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1518272678656{padding-top: 60px !important;padding-bottom: 60px !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text css=".vc_custom_1518272725236{margin-bottom: 0px !important;padding-bottom: 0px !important;}"]
<h2 style="text-align: center;">Latest Blockchain News</h2>
[/vc_column_text][/vc_column_inner][/vc_row_inner][coinz_devider version="version_3" align="centered" css=".vc_custom_1518272872231{margin-bottom: 60px !important;}"][coinz_blog_posts columns="two"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1517964996971{padding-top: 60px !important;padding-bottom: 60px !important;background-color: #ececec !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_column_text css=".vc_custom_1518273085314{margin-bottom: 0px !important;padding-bottom: 0px !important;}"]
<h2 style="text-align: center;">Our Partners</h2>
[/vc_column_text][coinz_devider version="version_3" align="centered" css=".vc_custom_1518273140872{margin-bottom: 30px !important;}"][vc_row_inner][vc_column_inner][coinz_partners style="version_3"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';

		$crypto_blog = '[vc_row][vc_column][coinz_blog_all_posts title="Recent Posts" link="http://alexgurghis.com/themes/coinz/wp/" link_text="View all recent posts" columns="recent"][/vc_column][/vc_row][vc_row css=".vc_custom_1518529066801{margin-top: 30px !important;margin-bottom: 90px !important;}"][vc_column][coinz_video_player image="1563"][/vc_column][/vc_row][vc_row][vc_column][coinz_blog_all_posts title="Editors Pick" post_type="editor"][/vc_column][/vc_row]';

		$our_services = '<p>[vc_row full_width="stretch_row" css=".vc_custom_1517963802180{padding-top: 60px !important;padding-bottom: 60px !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner css=".vc_custom_1517150043628{padding-bottom: 20px !important;}"][vc_column_inner][vc_column_text el_class="coinz-section-title"]</p>
<h2 style="text-align: center;">Our Services</h2>
<p>[/vc_column_text][coinz_devider version="version_3" css=".vc_custom_1517246816416{margin-bottom: 30px !important;}"][vc_column_text]</p>
<p style="text-align: center;"><span style="color: #64666b;">We have more than 20 years of experience building and reviewing security applications,<br />
and have active in the cryptocurrency field. We have designed new bitcoin-related cryptocurrency protocols and discovered<br />
and reported various security vulnerabilities.</span></p>
<p>[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][coinz_icon_box title="Smart Contracts" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-like"]</p>
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
<p>[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Smart Contracts Audit" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-bulb"]</p>
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
<p>[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Blockchain Development" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-data"]</p>
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
<p>[/coinz_icon_box][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][coinz_icon_box title="Exchanges" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_fontawesome="fa fa-exchange"]</p>
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
<p>[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Training" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-user"]</p>
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
<p>[/coinz_icon_box][/vc_column_inner][vc_column_inner width="1/3"][coinz_icon_box title="Wallets" style="icon_top_center_alt_2" box_style="color_bg_1" add_icon="true" icon_type="linecons" icon_linecons="vc_li vc_li-vallet"]</p>
<p style="text-align: left;">Pellentesque accumsan semper consectetur. Nullam volutpat euismod molestie. Vestibulum ante ipsum primis in faucibus.</p>
<p>[/coinz_icon_box][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1517955645066{padding-top: 60px !important;padding-bottom: 60px !important;background: #ececec url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-6.jpg?id=1265) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="45" prenumber=" $" afternumber="M" title="Transactions" custom_color="#ffffff" custom_title_color="#f53e82"][/vc_column_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="45700" afternumber="" title="CoinZ Wallets" custom_color="#ffffff" custom_title_color="#f53e82"][/vc_column_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="240" afternumber="+" title="Online Experts" custom_color="#ffffff" custom_title_color="#f53e82"][/vc_column_inner][vc_column_inner width="1/4"][coinz_animated_number_box number="20" afternumber="+" title="Years of Experience" custom_color="#ffffff" custom_title_color="#f53e82"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518042314214{padding-top: 90px !important;padding-bottom: 150px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/02/bg-7.jpg?id=1296) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text el_class="coinz-section-title"]</p>
<h2 style="text-align: center; color: #fff;">Case Studies</h2>
<p>[/vc_column_text][coinz_devider version="version_3" align="centered" css=".vc_custom_1518042706332{margin-bottom: 30px !important;}"][coinz_work align="centered"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1517963813659{padding-top: 90px !important;padding-bottom: 60px !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_column_text el_class="coinz-section-title"]</p>
<h2 style="text-align: center;">Our Team</h2>
<p>[/vc_column_text][coinz_devider version="version_3" css=".vc_custom_1517246816416{margin-bottom: 30px !important;}"][coinz_team][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1518215560883{padding-top: 90px !important;padding-bottom: 120px !important;background-image: url(http://alexgurghis.com/themes/coinz/wp-content/uploads/2018/01/bg-6.jpg?id=1369) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text]</p>
<h2 style="text-align: center; color: #fff;">Testimonials</h2>
<p>[/vc_column_text][coinz_devider version="version_3" align="centered"][coinz_testimonial style="version_3" background="dark"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1517964996971{padding-top: 60px !important;padding-bottom: 60px !important;background-color: #ececec !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][coinz_partners style="version_3"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]</p>
';

		$our_team = '[vc_row css=".vc_custom_1517342766180{margin-top: 60px !important;margin-bottom: 60px !important;}"][vc_column width="3/4"][coinz_team version="version_2"][/vc_column][vc_column width="1/4"][coinz_subscribe css=".vc_custom_1517429056671{margin-bottom: 30px !important;}"]
<h3>Newsletter!</h3>
Subscribe and get <a href="#"><strong>Introduction in Cryptocurrency</strong></a> course for free.[/coinz_subscribe][vcw_container title="Converter" vcw_container_style="style_2"][vcw-converter symbol2="USD"][/vcw_container][/vc_column][/vc_row]';

		$maintenance = '[vc_row full_width="stretch_row" full_height="yes" parallax="content-moving" css=".vc_custom_1474630728188{background-image: url(http://alexgurghis.com/themes/fubix/wp-content/uploads/code.jpg?id=251) !important;background-position: center;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_column_text css_animation="bottom-to-top" el_class="hero-content"]
<h2 style="text-align: center;">WE ARE UNDER</h2>
<h2 style="text-align: center;"><span class="highlight">MAINTENANCE</span></h2>
&nbsp;
<p style="text-align: center;">We are performing scheduled maintenance. We should be back online shortly.
<strong>Thanks for your patience.</strong></p>
[/vc_column_text][/vc_column][/vc_row]';



		$error404_page_url = home_url( '/' ).'404';

		$pages = apply_filters( 'coinz_import_demo', array(
			'homepage' => array(
				'name'       => _x( 'fintech-company', 'Page slug', 'coinz' ),
				'title'      => _x( 'FinTech Company', 'Page title', 'coinz' ),
				'content'    => $homepage,
				'is_parent'  => 1,
				'parent'     => '',
				'template'   => 'templates/template-full-width.php',
				'theme_mod'  => '',
				'homepage'   => 1,
				'hide_title' => 2,
				'menu_badge' => '',
				'type'       => 'page',
				'url'        => '',
			),
			'ico' => array(
				'name'       => _x( 'ico-landing-page', 'Page slug', 'coinz' ),
				'title'      => _x( 'ICO Landing Page', 'Page title', 'coinz' ),
				'content'    => $ico,
				'is_parent'  => 0,
				'parent'     => 'homepage',
				'template'   => 'templates/template-full-width.php',
				'theme_mod'  => '',
				'homepage'   => 0,
				'hide_title' => 2,
				'menu_badge' => 'new_badge',
				'type'       => 'page',
				'url'        => '',
			),
			'crypto_wallet' => array(
				'name'       => _x( 'crypto-wallet', 'Page slug', 'coinz' ),
				'title'      => _x( 'Crypto Wallet', 'Page title', 'coinz' ),
				'content'    => $crypto_wallet,
				'is_parent'  => 0,
				'parent'     => 'homepage',
				'template'   => 'templates/template-full-width.php',
				'theme_mod'  => '',
				'homepage'   => 0,
				'hide_title' => 2,
				'menu_badge' => 'hot_badge',
				'type'       => 'page',
				'url'        => '',
			),
			'crypto_wallet' => array(
				'name'       => _x( 'crypto-blog', 'Page slug', 'coinz' ),
				'title'      => _x( 'Crypto Blog', 'Page title', 'coinz' ),
				'content'    => $crypto_blog,
				'is_parent'  => 0,
				'parent'     => 'homepage',
				'template'   => 'templates/template-blog-right-sidebar-vc.php',
				'theme_mod'  => '',
				'homepage'   => 0,
				'hide_title' => 2,
				'menu_badge' => '',
				'type'       => 'page',
				'url'        => '',
			),
			'pages' => array(
				'name'       => _x( 'pages', 'Page slug', 'coinz' ),
				'title'      => _x( 'Pages', 'Page title', 'coinz' ),
				'content'    => '',
				'is_parent'  => 1,
				'parent'     => '',
				'template'   => '',
				'theme_mod'  => '',
				'homepage'   => 0,
				'hide_title' => 1,
				'menu_badge' => 'megamenu',
				'type'       => 'custom',
				'url'        => '#',
			),
			'our_services' => array(
				'name'       => _x( 'our-services', 'Page slug', 'perfetto' ),
				'title'      => _x( 'Our Services', 'Page title', 'perfetto' ),
				'content'    => $our_services,
				'is_parent'  => 0,
				'parent'     => 'pages',
				'template'   => 'templates/template-full-width.php',
				'theme_mod'  => '',
				'homepage'   => 0,
				'hide_title' => 1,
				'menu_badge' => '',
				'type'       => 'page',
				'url'        => '',
			),
			'our_team' => array(
				'name'       => _x( 'our-team', 'Page slug', 'perfetto' ),
				'title'      => _x( 'Our Team', 'Page title', 'perfetto' ),
				'content'    => $our_team,
				'is_parent'  => 0,
				'parent'     => 'pages',
				'template'   => 'templates/template-full-width.php',
				'theme_mod'  => '',
				'homepage'   => 0,
				'hide_title' => 1,
				'menu_badge' => '',
				'type'       => 'page',
				'url'        => '',
			),
			'our_blog' => array(
				'name'       => _x( 'our-blog', 'Page slug', 'perfetto' ),
				'title'      => _x( 'Our Blog', 'Page title', 'perfetto' ),
				'content'    => '',
				'is_parent'  => 0,
				'parent'     => 'pages',
				'template'   => 'templates/template-blog-right-sidebar.php',
				'theme_mod'  => '',
				'homepage'   => 0,
				'hide_title' => 1,
				'menu_badge' => '',
				'type'       => 'page',
				'url'        => '',
			),
			'pagesmaintenance' => array(
				'name'       => _x( 'maintenance', 'Page slug', 'perfetto' ),
				'title'      => _x( 'Maintenance', 'Page title', 'perfetto' ),
				'content'    => $maintenance,
				'is_parent'  => 0,
				'parent'     => 'pages',
				'template'   => 'template-blank-page.php',
				'theme_mod'  => '',
				'homepage'   => 0,
				'hide_title' => 1,
				'menu_badge' => '',
				'type'       => 'page',
				'url'        => '',
			),
			'utility_error_404' => array(
				'name'       => _x( 'error-404', 'Page slug', 'perfetto' ),
				'title'      => _x( 'Error 404', 'Page title', 'perfetto' ),
				'content'    => '',
				'is_parent'  => 0,
				'parent'     => 'pages',
				'template'   => '',
				'theme_mod'  => '',
				'homepage'   => 0,
				'hide_title' => 1,
				'menu_badge' => '',
				'type'       => 'custom',
				'url'        => $error404_page_url,
			),
		) );

		foreach ( $pages as $key => $page ) {
			self::coinz_create_demo_page( esc_sql( $page['name'] ), 'coinz_' . $key . '_page_id', $page['title'], $page['content'], $page['is_parent'], $page['parent'], $page['template'], $page['theme_mod'], $page['homepage'], $page['hide_title'], $page['menu_badge'], $page['type'], $page['url'] );
		}

	}

}
