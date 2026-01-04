<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kasax
 */

	//ユーザーid。書き換えよう。2023-08-30
	echo kx_authorID();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<!-- 170924 -->

		<?php
			include  __DIR__ .'/../lib/html/h1.php';
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kasax' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
<?php dynamic_sidebar('footer'); ?>
	<Div Align="right">
	<footer class="entry-footer">
<!-- ����			<?php _0_entry_footer(); ?> -->
	</Div>
		</footer><!-- .entry-footer -->
</article><!-- #post-## -->
