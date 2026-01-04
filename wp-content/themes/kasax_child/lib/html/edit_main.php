<!-- OpenButton -->
<?php //echo '_op_a'. $this->kxedOUT[ 'kahen' ].' _js_edit'.$this->kxedOUT[ 'id' ].$this->kxedOUT[ 'class_OpenButton' ];?>
<?php if( empty( $this->kxedS1[ 'kx30_on' ] ) ): ?>

	<div
		id="_op_a<?php echo $this->kxedOUT[ 'kahen' ]; ?>"
		class="_op_a<?php echo $this->kxedOUT[ 'kahen' ]; ?> _js_edit<?php echo $this->kxedOUT[ 'id' ] ?> <?php echo $this->kxedOUT[ 'class_OpenButton' ] ; ?>"
		style="<?php echo $this->kxedOUT[ 'style_OpenButton' ] . $this->kxedOUT[ 'style_OpenButton_add' ]; ?>"
	>

		<?php if( !empty( $this->kxedS1[ 'yomikomi_on' ] ) ): ?>

			<a tabindex="-1" href="wp-content/themes/kasax_child/lib/php/p_hyouji_edit.php?id=<?php echo $this->kxedOUT[ 'id' ]; ?>" style="padding:0 5px 0 0;">

		<?php endif; ?>

		<?php echo $this->kxedS1[ 'hyouji' ] . $this->kxedOUT[ 'hyouji_add' ]; ?>

		<?php if( !empty( $this->kxedS1[ 'yomikomi_on' ] ) ): ?>

			</a>

		<?php endif; ?>

	</div>

<?php endif; ?>
<!-- OpenButton -->

