<?php
/**
 * 子テーマ。改造。
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>><!-- TO footer -->
	<head>

		<!-- ���e�X�g -->
		<?php if(wp_is_mobile()) :?>
			<script type="text/javascript">
				if( screen.width <= 768 ){
					document.write('<meta name="viewport" content="width=device-width, initial-scale=1.0"  />');
				} else{
					document.write('<meta name="viewport" content="width=1000" />');
				}
			</script>
		<?php else : ?>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php endif ;?>

		<!-- -- -->
		<?php wp_head(); ?>
		<?php //kasax_phpcss();?>		<!-- 2018-01-16：：削除：2025-12-28 -->

	</head>

	<body <?php body_class(); ?>><!-- TO footer -->

		<!-- ローダーJS系 -->
		<div id="loader" >
		</div>

		<!--<div id="loader2"></div>--><!-- ローダーJS系 -->

		<div id="page" class="site"><!-- TO footer -->

			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'test_testunderscores' ); ?>
			</a>

			<header id="masthead" class="site-header" role="banner">

				<nav id="site-navigation" class="main-navigation" role="navigation">

					<?php echo kx_header_bar(); ?><!-- 170929' -->
					<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>

				</nav><!-- #site-navigation -->

			</header><!-- #masthead -->

			<div id="content" class="site-content"><!-- TO footer -->