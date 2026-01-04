<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kasax
 */
get_header(); ?>
<section STYLE="overflow: hidden;"><!-- スクロール削除追記。‘170927' -->
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) : ?>
			<header class="page-header">
				<?php
					the_archive_title( '<h2 class="page-title">','</h2>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			<p><?php echo $wp_query->found_posts; ?>件</p><!--追記ヒット数。‘170928' -->

			<?php $_SESSION[ 'kensaku' ] = $wp_query->found_posts;?><!--ヒット数保存‘181130' -->

			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content','search' );
/* ↑改良 */
			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>


<!-- .前と次のページを表示 -->
<?php
if ( is_single() ) :

else :
	echo "<hr class=hr002>";
	echo previous_posts_link('＜＜＜Prevue');
	echo "&nbsp&nbsp&nbsp";
	echo next_posts_link('Next＞＞＞');

endif; ?>



		</main><!-- #main -->
	</div><!-- #primary -->



<?php
get_sidebar();
get_footer();