<!-- 引き出し内 Drawer -->
<div class="_op_z" style="<?php echo $this->kxedOUT[ 'Drawer_top_style' ]; ?>">

	<!-- トップバー top_bar -->
	<div class="" style="<?php echo $this->kxedOUT[ 'Top_bar_style' ]; ?>">

		<?php echo $this->kxedOUT[ 'top_bar' ] ; ?>

	</div>
	<!-- トップバー -->


	<!-- ゴースト系 -->
	<?php if( !empty( $this->kxedS1[ 'ghost_on' ] ) ): ?>

		<form method="post" action="wp-content/themes/kasax_child/lib/php/p_update_post.php"	class="" style="margin:0;"	id="f_g<?php echo $this->kxedOUT[ 'kahen' ] ?>">

			<div class="" style="<?php echo $this->kxedOUT[ 'Ghost_style' ]; ?>">

				<div class="_op_a __hover" style="margin:0 0 0px 3px;padding:0 0px 0 0px;">

					<span class="__text_shadow_white1" style="color:red;">

						▼GhostON

					</span>

					＠

					<span style="font-size:x-small;">

						<?php echo $this->kxedOUT[ 'title_g' ]; ?>

					</span>

				</div>


				<!-- GHOST 引き出し -->
				<div class="_op_z " style="<?php echo $this->kxedOUT[ 'Ghost2_style' ] ?>">

					<span class="__text_shadow_white1" style="color:red;font-weight:bold;">
						Ghost
					</span>

					<?php if( empty( $this->kxedS1[ 'new' ] ) ): echo kx_script_id_clipboard( $this->kxedS1[ 'id_ghost' ] ); endif; ?>

					<!-- form 要素 GHOST -->
					<input type="hidden" name="id"	value="<?php echo $this->kxedS1[ 'id_ghost' ]; ?>">
					<input type="hidden" name="url" value="<?php echo $this->kxedOUT[ 'url' ]; ?>">
					<input type="hidden" name="time"	value="<?php // echo $_time ; ?>">

					<!-- Title上部隠蔽 GHOST -->
					<div>
						▽Title0
						<input type="text" name="title0" value="<?php echo $this->kxedOUT[ 'Ghost21_value' ] ?>" style="<?php echo $this->kxedOUT[ 'Ghost21_style' ]; ?>">

					</div>
					<!-- Title上部隠蔽 GHOST -->
					<!-- プロット用・各種数値 -->
					<?php echo $this->kxedOUT[ 'title_1s_g' ] ?>
					<?php echo $this->kxedOUT[ 'EditButton' ] ?>
					<hr>



					<!-- コード・隠蔽 GHOST -->
					<div>

						▽shortCODE
						<span class="__text_shadow_white1" style="color:red;font-weight:bold;">

							<input type="checkbox" name="format_off" value="format_off" />
							format_off

						</span>

						<?php echo $this->kxedOUT[ 'GHOST_shortCODE' ]; ?>

					</div>
					<!-- コード・隠蔽 GHOST -->

					<!-- テキスト・エリア・隠蔽 GHOST -->
					<div>
						▽Content：
						<textarea
							type="text" name="text99"
							style="<?php echo $this->kxedOUT[ 'Ghost22_style' ]; ?>"
							placeholder="new content"
						><?php echo $this->kxedOUT[ 'GHOST_content' ] ?></textarea>
					</div>
					<!-- テキスト・エリア・隠蔽 GHOST -->

					<!-- メインボタン GHOST -->
					<?php echo $this->kxedOUT[ 'EditButton' ] ?>

					<!--　削除button -->
					<?php echo kx_delete_post(); ?>
					<?php echo kx_delete( $this->kxedS1[ 'id_ghost' ] ); ?>

				</div>


				<!-- GHOST Title メイン -->
				<div>

					<div>

						▽

						<span class="__text_shadow_white1" style="color:red;font-weight:bold;">
							Ghost
						</span>

						Title Main

					</div>

					<input type="text" name="title99" value="<?php echo $this->kxedOUT[ 'title_end_g' ] ?>" style="background:hsla(90,100%,92%);display:inline-block;<?php echo $this->kxedOUT[ 'width_sbi' ]; ?>" id="titlearea_g<?php echo $this->kxedOUT[ 'kahen' ]; ?>">

					<!-- 送信ボタン -->
					<span class="" style="display:inline-block;">

						<?php echo $this->kxEdit_input_button_submit1( 'display:inline-block;' ); ?>

					</span>

				</div>
				<!-- Title・メイン・隠蔽 GHOST -->

			</div>
		</form>
	<?php endif; ?>
	<!-- ゴースト系 GHOST -->



	<!--　MAIN　form 全体 -->
	<div class="">

		<form
			method="post" action="wp-content/themes/kasax_child/lib/php/p_update_post.php"
			id="f<?php echo $this->kxedOUT[ 'kahen' ] ?>"
			class=""
		>
			<!--　MAIN　 form 要素 -->
			<?php if( empty( $this->kxedS1[ 'new' ] ) ): ?>

				<input type="hidden" name="id"	value="<?php echo $this->kxedOUT[ 'id' ]; ?>">

			<?php endif; ?>

			<input type="hidden" name="url"	value="<?php echo $this->kxedOUT[ 'url' ]; ?>">
			<input type="hidden" name="time"	value="<?php //echo $_time ; ?>">


			<!--　MAIN　 Title上部　-->
			<div class="_op_a __hover" style="<?php echo $this->kxedOUT[ 'Main1_style' ];?>">

				▼TITLE0
				<span style="font-size:x-small;">
					<?php
						$post_id = $this->kxedOUT['id'];

						// 更新日時（年月日＋時分）
						$modified_date = get_the_modified_date( 'y/m/d H:i', $post_id );

						// 更新日時のタイムスタンプ
						$modified_time = get_post_modified_time( 'U', false, $post_id );

						// 現在時刻との差分を「◯分前」形式で取得
						$diff = human_time_diff( $modified_time, current_time( 'timestamp' ) );

					// 出力

					echo  $this->kxedOUT[ 'title_0_top' ] .'　-　'.get_the_modified_date( 'y/m/d H:i' , $this->kxedOUT[ 'id' ] );
					echo ' （' . $diff . '前）';
					?>
				</span>

			</div>

			<div class="_op_z" style="<?php echo $this->kxedOUT[ 'Main2_style' ]; ?>">

				<div>
					<?php
						if( empty( $this->kxedS1[ 'new' ] ) )
						{
							echo kx_script_id_clipboard( $this->kxedOUT[ 'id' ] ) ;
						}
					?>
				</div>

				▽TITLE 0
				<input type="text" name="title1" value="<?php echo $this->kxedOUT[ 'title_0' ];?>" class="" style="<?php echo $this->kxedOUT[ 'Main3_style' ]; ?>">

				<!--　送信button -->

				<?php echo $this->kxedOUT[ 'EditButton' ]; ?>

				<?php echo $this->kxedOUT[ 'base_titles' ]; ?>


				<?php if( empty( $this->kxedS1[ 'ghost_on' ] ) ): ?>

					<!--　削除button -->
					<?php echo kx_delete_post(); ?>
					<?php echo kx_delete( $this->kxedOUT[ 'id' ] ); ?>

				<?php else: ?>

					<div style="text-align:right;">
						GHOST！
					</div>

				<?php endif; ?>

			</div>
			<!--　MAIN　 Title上部 -->


			<!--　MAIN　 Title・追記 -->
			<?php if( !empty( $this->kxedOUT[ 'title_1' ] ) ): ?>

				<div class="_op_a __hover" style="<?php echo $this->kxedOUT[ 'style3mt1_a' ]; ?>">
					▼Title1：<?php echo $this->kxedOUT[ 'title_1' ]; ?>
				</div>

				<div class="_op_z " style="<?php echo $this->kxedOUT[ 'style3mt1_z' ]; ?>">
					<?php echo $this->kxedOUT[ 'title_1s_on' ]; ?>
					<?php echo $this->kxedOUT[ 'EditButton' ]; ?>
				</div>

			<?php endif; ?>
			<!-- MAIN　Title　追記 -->


			<!-- MAIN　ShortCODE -->
			<?php if(	!empty( $this->kxedOUT[ 'shortCODE_string' ] ) ): ?>

				<?php	if( empty( $this->kxedS1[ 'short_code_form_on' ] )	): 	//$_3ms_op_z = NULL; //$_3ms_op_z = '_op_z'; ?>

					<div class="_op_a __hover" style="<?php echo $this->kxedOUT[ 'style3ms_a' ]; ?>">

						▼CODE：
						<?php echo $this->kxedOUT[ 'shortCODE_type' ]; ?>

					</div>

				<?php endif; ?>

				<div class="<?php echo $this->kxedOUT[ 'MAIN_ShortCODE_class' ]; ?>" style="<?php echo $this->kxedOUT[ 'style3ms_z' ]; ?>">

					<div style="word-wrap: break-word;">

						▽shortCODE：<?php echo $this->kxedOUT[ 'shortCODE_string' ]; ?>

					</div>

					<?php
						//ショートコード。設定。2023-09-06
						$this->kxedOUT[ 'template_form_html2' ]	= $this->kxedOUT[ 'shortCODE_array' ];
						echo $this->kxEdit_shortCODE();
						unset($this->kxedOUT[ 'template_form_html2' ]);
					?>

					<?php echo $this->kxedOUT[ 'EditButton' ] ?>

				</div>

			<?php endif; ?>
			<!-- MAIN　ShortCODE -->


			<!-- MAIN_Title -->
			<?php if( !empty( $this->kxedS1[ 'ghost_on' ] ) ):	//$op_z = NULL;//$op_z=' _op_z';	?>

				<div class="_op_a __hover" style="<?php echo $this->kxedOUT[ 'style3mte_a' ]; ?>">
					▼Title E
				</div>

			<?php endif; ?>


			<!-- 隠蔽部 MAIN_Title_hidden -->
			<div class="<?php echo $this->kxedOUT[ 'MAIN_Title_hidden_class' ]; ?>" style="<?php echo $this->kxedOUT[ 'MAIN_Title_hidden_style' ]; ?>">

				<div>

					<?php if( !empty( $this->kxedS1[ 'ghost_on' ] ) ):echo '▽Title E';	endif; ?>
					<?php echo $this->kxedOUT[ 'J' ][ 'new' ][ 'new_attention' ]; ?>

				</div>

				<input type="text" name="title99" value="<?php echo $this->kxedOUT[ 'title_end' ]; ?>" style="background:hsla(180,100%,92%);display:inline-block;<?php echo $this->kxedOUT[ 'width_sbi' ];?>" id="titlearea<?php echo $this->kxedOUT[ 'kahen' ]; ?>">


				<span class="" style="vertical-align:top;display: inline-block;">

					<?php
						if( empty( $this->kxedS1[ 'header_bar'] ) )
						{
							echo $this->kxEdit_input_button_submit1(	'display:inline;' );
						}
						else
						{
							echo $this->kxEdit_input_button_submit2(	'display:inline;' );
						}

					?>

				</span>

			</div>
			<!-- ↑ MAIN_Title_hidden -->


			<!-- MAIN_Content -->
			<?php	if( empty( $this->kxedS1[ 'content_form_on' ] ) )://$_class3mc_z = NULL;//$_class3mc_z	= '_op_z';?>

				<div class="_op_a __hover" style="<?php echo $this->kxedOUT[ 'style_MAIN_Content' ];//style3mc_a ?>">

					▼Content

				</div>

			<?php endif;?>


			<!-- MAIN_Content_hidden -->
			<div class="<?php echo $this->kxedOUT[ 'MAIN_Content_hidden_class' ]; ?>" style="<?php echo $this->kxedOUT[ 'style_MAIN_Content_hidden' ] ?>">

				<div>

					<?php if(	!empty( $this->kxedS1[ 'ghost_on' ] )	):	echo '▽Content';	endif; ?>
					<?php echo $this->kxedOUT[ 'J' ][ 'new' ][ 'new_attention' ]; ?>

				</div>

				<textarea
					id					= "textarea<?php echo $this->kxedOUT[ 'kahen' ]; ?>"
					type				= "text"
					name				= "content"
					class				= "<?php echo	$this->kxedOUT[ 'class_TextArea' ]; ?>"
					style				= "<?php echo	$this->kxedOUT[ 'TextArea_style' ]; ?>"
					placeholder	= "new content"
				><?php echo $this->kxedOUT[ 'content' ];?></textarea>
				<!-- 要注意・↑隙間を作らない・2023-09-06 -->

				<span class="" style="vertical-align:top;display: inline-block;">

					<?php
						if( empty( $this->kxedS1[ 'header_bar'] ) )
						{
							echo $this->kxEdit_input_button_submit1(	'display:inline;' ).'<br>';
						}
						else
						{
							//echo $this->kxEdit_input_button_submit2(	'display:inline;' );
						}
						echo $this->kxEdit_input_button_submit2(	'display:inline;' );
					?>

					<input type="button" value="×" class="_op_a<?php echo $this->kxedOUT[ 'kahen' ] ?> __btn_s3 __btn_close" style="display:block;">

					<span class="_js_edit<?php echo $this->kxedOUT[ 'id' ]; ?>">

						<a tabindex="-1" href="wp-content/themes/kasax_child/lib/php/p_hyouji_edit.php?id=<?php echo $this->kxedOUT[ 'id' ] ?>">

							🔃

						</a>

					</span>

				</span>

				<!-- メインボタン main_button -->
				<div class="" style="<?php echo $this->kxedOUT[ 'style_main_button' ] ?>">

					<?php echo $this->kxedOUT[ 'EditButton' ] ?>

				</div>
				<!-- メインボタン -->

			</div>
			<!-- テキスト・エリア -->

		</form>



	</div>
	<!-- form 全体 -->

<!--
	<div  class="_op_a">
		coment
	</div>
	<div  class="_op_z __background_normal"  style="<?php //echo $this->kxedOUT[ 'width_sbi' ]; ?>">
		<?php //echo $this->kxEdit_coment() ?>
		<?php //comments_template();//コメント欄追記 ?>
	</div>
-->


</div>
<!-- 引き出し内 -->


<?php if( !empty( $this->kxedS1[ 'hyouji_ids' ] ) ): ?>
	<span>
		<?php echo $this->kxedS1[ 'hyouji_ids' ]; ?>
</span>
<?php endif; ?>


<!--</div> -->
<!-- 全体 -->