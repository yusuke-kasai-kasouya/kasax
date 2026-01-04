<?php
/**
 * error出力用。
 * 未使用。2022-04-26
 */

//white-space: nowrap;

?>

<!-- 全体 -->
<div class="_error_">

  <!-- ▼フレーム -->
  <div class="_frame <?php echo $css_frame; ?>">

    <!-- ▼左 -->
    <div class="_left __switch_start">

      <?php echo $left.$error_word; ?>

      <!-- ▼contents -->
      <div class="__navi_back_l2">

        <?php echo $content; ?>

      </div>
      <!-- ▲contents -->

    </div>
    <!-- ▲左 -->

    <!-- ▼右-->
    <div class="_right __switch_start">

      右

      <!-- ▼new-->
      <?php if( $new_on && kx_current_user()['edit']	&&	!preg_match ('/new_off/' , $inx['sys'] )	&&	!$new_off	): ?>

        <div class  = "__navi_back_l_new">

          <form action="wp-content/themes/kasax_child/kx_insert_post.php" method="post">

            <input type="hidden" name="url" value="<?php echo $_url; ?>">

            TEXT：
            <input type="text" name="text" value="<?php echo $new_content; ?>" style = "width:300px;font-size:small;">

            <span class="ea<?php echo $err_num; ?>">
              <input type="submit" value=" 新規E<?php echo $err_num; ?> " >
            </span>

            title：
            <input type="text" name="title" value="<?php echo $_new_title;  ?>" style = "width:200px;font-size:small;">



          </form>

        </div>
      <?php endif; ?>
      <!-- ▲new-->

    </div>
    <!-- ▲右-->

  </div>
  <!-- ▲フレーム -->

</div>
<!-- ▲全体 -->