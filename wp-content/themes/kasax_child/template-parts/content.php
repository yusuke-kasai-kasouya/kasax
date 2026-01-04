<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kasax
 */




?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<!-- 改変‘170924' タイトルにリンク追加 -->
		<?php
			//KxDy::set('content', ['id' => get_the_ID() ]);
			//echo 'A';
			//var_dump(KxDy::get('work'));

    		if ( is_single() )
			{
			    //echo kx_title_h1();
				include  __DIR__ .'/../lib/html/h1.php';
			}
			else
			{
				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			}


			if ( 'post' === get_post_type() ) :


		?>

		<div class="entry-meta">

			<?php kasax_posted_on(); ?>

		</div><!-- .entry-meta -->

		<?php
			endif;
		?>

	</header><!-- .entry-header -->

	<!-- エラー時の表示用。entry-contentに設定しないと、何故かentry-contentを消される。2023-08-21 -->
	<script>
		setTimeout(function() {
			document.querySelector('.__js_show_content').className = 'entry-content';
		}, 10000);
	</script>

	<div class="entry-content __js_show_content">
		<!-- 改変‘170924' タイトルにリンク追加 -->
		<!-- 改変 2019/04/20 コンテンツ上部に追加 -->

			<?php
			if ( is_single() ) :

				echo kx_add_content( get_the_ID()	);

				echo	'<div class="_kx_">';// displayArea3'.get_the_ID().'

				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'kasax' ),
					array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"',
					'"</span>', false )
				) );

				echo	'</div>';


				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kasax' ),
					'after'  => '</div>',
				) );


			else :
				the_excerpt();
				echo '<Div class="content_php">';
				echo '<hr class=hr003>';
				echo '<Div Align="right">';
				echo the_modified_date('Y/m/d G:i');
				echo '&nbsp-&nbsp';
				echo the_category(', ');
				echo '&nbsp-&nbsp';
				echo the_tags();
				echo '</Div>'.'</Div>';
			endif; ?>
		<!-- nl2br("\n") は 改行記号[170427] -->
		<!-- &nbsp は スペース[170427] -->

		<hr class="__content_end">

		<!-- .displayArea -->
		<div class	= "__absolute_displayArea displayArea __background_normal">
		</div>

		<div class	= "__absolute_displayArea_right displayArea_right __background_normal">
		</div>

	</div><!-- .entry-content -->


	<footer class="entry-footer">

		<?php //_0_entry_footer(); ?><!-- 機能停止。2020-12-10 -->

		<div class="__js_show">

			<div>
				<?php

				if( !empty( $_SESSION[ 'kxError' ][ 'count' ] ))
				{
					echo 'Error-COUNT：';
					echo $_SESSION[ 'kxError' ][ 'count' ];
					echo '<br>';
					$i = 0 ;
					foreach( $_SESSION[ 'kxError' ][ 'type' ] as $value )
					{
						$i++;
						echo $i.'：';
						echo $value;
						echo '<br>';
					}
				}
				else
				{
					echo 'Error-NO';
				}

				?>

			</div>
			<hr>

			<div>

				<?php

					$i2 = 0;
					if( is_array(	$_SESSION[ 'color' ]	)	)
					{
						echo '<div>Search：LIST-color</div>';

						$i = 0;
						foreach	(	$_SESSION[ 'color' ]	as $key => $_arr):

							$i++;

							$i2	= $i2	+	$_SESSION[ 'color' ][$key]['count'];

						endforeach;


						echo 'カウント'. count( $_SESSION[ 'color' ] );
						echo ' / '.$i2.'<hr>';
					}
					unset(	$i,$i2	);
				?>

			</div>

			<div>

				<?php

					if(is_array(	$_SESSION[ 'color2' ]	)	):

						echo '<div>Search：LIST-color2</div>';

						$i = 0;
						$i2 = 0;
						foreach	(	$_SESSION[ 'color2' ]	as $key => $_v):

							$i++;
							echo '<div>'.$i.'：'.$key.'：'.$_SESSION[ 'color2' ][$key]['count'].'件</div>';

							$i2	= $i2	+	$_SESSION[ 'color2' ][$key]['count'];

						endforeach;

						echo '<br>作業数'.$i2;

					endif;
					unset(	$i,$i2	);

				?>

				</div>

			<?php if( !empty( $_SESSION[ 'kx_memory' ] )  && is_array( $_SESSION[ 'kx_memory' ] ) ):	?>

			<hr>

			<div>Search：LIST</div>

			<table width="">

				<?php $i=0;	foreach	(	$_SESSION[ 'kx_memory' ]	as $key => $_v ):	$i++;	?>

					<?php	preg_match(	'/\d{1,}/'	,	$key	,	$matches	);	?>

					<tr>
						<td width="5"><?php echo $i;	?></td>
						<td width="40"><?php echo sprintf(	"該当 %'*5d 件", count( $_v ));		?></td>
						<td width="150"><?php echo $key;		?></td>

						<td width="30">
							検索<?php echo $_SESSION['kx_memory_count'][$key]; ?>回
						</td>

						<td width="100">
							<?php echo get_cat_name( $matches[0] ); ?>
						</td>



					</tr>

				<?php	endforeach;	?>

			</table>

			<?php	if( !empty( $_SESSION['kx_memory_count']['attention'] )	):		?>

			■注意：<?php echo $_SESSION['kx_memory_count']['attention'];		?>



			<?php	endif;	?>
			<br>
			総表示数<?php echo $_SESSION['kx_memory_count']['all'];	?>

			<hr>

			<?php	endif;	?>

		<div>

	</footer><!-- .entry-footer -->

	<?php //comments_template();//コメント欄追記 ?>


</article><!-- #post-## -->
