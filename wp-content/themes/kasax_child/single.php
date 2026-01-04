<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package kasax
 */
get_header(); ?>
	<div id="primary" class="content-area">

		<div class="__tyousei">

		<main id="main" class="site-main" role="main">
		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );
			//the_post_navigation();	//次の記事など。消す。2020-12-06

		endwhile; // End of the loop.
		?>
		</main><!-- #main -->

		</div>

	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
