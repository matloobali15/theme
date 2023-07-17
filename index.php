<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package COALA
 * @since COALA 1.0
 */

$coala_template = apply_filters( 'coala_filter_get_template_part', coala_blog_archive_get_template() );

if ( ! empty( $coala_template ) && 'index' != $coala_template ) {

	get_template_part( $coala_template );

} else {

	coala_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$coala_stickies   = is_home()
								|| ( in_array( coala_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) coala_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$coala_post_type  = coala_get_theme_option( 'post_type' );
		$coala_args       = array(
								'blog_style'     => coala_get_theme_option( 'blog_style' ),
								'post_type'      => $coala_post_type,
								'taxonomy'       => coala_get_post_type_taxonomy( $coala_post_type ),
								'parent_cat'     => coala_get_theme_option( 'parent_cat' ),
								'posts_per_page' => coala_get_theme_option( 'posts_per_page' ),
								'sticky'         => coala_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $coala_stickies )
															&& count( $coala_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		coala_blog_archive_start();

		do_action( 'coala_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'coala_action_before_page_author' );
			get_template_part( apply_filters( 'coala_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'coala_action_after_page_author' );
		}

		if ( coala_get_theme_option( 'show_filters' ) ) {
			do_action( 'coala_action_before_page_filters' );
			coala_show_filters( $coala_args );
			do_action( 'coala_action_after_page_filters' );
		} else {
			do_action( 'coala_action_before_page_posts' );
			coala_show_posts( array_merge( $coala_args, array( 'cat' => $coala_args['parent_cat'] ) ) );
			do_action( 'coala_action_after_page_posts' );
		}

		do_action( 'coala_action_blog_archive_end' );

		coala_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'coala_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'coala_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
