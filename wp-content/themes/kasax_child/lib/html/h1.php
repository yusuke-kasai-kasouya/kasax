<?php
  //素材

  $id    = get_the_ID();
  $title = get_the_title();
  $_kxcl = kx_CLASS_kxcl( '', 'kxx');

  // ■装飾
  $_class  = $_kxcl['text_class'];
  $_class .= ' ' . $_kxcl[ 'border_class' ];
  $_class .= ' __float_left';
  $_class .= ' __font_weight_bold';
  $_class .= ' kx_title_h1_ue';

  //制作中。
  //$_kxtt_h1 = kxm_title($id);
  //kxm_title_h1(get_the_ID());
  //var_dump( KxDy::get('content'));
  //var_dump( KxDy::get('work'));
  //echo '<hr>';

  $_kxtt_h1 = kx_CLASS_kxTitle(
  [
    'type'    => 'h1',
    'title'   => $title ,
  ] );

  //echo "現在のメモリ使用量: " . memory_get_usage() . " bytes\n";
  //echo "ピーク時のメモリ使用量: " . memory_get_peak_usage() . " bytes\n";
  //echo "メモリ制限: " . ini_get('memory_limit') . "\n";
?>



<span id="kx_page_top_link"></span> <!-- リンク用 -->

<div class="kx_title_h1" style="<?= $_kxcl['background_light_style'] ?>"> <!-- ① -->

  <div class="kx_title_h1_modified_date <?= $_kxcl['text_class'] ?>"> <!-- ② -->
      <span class="<?= $_class ?>" style="<?= $_kxcl['background_normal_style'] ?>">
          <?= $_kxtt_h1['h1_small'] ?>
      </span> <!-- ue -->

      <span class="_op_a">ID：<?= $id ?></span> <!-- ue -->
      <span class="_op_z __background_normal" style="z-index:2;">
            <?= kx_script_id_clipboard($id) ?>
      </span>

      - modified date&nbsp;-&nbsp;<?= get_the_modified_date('Y/m/d G:i') ?>
  </div> <!-- ② -->

  <h1>
      <div class="kx_title_h1_main __edit_color <?= $_kxcl['text_class'] ?>"> <!-- ③ -->
          <?php if (!empty($_kxtt_h1['h1_title'][0])): ?>
              <span style="font-size: 13px; padding-right:1em;">
                  <?= $_kxtt_h1['h1_title'][0] ?>
              </span>
          <?php endif; ?>

          <?php if (!empty($_kxtt_h1['h1_title'][1])): ?>
              <span style="font-size: 16px; padding-right:1em;">
                  <?= $_kxtt_h1['h1_title'][1] ?>
              </span>
          <?php endif; ?>

          <?php if (!empty($_kxtt_h1['h1_title']['main'])): ?>
              <?= $_kxtt_h1['h1_title']['main'] ?>
          <?php endif; ?>

          <?php if (!empty($_kxtt_h1['h1_title']['add'])): ?>
                <span style="font-size: 13px; padding-right:1em;">
                    <?= $_kxtt_h1['h1_title']['add'] ?>
                </span>
          <?php endif; ?>
      </div> <!-- ③ -->
  </h1>

</div> <!-- ① -->