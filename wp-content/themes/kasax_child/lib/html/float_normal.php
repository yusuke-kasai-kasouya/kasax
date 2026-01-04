<?php
  $str = '';
  //var_dump(KxDy::get('content')[$this->kxft_S1['id']]['db_kx1']['タグ'] );

  $_KxDy = KxDy::get('content')[$this->kxft_S1['id']];

  if( empty( $_KxDy['db_kx1']['タグ'] )  )
  {
    return;
  }
  else
  {
    foreach( explode('、',$_KxDy['db_kx1']['タグ']) as $_tag ):


      $str .= '<div style="text-align:right;margin-right:12px;font-size:11px;line-height:18px;">';

      $str .= '<a style="display:inline-block;" href="wp-content/themes/kasax_child/lib/php/DB_list.php?table_name=wp_kx_1&column=json&text3='. $_tag.'">'.$_tag.'</a>';

      $str .= '</div>';


    endforeach;

    //unset( $key , $value );

  }

  $str_html = $str;


  //form

?>



<!--　html　-->

<div style="position:absolute;right:5px;line-height:1.6em;min-width:150px;">
  <?php echo $str_html; ?>
</div>

