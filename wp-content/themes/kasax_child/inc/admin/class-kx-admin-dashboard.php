<?php
namespace Kx\Admin;

//use Kx\Core\SystemConfig as Su;
//use Kx\Database\Hierarchy;

/**
 * 物語制作支援システム 管理画面コントローラー
 */
class Dashboard {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
    }

    /**
     * 左メニューへの登録
     */
    public function add_admin_menu() {
        // 親メニュー（トップページ）
        $parent_slug = 'kx-dashboard';
        add_menu_page(
            '管理画面：kasax_child', // ブラウザのタブやタイトルタグに表示されるページタイトルです
            'kasax_child管理',       // 管理画面の左メニューに実際に表示されるテキスト（メニュー名）です
            'manage_options',     // このメニューを表示できるユーザー権限（例：管理者のみ）を指定します
            $parent_slug,         // このメニューを識別するための固有のID（スラッグ）です
            [$this, 'render_dashboard'], // メニューがクリックされた際に実行される表示用の関数（メソッド）を指定します
            'dashicons-rest-api', // メニューの横に表示されるアイコン（WordPress標準のDashicons）の種類です
            2                     // メニューが表示される上下の位置（並び順）を数値で指定します
        );

        // 2. サブメニュー：トップ（親と同じスラッグを指定することで、トップ項目を明示的に作成）
        add_submenu_page(
            $parent_slug,
            'kasax_childダッシュボード',
            'TOP画面',
            'manage_options',
            $parent_slug,
            [$this, 'render_dashboard']
        );

        // 3. サブメニュー：ステータス一覧（ここを修正）
        add_submenu_page(
            $parent_slug,
            'ステータス一覧',
            'ステータス一覧',
            'manage_options',
            'kx-status-list',
            [$this, 'render_status_page']
        );

        // 4. サブメニュー：階層・整合性管理
        add_submenu_page(
            $parent_slug,
            '階層・整合性管理',
            '階層管理',
            'manage_options',
            'kx-json-manager',
            [$this, 'render_hierarchy_page']
        );
    }

    /**
     * 各ページの描画メソッド（中身は別テンプレートを呼ぶ）
     */
    public function render_status_page() {
        $this->load_view('status-list.php');
    }

    public function render_hierarchy_page() {
        $this->load_view('hierarchy-manager.php');
    }

    public function render_json_page() {
        $this->load_view('json-manager.php');
    }

    private function load_view($file_name) {
        $view_path = get_stylesheet_directory() . '/templates/admin/' . $file_name;
        if (file_exists($view_path)) {
            include $view_path;
        }
    }



    /**
     * 管理画面（TOP）の描画
     */
    public function render_dashboard() {
        // 最新の投稿30件を取得
        $recent_posts = get_posts([
            'post_type'      => 'post',
            'posts_per_page' => 30,
            'post_status'    => 'publish',
            'orderby'        => 'modified', // 更新日で並び替え
            'order'          => 'DESC',     // 降順（新しい順）
        ]);


        // 最新の固定ページ10件を取得
        $recent_pages = get_posts([
            'post_type'      => 'page',
            'posts_per_page' => 5,
            'post_status'    => 'publish',
            'orderby'        => 'modified', // 更新日で並び替え
            'order'          => 'DESC',     // 降順（新しい順）
        ]);

        // MySQLエラーログの取得と解析
        $error_log_data = $this->get_mysql_error_stats();

        // システム診断（メンテナンス）結果の取得
        $maintenance_data = $this->get_maintenance_stats();



        // テンプレートに渡すデータ
        $stats = [
            'recent_posts'  => $recent_posts,
            'recent_pages'  => $recent_pages,
            'total_nodes'   => $this->get_node_count(),
            'virtual_nodes' => $this->get_virtual_count(),
            'error_logs'    => $error_log_data,
            'maintenance'   => $maintenance_data, // ★追加：診断結果
        ];

        // 読み込むビューファイル名を確認
        $view_path = get_stylesheet_directory() . '/templates/admin/dashboard-visualizer.php';

        if (file_exists($view_path)) {
            // $stats 変数がテンプレート内で利用可能になります
            include $view_path;
        } else {
            echo '<div class="wrap"><h1>Error</h1><p>Viewファイルが見つかりません。</p></div>';
        }
    }



    /**
     * MySQLエラーログを解析して結果を返す（内部用）
     */
    private function get_mysql_error_stats() {
        $logFilePath = 'D:/00_WP/xampp/mysql/data/mysql_error.log';
        $today = date('Y-m-d');
        $error_found = false;
        $error_time = '';
        $log_content = '';

        if (file_exists($logFilePath) && is_readable($logFilePath)) {
            $logFile = fopen($logFilePath, 'r');
            if ($logFile) {
                // 今日付の[ERROR]を検索するパターン
                $date_pattern = '/(' . preg_quote($today) . '.*)(\d{2}:\d{2}:\d{2}).*\[ERROR\]/';

                while (($line = fgets($logFile)) !== false) {
                    if (preg_match($date_pattern, $line, $matches)) {
                        $error_found = true;
                        $error_time = $matches[2];
                        // ログ内容を蓄積（セキュリティのためパスを一部隠蔽処理）
                        $line_colored = preg_replace('/\'[.]\\\wp0\\\.*bd\'/', '<span style="color:cyan;">$0</span>', $line);
                        $log_content .= esc_html($line_colored) . "\n<br>";
                    }
                }
                fclose($logFile);
            }
        }

        return [
            'has_error' => $error_found,
            'today'     => $today,
            'time'      => $error_time,
            'raw_html'  => $log_content,
        ];
    }



    /**
     * システム診断関数を一括実行し、結果を配列で返す
     * 旧 [KxMaintenance] ショートコードの移植・構造化
     */
    private function get_maintenance_stats() {
        $results = [];

        // 各診断関数の実行結果をラベル付きで格納
        // 注意：これらの関数が未定義の場合にエラーにならないよう function_exists でチェックしています
        $results['db_maintenance'] = function_exists('kx_db_Maintenance') ? kx_db_Maintenance() : '関数未定義';
        $results['title_mismatch'] = function_exists('kx_check_title_tag_mismatch') ? kx_check_title_tag_mismatch() : '関数未定義';
        $results['post_error_id']  = function_exists('kx_get_Post_error_id') ? kx_get_Post_error_id() : '関数未定義';
        $results['trashed_posts']  = function_exists('kx_list_trashed_posts_by_deleted_date') ? kx_list_trashed_posts_by_deleted_date() : '関数未定義';
        $results['integrity_mismatch'] = function_exists('kx_check_db_integrity_mismatch') ? kx_check_db_integrity_mismatch() : '関数未定義';

        // クラスメソッドの呼び出し
        if (class_exists('\Kx\Database\Hierarchy')) {
            $results['hierarchy_maintenance'] = \Kx\Database\Hierarchy::maintenance_full();
        }

        // Laravelテストパーツの読み込み（バッファリングして文字列として取得）
        $laravel_test_part = locate_template('templates/admin/Laravel_test.php');
        if ($laravel_test_part) {
            ob_start();
            include $laravel_test_part;
            $results['laravel_test'] = ob_get_clean();
        } else {
            $results['laravel_test'] = 'ERROR：Laravel_test.php が見つかりません';
        }

        return $results;
    }




    private function get_node_count() {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM wp_kx_hierarchy");
    }

    private function get_virtual_count() {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM wp_kx_hierarchy WHERE is_virtual = 1");
    }
}

// インスタンス化
new Dashboard();