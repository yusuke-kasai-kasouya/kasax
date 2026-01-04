<?php

  /*
  製作中。2020/12/20
  */

  require_once ('../../../../../wp-blog-header.php');


  //$_POST['title_replace_1'] = str_replace( '\\\\d' , '\\d' ,  $_POST['title_replace_1'] ) ;
  $pattern = [
    '\\\\d' => '\\d' ,
    '\\\\w' => '\\w' ,
  ];

  $_POST['title_replace_1'] = str_replace( array_keys($pattern), array_values($pattern) ,  $_POST['title_replace_1'] ) ;
  $_POST['content_replace_1'] = str_replace( array_keys($pattern), array_values($pattern) ,  $_POST['content_replace_1'] ) ;


  $title_replace_1_form = trim($_POST['title_replace_1'], '/');

  echo 'title_replace_1:'.   $_POST['title_replace_1'].'<hr>';

  if( !empty( $_POST['time_on']) )
  {

    foreach( $_POST as $key => $value):

      if( $_POST['search1'] ):

        $search1 = '&search1=' . $_POST['search1'];

      endif;

      if( preg_match ( '/time(\d)/' , $key  , $matches ) ):

        if( $_POST[ $matches[0] ] == 1 ):

          $timeNum = $matches[0];
          //echo '+++'.$matches[0].'+++';

          break;

        endif;

      endif;



    endforeach;
    unset( $key , $value );

    $get = 'time_on=1&'.$timeNum.'=1';

    echo '<br>++'. $get .'++<br>';

    $_POST   = kx_ChangePOST_FormTIME( $_POST );

    $str .= '<div><span style="color:hsla( 0 , 0% , 0% ,.33 )";>' . $key .'</span>：<span style=color:red;>'. $value . '</span></div>';
  }
  else
  {
    $i = 0;
    $str = NULL;
    foreach( $_POST as $key => $value):


      if( $i == 0 )
      {
        $get = $key . '=' . $value;
      }
      else
      {
        $get .= '&' . $key . '=' . $value;
      }

      $str .= '<div><span style="color:hsla( 0 , 0% , 0% ,.33 )";>' . $key .'</span>：<span style=color:red;>'. $value . '</span></div>';

      $i++;

    endforeach;
    unset( $i , $key , $value );

  }

	 $result = kx_ChangePOST_Form( $_POST );

   $ret = $result['string'];

?>


<!DOCTYPE html>
<html lang="ja">

  <head>

    <meta charset="UTF-8">
    <title>置換・確認</title>

  </head>

  <body>

    <form
      method  = "post"
      action  = "update_posts0.php"
      style   = "text-align:left;"
      class   = ""
      target="_blank"
    >

      <input type="hidden" name="type" value="ChangePost_FormGet">

      <div style="margin-left:20px;">

        <div style="display:inline-block;width:90px;">
          Title：
        </div>

        <div style="display:inline-block;">

          <input type="hidden" name="ids" value="<?php echo $result['ids']; ?>">
          <input type="hidden" name="Title1" value="<?php echo $title_replace_1_form; ?>">
          <input type="text"   name="Title2" value="<?php echo $_POST['title_replace_2']; ?>" style="width:400px;">

        </div>

        <?php if(!empty($_POST['content_on'])): ?>
          <hr>

          <div style="display:inline-block;width:90px;">
            Content：
          </div>
          <input type="hidden" name="content_replace_on" value="1">
          <input type="hidden" name="Content1" value="<?php echo $_POST['content_replace_1']; ?>">
          <input type="text"   name="Content2" value="<?php echo $_POST['content_replace_2']; ?>" style="width:400px;">

        <?php endif; ?>

      </div>


      <div>
        <input type="submit" name="back" value="置換" class="question_fulltime __btn2" style="width:50%;height:25px;padding:3px 10px 4px 20px;margin-top:10px;margin-left:115px;">
      </div>

    </form>




    <hr>
    <div>
      <a href="p_ChangePost.php">formに戻る</a><br>
    </div>

    <div>
      <a href="p_ChangePost_FormGet2.php?<?php echo $get; ?>&ppp=5&on=1" style="color:red;">★★置換開始★★</a>
    </div>

    <hr>
    <div>
      ━━　POST確認　━━
    </div>

    <?php

      if( !empty( $announce ) ):
        echo $announce;
      endif;

    ?>


		<?php echo $str; ?>

		<h2>Function</h2>
		<?php echo $ret; ?>
		<hr>


  </body>

</html>


<?php unset($post ,$title ,$content); ?>