<?php
require_once('../../../../../wp-load.php');

// 投稿IDの受け取り
if (empty($_POST['id'])) {
    echo 'ERROR - 投稿IDが指定されていません。';
    exit;
}

$id = intval($_POST['id']);
$post = get_post($id);

if (!$post) {
    echo 'ERROR - 投稿が存在しません。';
    exit;
}

// タイトルと本文取得
$title_raw = kx_title_end_format($post->post_title);
$content_raw = apply_filters('the_content', $post->post_content);

// タイトルをファイル名用にサニタイズ
$title_safe = preg_replace('/[\\\\\/:*?"<>|]/', '_', $title_raw);

// スタイル除去（color指定のみ）
$content_clean = preg_replace('/style\s*=\s*"[^"]*color\s*:[^";]+;?[^"]*"/i', '', $content_raw);


// nl2br() を使った後に、不要な <br /> を除去
$content_html = nl2br($content_clean);

// 見出しタグ内の <br /> を除去（新規追加）
$content_html = preg_replace_callback('/<h[1-6][^>]*>.*?<\/h[1-6]>/is', function ($match) {
    return preg_replace('/<br\s*\/?>/i', '', $match[0]);
}, $content_html);

// 見出しやリストの直後の <br /> を除去（既存）
$content_html = preg_replace('/(<h[1-6]>.*?<\/h[1-6]>)<br\s*\/?>/i', '$1', $content_html);
$content_html = preg_replace('/(<hr\s*\/>)<br\s*\/?>/i', '$1', $content_html);
$content_html = preg_replace('/(<ul>)<br\s*\/?>/i', '$1', $content_html);
$content_html = preg_replace('/(<ol>)<br\s*\/?>/i', '$1', $content_html);
$content_html = preg_replace('/(<li>)<br\s*\/?>/i', '$1', $content_html);
$content_html = preg_replace('/(<\/li>)<br\s*\/?>/i', '$1', $content_html);
$content_html = preg_replace('/(<\/ul>)<br\s*\/?>/i', '$1', $content_html);
$content_html = preg_replace('/(<\/ol>)<br\s*\/?>/i', '$1', $content_html);
$content_html = preg_replace('/(<\/p>)<br\s*\/?>/i', '$1', $content_html);

// テーブルタグ内の <br /> を除去
$content_html = preg_replace_callback('/<table.*?>.*?<\/table>/is', function ($match) {
    return preg_replace('/<br\s*\/?>/i', '', $match[0]);
}, $content_html);

// 改行文字を <br> に変換（LaTeXで \\ に変換される）
//$content_html = nl2br($content_clean);




// HTML構築（CSSで折り返し指示を追加）
$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>{$title_raw}</title>
  <style>
    body {
      word-break: break-word;
      overflow-wrap: break-word;
    }
  </style>
</head>
<body>
  <h1>{$title_raw}</h1>
  {$content_html}
</body>
</html>
HTML;

// 一時HTMLファイル出力
$tmp_html = tempnam('D:/00_WP/Export/', 'epu');
rename($tmp_html, $tmp_html . '.html');
$tmp_html .= '.html';
file_put_contents($tmp_html, $html);


// 出力ファイルパス設定
$datetime = date('Ymd_His');
$save_dir = 'D:/00_WP/Export/';
if (!file_exists($save_dir)) {
    mkdir($save_dir, 0755, true);
}
$epub_file = "{$save_dir}{$title_safe}_ID{$id}_{$datetime}.epub";
$pdf_file  = "{$save_dir}{$title_safe}_ID{$id}_{$datetime}.pdf";

// PandocとPDFエンジンのパス
$pandoc     = '"C:\Users\kasai\AppData\Local\Pandoc\\pandoc.exe"';
$pdf_engine = '"E:\texlive\2025\bin\windows\xelatex.exe"';

// EPUB生成コマンド
$cmd_epub = "{$pandoc} \"{$tmp_html}\" -o \"{$epub_file}\"";

// PDF生成コマンド（HTML構造維持＋日本語フォント指定）
//$cmd_pdf = "{$pandoc} --from=html+smart \"{$tmp_html}\" -o \"{$pdf_file}\" --pdf-engine={$pdf_engine} -V mainfont=\"Meiryo UI\" 2>&1";

$template = 'D:/00_WP/template.tex';
$cmd_pdf = "{$pandoc} --from=html+smart \"{$tmp_html}\" -o \"{$pdf_file}\" --pdf-engine={$pdf_engine} --template=\"{$template}\" 2>&1";

// HTML出力ファイル名（タイトルベース）
$html_file = "{$save_dir}{$title_safe}_ID{$id}_{$datetime}.html";
// HTMLファイル保存
file_put_contents($html_file, $html);


// 実行
exec($cmd_epub, $out_epub, $status_epub);
exec($cmd_pdf,  $out_pdf,  $status_pdf);

// 結果表示
echo "<pre>EPUBコマンド:\n{$cmd_epub}\n\nPDFコマンド:\n{$cmd_pdf}\n</pre>";

if ($status_epub === 0) {
    echo "✅ EPUB生成成功<br>保存場所: {$epub_file}<br>";
} else {
    echo "❌ EPUB変換に失敗しました。<br><pre>" . implode("\n", $out_epub) . "</pre>";
}

if ($status_pdf === 0) {
    echo "✅ PDF生成成功<br>保存場所: {$pdf_file}<br>";
} else {
    echo "❌ PDF変換に失敗しました。<br><pre>" . implode("\n", $out_pdf) . "</pre>";
}
?>
