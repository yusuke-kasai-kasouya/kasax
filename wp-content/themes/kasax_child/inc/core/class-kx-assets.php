<?php
/**
 *D:\00_WP\xampp\htdocs\0\wp-content\themes\kasax_child\inc\core\class-kx-assets.php
 */

namespace Kx\Core;

/**
 * Assets 管理クラス
 * 2025-12-28 理想構成対応版
 */
class Assets {
    public static function init() {
        // フロントエンド読み込み
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_frontend'], 20);
        // 管理画面・ツール読み込み
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_admin']);
    }

    /**
     * 共通基盤スタイルの読み込み (Base層)
     * フロントエンドと独自管理画面の両方で使用する
     */
    private static function enqueue_base_assets($uri, $ver_func) {
        // 1. 【Base】タグ基本定義（旧 1.css）
        wp_enqueue_style('kx-base-core', "$uri/Base/core-elements.css", [], $ver_func('Base/core-elements.css'));
        // 2. 【Base】共通UIパーツ（旧 3.css）
        wp_enqueue_style('kx-base-ui', "$uri/Base/common-ui.css", ['kx-base-core'], $ver_func('Base/common-ui.css'));
    }

    /**
     * フロントエンド専用の読み込み
     */
    public static function enqueue_frontend() {
        $uri = get_stylesheet_directory_uri() . '/assets/css';
        $path = get_stylesheet_directory() . '/assets/css';

        $ver = function($rel_path) use ($path) {
            return file_exists("$path/$rel_path") ? filemtime("$path/$rel_path") : '1.0.0';
        };

        // 基盤読み込み
        self::enqueue_base_assets($uri, $ver);

        // 3. 【Layout: Visual】フロント限定の装飾・アニメーション（a:hover拡大など）
        wp_enqueue_style('kx-layout-visual', "$uri/Layout/front-visual.css", ['kx-base-ui'], $ver('Layout/front-visual.css'));

        // 4. 【Layout: Width】解像度判定
        $is_1920 = false;
        if ( class_exists('\KxSu') ) {
            $is_1920 = preg_match(\KxSu::get('title_preg')['1920'], get_the_title());
        }
        $res_file = $is_1920 ? 'screen-1920.css' : 'screen-1440.css';
        wp_enqueue_style('kx-layout-width', "$uri/Layout/$res_file", ['kx-layout-visual'], $ver("Layout/$res_file"));

        // 5. 【Layout: Level】権限判定
        $level = (current_user_can('level_10') || current_user_can('level_7')) ? 'Lv-10' : 'Lv-0';
        wp_enqueue_style('kx-layout-level', "$uri/Layout/$level.css", ['kx-layout-width'], $ver("Layout/$level.css"));

        // 6. 【Theme】カラーモード判定
        $theme_mode = 'normal';
        if ( class_exists('\KxSu') && \KxSu::get('display_colors_css') === 'd' ) {
            $theme_mode = 'dark';
        }
        $mode_sfx = ($theme_mode === 'dark') ? 'd' : 'n';

        wp_enqueue_style('kx-theme-core', "$uri/Theme/$theme_mode/kx_$mode_sfx.css", ['kx-layout-level'], $ver("Theme/$theme_mode/kx_$mode_sfx.css"));
        wp_enqueue_style('kx-theme-type', "$uri/Theme/$theme_mode/type_color_$mode_sfx.css", ['kx-theme-core'], $ver("Theme/$theme_mode/type_color_$mode_sfx.css"));

        // 7. 【Modules】特定テンプレート専用
        if ( is_page_template('page-templates/ResizePage.php') ) {
            wp_enqueue_style('kx-module-kanri', "$uri/Modules/admin-custom.css", ['kx-theme-type'], $ver('Modules/admin-custom.css'));
        }
    }

    /**
     * 管理画面（独自ページ ?page=kx）用の読み込み
     * front-visual.css を除外することでレイアウト崩れを防ぐ
     */
    public static function enqueue_admin($hook) {
        if ( isset($_GET['page']) && $_GET['page'] === 'kx' ) {
            $uri = get_stylesheet_directory_uri() . '/assets/css';
            $path = get_stylesheet_directory() . '/assets/css';
            $ver = function($rel_path) use ($path) {
                return file_exists("$path/$rel_path") ? filemtime("$path/$rel_path") : '1.0.0';
            };

            // 1. 基盤のみを読み込み（front-visualは読み込まない）
            self::enqueue_base_assets($uri, $ver);

            // 2. 管理画面専用の微調整
            wp_enqueue_style('kx-module-admin-custom', "$uri/Modules/admin-custom.css", ['kx-base-ui'], $ver('Modules/admin-custom.css'));

            // 必要に応じて管理画面でもテーマカラーを適用する場合
            // ... ここに Theme 判定をコピーすることも可能ですが、
            // 管理画面の標準色を維持するなら基盤と admin-custom だけで十分です。
        }
    }
}

// 初期化実行
Assets::init();