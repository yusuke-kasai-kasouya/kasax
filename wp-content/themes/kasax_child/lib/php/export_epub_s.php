<?php
// WordPress環境のロード（相対パスを調整）
require_once('../../../../../wp-load.php');

if (empty($_POST['ids'])) {
    echo 'ERROR - 投稿IDが指定されていません。';
    return;
}

// 投稿 ID を取得
$post_ids = explode(",", $_POST['ids']);

// 出力用HTMLを初期化
$html_output = "<!DOCTYPE html><html><head><meta charset='utf-8'><title>WordPress EPUB Export</title></head><body>";

foreach ($post_ids as $id) {
    $post = get_post($id);
    if (!$post) continue;

    $title = kx_title_end_format($post->post_title);
    $html_output .= "<h1>{$title}</h1>";

    // コンテンツ取得
    if (preg_match('/

\[raretu(?:\s+[^\]

=]+=[^\]

]+)?\]

/', $post->post_content)) {
        $_result = kx_db1(['id' => $id], 'SelectID');
        if (!empty($_result['概要'])) {
            $post_g = get_post($_result['概要']);
            $_content = $post_g->post_content;
        } else {
            $_content = '';
        }
    } elseif (preg_match('/

\[kx_format\s+id=(\d+)(?:\s+[^\]

]+)?\]

/', $post->post_content, $matches)) {
        $id_f = intval($matches[1]);
        $post_f = get_post($id_f);
        $_content = $post_f->post_content;
    } else {
        $_content = $post->post_content;
    }

    $_content = preg_replace('/

\[[^\]

]+\]

/', '', $_content); // ショートコード除去
    $_content = trim($_content);
    $html_output .= "<div>{$_content}</div>";
}

$html_output .= "</body></html>";

// 一時ファイルへ保存
$tmp_html = tempnam(sys_get_temp_dir(), 'epub_input_') . '.html';
file_put_contents($tmp_html, $html_output);

// 出力ファイル名と保存先指定
$save_directory = "D:/00_WP/Export/";
$datetime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
$filename = "wordpress_epub_" . $datetime->format("Ymd_His") . ".epub";
$file_path = $save_directory . $filename;

// 保存先フォルダが存在しなければ作成
if (!file_exists($save_directory)) {
    mkdir($save_directory, 0755, true);
}

// Pandocの実行（パスは環境に応じて調整）
$cmd = "\"C:\\Program Files\\Pandoc\\pandoc.exe\" \"{$tmp_html}\" -o \"{$file_path}\"";
exec($cmd, $output, $return_code);

if ($return_code === 0) {
    echo "EPUBファイルを生成しました。<br>";
    echo "保存先: {$file_path}";
} else {
    echo "EPUB変換に失敗しました。";
}
?>
