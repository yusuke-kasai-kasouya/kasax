<?php

  $_id		      = get_the_ID();
  $_title       = get_the_title( $_id );
  $_kxcl_header = kx_CLASS_kxcl( '' , 'header');
  $_kxcl        = kx_CLASS_kxcl();

  $_class       = ' ' . $_kxcl[ 'text_class' ];

  $_edit = NULL;

  if( array_key_exists('s', $_GET) or array_key_exists('cat', $_GET) or array_key_exists('tag', $_GET) )
  {
    $off = 'off';

    if( !empty( $_GET['s'] ) )
    {
      $_title = '━━━　検索結果　━━━”　 ' . get_search_query() . '　”━━━';
    }
    elseif( !empty( $_GET['cat'] ) || !empty( $_GET['tag'] ) )
    {
      $_title = get_the_archive_title();
    }

  }
  else
  {
    $_edit	= kxEdit(
    [
      'hyouji'			=> kx_header_title( $_title ) . '&nbsp;',//'<span style="margin:0 5px 0 0;">'..'</span>'
      'css_hyouji'	=> '__header_bar_edit',
      'header_bar'  => 1,
    ] );

    //$_arr_db = kx_db1( ['id'=> $_id] , 'SelectID' );
    //print_r( $_arr_db);
    KxDy::set('content', ['id' => $_id ]);
    //echo 'A';
    //var_dump(    KxDy::get('content')[$_id]);

    //サイドフロート。
    $kxft = new kxft;
    $float_arr = $kxft->kxft_Main(
    [
      'id'         => $_id,
      'title_base' => $_title
    ] );
  }



  $_menu	= wp_nav_menu(
  [
    'menu' 						=>	'main',
    'echo' 	  				=>	false,
    'container_class'	=>	'__header_bar_container',
  ] );

  // スクリプト表示用
  $_upper = '🟨';

  if( !preg_match('/≫/' , $_title))
  {
    $_upper = '';
  }
  elseif( !empty( $_id ) )
  {
    $_db = kx_db0( [ 'id' => $_id ] , 'header_bar' );

    if( !empty( $_db->id ))
    {
      $ret  = '';
      $ret .= '<span  class="__js_hover_UpperLINKq">';
      $ret .= '<a href="' . get_permalink( $_db->id )  . '">&nbsp;▲　</a>';
      $ret .= '</span>';
      $ret .= '<span class="__js_hover_UpperLINKa">';
      $ret .= 'UPPER-LINK：'.$_db->title;
      $ret .= '</span>';
      $_upper = $ret;
    }
    else
    {
      $_upper = '🟥';
    }
  }
  else{
    $_upper = '🟪';
  }
?>

<!--　TOP　-->
<div class= "__header_bar_clone2 <?php echo $_class ?>" style="background:hsla(<?php echo $_kxcl[ '色相' ] ?>,50%,50%,.8);
border-bottom:6px solid hsla(<?php echo $_kxcl_header[ '色相' ] ?>,100%,20%,1);">
</div>

<div class= "__header_bar <?php echo $_class; ?>" style="background:hsla(<?php echo $_kxcl_header[ '色相' ] ?>,50%,50%,.2);">

  <!--　左1　-->
  <div style="display: inline-block;">

  <?php echo $_upper; ?>

  </div>

  <!--　左1　-->

  <!--　中1　	// __js_hover13_q　-->
  <div class= "__menu" style="display: inline-block;">

    <?php echo $_menu ?>

  </div>
  <!--　中1　-->


  <!--　右1　__header_bar __c -->
  <div class="__c __js_show">

    <?php echo $_edit; ?>

  </div>
  <!--　右1　-->


  <!--　右2　-->
  <div class="gnavi_top_relation _op_a_non __c __js_show" style="margin:0 20px 0 0;">

    <a href="wp-content/themes/kasax_child/lib/php/p_top_relation.php?id=<?php echo $_id; ?>">

      〓

    </a>

  </div>

  <div class="_op_z_non displayArea_top_relation __relation __background_normal">
  </div>
  <!-- 右2　-->

</div>
<!-- TOP　-->

<!--　背景　-->
<div class= "__header_bar_clone <?php echo $_class  ?>">
</div>

<?php if( !empty($float_arr ) ): ?>

  <div class="__header_bar_float __js_show">
    <div style="opacity: 0.2;">

      <?php echo $float_arr[ 'type' ]; ?>

    </div>

    <?php echo $float_arr[ 'content' ]; ?>
  </div>
<?php endif; ?>