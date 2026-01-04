<?php
  /**
   * スクリプト表示。シンプルタイプ。
   */
  require_once ('../../../../../wp-blog-header.php');

  //チェック用。残す。2025-04-30
  //echo $_GET[ 'type' ];
  //echo $_GET[ 'title' ];
  echo kxdbTemp_update_posts('Update_ON');

?>


<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<title>書き出しページ</title>
</head>

<body>
<h1>内容</h1>

<?php

//echo $_GET[ 'key' ];
//echo'<br>';
//echo $_GET[ 's' ];
//echo'<br>';

?>

</body>

</html>


<?php unset($post ,$title ,$content); ?>