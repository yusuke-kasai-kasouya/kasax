<?php
  /*
  2020/12/20
  */

  require_once ('../../../../../wp-blog-header.php');

  $pattern = [
    '\\\\d' => '\\d' ,
    '\\\\w' => '\\w' ,
  ];

  /*
  var_dump( $_GET );
  echo '<br>';
  echo $_GET['title_replace_1'];
  echo '<br>';
  */

  //if( !empty( $_GET['content_replace_1'] )):

  $_GET['content_replace_1'] = str_replace( array_keys($pattern), array_values($pattern) ,  $_GET['content_replace_1'] ) ;
  $_GET['title_replace_1'] = str_replace( array_keys($pattern), array_values($pattern) ,  $_GET['title_replace_1'] ) ;


  if( !empty( $_GET['time_on'] ) )
  {
    $_POST   = kx_ChangePOST_FormTIME( $_GET );

    $_POST['search1']   = $_GET['search1'];
    $_POST['on']        = $_GET['on'];
    $_POST[ 'ppp' ]        = $_GET[ 'ppp' ];

    $ret = kx_ChangePOST_Form( $_POST )['string'];
  }
  else
  {

    $ret0 = kx_ChangePOST_Form( $_GET );

    $ret = isset($ret0['string']) ? $ret0['string'] : '';
    //echo '++++++++++';
    //echo $ret;
    //echo '++++++++++';

  }


  $_time = 1;

	$_mete_reload = NULL;
  if( !preg_match( '/❗該当なし❌/' , $ret  , $matches) )
  {
    echo 'RELOAD_' . $_time . '秒';
    $_mete_reload = '<meta http-equiv="refresh" content="' . $_time . '; URL=">';
    $_title       = '置換GET2';
  }
  elseif( !empty( $_GET[ 'update' ] ) && $_GET[ 'update' ] == 'RELOAD' )
  {
    $ret    = '❗更新なし' . $matches[0];
    $_title = '❗置換終了';
  }
  else
  {
    $ret    = '❗更新なし' . $matches[0];
    $_title = '❗置換終了';
  }
?>

<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <title><?php echo $_title; ?></title>
    <?php echo $_mete_reload; ?>
  </head>

  <body>

    <hr>

    <div>
      <a href="p_ChangePost_Form.php">FORMに戻る</a><br>
    </div>

    <h2>Function</h2>

		<?php echo $ret; ?>
    <hr>

  </body>

</html>