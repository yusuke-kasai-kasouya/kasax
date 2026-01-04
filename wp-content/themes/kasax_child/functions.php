<?php
/**
 * 子テーマfunction。
 * xampp\htdocs\0\wp-content\themes\kasax_child\functions.php
 * 2026-01-02
 *
 * @return void
 */

// 1. 親テーマのスタイル読み込み
add_action( 'wp_enqueue_scripts' , function() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
});



// 2. 自動読み込み設定（まずは database のみ追加）
$inc_directories = [
    'core',// SystemConfig(Su) や DynamicRegistry(Dy) を最優先
    'database', // inc/database/ 内のファイルを自動ロード
    'admin',
    'utils',
];

foreach ( $inc_directories as $dir ) {
    $path = get_stylesheet_directory() . '/inc/' . $dir;
    if ( is_dir( $path ) ) {
        // globの戻り値をチェックし、確実にPHPファイルのみを読み込む
        $files = glob( "$path/*.php" );
        if ( $files ) {
            foreach ( $files as $filename ) {
                require_once $filename;
            }
        }
    }
}

// 3. 既存の core-loader を読み込む（他のファイルはまだ lib/ にあるため。2025年12月27日より、フォルダ構成最適化中。）
$core_loader = 'inc/core-loader.php';
if ( locate_template( $core_loader ) ) {
    require_once locate_template( $core_loader, true );
}