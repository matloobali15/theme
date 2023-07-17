<div class="front_page_section front_page_section_team<?php
	$coala_scheme = coala_get_theme_option( 'front_page_team_scheme' );
	if ( ! empty( $coala_scheme ) && ! coala_is_inherit( $coala_scheme ) ) {
		echo ' scheme_' . esc_attr( $coala_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( coala_get_theme_option( 'front_page_team_paddings' ) );
	if ( coala_get_theme_option( 'front_page_team_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$coala_css      = '';
		$coala_bg_image = coala_get_theme_option( 'front_page_team_bg_image' );
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
	$coala_anchor_icon = coala_get_theme_option( 'front_page_team_anchor_icon' );
	$coala_anchor_text = coala_get_theme_option( 'front_page_team_anchor_text' );
if ( ( ! empty( $coala_anchor_icon ) || ! empty( $coala_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_team"'
									. ( ! empty( $coala_anchor_icon ) ? ' icon="' . esc_attr( $coala_anchor_icon ) . '"' : '' )
									. ( ! empty( $coala_anchor_text ) ? ' title="' . esc_attr( $coala_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_team_inner
	<?php
	if ( coala_get_theme_option( 'front_page_team_fullheight' ) ) {
		echo ' coala-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$coala_css      = '';
			$coala_bg_mask  = coala_get_theme_option( 'front_page_team_bg_mask' );
			$coala_bg_color_type = coala_get_theme_option( 'front_page_team_bg_color_type' );
			if ( 'custom' == $coala_bg_color_type ) {
				$coala_bg_color = coala_get_theme_option( 'front_page_team_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_team_content_wrap content_wrap">
			<?php
			// Caption
			$coala_caption = coala_get_theme_option( 'front_page_team_caption' );
			if ( ! empty( $coala_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_team_caption front_page_block_<?php echo ! empty( $coala_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $coala_caption, 'coala_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$coala_description = coala_get_theme_option( 'front_page_team_description' );
			if ( ! empty( $coala_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_team_description front_page_block_<?php echo ! empty( $coala_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $coala_description ), 'coala_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_team_output">
				<?php
				if ( is_active_sidebar( 'front_page_team_widgets' ) ) {
					dynamic_sidebar( 'front_page_team_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! coala_exists_trx_addons() ) {
						coala_customizer_need_trx_addons_message();
					} else {
						coala_customizer_need_widgets_message( 'front_page_team_caption', 'ThemeREX Addons - Team' );
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
