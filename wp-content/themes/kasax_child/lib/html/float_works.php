<?php

  $_width_all     = '100%';
  $_width_all_min = '300px';
  $_width_Left    = '45%';
  $_width_Center  = '10%';
  $_width_Right   = '45%';

  $str = NULL;

  /*
  echo '++';
  foreach( explode('≫' , 'a≫b≫c≫d' ) as $value_test ):
    echo $value_test;
  endforeach;
  */



  if(preg_match('/^([^≫]*)≫.*list/', $args['title_base'], $matches))
  {
    $_top = '<div style="margin-top:10px;font-size:small;opacity: 0.5;"><a style="display:inline-block;" href="'.get_permalink(KxSu::get('post_id')[ $matches[1].'≫芸術・作品' ] ) .'">▲芸術・作品</a></div>';
  }
  else
  {
    $_top = NULL;
  }
  //echo $matches[1];


  unset( $matches );


  //print_r($kxdbW->select);

  foreach( $kxdbW->select as $key => $value ):

    if( $key == 'title')
    {

      $str_Title = NULL;
      $str_Title .= '<div style="font: size 15px;text-align:center;width:'.$_width_all.';min-width:'.$_width_all_min.';background:navy;">';
      $str_Title .= $value .'</div>';

      //削除用
      $_title = $value;
    }
    elseif( $key == 'date' &&  $value != 'null' )
    {
      $str_Date = NULL;

      if( empty( $value ) )
      {
        $str_Date .= '<div style="width:'.$_width_all.';min-width:'.$_width_all_min.'">';
          $str_Date .= '<div style="width:'.$_width_Left.';display:inline-block;">';
          $str_Date .= 'Date';
          $str_Date .= '</div>';
          $str_Date .= '<div style="width:'.$_width_Center.';display:inline-block;text-align:center;">:</div>';
          $str_Date .= '<div style="width:'.$_width_Right.';display:inline-block;text-align:left;">';
          $str_Date .= 'N/A</div></div>';
      }
      else
      {

        foreach( kx_json_decode( $value ) as $key_date => $_v_date):

          $_v_date = str_replace('/00', '' , $_v_date );

          $_link = '<a href="wp-content/themes/kasax_child/lib/php/DB_list.php?c='.$key.'&1a='.$key_date.'&title='. $args['title_base'] .'">'.$key_date.'</a>';

          $str_Date .= '<div style="width:'.$_width_all.';min-width:'.$_width_all_min.'">';
          $str_Date .= '<div style="width:'.$_width_Left.';display:inline-block;">';
          //$str_Date .= $key_date;
          $str_Date .= $_link;
          $str_Date .= '</div>';
          $str_Date .= '<div style="width:'.$_width_Center.';display:inline-block;text-align:center;">:</div>';
          $str_Date .= '<div style="width:'.$_width_Right.';display:inline-block;text-align:left;">';
          $str_Date .= $_v_date .'</div></div>';

        endforeach;

      }
    }
    elseif( $key == 'json' )
    {
      if( $value != 'null' && !empty( $value) )
      {
        $str_Json = NULL;
        $str_tag = '';
        foreach( kx_json_decode( $value ) as $key_date => $_v_date):

          if( $key_date == 'タグ' )
          {

          }
          else
          {
            $_v_date = '<a href="wp-content/themes/kasax_child/lib/php/DB_list.php?c='.$key.'&1a='.$key_date.'&1b='.$_v_date.'&title='. $args['title_base'] .'">'.$_v_date.'</a>';

            $str_Json .= '<div style="width:'.$_width_all.';min-width:'.$_width_all_min.';">';
            $str_Json .= '<div style="width:'.$_width_Left.';display:inline-block;vertical-align:top;">';
            $str_Json .= $key_date;
            $str_Json .= '</div>';
            $str_Json .= '<div style="width:'.$_width_Center.';display:inline-block;text-align:center;vertical-align:top;">:</div>';
            $str_Json .= '<div style="width:'.$_width_Right.';display:inline-block;text-align:left;">';
            $str_Json .= $_v_date .'</div></div>';
          }
        endforeach;
      }
    }


  endforeach;
  $str_Link = $str;


  //表示
  $str_html = NULL;

  $str_html .= $str_Title ;

  if( !empty( $str_Date ) &&  $str_Date != 'null' ):

    $str_html .= $str_Date;

  endif;

  if( !empty( $str_Json ) &&  $str_Json != 'null' ):

    $str_html .= $str_Json;

  endif;

  $str_html .= $str_Link;

  if( !empty( $str_tag ) &&  $str_tag != 'null' ):

    $str_html .= $str_tag;

  endif;


  //$_edit = $this->edit;


?>

<!--　html　-->

<div style="line-height:1.6em;margin-top:0px;position:fixed; right:0;max-width:300px;">
  <?php echo $_top; ?>
</div>

<div class="_op_a" style="font-size: large; margin-top:80px; font-size:x-small;">
  ▼作品
</div>
<div style="background:black;line-height:1.6em;margin-top:0px;position:fixed; right:0;max-width:300px;" class="_op_z">
  <?php echo $str_html; ?>
</div>

