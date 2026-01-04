<?php

  /**
   * 読み込み型・右用(r)
   */

  //<!-- wpのシステム読み込み -->
  require_once ('../../../../../wp-blog-header.php');

  $_SESSION[ 'add_new' ]	=1000;
  KxDy::kxdy_trace_count('kxx_sc_count', 1);
  $type         = $_GET['type'];
  $width_hyouji = $_GET['width_hyouji'];
  $line1        = $_GET['line1']; ////※※※$line1廃止予定※※※

  if(!$width_hyouji):
    $width_hyouji  = 'width:600px;';
  endif;

?>

<?php if($type  !=  'off'): ?>

  <form method="post" action="wp-content/themes/kasax_child/lib/php/p_hyouji0.php" class="gnavi_r __text_center __transition_unset" onClick="return false;">

    <input type="hidden" class="id" value="'.$id.'">

    <a href="wp-content/themes/kasax_child/lib/php/p_hyouji0.php">
      <input type="submit" value="" class="__btn0" style="<?php echo $width_hyouji;  ?>">
    </a>

  </form>

<?php endif; ?>

<span style="<?php echo $width_hyouji; ?>">

<?php

  $post		  = get_post( $_GET[ 'id' ] );
  setup_postdata($post);
  $more     = false;

  if($line1):

    //※※※$line1廃止予定※※※

    //ショートコード無効化
    $content = apply_filters( 'the_content',preg_replace( '/\[.*?\]/' ,'' ,get_the_content("") ) );

    $content = preg_replace( "/\r\n|\r|\n/", "", trim( $content ) );
    $content = strip_tags( $content, "<strong><span>" );

  else:

    $content = apply_filters( 'the_content',get_the_content("")  );

  endif;

  echo  $content;
  wp_reset_postdata();

?>

</span>

<?php if($type  !=  'off'):  ?>
<form method="post" action="wp-content/themes/kasax_child/lib/php/p_hyouji0.php" class="gnavi_r __text_center __transition_unset" onClick="return false;">

  <input type="hidden" class="id" value="'.$id.'">
  <a href="wp-content/themes/kasax_child/lib/php/p_hyouji0.php">
    <input type="submit" value="" class="__btn0" style="<?php echo $width_hyouji;  ?>">
  </a>
</form>
<?php
  KxDy::kxdy_trace_count('kxx_sc_count', -1);
  endif;
?>