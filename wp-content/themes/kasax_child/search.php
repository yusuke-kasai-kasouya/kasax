<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package kasax
 */
get_header(); ?>
	<section id="primary" class="content-area" STYLE="overflow: hidden;"><!-- スクロール削除追記。2017年9月2日 -->
		<main id="main" class="site-main" role="main">

		<?php		echo '<p> </p>'.do_shortcode('[kx_tp type=search t=1]');	?>

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h2 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'kasax' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
			<p><?php echo $wp_query->found_posts; ?>件<!--追記ヒット数。‘170928' -->
			</p>
			<p>
			<?php $_url= $_SERVER["REQUEST_URI"]; ?>

			<?php

			$_cat = NULL;
			if(preg_match('/cat/',$_url) ):
				$_arr=explode("&", $_url);

				foreach($_arr as $_v):
					if(preg_match('/cat=/',$_v) ):
						$pattern = '/\d{2,3}/u';
						preg_match($pattern, $_v, $match);
						//						$_cat.= $match[0].'';
						$_cat.= $_v.'/';
						$_cat= str_replace('cat=' ,'' ,$_cat );
						//						$category = get_the_category();
						//						$count         = count($category);  //カテゴリーの個数を取得
						//						$cat_name      = $category[$count]->cat_name;
						//						$i             = 0; //初期化
						//						$_cat='';
						//						while($i <= $count):
						//						$_cat= $cat_name[$i];
						//						$_cat      .= $category[$i]->cat_name.'　';
						//						$i++;
						//						endwhile;
					endif;
				endforeach;

				//				preg_match('/(?<=cat=)(.*)/', $_url, $match);
				//				$_cat= $match[1];
				//				if(preg_match('/tag/',$_cat) !== false):
				//					preg_match('/(?=&tag)(.*)/', $_cat, $match);
				//					$keshi= $match[1];
				//					$_cat= str_replace($keshi,'',$_cat);
				//				$pattern = '/\d{2,3}/u';
				//				preg_match($pattern, $_cat, $match);
				//				$_cat= $match[0];
				//					$_cat= str_replace('&cat=' ,'/' ,$_cat );
				//				endif;
				$_cat = substr( $_cat, 0, -1);
				echo 'cat：'. $_cat ;

			endif;

			?>

			</p>
			<p>
			<?php
			if(preg_match('/tag/',$_url)):
				preg_match('/(?<=tag=)(.*)/', $_url, $match);
				$_tag= $match[1];
				$_tag = urldecode($_tag);
				$_tag= str_replace('&tag=' ,'/' ,$_tag );
				echo 'tag：'.$_tag ;
			endif;
			?>
			</p>

			<?php $_SESSION[ 'kensaku' ] = $wp_query->found_posts;?><!--ヒット数保存‘181130' -->
			</header><!-- .page-header -->


			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

<!-- .前と次のページを表示 -->
<?php
if ( is_single() ) :

else :
	echo "<HR>";
	echo previous_posts_link('＜＜＜Prevue');
	echo "&nbsp&nbsp&nbsp";
	echo next_posts_link('Next＞＞＞');

endif; ?>



		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
