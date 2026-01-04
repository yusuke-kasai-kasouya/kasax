<?php

  /**
  * outline 統合型。
  * 2022-01-29。制作開始。
  */

?>

<!-- ▼ALL -->
<div class="__kxol__ <?php echo $this->kxol_str[ 'class_ALL' ];?>">

  <!-- ▼Head0 薄いbackground -->
  <div class="<?php echo $this->kxol_str[ 'class_Head0' ];?>" style="font-weight:bold;<?php echo $this->kxol_str[ 'style_Head0' ];?>">

    <span class="_op_a" style="opacity:.2;float: right;font-size:small;padding-right:5px;padding-top:2px; ">
      〓
    </span>
    <div class="_op_z __background_normal" style="width:220px;padding:15px 5px;z-index:2;line-height: 20px;">

      <div>
        Type：<?php echo $this->kxolS1[ 'type' ]; ?>
      </div>

      <div>
        Type：<?php echo $this->kxolS1[ 't' ]; ?>
      </div>

      <?php echo $this->kxolS1[ 'head_before' ].$this->kxolS1[ 'head_after' ]; ?>

    </div>



    <!-- ▼Head1 タブ型のメイン表記 -->
    <?php if(  !empty( $this->kxol_str[ 'link_on' ] ) ):  ?>

      <a href="<?php echo $this->kxol_str[ 'Head_link' ]; ?>">

    <?php endif;  ?>

    <span class="kx_index_ue_midashi <?php echo $this->kxol_str[ 'class_Head1' ];?>" style="<?php echo $this->kxol_str[ 'style_Head1' ];?>">

      <?php echo  $this->kxol_str[ 'head' ]; ?>

    </span>


    <!-- ▲Head1 -->

      <!-- ▼Head_test -->
      <span style="<?php echo $this->kxol_str[ 'style_head_LINK' ];?>;padding-left:3px;">
        <?php echo $this->kxol_str[ 'link_on' ]; ?>
      </span>
      <!-- ▲Head_test -->


    <?php if( !empty( $this->kxol_str[ 'link_on' ] ) ):  ?>
      </a>
    <?php
        if( !empty( $url_on_TopOnly ) ):
          unset( $url );
        endif;
      endif;
    ?>

  </div>
  <!-- ↑Head0 -->

  <!-- ↓outline_Main -->
  <div class="<?php echo $this->kxolS1[ 'judge' ][ 'class_outline_Main0' ];?>" id="<?php echo $this->kxolS1[ 'judge' ][ 'id_outline_Main0' ];?>">
    <div class="<?php echo $this->kxolS1[ 'judge' ][ 'class_outline_Main1' ];?>" id="<?php echo $this->kxolS1[ 'judge' ][ 'id_outline_Main1' ];?>">
      <div class="<?php echo $this->kxolS1[ 'judge' ][ 'class_outline_Main2' ]; //$class7000 ?>">

      <?php echo $this->kxol_str[ 'outline_str' ] ?>

      </div>
    </div>
  </div>
  <!-- ↑outline_Main -->


  <!-- ↓bottom -->
  <div class="<?php echo $this->kxol_str[ 'class9000' ];?>" style="<?php echo $this->kxol_str[ 'style9000' ];?>">

    <span class="<?php echo $this->kxol_str[ 'class9200' ];?>">

      <?php echo $this->kxol_str[ 'bottom_left' ];?>

    </span>


    <span style="<?php echo $this->kxol_str[ 'style9400' ];?>">

      <?php echo $this->kxol_str[ 'bottom_right' ];?>

    </span>

  </div>

</div>
<!-- ▲ALL -->
