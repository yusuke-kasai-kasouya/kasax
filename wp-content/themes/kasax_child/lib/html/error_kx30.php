<div class="_error_">
  <table class="__js_zindex __err_table <?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'css_error_border' ] .' '. $this->kxerOUT[ 'Judge_kxx' ][ 'css_error_table' ] ; ?>">
    <tr>
      <td style="width:135px;text-align:right;opacity:.2;" >

        <?php echo $this->kxerOUT[ 'making_temporary' ]; ?>

      </td>

      <td>
        <div class="__switch_start">
          <div class="__naviERROR__ <?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'css_error_border_waku' ]; ?>">

            <br>

            <div class="<?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'css_error_border' ]; ?> zindex2 __radius_05">

              <!-- エラー内容の表示。2023-08-26 -->
              <?php echo $this->kxerOUT[ 'kxx_content_hidden' ];  ?>

            </div>
          </div>

          <script type="text/javascript" language="javascript">
            jQuery(document).ready(function(){
              jQuery(".ea<?php echo $this->kxerOUT[ 'err_num' ]; ?>").on('click',function(){
                target = document.getElementById("ee<?php echo $this->kxerOUT[ 'err_num' ]; ?>");
                target.innerText = "✅完了";
              });
              jQuery(".ea<?php echo $this->kxerOUT[ 'err_num' ]; ?>").on('click',function(){
                target = document.getElementById("ef<?php echo $this->kxerOUT[ 'err_num' ]; ?>");
                target.innerText = "✅済";
              });
            });
          </script>

          <div
            id="ef<?php echo $this->kxerOUT[ 'err_num' ]; ?>"
            class="<?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'css_error_color' ].' '. $this->kxerOUT[ 'Judge_kxx' ][ 'css_title_top' ]; ?>"
            style="padding-left:5px;"
          >

            <a style="cursor:pointer;">

              <?php
                echo $this->kxerOUT[ 'Judge_kxx' ][ 'left' ]  . $this->kxerOUT[ 'Judge_kxx' ][ 'error_word' ];

                if( empty( $this->kxerOUT[ 'Judge_kxx' ][ 'new_on' ] ) )
                {
                  echo $this->kxerOUT[ 'Judge_kxx' ][ 'right' ];
                }
              ?>

            </a>

          </div>
        </div>
      </td>

      <?php if
        (
          !empty( $this->kxerOUT[ 'Judge_kxx' ][ 'new_on' ] )
          && empty( $this->kxerOUT[ 'kxx' ][ 'new_off' ] )
          && !empty( kx_current_user()['edit'] )
          && empty( $this->kxerOUT[ 'new_off_on' ] )
        ):
        //新規post作成。2023-08-22
      ?>

        <td style="text-align: right;">
          <span class="__switch_start">
            <span class="__navi_back_l_new">

              <form action="wp-content/themes/kasax_child/kx_insert_post.php" method="post"  style="text-align: left;">

                TEXT：
                <input type="text" name="text" value="<?php echo $this->kxerOUT[ 'new_content' ]; ?>" style="width:300px;font-size:small;">
                <input type="hidden" name="url" value="<?php echo $this->kxerOUT[ 'url' ]; ?>">
                <input type="hidden" name="post_type" value="<?php echo $this->kxerS1[ 'kxxErrS1' ]['post_type']; ?>">

                <span class="ea<?php echo $this->kxerOUT[ 'err_num' ]; ?>">
                  <input type="submit" value="新規E<?php echo $this->kxerOUT[ 'err_num' ]; ?>">
                </span>

                title：
                <input type="text" name="title" value="<?php echo rtrim( $this->kxerOUT[ 'new_title' ], '$'); ?>" style="width:180px;font-size:x-small;">

                Type：<?php echo $this->kxerS1[ 'kxxErrS1' ]['post_type']; ?>

              </form>

            </span>

            <spna id="ee<?php echo $this->kxerOUT[ 'err_num' ]; ?>">
              <span class="__add_js_zindex <?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'css_title_top' ]?> ">
                <span class="<?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'css_error_color' ] ?>">

                  <?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'right' ]; ?>

                </span>
              </span>
            </span>
          </span>
        </td>

      <?php elseif
        (
          ( !empty( $this->kxerS1[ 'kxxErrS1' ]['sys'] ) && preg_match ('/new_off/' , $this->kxerS1[ 'kxxErrS1' ]['sys'] ) )
          || !empty( $this->kxerOUT[ 'kxx' ][ 'new_off' ] )
        )	:
      ?>

        <td style="text-align: right;" class="<?php echo $this->kxerOUT[ 'Judge_kxx' ][ 'css_error_color' ]; ?>">
          E<?php echo $this->kxerOUT[ 'err_num' ]; ?>
        </td>

      <?php endif; ?>

    </tr>
  </table>
</div>