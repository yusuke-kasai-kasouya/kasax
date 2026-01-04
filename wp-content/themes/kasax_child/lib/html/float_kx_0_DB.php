<?php

  $str_ids = NULL;

  $_arr_db = kx_db1( $args , 'SelectID' );

  //print_r( $_arr_db['result'][0]->json );

  if(  !empty( $_arr_db['result'][0]->json )  &&  $_arr_db['result'][0]->json == 'null'  ):

    return;

  elseif( !empty( $_arr_db['result'][0]->json ) ):

    //echo '+A+';

    //echo $_arr_db['result'][0]->json ;

    //print_r(kx_json_decode( $_arr_db['result'][0]->json ));

    $_json = '';
    //$_count = '';
    foreach( kx_json_decode( $_arr_db['result'][0]->json ) as $key => $_arr_json_str ):


      if( $key == 'raretu_id' ):

        //

      elseif( $key == 'base_id' ):

        $_json .= '<div class="_op__a _float_side">';
        $_json .=  'LINK：'.count($_arr_json_str);
        $_json .= '</div>';
        $_json .= '<div class="_op__z _float_side">';
        foreach( $_arr_json_str as $_id):
          $_json .= '<div style="text-align:right;margin-right:0px;font-size:8px;line-height:13px;" class="__js_hover12_q">';
          $_json .= '<a style="display:inline-block;" href="'. get_permalink($_id).'">'.$_id.'</a>';
          $_json .= '</div>';
          $_json .= '<div class="__js_hover1_a">';
          $_json .= get_the_title( $_id);
          $_json .= '</div>';
        endforeach;
        $_json .= '</div>';


      elseif( $key != '概要' ):

        echo $key;

        $_arr_json = explode( '・' , $_arr_json_str );

        $_json .= '<div class="_op__a _float_side">';
        $_json .=  $key;
        $_json .= '</div>';

        $_json .= '<div class="_op__z _float_side">';


        $_v_date = NULL;
        $_v_date_all = NULL;
        foreach( $_arr_json  as  $value):


          if( $key == 'タグ' )
          {

            $_v_date_all .= '<div style="text-align:right;margin-right:10px;font-size:8px;line-height:13px;">';

            $_v_date_all .= '<a style="display:inline-block;" href="wp-content/themes/kasax_child/lib/php/DB_list.php?c=json&1a='. $value.'&title='. $args['title_base'] .'&type=DBfull&o='. $value.'">'.$value.'</a>';

            $_v_date_all .= '</div>';

            //$_count++;
          }

            $_v_date .= '<div style="text-align:right;margin-right:10px;font-size:8px;line-height:13px;">';

            $_v_date .= '<a style="display:inline-block;" href="wp-content/themes/kasax_child/lib/php/DB_list.php?c=json&1a='. $key .'&1b='.$value.'&title='. $args['title_base'] .'&type=DBfull">'.$value.'</a>';

            $_v_date .= '</div>';


        endforeach;


        $_json .= '<div>';
        $_json .=  $_v_date;
        $_json .= '</div>';
        $_json .= '</div>';

      endif;

    endforeach;

    unset( $key , $value );

  endif;

  $str_html = $str_ids;


  //form

?>



<!--　html　-->

<div style="position:absolute;right:5px;top:200px;line-height:1.6em;min-width:150px;">
  <?php if( !empty( $_arr_db['result'][0]->json ) ): echo $_json; endif; ?>
</div>

