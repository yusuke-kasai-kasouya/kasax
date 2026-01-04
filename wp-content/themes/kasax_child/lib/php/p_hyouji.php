<?php
  //<!-- wpのシステム読み込み -->
  //require_once ('../../../../../wp-blog-header.php');
  require_once('../../../../../wp-load.php');
  $_SESSION[ 'add_new' ]	=1000;

  KxDy::kxdy_trace_count('kxx_sc_count', 1);

  if( !empty($_GET['width_hyouji'] ))
  {
    $width_hyouji = $_GET['width_hyouji'];
  }
  else
  {
    $width_hyouji = NULL;
  }

  if( !empty($_GET[ 'more' ] ))
  {
    $more         = $_GET['more'];
  }


  if( empty( $width_hyouji ) )
  {
    $width_hyouji  = 'width:650px;';
  }

  if( !empty( $_GET['delay'] ) )
  {
    $delay  = $_GET['delay'] *  1000;

    usleep( $delay );
  }


  $button_close_on	= NULL;
  $add_top = NULL;
  $add_end = NULL;
  $add_text = NULL;
  if( !empty( $_GET['type'] ))
  {
    if( $_GET['type'] ==  'kx30'  )
    {
      $add_text = '✅';
    }
    elseif( $_GET['type'] ==  'reload'  )
    {
      //
    }
    else
    {
      $add_top = '<span class="__hyouji_sannkaku" style="">';
      $add_end = '</span>';
      $add_text = NULL;
    }


    if( $_GET['type']  == 'button_close_on')
    {



      $str  = 	'<form method="post" action="wp-content/themes/kasax_child/lib/php/p_hyouji0.php" class="gnavi gnavi_r __text_center gnavi2" onClick="return false;">';
      $str  .= '<a href="wp-content/themes/kasax_child/lib/php/p_hyouji0.php">';
      $str  .= '<input type="submit" value="" class="__btn0" style="'.$width_hyouji.';">';
      $str  .= '</a>';
      $str  .= '</form>';

      $button_close_on	= $str;

      unset($str);


    }

  }


?>

<?php echo $button_close_on; ?>

<span style="<?php echo $width_hyouji; ?>">

<?php

  $post		  = get_post($_GET[ 'id' ] );
  setup_postdata($post);


  if( !empty( $_GET['more'] ) )
  {
    $more     = true;
    $_SESSION[ 'reference_on' ]	= 1;
  }
  else
  {
    $more     = false;
  }


  $content = apply_filters( 'the_content',get_the_content("")  );

  unset($_SESSION[ 'reference_on' ] );

  if( $_GET['type'] ==  'kx30'  )
  {
    echo   '<p>'.preg_replace(  '/<p>|<\/p>/','' , $add_top . $add_text . $content . $add_end ).'</p>';
  }
  else
  {
    echo    $add_top . $add_text . $content . $add_end ;
  }

  wp_reset_postdata();

?>
</span>

<?php
  echo $button_close_on;
  KxDy::kxdy_trace_count('kxx_sc_count', -1);
?>

