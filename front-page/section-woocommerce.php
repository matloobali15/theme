<?php
$coala_woocommerce_sc = coala_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $coala_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$coala_scheme = coala_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $coala_scheme ) && ! coala_is_inherit( $coala_scheme ) ) {
			echo ' scheme_' . esc_attr( $coala_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( coala_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( coala_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$coala_css      = '';
			$coala_bg_image = coala_get_theme_option( 'front_page_woocommerce_bg_image' );
			if ( ! empty( $coala_bg_image ) ) {
				$coala_css .= 'background-image: url(' . esc_url( coala_get_attachment_url( $coala_bg_image ) ) . ');';
			}
			if ( ! empty( $coala_css ) ) {
				echo ' style="' . esc_attr( $coala_css ) . '"';
			}
			?>
	>
	<?php
		// Add anchor
		$coala_anchor_icon = coala_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$coala_anchor_text = coala_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $coala_anchor_icon ) || ! empty( $coala_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $coala_anchor_icon ) ? ' icon="' . esc_attr( $coala_anchor_icon ) . '"' : '' )
											. ( ! empty( $coala_anchor_text ) ? ' title="' . esc_attr( $coala_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( coala_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' coala-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$coala_css      = '';
				$coala_bg_mask  = coala_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$coala_bg_color_type = coala_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $coala_bg_color_type ) {
					$coala_bg_color = coala_get_theme_option( 'front_page_woocommerce_bg_color' );
				} elseif ( 'scheme_bg_color' == $coala_bg_color_type ) {
					$coala_bg_color = coala_get_scheme_color( 'bg_color', $coala_scheme );
				} else {
					$coala_bg_color = '';
				}
				if ( ! empty( $coala_bg_color ) && $coala_bg_mask > 0 ) {
					$coala_css .= 'background-color: ' . esc_attr(
						1 == $coala_bg_mask ? $coala_bg_color : coala_hex2rgba( $coala_bg_color, $coala_bg_mask )
					) . ';';
				}
				if ( ! empty( $coala_css ) ) {
					echo ' style="' . esc_attr( $coala_css ) . '"';
				}
				?>
		>
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$coala_caption     = coala_get_theme_option( 'front_page_woocommerce_caption' );
				$coala_description = coala_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $coala_caption ) || ! empty( $coala_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $coala_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $coala_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $coala_caption, 'coala_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $coala_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $coala_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $coala_description ), 'coala_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $coala_woocommerce_sc ) {
						$coala_woocommerce_sc_ids      = coala_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$coala_woocommerce_sc_per_page = count( explode( ',', $coala_woocommerce_sc_ids ) );
					} else {
						$coala_woocommerce_sc_per_page = max( 1, (int) coala_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$coala_woocommerce_sc_columns = max( 1, min( $coala_woocommerce_sc_per_page, (int) coala_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$coala_woocommerce_sc}"
										. ( 'products' == $coala_woocommerce_sc
												? ' ids="' . esc_attr( $coala_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $coala_woocommerce_sc
												? ' category="' . esc_attr( coala_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $coala_woocommerce_sc
												? ' orderby="' . esc_attr( coala_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( coala_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $coala_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $coala_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
