<?php
/*
Plugin Name: KX Math Assets (MathJax ES5)
Description: MathJaxライブラリを子テーマから分離し、管理を容易にするプラグイン。
Version: 1.1
*/

if (!defined('ABSPATH')) exit;

// 1. 本文をチェックして、必要な場合のみフッターでJSを出す準備をする
add_filter('the_content', function($content) {
    if (strpos($content, '$') !== false) {
        add_action('wp_footer', 'kx_inject_mathjax_assets');
    }
    return $content;
}, 20);

// 2. 実際の注入処理
function kx_inject_mathjax_assets() {
    // plugin_dir_url(__FILE__) を使うことで、404エラーを確実に防ぎます
    $base_url = plugin_dir_url(__FILE__) . 'assets/es5/';
    $js_url = $base_url . 'tex-svg.js'; // 本文の指定に合わせて tex-svg.js を採用

    ?>
    <script>
    window.MathJax = {
      tex: {
        inlineMath: [['$', '$'], ['\\(', '\\)']],
        displayMath: [['$$', '$$'], ['\\[', '\\]']]
      },
      svg: { fontCache: 'global' }
    };
    </script>
    <script id="mathjax-js" src="<?php echo esc_url($js_url); ?>" async></script>
    <?php
}