<?php

  /*
    稼働中。製作中。2020/12/20
  */

  require_once ('../../../../../wp-blog-header.php');

  $_div1_style = 'display:inline-block;width:150px';
  $_div2_style = 'display:inline-block';
  $_divC_style = 'display:inline-block;width:15px';

  $_arr = [
    'search1'             => [ 'value' => '' , 'checkbox'=>'' , '注意'=>'第一検索' , ],
    'title_search'        => [ 'value'=>'//' , 'checkbox'=>'<input type="checkbox" name="title_search_on" value="1">' , '注意'=>'正規表現。参考例/(?=^∬10≫c)(?!.*Idea)/、正規表現参考：(σ|γ|Β|δ)' ,] ,
    'title_replace_1'     => [ 'value'=>'//' , 'checkbox'=>'' ,'注意'=>'正規表現(\d,\wは対処済み。他の\関係は要注意)' , ],
    'title_replace_2'     => [ 'value' => '' , 'checkbox'=>'' ,'注意' => '',  ] ,
    'html1'               => '<hr>' ,
    'content_replace_1'   => [ 'value'=>'//' ,'checkbox'=>'<input type="checkbox" name="content_on" value="1">', '注意'=>'置換検索・正規表現' ,  ] ,
    'content_replace_1d'  => [ 'value'=>'//' , 'checkbox' => '' , '注意'=>'排除・正規表現'  ] ,
    'content_replace_2'   => [ 'value' => '' , 'checkbox' => '' , '注意'=>'置換後'] ,
    'html2'                => '<hr>' ,
    'checkbox0'            =>  '<div>TIME_ON<input type="checkbox" name="time_on" value="1"></div>',
    'checkbox1'            =>  '<div style="margin-left:100px;">Time1<input type="checkbox" name="time1" value="1"></div>',
    'checkbox2'            =>  '<div style="margin-left:100px;">Time2<input type="checkbox" name="time2" value="1"></div>',
    'checkbox3'            =>  '<div style="margin-left:100px;">Time3<input type="checkbox" name="time3" value="1"></div>',
    'checkbox4'            =>  '<div style="margin-left:100px;">Time4<input type="checkbox" name="time4" value="1"></div>',
    'checkbox5'            =>  '<div style="margin-left:100px;">Time5<input type="checkbox" name="time5" value="1">　time5-Type4桁</div>',
    'checkbox6'            =>  '<div style="margin-left:100px;">Time6<input type="checkbox" name="time6" value="1">　time6-Type19xx年タイプ</div>',
    'checkbox7'            =>  '<div style="margin-left:100px;">Time7<input type="checkbox" name="time7" value="1">　time7-Type19xx年タイプ</div>',

    /*
    'checkbox8'            =>  '
      <select name="time_num">
      <option value="1">time1</option>
      <option value="2">time2</option>
      <option value="3">time3</option>
      <option value="4">time4</option>
      </select>
    ',
    */

    'html3'                => '<hr>' ,

  ];

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>post置換_form検索型</title>
  </head>

  <body>
    <h1>FORM</h1>

    <form method="post" action="p_ChangePost_FormGet.php" class="" style="margin:0;"	id="" target="_blank">

      <?php
        foreach( $_arr as  $key => $value):


          if( preg_match( '/html|checkbox/ ' , $key ) ):

            echo $value;

          else:
          ?>

            <div>
              <div style="<?php echo $_div1_style; ?>;">
                <?php echo $key; ?>
              </div>
              <div style="<?php echo $_divC_style; ?>;">
                <?php echo $value['checkbox']; ?>
              </div>
              <div style="<?php echo $_div2_style; ?>;">
                <input type="text" name="<?php echo $key; ?>" value="<?php echo $value[ 'value' ]; ?>" style="width:300px;">
                <?php echo $value[ '注意' ]; ?>
              </div>
            </div>


          <?php
          endif;

        endforeach;
      ?>


      <input type="submit" name="submit"	value="確認"	class="">

		</form>




  </body>

</html>