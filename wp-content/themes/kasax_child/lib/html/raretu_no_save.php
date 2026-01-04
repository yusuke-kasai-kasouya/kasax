<?php
  /**
  *ww_w型・出力
  */

 /*
  //不使用。リサイズ。2025-06-16
  if (preg_match(KxSu::get('title_preg')['1920'], get_the_title())) {
    include 'ResizePage.php';
	}
    */

?>
<!-- 全体・最上部 -->
<div class="__kxra__">
  <?php echo $this->kxraM[ 'top_text' ]; ?>


  <!--　__switch_start　-->
  <div style="text-align:right;float: right;">

    <?php if( empty( $this->kxraS1[ 'outline_only' ] ) ): ?>

    <div class="__kxra_top __switch_start __color_gray66"  style="width:85px;margin:0 0px 0 0;display:inline-block;text-align: center;">

      <span class="__a_hover">

        <?php echo $this->kxraM[ 'system_name' ]; ?>


      </span>

      <?php echo $this->kxraM[ 'table_navi' ]; ?>

    </div>

    <?php endif; ?>

    <div>
      <?php echo $this->kxraM[ 'all_title_change' ];//全ポストのタイトル置換。2023-03-23 ?>
    </div>

  </div>

  <!-- outline / index -->
  <?php if( empty( $_SESSION[ 'raretu' ][ 'NO_outline' ] )): ?>

    <?php if( !empty( $this->kxraS1[ 'outline_only' ] ) ):?>
      <!-- dbなどoutline非表示。2023-05-29 -->
      <?php echo do_shortcode(	'[kasax_index t='. $this->kxraS1[ 'index_t' ] .' id='.  $this->kxraS1['id_base'] .']'); ?>
    <?php else: ?>

      <div class="_op__a" style="margin-left:10px;">
        <a>▼OUTLINE</a>
      </div>

      <div class="_op__z">
        <?php echo do_shortcode(	'[kasax_index t='. $this->kxraS1[ 'index_t' ] .' id='.  $this->kxraS1['id_base'] .']'); ?>
      </div>

    <?php endif; ?>

  <?php endif; ?>

  <?php
    $add_count=0;
    if( !empty( $this->kxraM[ 'add_gaiyou' ] )):       $add_count++;    endif;
    if( !empty( $this->kxraM[ 'add_idea' ] )):         $add_count++;    endif;
    if( !empty( $this->kxraM[ 'add_study' ] )):        $add_count++;    endif;
    if( !empty( $this->kxraM[ 'add_analyze' ] )):      $add_count++;    endif;
    if( !empty( $this->kxraM[ 'add_Sensitivity' ] )):  $add_count++;    endif;
    if( !empty( $this->kxraM[ 'add_Plan' ] )):         $add_count++;    endif;
  ?>
  <?php if( $add_count == 5 ): ?>

    <div class="<?php echo $this->kxraM[ 'add_gaiyou_class' ]; ?>">
      <div class="" style="padding:5px 10px;text-align: right;color:green;">
        ★★★★★Ⅴ
      </div>
    </div>

  <?php elseif( $add_count == 4 ): ?>

    <div class="<?php echo $this->kxraM[ 'add_gaiyou_class' ]; ?>">
      <div class="" style="padding:5px 10px;text-align: right;color:green;">
        ★★★★Ⅳ
      </div>
    </div>

  <?php elseif( $add_count == 3 ): ?>

    <div class="<?php echo $this->kxraM[ 'add_gaiyou_class' ]; ?>">
      <div class="" style="padding:5px 10px;text-align: right;color:green;">
        ★★★Ⅲ
      </div>
    </div>

  <?php elseif( $add_count == 2 ): ?>

    <div class="<?php echo $this->kxraM[ 'add_gaiyou_class' ]; ?>">
      <div class="" style="padding:5px 10px;text-align: right;color:green;">
        ★★Ⅱ
      </div>
    </div>

  <?php endif; ?>

  <?php if( !empty( $this->kxraM[ 'add_gaiyou' ] ) ): ?>

    <div class="<?php echo $this->kxraM[ 'add_gaiyou_class' ]; ?>">
      <div class="__gaiyou_top">
      </div>
      <?php echo  $this->kxraM[ 'add_gaiyou' ]; ?>

    </div>

  <?php endif; ?>

  <?php if( !empty( $this->kxraM[ 'add_idea' ] ) ): ?>

    <div class="<?php echo $this->kxraM[ 'add_gaiyou_class' ]; ?>">
      <div class="__gaiyou_top">
      </div>

      <?php echo  $this->kxraM[ 'add_idea' ]; ?>

    </div>

  <?php endif; ?>


  <?php if( !empty($this->kxraM[ 'add_analyze' ] ) ): ?>

    <div class="<?php echo $this->kxraM[ 'add_gaiyou_class' ]; ?>">

      <div class="__gaiyou_top">
      </div>

      <?php echo  $this->kxraM[ 'add_analyze' ]; ?>

    </div>

  <?php endif; ?>


  <?php if( !empty( $this->kxraM[ 'add_study' ] ) ): ?>

    <div class="<?php echo $this->kxraM[ 'add_gaiyou_class' ]; ?>">

      <div class="__gaiyou_top">
      </div>
      <?php echo  $this->kxraM[ 'add_study' ]; ?>

    </div>

  <?php endif; ?>

  <?php if( !empty( $this->kxraM[ 'add_Sensitivity' ] ) ): ?>

    <div class="<?php echo $this->kxraM[ 'add_gaiyou_class' ]; ?>">

      <div class="__gaiyou_top">
      </div>
      <?php echo  $this->kxraM[ 'add_Sensitivity' ]; ?>

    </div>

  <?php endif; ?>


  <?php if( !empty( $this->kxraM[ 'add_Plan' ] ) ): ?>

    <div class="<?php echo $this->kxraM[ 'add_gaiyou_class' ]; ?>">
      <div class="__gaiyou_top">
        計画
      </div>

      <?php echo  $this->kxraM[ 'add_Plan' ]; ?>

    </div>

  <?php endif; ?>


  <?php
    if( !empty( $this->kxraS1[ 'outline_only' ] ) ):
    elseif( $this->kxraS1[ 'raretu_count' ] == 1 ):
  ?>

    <?php if( !empty( $this->kxraM[ 'chara_list_edit_on' ] ) ): ?>
      <div>
        <?php echo $this->kxraM[ 'kxra_wwr_chara_bar1' ]; ?>
      </div>
    <?php else: ?>
      <div style="margin-top:2em;" >
        <?php echo $this->kxraM[ 'set_edit' ]; ?>
      </div>
    <?php endif; ?>


    <?php if( !empty( $this->kxraM[ 'template_on' ] ) ): ?>
      <div>
        <?php echo $this->kxraM[ 'template' ]; ?>
      </div>
    <?php endif; ?>

    <hr>

    <?php  if( $this->kxraS1[ 'raretu_count' ] == 1 ): ?>

      <div class="__kxra_ww_w_contents <?php echo $this->kxraM[ 'class_contents' ]; ?>">

      <?php echo $this->contents; ?>

      </div>

    <?php endif; ?>

  <?php endif; ?>

</div>


<!-- 最下部・全体 -->