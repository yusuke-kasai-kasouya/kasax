<?php
require_once('../../../../../wp-load.php');

// GETパラメータを取得
$id_base    = isset($_GET['id_base'])    ? $_GET['id_base']    : '';
$title_base = isset($_GET['title_base']) ? $_GET['title_base'] : '';
$ids        = isset($_GET['ids'])        ? $_GET['ids']        : '';
$title_end  = isset($_GET['title_end'])  ? $_GET['title_end']  : '';



//$base_ids = $this->kxra_arr_id['title_change_ids'];  // 初期ID群
$base_ids = explode(',',$ids);
$all_ids = [];

foreach ($base_ids as $_id) {
    kx_db0_raretu_get_all_sub_ids($_id, $all_ids); // 下位IDを再帰的に取得
}
unset($_id);

// $all_ids に取得した全IDを追加
$ids2 = array_merge($base_ids, $all_ids);



// 最終的にベースIDも明示的に追加（重複の可能性がある場合は要チェック）
$ids2[] = $id_base;
$ids2 = array_unique($ids2);
//var_dump($ids2);


//echo count($ids2);
//echo '<hr>';

$str_id_to_text ='';
foreach( $ids2 as $value ):
  $str_id_to_text .= $value.',';
endforeach;
$ids = rtrim($str_id_to_text, ',');

//echo $str_id_to_text;



// 現在のURL（戻り用）
$url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>全タイトル置換ページ</title>
  <style>
    body { font-family: sans-serif; padding: 20px; background: #f9f9f9; }
    .box { background: #fff; padding: 20px; border: 1px solid #ccc; }
    input[type="text"] { width: 400px; }
    .btn { padding: 5px 15px; margin-top: 10px; }
  </style>
</head>
<body>

<div class="box">
  <h2>■フォルダタイトル・全置換：<?php echo htmlspecialchars($id_base); ?></h2>
  <p><?php echo preg_replace('/' . preg_quote($title_end, '/') . '$/', '<span style="color:red;">$0</span>', htmlspecialchars($title_base)); ?></p>
  <p>対象ID群（<?php echo count($ids2); ?>件）：</p>
  <p style="word-break: break-all;"><?php echo htmlspecialchars($ids); ?></p>



  <form method="post" action="<?php echo get_stylesheet_directory_uri(); ?>/lib/php/update_posts0.php" target="_blank">
    <input type="hidden" name="type" value="title_change_ids">
    <input type="hidden" name="url" value="<?php echo htmlspecialchars($url); ?>">

    <div>
      <label>Title_ALL：<input type="checkbox" name="checkbox" value="1"></label><br>
      <input type="hidden" name="Title_ALL1" value="<?php echo htmlspecialchars($title_base); ?>">
      <input type="text" name="Title_ALL2" value="<?php echo htmlspecialchars($title_base); ?>">
    </div>

    <div>
      <label>Title：</label><br>
      <input type="hidden" name="ids" value="<?php echo htmlspecialchars($ids); ?>">
      <input type="hidden" name="Title_END1" value="<?php echo htmlspecialchars($title_end); ?>">
      <input type="text" name="Title_END2" value="<?php echo htmlspecialchars($title_end); ?>">
    </div>

    <div>
      <input type="submit" name="back" value="置換" class="btn">
    </div>
  </form>
</div>

</body>
</html>
