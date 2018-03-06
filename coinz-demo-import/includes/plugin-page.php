<?php
/**
 * The plugin page view - the "settings" page of the plugin.
 *
 * @package td-demo-import
 */

namespace TDDI;

?>

<div class="td-demo-import-page wrap about-wrap">

	<?php ob_start(); ?>
		<h1 class="td-demo-import-title"><?php esc_html_e( 'ThemesDojo Demo Import', 'td-demo-import' ); ?></h1>
	<?php

		$plugin_title = ob_get_clean();

		// Display the plugin title (can be replaced with custom title text through the filter below).
		echo wp_kses_post( apply_filters( 'td-demo-import/plugin_page_title', $plugin_title ) );

		// Display warrning if PHP safe mode is enabled, since we wont be able to change the max_execution_time.
		if ( ini_get( 'safe_mode' ) ) {
			printf(
				esc_html__( '%sWarning: your server is using %sPHP safe mode%s. This means that you might experience server timeout errors.%s', 'td-demo-import' ),
				'<div class="notice  notice-warning  is-dismissible"><p>',
				'<strong>',
				'</strong>',
				'</p></div>'
			);
		}

		// Start output buffer for displaying the plugin intro text.
		ob_start();

	?>

	<div class="td-demo-import-intro-notice notice notice-warning is-dismissible">
		<p><?php esc_html_e( 'Before you begin, make sure all the required plugins are activated.', 'td-demo-import' ); ?></p>
	</div>

	<div class="td-demo-import-intro-text">
		<p class="about-description">
			<?php esc_html_e( 'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme.', 'td-demo-import' ); ?>
			<?php esc_html_e( 'It will allow you to quickly edit everything instead of creating content from scratch.', 'td-demo-import' ); ?>
		</p>
	</div>

	<?php

		$plugin_intro_text = ob_get_clean();

		// Display the plugin intro text (can be replaced with custom text through the filter below).
		echo wp_kses_post( apply_filters( 'td-demo-import/plugin_intro_text', $plugin_intro_text ) );

	?>

	<div class="td-demo-import-item">
		<div class="td-demo-import-image-container">

			<img class="td-demo-import-item-image" src="<?php echo TD_PLUGIN_URL . '/includes/images/screenshot.jpg'; ?>">

		</div>
		<div class="td-demo-import-item-container">
			<h2 class="td-demo-import-item-title" title=""><?php esc_html_e( 'CoinZ Demo Content', 'td-demo-import' ); ?></h2>
			<div class="td-demo-import-list">
				<ul>
					<li class="import-images inactive">
						<div class="status-icons">
							<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							<i class="fa fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i>
							<i class="fa fa-check" aria-hidden="true"></i>
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						</div>
						Import Images
					</li>
					<li class="import-work inactive">
						<div class="status-icons">
							<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							<i class="fa fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i>
							<i class="fa fa-check" aria-hidden="true"></i>
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						</div>
						Import Work
					</li>
					<li class="import-testimonials inactive">
						<div class="status-icons">
							<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							<i class="fa fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i>
							<i class="fa fa-check" aria-hidden="true"></i>
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						</div>
						Import Testimonials
					</li>
					<li class="import-team inactive">
						<div class="status-icons">
							<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							<i class="fa fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i>
							<i class="fa fa-check" aria-hidden="true"></i>
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						</div>
						Import Team
					</li>
					<li class="import-partners inactive">
						<div class="status-icons">
							<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							<i class="fa fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i>
							<i class="fa fa-check" aria-hidden="true"></i>
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						</div>
						Import Partners
					</li>
					<li class="import-posts inactive">
						<div class="status-icons">
							<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							<i class="fa fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i>
							<i class="fa fa-check" aria-hidden="true"></i>
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						</div>
						Import Posts
					</li>
					<li class="inactive">
						<div class="status-icons">
							<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							<i class="fa fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i>
							<i class="fa fa-check" aria-hidden="true"></i>
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						</div>
						Import Pages and Menu
					</li>
					<li class="inactive">
						<div class="status-icons">
							<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
							<i class="fa fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i>
							<i class="fa fa-check" aria-hidden="true"></i>
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						</div>
						Setup Theme Options
					</li>
				</ul>
			</div>
			<button class="td-demo-import-item-button button button-primary js-td-demo-import-gl-import-data button  button-hero  button-primary"><?php esc_html_e( 'Import Demo Data', 'td-demo-import' ); ?></button>
		</div>
	</div>

</div>
