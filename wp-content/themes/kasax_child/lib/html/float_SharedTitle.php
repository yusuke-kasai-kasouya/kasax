<?php

  $str_ids = NULL;

  $_arr_db = kx_db_SharedTitle( $args , 'select_title' );


  //echo '<hr>';
	//var_dump($args);
	//echo '<hr>';






  //date
  if( isset($_arr_db['date']) && is_array($_arr_db['date']) && count($_arr_db['date']) > 0 && $_arr_db['date'] != 'n/a' )
  {
    preg_match('/(\d{4})_(\d{2})_(\d{2})/', $_arr_db[ 'date' ]  , $matches );

    $_date_str = NULL;
    $_date_str .= $matches[1] .'年';

    if( $matches[2] != '00' )
    {
      $_date_str .= $matches[2] .'月';
    }


    if( $matches[3] != '00' )
    {
      $_date_str .= $matches[3] .'日';
    }

    $_date = '';
    $_date .= '<div>Date：';
    $_date .= $_date_str;
    $_date .= '</div>';
  }
  else
  {
    $_date = '';
  }

  $_date = '';


  if( isset($_arr_db['date']) && is_array($_arr_db['date']) && count($_arr_db['date']) > 0 && $_arr_db['date'] != 'n/a' ):

    $_json = '';
    //$_count = '';
    foreach( kx_json_decode( $_arr_db[ 'json' ] ) as $key => $_arr_json_str ):

      if( $key == 'title')
      {
        $_arr_json = explode( '＞' , $_arr_json_str );
      }
      else
      {
        $_arr_json = explode( '・' , $_arr_json_str );
      }


      $_json .= '<div class="_op__a _float_side" style="margin-top:10px;">';
      $_json .=  $key;
      $_json .= '▽';
      $_json .= '</div>';

      $_v_date = NULL;
      $_v_date_all = NULL;
      foreach( $_arr_json  as  $value):

        if( $key == 'タグ' )
        {

          $_v_date_all .= '<div style="text-align:right;margin-right:0px;">';

          $_v_date_all .= '<a style="display:inline-block;" href="wp-content/themes/kasax_child/lib/php/DB_list.php?c=json&1a='. $value.'&title='. $args['title_base'] .'&type=DBfull&o='. $value.'">'.$value.'</a>';

          $_v_date_all .= '</div>';

          //$_count++;
        }

        $value = preg_replace('/〈.*〉/' ,'', $value );

        $_v_date .= '<div style="text-align:right;margin-right:0px;">';

        $_v_date .= '<a style="display:inline-block;" href="wp-content/themes/kasax_child/lib/php/DB_list.php?c=json&1a='. $key .'&1b='.$value.'&title='. $args['title_base'] .'&type=DBfull">'.$value.'</a>';

        $_v_date .= '</div>';


      endforeach;

      $_json .= '<div class="_op__z _float_side">';
      $_json .=  $_v_date;
      $_json .= '</div>';

    endforeach;

    if( !empty(  $_v_date_all ) ):

      $_json .= '<div class="_op__a _float_side" style="margin-top:10px;">';
      $_json .= 'All▽';
      $_json .= '</div>';
      $_json .= '<div class="_op__z _float_side">';
      $_json .=  $_v_date_all;
      $_json .= '</div>';

    endif;


    unset( $key , $value );

  endif;




  if (isset($_arr_db['ids']) && is_array($_arr_db['ids']) && !empty($_arr_db['ids']))
  {
    foreach( $_arr_db[ 'ids' ] as  $key => $_id ):

      //$str_ids .= '<div>';//background:red;
      $str_ids .= kx_CLASS_kxx( [
        't'							=> 66,
        'id'						=> $_id,
        'text_c'				=> '─&nbsp;'.(KxSu::get('DBshare_column_name')[$key] ?? 'ERROR'),//なぜか-が必要になった。2024-05-23
        'sys'           => 'no_hover_title',
      ] );

    endforeach;
  }

  unset( $key , $_id );

  $str_html = $str_ids;




  $_content	= get_post( $this->kxft_S1[ 'id' ] )->post_content;

  if( !preg_match( '/\[raretu.*db/' , $_content ) )
  {
    $_edit = kxEdit( [
      'new' 				=>	1,
      'new_title' 	=>	$this->kxft_S1[ 'title_base' ] . '≫新規',
      'new_content'	=>	'',
      'hyouji'      =>  '╋Share',
    ]);
  }
  else
  {
    $_edit = NULL;
  }

?>


<!--　html　-->
<div style="margin:5px 5px 15px 0;">
  <?php echo $_edit; ?>
</div>
<div style="margin:5px 5px 15px 0;">
  <?php echo $this->edit; ?>
</div>


<div style="position:absolute;right:5px;bottom:200px;line-height:1.6em;min-width:150px;">
  <?php if( !empty( $_arr_db[ 'date' ] ) ): echo $_date; endif; ?>
  <?php if( isset($_arr_db['date']) && is_array($_arr_db['date']) && count($_arr_db['date']) > 0 && $_arr_db['date'] != 'n/a' ): echo $_json; endif; ?>
</div>

<div style="position:absolute;right:-20px;bottom:50px;min-width:500px;">
  <?php echo $str_html ; ?>
</div>