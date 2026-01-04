<?php
/**
 * エディター用。
 *
 */
?>

<!-- TopBAR_FloatR -->
<div class="<?php echo $this->kxedOUT[ 'class_TopBAR_FloatR_all' ]; ?>" style="<?php echo $this->kxedOUT[ 'style_TopBAR_FloatR_all' ]; ?>"  >

  <div class="_op_a<?php echo $this->kxedOUT[ 'kahen' ]; ?>">

    <span class="<?php echo $this->kxedOUT[ 'class_TopBAR_FloatR_span' ]; ?>" style="<?php echo $this->kxedOUT[ 'style_TopBAR_FloatR_span' ]; ?>">

      No：<?php echo $this->kxedOUT[ 'kahen' ] . '　'; ?>
      <input type="button" name="" value="×" class="__btn_s __btn_close">

    </span>

  </div>

</div>

<!-- TopBAR_Left -->
<div class="__white_space_nowrap __text_left">
	<span class="__a_white __text_shadow_black1">

    <span class="<?php echo $this->kxedOUT[ 'class_TopBAR_Left_span' ]; ?>">

      <?php echo $this->kxedOUT[ 'TopBAR_Left_name' ]; ?>

    </span>

    <span class="question2 question2_open" style="padding-left:1em">

	    ─〓─

	  </span>


    <!-- hidden answer2 -->
    <div class="answer2 __small __back_white_op05" style="padding:0 10px;">

      <?php if( empty( $this->kxedS1[ 'new' ] ) ): ?>

        <?php if( !empty( $this->kxedS1[ 'id_ghost' ] ) ): ?>
          <?php $_ghost	= '（Ghost-BASE）'; ?>

          <div>
            <span class="__edit_red">

              <a href="<?php echo get_edit_post_link( $this->kxedS1[ 'id_ghost' ]	) ?>">

                ID： <?php echo $this->kxedS1[ 'id_ghost' ]; ?>
                ──　EDIT　──
              </a>

            </span>
          </div>

        <?php endif; ?>


        <?php if( get_post_status( $this->kxedOUT[ 'id' ] ) ): ?>

          <?php if( empty( $_ghost ) ): ?>

            <?php $_ghost = NULL; ?>

          <?php endif; ?>

          <!-- ■■■link -->
          <div>
            <a href="<?php echo get_permalink( $this->kxedOUT[ 'id' ] ) ?>" tabindex="-1">
              ──　Link　──<?php echo  $_ghost . $this->kxedOUT[ 'id' ]; ?>
            </a>
          </div>

          <!-- ■■■編集 -->
          <div>
            <a href="<?php echo get_edit_post_link( $this->kxedOUT[ 'id' ] ); ?>" class="__a_w __edit_red" tabindex="-1">

              ──　EDIT　──<?php echo $_ghost . $this->kxedOUT[ 'id' ]; ?>

            </a>
          </div>

          <!-- ■■■Kindle出力 -->

          <?php $_epub_ON_set= KxSu::get('on_off') ;$_epub_ON=$_epub_ON_set['epub_ex']; if( $_epub_ON === 1 || preg_match('/≫EPUB出力作業≫/', $this->kxedOUT['title'] ) ):?>

          <div>
            <form method="post"
                  action="<?php echo get_stylesheet_directory_uri(); ?>/lib/php/export_epub.php"
                  target="_blank"
                  style="display:inline;">
              <input type="hidden" name="id" value="<?php echo $this->kxedOUT['id']; ?>">
              <button type="submit" class="__a_w __export_btn" tabindex="-1">
                ──　Kindle出力　──<?php echo $_ghost . $this->kxedOUT['id']; ?>
              </button>
            </form>
          </div>
          <?php endif;?>


          <!-- ■■■プロンプト出力 -->
          <hr>
          <div>
              <?php echo kx_render_export_singletext_button($this->kxedOUT['id']); ?>
          </div>




        <?php else: ?>

          <div>

            <?php echo $this->kxedOUT[ 'id' ]; ?>：存在せず

          </div>

        <?php endif; ?>

        <!-- linkList -->

        <?php echo $this->kxedOUT[ 'TopBAR_LinkLIST' ];//存在しない。 ?>
        <?php echo $this->kxedS1[ 'memo' ];//存在しない。 ?>

      <?php endif; ?>

    </div>
    <!-- hidden answer2 -->

    <?php if( !empty( $this->kxedOUT[ 'Reference' ] ) && !preg_match( '/■Error/' , $this->kxedOUT[ 'Reference' ]	)	): ?>

      <span class="question2 __small reference" style="margin-left:20px;padding:5px;">

      🟩Reference

      </span>

      <div class="answer2 __background_normal" style="width:890px;border:3px solid hsla(90,100%,50%,1);z-index:3;background:hsl(90,100%,6%);">

        <div class="__small __color_normal" style="margin:5px 5px; font-weight:normal; text-shadow:none;">

          <?php echo $this->kxedOUT[ 'Reference' ]; ?>

        </div>

      </div>

    <?php endif; ?>

  </span>
</div>









