<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kasax
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div style="background-color:hsla(180,100%,50%,.033);border-radius:20px;">

		<header class="entry-header">
			<div class="__padding_left20"><BR>

					<?php
						echo '<a href=' . get_permalink() . '>' . kx_CLASS_kxTitle(
						[
							'type'   => 'TitleReplace',
							'title'  => get_the_title(),
						] )[ 'TitleReplace_html' ];
						echo '</a>';
					?>

			</div>

			<?php the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>

			<div class="__text_right __edit_color __padding_right20">

				<?php echo '<a href='.get_edit_post_link().'>edit</a>'; ?>
				<?php echo ':'; ?>
				<?php

					// 1. カウントアップ（初回なら0+1=1になる）
    			KxDy::kxdy_trace_count('kxx_content_count', 1);

    			// 2. 表示
    			echo KxDy::get('trace')['kxx_content_count'] ?? 0;

				?>

			</div>


			<?php if ( 'post' === get_post_type() ) : ?>

				<div class="entry-meta">

					<?php kasax_posted_on(); ?>

				</div><!-- .entry-meta -->
			<?php endif; ?>

		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	<div>

	<footer class="entry-footer">
		<?php _0_entry_footer(); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->