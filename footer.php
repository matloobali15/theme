<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package COALA
 * @since COALA 1.0
 */

							do_action( 'coala_action_page_content_end_text' );
							
							// Widgets area below the content
							coala_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'coala_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'coala_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'coala_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'coala_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$coala_body_style = coala_get_theme_option( 'body_style' );
					$coala_widgets_name = coala_get_theme_option( 'widgets_below_page' );
					$coala_show_widgets = ! coala_is_off( $coala_widgets_name ) && is_active_sidebar( $coala_widgets_name );
					$coala_show_related = coala_is_single() && coala_get_theme_option( 'related_position' ) == 'below_page';
					if ( $coala_show_widgets || $coala_show_related ) {
						if ( 'fullscreen' != $coala_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $coala_show_related ) {
							do_action( 'coala_action_related_posts' );
						}

						// Widgets area below page content
						if ( $coala_show_widgets ) {
							coala_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $coala_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'coala_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'coala_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! coala_is_singular( 'post' ) && ! coala_is_singular( 'attachment' ) ) || ! in_array ( coala_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="coala_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'coala_action_before_footer' );

				// Footer
				$coala_footer_type = coala_get_theme_option( 'footer_type' );
				if ( 'custom' == $coala_footer_type && ! coala_is_layouts_available() ) {
					$coala_footer_type = 'default';
				}
				get_template_part( apply_filters( 'coala_filter_get_template_part', "templates/footer-" . sanitize_file_name( $coala_footer_type ) ) );

				do_action( 'coala_action_after_footer' );

			}
			?>

			<?php do_action( 'coala_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'coala_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'coala_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>