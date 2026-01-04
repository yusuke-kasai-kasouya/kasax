<div class="__font_weight_bold <?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'css_error_color' ]; ?> __text_center">

  <?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'head' ] . $this->kxerOUT[ 'Judge_kxx' ][ 'ma' ]; ?>
  <?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'error_word' ]; ?>　-　「<?php echo $this->kxerOUT[ 'comment' ]; ?>」
  <?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'ma' ] . $this->kxerOUT[ 'Judge_kxx' ][ 'head' ]; ?>

</div>

<div class="__background_normal __radius_05">
  <div class="<?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'css_error_main' ]; ?>" style="font-size:x-small;">


    <?php echo $this->kxer_kxx_array[ 'output' ][ 'content' ]; ?>

    <hr>

    <table>
      <!-- table 廃止予定要素 div化？？？ -->
      <?php foreach(  $this->kxer_kxx_array as $key => $_arr ): ?>

        <?php
          if( empty( $_arr[ 'color_on_style' ] ) )
          {
            $_arr[ 'color_on_style' ] = NULL;
          }


          if( !empty( $_arr['hr_on'] ) )
          {
            echo '<tr><td colspan="3"><hr><td></tr>';
          }
        ?>

        <?php if(  $key == 'output' ):?>
        <?php else: ?>

          <tr>

            <td class="__text_right" style="width:47%;">
              <?php echo $key; ?>
            </td>

            <td class="__text_center">
              ：
            </td>

            <td class="__text_left"  style="width:47%;">
              <span class="" style="<?php echo $_arr[ 'color_on_style' ]; ?>">

                <?php
                  if( is_array( $_arr[ 'content'] ) )
                  {
                    echo 'print_r+<br>';
                    print_r($_arr[ 'content']);
                  }
                  else
                  {
                    echo $_arr[ 'content'];
                  }
                ?>

              </span>
            </td>

          </tr>

        <?php endif; ?>

      <?php endforeach; ?>
    </table>

  </div>
</div>

<div class="<?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'css_error_color' ]; ?>' __text_center">

  <?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'end' ] . $this->kxerOUT[ 'Judge_kxx' ][ 'ma' ] . $this->kxerOUT[ 'Judge_kxx' ][ 'error_word' ] . $this->kxerOUT[ 'Judge_kxx' ][ 'ma' ] . $this->kxerOUT[ 'Judge_kxx' ][ 'end' ]; ?>

</div>