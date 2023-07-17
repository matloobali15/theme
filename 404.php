<?php
/**
 * The template to display the 404 page
 *
 * @package COALA
 * @since COALA 1.0
 */

get_header();

get_template_part( apply_filters( 'coala_filter_get_template_part', 'templates/content', '404' ), '404' );

get_footer();
