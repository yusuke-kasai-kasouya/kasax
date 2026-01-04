<!-- 全体 -->
<span class="" style="<?php echo $kx40->kx40out[ 'judge' ][ 'style_general' ]; ?>">

  <!--	LINK -->
  <span id="__js_hober_40<?php echo $_random; ?>" class="" style="vertical-align :top;">

    <!-- left -->
    <?php if( $kx40->kx40out[ 'judge' ][ 'left_on' ] ): ?>

      <span class="<?php echo $kx40->kx40out[ 'judge' ][ 'css_left' ] ?>" style="<?php echo $kx40->kx40out[ 'judge' ][ 'style_left' ] ?>">

        <?php echo $kx40->kx40out[ 'left' ]; ?>

      </span>

    <?php endif; ?><!--	左 -->

    <!--	時間-->
    <?php if( $kx40->kx40out[ 'judge' ][ 'time_on' ] ): ?>

      <span class="" style="<?php echo $kx40->kx40out[ 'judge' ][ 'style_time' ] ?>">

        <?php echo $kx40->kx40out[ 'time' ] ?>

      </span>

    <?php endif; ?>
    <!--	時間 -->


    <!-- center -->
    <span class="<?php echo $kx40->kx40out[ 'judge' ][ 'css_center' ]; ?>" style="<?php echo $kx40->kx40out[ 'judge' ][ 'style_center' ]; ?>">

      <!--	hover　-->
      <?php if( array_key_exists( 'navi_on' , $kx40->kx40out[ 'judge' ] ) && !array_key_exists( 'type' , $this->kxxError )  ): //$this->error['type']  ?>

        <!-- hover スイッチ -->
        <div id="__js_hober_40_navi<?php echo $_random; ?>" style="display:inline;">

          <?php echo $kx40->kx40out[ 'center' ] ?>

          <div class="__js_hober_40_navi">

            <?php echo $this->kxxSxx[ 'ExcerptX' ] ?>

          </div>

        </div><!-- hover スイッチ -->

      <?php else: ?>

        <?php echo $kx40->kx40out[ 'center' ] ?>

      <?php endif; ?>
      <!--	hover　-->

    </span><!-- center -->

  </span><!--	LINK -->


  <!--	JS Hidden -->
  <span class="<?php echo $kx40->kx40out[ 'judge' ][ 'css_js' ]; ?>">

    <?php echo $kx40->kx40out[ 'ret2_js' ]; ?>

  </span><!--	JS Hidden -->


  <!--	右 -->
  <?php if( !empty( $kx40->kx40out[ 'judge' ][ 'right_on' ] ) ): ?>

    <span class="" style="<?php echo $kx40->kx40out[ 'judge' ][ 'style_right' ]; ?>">

      <?php if( $kx40->kx40out[ 'right' ] || array_key_exists( 'hikidashi' , $kx40->kx40 )) :  //$kx40->kx40out[ 'hikidashi' ] ?>

        <div>

          <?php echo $kx40->kx40out[ 'right' ] . $kx40->kx40out[ 'hikidashi' ] ?>

        </div>

      <?php endif; ?>


      <!--	yomikomi -->
      <?php if( !empty($yomikomi_r) ): ?>

        <span class="gnavi_r" style="display: inline-block;">

          <input type="hidden" class="id" value="<?php echo $id; ?>">

          <a href="wp-content/themes/kasax_child/lib/php/p_hyouji_r.php?id=<?php echo$id;?>&type=on&width_hyouji=<?php echo $width_hyouji; ?>">

            <input value="" class="__btn0" style="height:10px;width:40px;background-color:hsla(<?php echo $this->kxcl[ '色相' ]; ?>,100%,50%,1);">

          </a>

        </span>

      <?php endif ?><!-- yomikomi -->

    </span>

  <?php endif; ?>
  <!--	右 -->

</span>
<!-- 全体 -->