<?php
  if( !empty( $this->kxxS1 ) && ( $this->kxxS1[ 'ppp' ] != 1 || !empty( $this->kxxS1[ 'div_on' ] )  || !empty( $this->kxxS1[ 'p_on' ] ) ) )
  {
    echo '<div style="margin-bottom:3px;">';
  }
?>

<!-- 全体 -->
<span
  class="<?php echo $kx30->kx30out[ 'judge' ][ 'css0' ]  ?>"
  style="<?php echo $kx30->kx30out[ 'judge' ][ 'display0' ].$kx30->kx30out[ 'judge' ][ 'style0' ] ?>"
>

  <!--	左 -->
  <?php if( !empty( $kx30->kx30out[ 'judge' ][ 'plus1_on' ] ) ): ?>

    <span style="<?php echo $kx30->kx30out[ 'judge' ][ 'display1' ] . $kx30->kx30out[ 'judge' ][ 'style1' ] ?>width:<?php echo $kx30->kx30out[ 'judge' ][ 'p1_width' ] ?>;font-size:<?php echo $kx30->kx30out[ 'p1_font'] ?>pt;">

      <?php echo $kx30->kx30out[ 'edit0' ] ?>

      <span class="<?php echo $kx30->kx30out[ 'judge' ][ 'css11' ] ?>" style="<?php echo $kx30->kx30out[ 'judge' ][ 'style11' ] ?>">

      <?php echo $kx30->kx30out[ 'left' ] ?>

      </span>

      <?php echo $kx30->kx30out[ 'edit1' ] ?>

    </span>

  <?php endif; ?> <!--	左 -->


  <!--	真ん中 center -->
  <span
    class="__kx30_main_ _kxjq_yomi_main<?php echo $kx30->kx30out[ 'id_js' ] . $kx30->kx30out[ 'judge' ][ 'css_center' ] ?> __transition_unset"
    style="<?php echo $kx30->kx30out[ 'judge' ][ 'display2' ] . $kx30->kx30out[ 'judge' ][ 'style2' ]?>"
  >

    <div class="<?php echo $kx30->kx30out[ 'class_center' ] ?>">

      <?php echo $kx30->kx30out[ 'center' ] ?>

    </div>

  </span><!--	真ん中 -->


  <!--	右 -->
  <?php echo $kx30->kx30out[ 'Reload' ] ?>

  <?php if( !empty( $kx30->kx30out[ 'center_plus_on' ] ) ): ?>

    <span class="<?php echo $css_center_plus ?>" style="<?php echo $display_center_plus.$style_center_plus ?>">

      <?php echo $kx30->kx30out[ 'center_plus' ] ?>

    </span>

  <?php endif; ?>

  <!-- 右端・回り込み -->
  <?php echo $kx30->kx30out[ 'right_edge' ] ?>


  <!--	右 -->


</span><!-- 全体 -->

<?php
  if( !empty( $this->kxxS1 ) )
  {
    if( $this->kxxS1[ 'ppp' ] != 1  )
    {
      echo '</div>';
    }
    elseif( !empty( $this->kxxS1[ 'div_on' ] ) )
    {
      echo'</div>';
    }
    elseif( !empty( $this->kxxS1[ 'p_on' ] ) )
    {
      echo'</div><p>';
    }
  }
?>