<?php
/**
 * The Header: Logo and main menu
 *
 * @package COALA
 * @since COALA 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( coala_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'coala_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'coala_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('coala_action_body_wrap_attributes'); ?>>

		<?php do_action( 'coala_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'coala_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('coala_action_page_wrap_attributes'); ?>>

			<?php do_action( 'coala_action_page_wrap_start' ); ?>

			<?php
			$coala_full_post_loading = ( coala_is_singular( 'post' ) || coala_is_singular( 'attachment' ) ) && coala_get_value_gp( 'action' ) == 'full_post_loading';
			$coala_prev_post_loading = ( coala_is_singular( 'post' ) || coala_is_singular( 'attachment' ) ) && coala_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $coala_full_post_loading && ! $coala_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="coala_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'coala_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'coala' ); ?></a>
				<?php if ( coala_sidebar_present() ) { ?>
				<a class="coala_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'coala_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'coala' ); ?></a>
				<?php } ?>
				<a class="coala_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'coala_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'coala' ); ?></a>

				<?php
				do_action( 'coala_action_before_header' );

				// Header
				$coala_header_type = coala_get_theme_option( 'header_type' );
				if ( 'custom' == $coala_header_type && ! coala_is_layouts_available() ) {
					$coala_header_type = 'default';
				}
				get_template_part( apply_filters( 'coala_filter_get_template_part', "templates/header-" . sanitize_file_name( $coala_header_type ) ) );

				// Side menu
				if ( in_array( coala_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'coala_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'coala_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'coala_action_after_header' );

			}
			?>

			<?php do_action( 'coala_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( coala_is_off( coala_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $coala_header_type ) ) {
						$coala_header_type = coala_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $coala_header_type && coala_is_layouts_available() ) {
						$coala_header_id = coala_get_custom_header_id();
						if ( $coala_header_id > 0 ) {
							$coala_header_meta = coala_get_custom_layout_meta( $coala_header_id );
							if ( ! empty( $coala_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$coala_footer_type = coala_get_theme_option( 'footer_type' );
					if ( 'custom' == $coala_footer_type && coala_is_layouts_available() ) {
						$coala_footer_id = coala_get_custom_footer_id();
						if ( $coala_footer_id ) {
							$coala_footer_meta = coala_get_custom_layout_meta( $coala_footer_id );
							if ( ! empty( $coala_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'coala_action_page_content_wrap_class', $coala_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'coala_filter_is_prev_post_loading', $coala_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( coala_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'coala_action_page_content_wrap_data', $coala_prev_post_loading );
			?>>
				<?php
				do_action( 'coala_action_page_content_wrap', $coala_full_post_loading || $coala_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'coala_filter_single_post_header', coala_is_singular( 'post' ) || coala_is_singular( 'attachment' ) ) ) {
					if ( $coala_prev_post_loading ) {
						if ( coala_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'coala_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$coala_path = apply_filters( 'coala_filter_get_template_part', 'templates/single-styles/' . coala_get_theme_option( 'single_style' ) );
					if ( coala_get_file_dir( $coala_path . '.php' ) != '' ) {
						get_template_part( $coala_path );
					}
				}

				// Widgets area above page
				$coala_body_style   = coala_get_theme_option( 'body_style' );
				$coala_widgets_name = coala_get_theme_option( 'widgets_above_page' );
				$coala_show_widgets = ! coala_is_off( $coala_widgets_name ) && is_active_sidebar( $coala_widgets_name );
				if ( $coala_show_widgets ) {
					if ( 'fullscreen' != $coala_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					coala_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $coala_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'coala_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $coala_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'coala_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'coala_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="coala_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( coala_is_singular( 'post' ) || coala_is_singular( 'attachment' ) )
							&& $coala_prev_post_loading 
							&& coala_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'coala_action_between_posts' );
						}

						// Widgets area above content
						coala_create_widgets_area( 'widgets_above_content' );

						do_action( 'coala_action_page_content_start_text' );
