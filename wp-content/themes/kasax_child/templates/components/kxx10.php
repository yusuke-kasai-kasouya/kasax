


<!-- h2・anchor -->
<?php if( !empty( $kx10->kx10out[ 'id_anchor' ] ) ): ?>

  <div id="<?php echo $kx10->kx10out[ 'id_anchor' ] ?>" class="__kxra_h2_hidden_id"></div>

<?php endif; ?>


<!--　■3000　■　追記要素  Plot用・年齢変化バー/set用太さ変更バー　-->
<?php if( !empty( $kx10->kx10out[ 'bar' ] ) ): ?>

  <div class="_kx10_bar_ <?php echo $kx10->kx10out[ 'class_bar' ] ?>" style="<?php echo $kx10->kx10out[ 'style_bar' ] ?>">


    <?php echo $kx10->kx10out[ 'bar' ]; ?>

  </div>	<!--3000 -->

<?php endif; ?>

<!--  KX10・main・コンテンツ -->
<div class="__kx10_MainContents__ <?php echo $kx10->kx10out[ 'class_MainContents' ] ?>" style="<?php echo $kx10->kx10out[ 'style_MainContents' ] ?>">		<!--00 -->

  <!--■00　■　追加要素　プロット用ネームバー　■ -->
  <?php echo $kx10->kx10out[ 'main_name_bar' ]; ?>


  <!--■0 -->
  <div class="__switch_start" >

    <!--■1 上段 -->
    <div>
      <!--上段・左 -->


      <div class="<?php echo $kx10->kx10out[ 'class_top_left' ] ?>" style="<?php echo $kx10->kx10out[ 'style_top_left' ] ?>">		<!--上左 -->
        <a href="<?php echo get_permalink( $kx10->kx10out[ 'id_js' ] ); //$id ?>">
          <spna style="<?php echo $kx10->kx10out[ 'style_top_left2' ] ?>">
            <?php echo $kx10->kx10out[ 'top_left' ]; ?>
          </spna>
        </a>
      </div>


      <!--上段・右 -->
      <div class="<?php echo $kx10->kx10out[ 'class12' ] ?>" style="<?php echo $kx10->kx10out[ 'style12' ] ?>">
        <?php echo $kx10->kx10out[ 'top_right' ]; ?>
      </div><!--上・右 -->
      <div class="<?php echo $kx10->kx10out[ 'class12' ] ?>" style="<?php echo $kx10->kx10out[ 'style12' ] ?>">
        <?php echo $kx10->kx10out[ 'edit_new' ]; ?>
      </div><!--上・右 -->

    </div>

    <!--　■中段・オプション■ -->
    <?php echo $kx10->kx10out[ 'reload' ]; ?>
    <?php echo kx_add_content( $kx10->kx10out[ 'id_js' ]	); ?>

    <!--■2 中段 -->
    <div class="__center__ <?php echo $kx10->kx10out[ 'kx10_class_center' ]; ?>">

      <?php echo $kx10->kx10out[ 'center_option_top' ]; ?>
      <!--basu -->
      <?php
        if( !empty( $this->kxxSxx[ 'ExcerptA' ] ) ):
          echo $this->kxxSxx[ 'ExcerptA' ];
        endif;
      ?>
      <?php echo $kx10->kx10out[ 'center_option_end' ]; ?>

    </div><!--■2 中段 -->

  </div>	<!--0 -->

  <!-- bottom_HR -->
  <?php

    if( !empty( $kx10->kx10out[ 'hr_on' ] ) )
    {
      echo '<hr class="__kx10__">';
    }
    elseif( !empty( $kx10->kx10out[ 'style_bottom_hr' ] ) && empty( $hr_off ))
    {
      echo '<div style="'. $kx10->kx10out[ 'style_bottom_hr' ] .'" >&nbsp;</div>';
    }
    elseif( !empty( $nbsp_on ) && empty( $hr_off ) )
    {
      echo '<p>&nbsp;</p>';//余計な隙間になっている。
    }
    else
    {
      echo '<div>&nbsp;</div>';
    }

  ?><!-- bottom_HR -->

</div>	<!--  KX10・main・コンテンツ -->




