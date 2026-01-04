
<?php
// JSONファイルのパス
$jsonFilePath = 'D:\00_WP\CSV\chat_gpt.json';
$jsonFilePath2 = 'D:\00_WP\CSV\chat_gpt2.json';


// JSONファイルの読み込み
$jsonContent = file_get_contents($jsonFilePath);

// JSON文字列をデコード
$data = json_decode($jsonContent, true);

// エスケープされたUnicode文字列を再変換
if (json_last_error() === JSON_ERROR_NONE) {
    // JSONエンコード時にエスケープ文字列に戻さない設定
    $jsonContent = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    // 再度ファイルに書き込む
    file_put_contents($jsonFilePath2, $jsonContent);
    echo "JSONファイルが日本語に変換され、正常に保存されました。";
} else {
    echo "JSONのデコードに失敗しました。エラー: " . json_last_error_msg();
}



?>


<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <title>書き出しページ</title>


  </head>

  <body>
    <h1>内容</h1>

    <?php echo print_r($data); ?>




  </body>

</html>


<?php unset($post ,$title ,$content); ?>