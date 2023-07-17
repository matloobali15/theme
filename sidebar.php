<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package COALA
 * @since COALA 1.0
 */

if ( coala_sidebar_present() ) {
	
	$coala_sidebar_type = coala_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $coala_sidebar_type && ! coala_is_layouts_available() ) {
		$coala_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $coala_sidebar_type ) {
		// Default sidebar with widgets
		$coala_sidebar_name = coala_get_theme_option( 'sidebar_widgets' );
		coala_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $coala_sidebar_name ) ) {
			dynamic_sidebar( $coala_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$coala_sidebar_id = coala_get_custom_sidebar_id();
		do_action( 'coala_action_show_layout', $coala_sidebar_id );
	}
	$coala_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $coala_out ) ) {
		$coala_sidebar_position    = coala_get_theme_option( 'sidebar_position' );
		$coala_sidebar_position_ss = coala_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $coala_sidebar_position );
			echo ' sidebar_' . esc_attr( $coala_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $coala_sidebar_type );

			$coala_sidebar_scheme = apply_filters( 'coala_filter_sidebar_scheme', coala_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $coala_sidebar_scheme ) && ! coala_is_inherit( $coala_sidebar_scheme ) && 'custom' != $coala_sidebar_type ) {
				echo ' scheme_' . esc_attr( $coala_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="coala_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'coala_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $coala_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$coala_title = apply_filters( 'coala_filter_sidebar_control_title', 'float' == $coala_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'coala' ) : '' );
				$coala_text  = apply_filters( 'coala_filter_sidebar_control_text', 'above' == $coala_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'coala' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $coala_title ); ?>"><?php echo esc_html( $coala_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'coala_action_before_sidebar', 'sidebar' );
				coala_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $coala_out ) );
				do_action( 'coala_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'coala_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
