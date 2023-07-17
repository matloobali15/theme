<?php
/**
 * The template to display single post
 *
 * @package COALA
 * @since COALA 1.0
 */

// Full post loading
$full_post_loading          = coala_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = coala_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = coala_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$coala_related_position   = coala_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$coala_posts_navigation   = coala_get_theme_option( 'posts_navigation' );
$coala_prev_post          = false;
$coala_prev_post_same_cat = coala_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( coala_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	coala_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'coala_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $coala_posts_navigation ) {
		$coala_prev_post = get_previous_post( $coala_prev_post_same_cat );  // Get post from same category
		if ( ! $coala_prev_post && $coala_prev_post_same_cat ) {
			$coala_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $coala_prev_post ) {
			$coala_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $coala_prev_post ) ) {
		coala_sc_layouts_showed( 'featured', false );
		coala_sc_layouts_showed( 'title', false );
		coala_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $coala_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'coala_filter_get_template_part', 'templates/content', 'single-' . coala_get_theme_option( 'single_style' ) ), 'single-' . coala_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $coala_related_position, 'inside' ) === 0 ) {
		$coala_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'coala_action_related_posts' );
		$coala_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $coala_related_content ) ) {
			$coala_related_position_inside = max( 0, min( 9, coala_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $coala_related_position_inside ) {
				$coala_related_position_inside = mt_rand( 1, 9 );
			}

			$coala_p_number         = 0;
			$coala_related_inserted = false;
			$coala_in_block         = false;
			$coala_content_start    = strpos( $coala_content, '<div class="post_content' );
			$coala_content_end      = strrpos( $coala_content, '</div>' );

			for ( $i = max( 0, $coala_content_start ); $i < min( strlen( $coala_content ) - 3, $coala_content_end ); $i++ ) {
				if ( $coala_content[ $i ] != '<' ) {
					continue;
				}
				if ( $coala_in_block ) {
					if ( strtolower( substr( $coala_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$coala_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $coala_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $coala_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$coala_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $coala_content[ $i + 1 ] && in_array( $coala_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$coala_p_number++;
					if ( $coala_related_position_inside == $coala_p_number ) {
						$coala_related_inserted = true;
						$coala_content = ( $i > 0 ? substr( $coala_content, 0, $i ) : '' )
											. $coala_related_content
											. substr( $coala_content, $i );
					}
				}
			}
			if ( ! $coala_related_inserted ) {
				if ( $coala_content_end > 0 ) {
					$coala_content = substr( $coala_content, 0, $coala_content_end ) . $coala_related_content . substr( $coala_content, $coala_content_end );
				} else {
					$coala_content .= $coala_related_content;
				}
			}
		}

		coala_show_layout( $coala_content );
	}

	// Comments
	do_action( 'coala_action_before_comments' );
	comments_template();
	do_action( 'coala_action_after_comments' );

	// Related posts
	if ( 'below_content' == $coala_related_position
		&& ( 'scroll' != $coala_posts_navigation || coala_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || coala_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'coala_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $coala_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $coala_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $coala_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $coala_prev_post ) ); ?>"
			<?php do_action( 'coala_action_nav_links_single_scroll_data', $coala_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
