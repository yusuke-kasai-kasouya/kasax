<?php
/**
 * Hierarchy クラス
 * D:\00_WP\xampp\htdocs\0\wp-content\themes\kasax_child\inc\database\Hierarchy.php
 *
 * 物語制作支援システムにおけるタイトルの「≫」区切りによる階層構造を
 * wp_kx_hierarchy テーブルにマッピング管理する。
 *
 * 仕様：wp_kx_hierarchyテーブルのupdate処理はsave_with_log()を経由すること。
 */

namespace Kx\Database;

use Kx\Utils\Time; // 仕様書に基づき Time クラスを使用
use Kx\Core\DynamicRegistry as Dy;

class Hierarchy {

    private static $mt_list = [];

    /**
     * メインの同期処理
     * @param array  $args ['id' => ポストID, 'title' => タイトル]
     * @param string $type 'insert' | 'update' | 'id' 等
     */
    public static function sync($args, $type) {
        switch ($type) {
            case 'insert':
            case 'update':
            case 'id':
                return self::sync_by_post_id($args);
            case 'feed_dy':

                $post_id = $args['id'] ?? null;

                if (Dy::get_content_cache($post_id, 'hierarchy') !== null) return;

                return self::feed_dy($args);

            case 'delete':
                return self::process_delete($args);
            case 'integrity_check': // 仕様書にある整合性監視用
                return self::check_integrity($args);
            default:
                // 未知のタイプに対するエラーハンドリングまたはログ
                break;
        }
    }


    /**
     * 登録・更新の統合処理
     */
    private static function sync_by_post_id($args) {
        //var_dump(Dy::get('cotent'));

        global $wpdb;
        $table = $wpdb->prefix . 'kx_hierarchy';
        $post_id = isset($args['id']) ? intval($args['id']) : 0;
        if ($post_id <= 0) return;

        $kx0_cache = Dy::get_content_cache($post_id, 'db_kx0');

        //var_dump(Dy::get_content_cache($post_id, 'db_kx0'));

        // ステータスチェック（修正済み）
        $post_status = ($kx0_cache) ? 'publish' : get_post_status($post_id);
        if ($post_status === 'trash' || !$post_status) {
            self::purge_post_record($post_id, 'trash');
            return;
        }

        $current_title_path = (isset($kx0_cache['title'])) ? $kx0_cache['title'] : get_the_title($post_id);


        // 現在DBに登録されているパスを取得
        //$db_path = $wpdb->get_var($wpdb->prepare("SELECT full_path FROM $table WHERE post_id = %d", $post_id));
        // ...


        if ($post_id > 0) {
            //echo $post_id;
            //echo '<br>';
            //$status = get_post_status($post_id);
            // 1. まず「現在の記事のタイトル（これが新しいパスになる）」を取得

            $db_path = $wpdb->get_var($wpdb->prepare("SELECT full_path FROM $table WHERE post_id = %d", $post_id));
            //echo $db_path.'<hr>';

            if (!empty($db_path) && $current_title_path !== $db_path) {
                // タイトル変更なら古いパスのレコードのみ抹消（メタデータは保護）。
                // ここで return しないことで、下のロジックにより「新しいパス」が即座に生成される。
                self::purge_post_record($post_id, 'mismatch');
            }

            $existing_record = $wpdb->get_row($wpdb->prepare(
                "SELECT full_path, is_virtual, post_id FROM $table WHERE full_path = %s",
                $current_title_path
            ));

            if( $existing_record )
            {
                //$_full_path = $existing_record->full_path;
                //var_dump($existing_record);
                //var_dump($existing_record->full_path);
                //$_full_path = $existing_record->full_path;
                //echo $_full_path;

                // A: すでに virtual として存在している場合 → 実体化（昇格）
                if ((int)$existing_record->is_virtual === 1) {
                    $wpdb->update(
                        $table,
                        [
                            'post_id'    => $post_id,
                            'is_virtual' => 0,
                            'time'       => time()
                        ],
                        ['full_path' => $current_title_path],
                        ['%d', '%d', '%d'],
                        ['%s']
                    );
                    // 実体化したので、この後の新規 INSERT を防ぐために return するか、
                    // あるいは後続の JSON 更新処理に流す
                }
                // B: すでに誰か別の実体(is_virtual=0)がこのパスを占有している場合
                elseif ((int)$existing_record->post_id !== $post_id) {
                    // ここは運用ルール次第ですが、基本は「上書き」か「スキップ」
                    // 今回は「最新の post_id で上書き」するなら update へ
                }
            }
        }


        //$full_title = isset($args['title']) ? $args['title'] : $current_title_path;

        //echo $full_title;
        //echo '+<br>';

        if (empty($current_title_path)) return;

        $nodes = explode('≫', $current_title_path);
        $current_path = '';
        $ancestor_data = []; // 連想配列として初期化

        foreach ($nodes as $index => $node_name) {
            $parent_path = ($index === 0) ? NULL : $current_path;
            $current_path .= ($index === 0) ? $node_name : '≫' . $node_name;

            // 既存データの取得
            $existing = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE full_path = %s", $current_path));
            $json_data = ($existing && !empty($existing->json)) ? json_decode($existing->json, true) : [];

            $is_final = ($index === count($nodes) - 1);
            $target_id = $is_final ? $post_id : ($existing->post_id ?? 0);

            // --- A. hierarchy_role (最上位判定) ---
            if ($index === 0) {
                $json_data['hierarchy_role'] = 'origin';
            } else {
                unset($json_data['hierarchy_role']);
            }

            // --- B. ancestry (祖先リスト) の構築 ---
            // 自身より上の階層（index 0 〜 index-1）を ancestry にセット
            $json_data['ancestry'] = $ancestor_data;

            // 次のループ（子階層）のために、自身の情報を ancestry 用のリストに追加
            // キーを 1, 2, 3... とするために index + 1 を使用
            $ancestor_data[$index + 1] = ($target_id > 0) ? (string)$target_id : "virtual";

            // --- C. descendants (子孫) 登録のための親通知 ---
            if (!empty($parent_path)) {
                self::register_to_parent($parent_path, $target_id, $node_name, $table);
            }

            // (既存の [raretu] 確認やアラート判定ロジック...)
            $json_data['raretu'] = self::check_raretu_from_kx1($target_id);
            $json_data = self::judge_hierarchy_alert($current_path, $is_final, $json_data, $table);


            $data = [
                'post_id'     => $target_id,
                'parent_path' => $parent_path,
                'level'       => $index + 1,
                'is_virtual'  => ($target_id > 0) ? 0 : 1,
                // ここで 'json' キーを定義せず、関数に任せる
            ];

            //echo $post_id;
            //echo '<br>';
            //echo $target_id;
            //echo '<hr>';

            // 関数内で $json_data（配列）を検証し、
            // $data['json'] にエンコード済みの文字列をセットして戻す
            $data = self::clean_json_id($json_data, $data , $post_id);

            /*
            if( $post_id == $target_id )
            {
                echo $full_title;
                echo '+<br>';
            }
            */

            // 変更があるかどうかのフラグを初期化
            $has_change = true;

            // 既存データがある場合のみ、内容を比較する
            if ($existing) {
                $has_change = false; // いったん false（変更なし）とする

                foreach ($data as $key => $value) {
                    // ★★ データベースの既存値と新しい値を比較（値が存在しない、または異なる場合）
                    if (!property_exists($existing, $key) || (string)$existing->$key !== (string)$value) {
                        $has_change = true;
                        break;
                    }
                }
            }

            // 変更がある場合のみ保存処理を実行
            if ($has_change) {
                // 履歴付き保存
                $action = ($target_id > 0) ? 'u' : 'i';
                self::save_with_log($current_path, $data, $action);
            }

            if ($target_id === $post_id) {
                // save_with_log 内で付与された time や text を反映させるため、
                // 最新の状態を整理して Dy にセット
                $cache_data = $data;
                $cache_data['full_path'] = $current_path;
                $cache_data['time'] = time(); // 保存時刻と合わせる

                // db_hierarchy グループとしてキャッシュを最新化
                Dy::set_content_cache($post_id, 'db_hierarchy', $cache_data);
            }

            // 履歴付き保存
            /*
            $action = ($target_id > 0) ? 'u' : 'i';
            self::save_with_log($current_path, $data, $action);
            */
            //unset($data, $action ,$json_data);
        }
    }


    /**
     * DBから階層データを取得し、Dyキャッシュに供給する
     *
     * @param array $args ['id' => ポストID]
     * @return void
     */
    private static function feed_dy($args) {

        $post_id = $args['id'] ?? null;
        if (!$post_id) return;

        global $wpdb;
        $table = $wpdb->prefix . 'kx_hierarchy';

        // 1. DBから該当ポストの階層レコードを1件取得
        // Hierarchyテーブルは post_id ではなく full_path が主キーの可能性があるため、
        // post_id で検索して最新または単一のレコードを特定します。
        $data = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table WHERE post_id = %d LIMIT 1", $post_id),
            ARRAY_A
        );

        // 2. データが存在する場合のみ、Dyの 'db_hierarchy' グループにセット
        if ($data) {
            Dy::set_content_cache($post_id, 'db_hierarchy', $data);
        }
    }



    /**
     * 未設定
     *
     * @param [type] $args
     * @return void
     */
    private static function process_delete($args) {
        // 削除時の階層クリーニングロジック
    }


    /**
     * 未設定
     *
     * @param [type] $args
     * @return void
     */
    private static function check_integrity($args) {
        // 未設定
    }


    /**
     * JSONデータのクリーンアップと整合性チェック
     * * 1. descendants: wp_kx_0 に不在、またはパスが前方一致しないIDを排除
     * 2. ancestry: wp_kx_0 に不在のIDを "virtual" に置換
     * 3. save_with_log を通じて text カラム（日時+フラグ）を更新
     * * @param array $json_data  デコード済みのJSON配列
     * @param array $data       保存対象のレコードデータ (full_path 等を含む)
     * @return array クリーンアップ後の $data
     */
    private static function clean_json_id($json_data, $data,$post_id) {
        global $wpdb;
        $kx0_table = $wpdb->prefix . 'kx_0';
        //$my_path = $data['full_path'] ?? '';
        $my_path = get_the_title($post_id);

        /*
        if (
            !empty($json_data['descendants'])
            && is_array($json_data['descendants'])
            && ( $post_id == $data['post_id'] )
            ) {
            echo get_the_title($post_id);
            echo $post_id;
            echo '<br>';
            var_dump($json_data['descendants']);
            echo '<hr>';
        }
            */



        // descendants の検証
        if (
            !empty($json_data['descendants'])
            && is_array($json_data['descendants'])
            && ( $post_id == $data['post_id'] )
        ) {

            $cleaned_descendants = [];

            //var_dump($json_data['descendants']);
            //echo '<hr>';
            foreach ($json_data['descendants'] as $child_id) {

                //echo $my_path;
                //echo '<br>';

                // 存在チェック
                $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $kx0_table WHERE id = %d", $child_id));
                //echo get_the_title($child_id) .'<br>';
                //echo $child_id;

                //echo $child_title.'<br>'.$my_path . '≫'.$child_id.'<hr>';

                if ($exists) {

                    // 階層パスの前方一致チェック (かつての子を排除)
                    $child_title = get_the_title($child_id);
                    $expected_prefix = $my_path ;
                    //echo $child_title.'<br>'.$my_path . '≫'.$child_id.'<hr>';
                    if (strpos($child_title, $expected_prefix) === 0) {
                        //echo '+';

                        $cleaned_descendants[] = (string)$child_id;
                        //var_dump($cleaned_descendants);
                    }

                }
                //echo '<hr>';
            }
            $json_data['descendants'] = $cleaned_descendants;
            //var_dump($json_data['descendants']);
            //echo '<hr>';
        }


        if (
            !empty($json_data['virtual_descendants'])
            && is_array($json_data['virtual_descendants'])
            && ( $post_id == $data['post_id'] )
        ) {

            $_virtual_descendants = [];
            foreach( $json_data['virtual_descendants'] as $_title )
            {
                //echo $my_path.'≫'.$_title;
                //echo '<br>';

                // テーブル名と検索したい文字列を指定
                $_table_name = $wpdb->prefix . 'kx_hierarchy'; // または "wp_kx_hierarchy"
                $target_path = $my_path.'≫'.$_title; // 検索したい文字列

                // get_var で post_id を取得
                $_post_id = $wpdb->get_var($wpdb->prepare(
                    "SELECT post_id FROM $_table_name WHERE full_path = %s",
                    $target_path
                ));

                if ( $_post_id == 0 ) {
                    // 一致するものがあった場合の処理
                    //echo "見つかったポストID: " . $post_id;
                    $_virtual_descendants[] = $_title;
                }
            }
            $json_data['virtual_descendants'] = $_virtual_descendants;
        }


        // ancestry の検証
        if (!empty($json_data['ancestry']) && is_array($json_data['ancestry'])) {
            foreach ($json_data['ancestry'] as $level => $parent_id) {
                if ($parent_id === 'virtual') continue;
                $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $kx0_table WHERE id = %d", $parent_id));
                if (!$exists) {
                    $json_data['ancestry'][$level] = "virtual";
                }
            }
        }

        // 最終データをJSON化してセット
        $data['json'] = json_encode($json_data, JSON_UNESCAPED_UNICODE);
        return $data;
    }



    /**
     * 親レコードに対し、自身を子（descendants または virtual_descendants）として登録
     */
    private static function register_to_parent($parent_path, $my_id, $my_name, $table) {
        global $wpdb;
        $parent = $wpdb->get_row($wpdb->prepare("SELECT json FROM $table WHERE full_path = %s", $parent_path));
        if (!$parent) return;

        $json = json_decode($parent->json, true) ?: [];
        // ★★ 変更があったかどうかを判定するフラグを初期化
        $updated = false;


        if ($my_id > 0) {
            // 実体がある場合：IDを descendants に追加
            $list = isset($json['descendants']) ? (array)$json['descendants'] : [];
            if (!in_array((string)$my_id, $list)) {
                $list[] = (string)$my_id;
                $json['descendants'] = array_values(array_unique($list));
                // ★★ IDが追加されたのでフラグを真にする
                $updated = true;

            }
        } else {
            // 実体がない場合：名前を virtual_descendants に追加
            $list = isset($json['virtual_descendants']) ? (array)$json['virtual_descendants'] : [];
            if (!in_array($my_name, $list)) {
                $list[] = $my_name;
                $json['virtual_descendants'] = array_values(array_unique($list));
                // ★★ 名前が追加されたのでフラグを真にする
                $updated = true;
            }
        }
        // ★★ フラグが true の場合（＝リストに未登録だった場合）のみ保存を実行
        if ($updated) {
            // 親の更新時も履歴を残す
            self::save_with_log($parent_path, ['json' => json_encode($json, JSON_UNESCAPED_UNICODE)], 'u');
        }

        // 親の更新時も履歴を残す
        //self::save_with_log($parent_path, ['json' => json_encode($json, JSON_UNESCAPED_UNICODE)], 'u');
    }



    /**
     * wp_kx_1 から ShortCODE: raretu の有無を判定
     */
    private static function check_raretu_from_kx1($id) {
        global $wpdb;
        if ($id <= 0) return 0;

        // 修正
        $table_kx1 = $wpdb->prefix . 'kx_1';
        $kx1_json = $wpdb->get_var($wpdb->prepare("SELECT json FROM $table_kx1 WHERE id = %d", $id));

        if (!$kx1_json) return 0;
        $data = json_decode($kx1_json, true);
        return (isset($data['ShortCODE']) && $data['ShortCODE'] === 'raretu') ? 1 : 0;
    }



    /**
     * 階層アラートの判定ロジック
     */
    private static function judge_hierarchy_alert($path, $is_final, $json_data, $table) {
        global $wpdb;
        $has_raretu = $json_data['raretu'] ?? 0;
        $should_alert = false;

        if (!$is_final) {
            $should_alert = ($has_raretu === 0);
        } else {
            $has_child = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE parent_path = %s", $path));
            $should_alert = ($has_child > 0 && $has_raretu === 0);
        }

        if ($should_alert) {
            $json_data['alert'] = 1;
        } else {
            unset($json_data['alert']);
        }
        return $json_data;
    }






    /**
     * 指定した親パスの直下の子要素を取得 (#1 用)
     */
    public static function get_children($parent_path = NULL) {
        global $wpdb;
        $table = $wpdb->prefix . 'kx_hierarchy';
        $query = $parent_path === NULL
            ? "SELECT * FROM $table WHERE parent_path IS NULL"
            : $wpdb->prepare("SELECT * FROM $table WHERE parent_path = %s", $parent_path);

        return $wpdb->get_results($query);
    }



    /**
     * ツリー表示 + 投稿作成処理の実行
     */
    public static function get_full_tree_text($parent_path = NULL, $indent = "", $recursive = true) {
        $text = "";

        // 作成成功メッセージの表示（URLパラメータから判定）
        if ($parent_path === NULL && isset($_GET['kx_created'])) {
            $text .= '<div style="background:#4ec9b0; color:#000; padding:10px; margin-bottom:10px; border-radius:5px; font-weight:bold;">投稿を作成しました。</div>';
        }

        $children = self::get_children($parent_path);
        $count = count($children);

        foreach ($children as $i => $child) {

            $status = get_post_status($child->post_id);
            if ($status === 'trash') {
                self::purge_post_record($child->post_id, 'trash');
                continue;
            }
            elseif ($child->is_virtual == 0 && $child->full_path !== get_the_title($child->post_id)) {
                // 第2引数を 'mismatch' にすることで、メタデータ(kx_db0)を保護しつつ掃除
                self::purge_post_record($child->post_id, 'mismatch');
                // 削除したため、このループの描画処理はスキップ
                continue;
            }


            $is_last = ($i === $count - 1);
            $branch = $is_last ? "└ " : "├ ";

            $json = !empty($child->json) ? json_decode($child->json, true) : [];
            $has_alert = (isset($json['alert']) && $json['alert'] === 1);
            $full_path = $child->full_path;
            $nodes = explode('≫', $full_path);
            $display_name = end($nodes);

            $create_btn = "";


            // --- 【修正ポイント2】ボタンのHTML構成 ---
            if ($child->is_virtual || (int)$child->post_id === 0) {
                $color = '#f44747'; // Virtual: Red

                // フォームタグを含める
                $create_btn = ' <form method="post" style="display:inline; margin-left:8px;">';
                $create_btn .= '<input type="hidden" name="target_title" value="'.esc_attr($full_path).'">';

                $create_btn .= '<button type="submit" name="create_virtual_post" value="1" style="background:#cc0000; color:#fff; border:none; padding:1px 4px; cursor:pointer; font-size:9px; border-radius:3px;">＋ Create</button>';

                //$create_btn .= '<button type="submit" name="create_virtual_post" value="1" ...>＋ Create</button>';
                $create_btn .= '</form>';

                $label = esc_html($display_name) . ' <span style="font-size:0.8em; opacity:0.8;">(virtual)</span>';
            }
            elseif ($has_alert) {
                $color = '#dcdcaa';
                $url = get_permalink($child->post_id);
                $label = '<a href="' . esc_url($url) . '" target="_blank" style="color:'.$color.'; text-decoration:underline dotted;">' . esc_html($display_name) . ' (alert)</a>';
            }
            else {
                global $wpdb;
                $table = $wpdb->prefix . 'kx_hierarchy';
                $is_parent = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE parent_path = %s", $full_path));
                $color = ($is_parent > 0) ? '#4ec9b0' : '#569cd6';
                $url = get_permalink($child->post_id);
                $label = '<a href="' . esc_url($url) . '" target="_blank" style="color:'.$color.'; text-decoration:none;">' . esc_html($display_name) . '</a>';
            }

            $text .= '<div style="line-height:2.0; white-space:nowrap; font-family: monospace;">';
            $text .= '<span style="color:#555;">' . $indent . $branch . '</span>';
            $text .= '<span style="color:'.$color.'">' . $label . '</span>';
            $text .= $create_btn;
            $text .= '</div>';

            if ($recursive === true) {
                $text .= self::get_full_tree_text($child->full_path, $indent . ($is_last ? "　 " : "│ "), true);
            }
        }
        return $text;
    }





    /**
     * 指定されたベースタイトル以下の階層構造を修復する
     * @param string $base_title 起点となるタイトル
     * @param bool   $recursive  全下位階層をスキャンするかどうか
     */
    public static function repair_hierarchy($base_title, $recursive = false) {
        global $wpdb;
        $table = $wpdb->prefix . 'kx_0'; // 実体データがあるテーブル

        if ($recursive) {
            // 前方一致で指定タイトル以下の全ポストを取得
            $results = $wpdb->get_results($wpdb->prepare(
                "SELECT id, title FROM $table WHERE title LIKE %s",
                $base_title . '%'
            ));
        } else {
            // 直下の階層（次の≫まで）だけを対象にするなど、要件に応じた取得
            $results = $wpdb->get_results($wpdb->prepare(
                "SELECT id, title FROM $table WHERE title = %s",
                $base_title
            ));
        }

        if ($results) {
            foreach ($results as $row) {
                // 現在の最新ロジックである sync を呼び出すことで、
                // ancestry, descendants, origin, text日時 などを一括再構築する
                self::sync(['id' => $row->id, 'title' => $row->title], 'update');
            }
        }
    }

    /**
     * メンテナンス用：統合実行
     * #1のショートコードから呼び出されるメイン関数
     */
    public static function maintenance_full() {

        // 0. 準備：現在の状態をリスト化
        self::$mt_list = self::mt_get_status_lists();


        $report = "<h3>Hierarchy System Maintenance Report</h3>";

        // 1. 実行：wp_kx_0 との同期
        $report .= self::mt_sync_real_with_kx0();

        $report .= self::mt_clean_json();


        //$report .= self::mt_clean_json_ids();
        //$report .= self::mt_clean_mismatched_descendants();

        $report .= self::mt_cleanup_virtual_leaves();


        $report .= self::mt_render_report($log_messages = '');

        $report .= self::mt_list_alert_nodes() ;

        return $report;
    }



    /**
     * Undocumented function
     *
     * @return void
     */
    public static function mt_get_status_lists() {

        global $wpdb;

        $table = $wpdb->prefix . 'kx_hierarchy';

        // 全件取得（メモリ負荷が高い場合は必要なカラムに限定）
        $results = $wpdb->get_results("SELECT post_id, full_path, is_virtual, json FROM $table", ARRAY_A);


        $lists = [
            'virtual' => [],
            'real'    => []
        ];

        if ($results) {
            foreach ($results as $row) {

                $post_id = (int)$row['post_id'];
                $is_virtual = (int)$row['is_virtual'];



                // 1. 実体がある投稿（is_virtual = 0 かつ post_id > 0）の場合、ステータスをチェック
                if ($is_virtual === 0 && $post_id > 0) {
                // WordPress標準関数でステータス取得
                    $status = get_post_status($post_id);

                // ゴミ箱に入っている場合は、リストに追加せずスキップ
                if ($status === 'trash') {
                    // ゴミ箱ならメタデータも含めて完全抹消
                    self::purge_post_record($post_id, 'trash');
                    continue;
                }
                elseif ($row['full_path'] !== get_the_title($post_id)) {
                    // タイトル不一致なら、メタデータは保護しつつ古い階層レコードのみ削除
                    self::purge_post_record($post_id, 'mismatch');
                    continue;
                }

            }


                // full_path をキーにすることで、後続の処理で isset による高速検索を可能にする
                if ((int)$row['is_virtual'] === 1) {
                    $lists['virtual'][$row['full_path']] = $row;
                } else {
                    $lists['real'][$row['full_path']] = $row;
                }
            }
        }

        return $lists;
    }





    /**
     * mt_: Realリストを wp_kx_0 と照合し、存在しないレコードを削除する
     * 同時に、メモリ上の self::$mt_list['real'] も最新の状態に更新する
     */
    private static function mt_sync_real_with_kx0() {
        global $wpdb;
        $table_hierarchy = $wpdb->prefix . 'kx_hierarchy';
        $table_kx0 = $wpdb->prefix . 'kx_0';
        $deleted_count = 0;

        if (empty(self::$mt_list['real'])) {
            return "<li>照合対象のRealデータがありません。</li>";
        }

        // 1. wp_kx_0 に存在するIDをハッシュマップ化（高速照合用）
        $existing_kx0_ids = array_flip($wpdb->get_col("SELECT id FROM $table_kx0"));

        // 2. mt_list['real'] をループしてチェック
        foreach (self::$mt_list['real'] as $full_path => $data) {
            $post_id = (int)$data['post_id'];

            // wp_kx_0 に ID が存在しない場合
            if (!isset($existing_kx0_ids[$post_id])) {

                // A. Hierarchyテーブルから物理削除
                $wpdb->delete(
                    $table_hierarchy,
                    ['full_path' => $full_path],
                    ['%s']
                );

                // B. メモリ上のリスト(self::$mt_list)からも削除して同期
                unset(self::$mt_list['real'][$full_path]);

                $deleted_count++;
            }
        }

        return "<li>wp_kx_0 照合完了: 実体不明のレコードを {$deleted_count} 件削除し、リストを更新しました。</li>";
    }



    /**
     * メンテナンス用：JSONデータの統合クリーンアップ
     * IDsの存在チェックとタイトル不整合チェックを一度のループで実行する
     */
    /**
     * mt_clean_json の最適化版
     */
    private static function mt_clean_json() {
        global $wpdb;
        $table_kx0 = $wpdb->prefix . 'kx_0';
        $table_h = $wpdb->prefix . 'kx_hierarchy'; // プレフィックス修正

        // 全件の ID -> Path マップを一度だけ取得（SQL爆発を防止）
        $id_to_path_map = array_column(
            $wpdb->get_results("SELECT post_id, full_path FROM $table_h WHERE is_virtual = 0", ARRAY_A),
            'full_path',
            'post_id'
        );
        $existing_kx0_ids = array_flip($wpdb->get_col("SELECT id FROM $table_kx0"));

        $updated_count = 0;
        $all_groups = ['real', 'virtual'];

        foreach ($all_groups as $group) {
            foreach (self::$mt_list[$group] as $full_path => $data) {
                if (empty($data['json'])) continue;
                $json_data = json_decode($data['json'], true);
                if (!is_array($json_data)) continue;

                $is_dirty = false;

                // 修正後のロジック呼び出し
                if (self::logic_filter_non_existent_ids($json_data, $existing_kx0_ids)) $is_dirty = true;
                if (self::logic_fix_ancestry_virtual($json_data, $existing_kx0_ids, $full_path)) $is_dirty = true;

                // SQLを発行しない高速版
                if (self::logic_filter_mismatched_descendants_fast($json_data, $full_path, $id_to_path_map)) $is_dirty = true;

                if ($is_dirty) {
                    $new_json_str = json_encode($json_data, JSON_UNESCAPED_UNICODE);
                    self::save_with_log($full_path, ['json' => $new_json_str], 'm');
                    self::$mt_list[$group][$full_path]['json'] = $new_json_str;
                    $updated_count++;
                }
            }
        }
        return "<li>JSON統合クリーンアップ: {$updated_count} 件を最適化しました。</li>";
    }


    /**
     * ロジック：子孫リストから存在しないIDを排除
     */
    private static function logic_filter_non_existent_ids(&$json_data, $existing_kx0_ids) {
        if (!isset($json_data['descendants']) || !is_array($json_data['descendants'])) return false;

        $original_count = count($json_data['descendants']);
        $json_data['descendants'] = array_values(array_filter($json_data['descendants'], function($id) use ($existing_kx0_ids) {
            return isset($existing_kx0_ids[(int)$id]);
        }));

        return count($json_data['descendants']) !== $original_count;
    }


    /**
     * ロジック：先祖リストの整合性チェック
     * 1. ID不在なら "virtual" セット
     * 2. 名前（パス上の名称）が変わっていたら最新の名前に同期（※追加要件）
     */
    private static function logic_fix_ancestry_virtual(&$json_data, $existing_kx0_ids, $current_path) {
        if (!isset($json_data['ancestry']) || !is_array($json_data['ancestry'])) return false;

        $changed = false;
        $path_nodes = explode('≫', $current_path); // 現在のフルパスを分割

        foreach ($json_data['ancestry'] as $level => $parent_id) {
            $index = $level - 1;
            if (!isset($path_nodes[$index])) continue;

            // IDチェック：実体テーブルに存在しない場合、"virtual" に変更
            if ($parent_id !== 'virtual' && !isset($existing_kx0_ids[(int)$parent_id])) {
                $json_data['ancestry'][$level] = "virtual";
                $changed = true;
            }

            // 【重要】名前変更チェック：現在のパス構成と、保存されているレベルが矛盾していないか
            // ancestryは通常 ID を保存しているが、もしここを名前管理にする場合や、
            // 階層深さが変わっている場合の整合性担保ロジックをここに集約する
        }
        return $changed;
    }



    /**
     * 高速版：メモリ上のマップを使用してパス不整合をチェック
     */
    private static function logic_filter_mismatched_descendants_fast(&$json_data, $current_path, $id_to_path_map) {
        if (!isset($json_data['descendants']) || !is_array($json_data['descendants'])) return false;

        $changed = false;
        $valid_descendants = [];
        $prefix = $current_path . '≫';

        foreach ($json_data['descendants'] as $child_id) {
            $child_id = (int)$child_id;
            $child_path = $id_to_path_map[$child_id] ?? null; // メモリから取得

            if ($child_path && strpos($child_path, $prefix) === 0) {
                $valid_descendants[] = (string)$child_id;
            } else {
                $changed = true;
            }
        }
        if ($changed) $json_data['descendants'] = array_values($valid_descendants);
        return $changed;
    }



    /**
     * ロジック：タイトル（パス）が前方一致しない子孫を排除
     */
    private static function logic_filter_mismatched_descendants(&$json_data, $current_path) {
        global $wpdb;
        $table_h = $wpdb->prefix . 'kx_hierarchy'; //

        if (!isset($json_data['descendants']) || !is_array($json_data['descendants'])) return false;

        $changed = false;
        $valid_descendants = [];
        $prefix = $current_path . '≫'; //

        foreach ($json_data['descendants'] as $child_id) {
            $child_id = (int)$child_id;
            // 子の現在のパスをDBから取得
            $child_path = $wpdb->get_var($wpdb->prepare("SELECT full_path FROM $table_h WHERE post_id = %d", $child_id));

            if ($child_path && strpos($child_path, $prefix) === 0) { //
                $valid_descendants[] = (string)$child_id;
            } else {
                $changed = true; //
            }
        }

        if ($changed) {
            $json_data['descendants'] = array_values($valid_descendants); //
        }
        return $changed;
    }




    /**
     * mt_: 全レコード(Real/Virtual)のJSON内から、wp_kx_0に存在しないIDを排除する
     * save_with_log を経由して text カラムの日時を更新する
     */
    /*
    private static function mt_clean_json_ids() {
        global $wpdb;
        $table_kx0 = $wpdb->prefix . 'kx_0';
        $updated_count = 0;

        // 1. wp_kx_0 に存在する有効なIDリストを取得
        $existing_kx0_ids = array_flip($wpdb->get_col("SELECT id FROM $table_kx0"));

        // 2. メモリ上の self::$mt_list (real と virtual 両方) を走査
        $all_groups = ['real', 'virtual'];

        foreach ($all_groups as $group) {
            if (empty(self::$mt_list[$group])) continue;

            foreach (self::$mt_list[$group] as $full_path => $data) {
                if (empty($data['json'])) continue;

                $json_data = json_decode($data['json'], true);
                if (!is_array($json_data)) continue;

                $is_dirty = false;
                // ancestry と descendants の配列をチェック
                foreach (['ancestry', 'descendants'] as $key) {
                    if (isset($json_data[$key]) && is_array($json_data[$key])) {
                        $original_count = count($json_data[$key]);

                        // IDをフィルタリング（wp_kx_0 に存在するものだけ残す）
                        $json_data[$key] = array_values(array_filter($json_data[$key], function($id) use ($existing_kx0_ids) {
                            return isset($existing_kx0_ids[(int)$id]);
                        }));

                        if (count($json_data[$key]) !== $original_count) {
                            $is_dirty = true;
                        }
                    }
                }

                // 変更があった場合、save_with_log を経由してDBとメモリを更新
                if ($is_dirty) {
                    $new_json_str = json_encode($json_data, JSON_UNESCAPED_UNICODE);

                    // save_with_log($path, $data, $action_type) を使用
                    // 第3引数 'm' は Maintenance の意
                    self::save_with_log($full_path, ['json' => $new_json_str], 'm');

                    // メモリ上のリストも最新化
                    self::$mt_list[$group][$full_path]['json'] = $new_json_str;
                    $updated_count++;
                }
            }
        }

        return "<li>JSON IDクリーンアップ: {$updated_count} 件のレコードを修復・保存しました。</li>";
    }
        */


    /**
     * mt_: 子孫リスト(descendants)を検証し、自身のパスと前方一致しないIDを排除する。
     * タイトル変更によって「かつての子」が別階層へ移動した場合の不整合を解消する。
     */
    /*
    private static function mt_clean_mismatched_descendants() {
        global $wpdb;
        $table_h = $wpdb->prefix . 'kx_hierarchy';
        $updated_count = 0;

        // 全レコード（Real/Virtual）を対象にループ
        $all_groups = ['real', 'virtual'];

        foreach ($all_groups as $group) {
            if (empty(self::$mt_list[$group])) continue;

            foreach (self::$mt_list[$group] as $current_path => $data) {
                if (empty($data['json'])) continue;

                $json_data = json_decode($data['json'], true);
                if (!isset($json_data['descendants']) || !is_array($json_data['descendants'])) continue;

                $original_count = count($json_data['descendants']);
                $valid_descendants = [];
                $is_dirty = false;

                foreach ($json_data['descendants'] as $child_id) {
                    $child_id = (int)$child_id;
                    // 子の現在のパスをDBから直接取得（最新の情報を得るため）
                    $child_current_path = $wpdb->get_var($wpdb->prepare(
                        "SELECT full_path FROM $table_h WHERE post_id = %d",
                        $child_id
                    ));

                    if ($child_current_path) {
                        // 自身のパス + '≫' で始まっているか確認
                        $prefix = $current_path . '≫';
                        if (strpos($child_current_path, $prefix) === 0) {
                            // 正当な子孫なので保持
                            $valid_descendants[] = (string)$child_id;
                        } else {
                            // タイトル変更等で他所へ移った子孫なので排除
                            $is_dirty = true;
                        }
                    } else {
                        // そもそも子が存在しない場合も排除
                        $is_dirty = true;
                    }
                }

                // 変更があった場合、保存
                if ($is_dirty) {
                    $json_data['descendants'] = array_values($valid_descendants);
                    $new_json_str = json_encode($json_data, JSON_UNESCAPED_UNICODE);

                    // 履歴付き保存（アクション 'm'）
                    self::save_with_log($current_path, ['json' => $new_json_str], 'm');

                    // メモリ上のリストも更新
                    self::$mt_list[$group][$current_path]['json'] = $new_json_str;
                    $updated_count++;
                }
            }
        }

        return "<li>タイトル不整合チェック完了: {$updated_count} 件の親子関係を修復しました。</li>";
    }
        */





    /**
     * mt_: virtualリストのうち、下位(descendants)が存在しない空の仮想階層を削除する。
     * 削除された場合、親の descendants リストからも自身のパスを削除し、
     * 親も空になれば再帰的に削除を行う。
     */
    private static function mt_cleanup_virtual_leaves() {
        $deleted_paths = [];

        if (empty(self::$mt_list['virtual'])) {
            return "<li>仮想階層のデータがありません。</li>";
        }

        // virtualリストをコピーしてループ（ループ内でのunsetによる影響を避けるため）
        $virtual_copy = self::$mt_list['virtual'];

        foreach ($virtual_copy as $full_path => $data) {
            // すでに再帰処理で削除されている場合はスキップ
            if (!isset(self::$mt_list['virtual'][$full_path])) continue;

            $json = json_decode($data['json'], true);

            // 子孫(descendants)が空、かつ仮想(Virtual)であるものを削除対象とする
            if (empty($json['descendants'])) {
                $deleted_paths[] = self::mt_recursive_delete_virtual($full_path);
            }
        }

        $count = count(array_filter($deleted_paths));
        return "<li>空の仮想階層の再帰削除完了: {$count} 件のノードを整理しました。</li>";
    }

    /**
     * 指定された仮想パスを削除し、親のリストを更新。
     * 親が空になればさらに再帰する。
     */
    private static function mt_recursive_delete_virtual($path) {
        global $wpdb;
        $table = $wpdb->prefix . 'kx_hierarchy';

        // 1. 削除対象のデータを取得
        $target = isset(self::$mt_list['virtual'][$path]) ? self::$mt_list['virtual'][$path] : null;
        if (!$target) return null;

        $json = json_decode($target['json'], true);

        // 安全策：子孫が残っている場合は削除しない
        if (!empty($json['descendants'])) return null;

        // 2. DBから削除
        $wpdb->delete($table, ['full_path' => $path], ['%s']);

        // 3. 親のパスを特定
        $nodes = explode('≫', $path);
        array_pop($nodes);
        $parent_path = implode('≫', $nodes);

        // 4. 自信をメモリ上から削除
        unset(self::$mt_list['virtual'][$path]);

        // 5. 親が存在する場合の処理
        if (!empty($parent_path)) {
            // 親が virtual か real か判定
            $parent_group = isset(self::$mt_list['real'][$parent_path]) ? 'real' : (isset(self::$mt_list['virtual'][$parent_path]) ? 'virtual' : null);

            if ($parent_group) {
                $parent_data = self::$mt_list[$parent_group][$parent_path];
                $parent_json = json_decode($parent_data['json'], true);

                // 親の descendants から現在のパスを削除
                if (isset($parent_json['descendants']) && is_array($parent_json['descendants'])) {
                    $original_count = count($parent_json['descendants']);
                    $parent_json['descendants'] = array_values(array_diff($parent_json['descendants'], [$path]));

                    // 親の JSON に変更があれば更新
                    if (count($parent_json['descendants']) !== $original_count) {
                        $new_json_str = json_encode($parent_json, JSON_UNESCAPED_UNICODE);

                        // save_with_log を使用して text カラムも更新（アクション 'm'）
                        self::save_with_log($parent_path, ['json' => $new_json_str], 'm');

                        // メモリ上も更新
                        self::$mt_list[$parent_group][$parent_path]['json'] = $new_json_str;

                        // もし親が Virtual で、かつ子がいなくなったなら再帰削除
                        if ($parent_group === 'virtual' && empty($parent_json['descendants'])) {
                            self::mt_recursive_delete_virtual($parent_path);
                        }
                    }
                }
            }
        }

        return $path;
    }


    /**
     * mt_: メンテナンス結果のレポートを表示用に生成する
     * 1. 黒バック基調のデザイン
     * 2. ルート階層（第一ノード）ごとのアコーディオン表示
     */
    private static function mt_render_report($log_messages = '') {
        // 全体コンテナ（黒バック・白文字）
        $output = '<div class="maintenance-report" style="background:#1a1a1a; color: #eee; padding:20px; border-radius:8px; font-family: sans-serif; margin-top:20px; border:1px solid #444;">';
        $output .= '<h3 style="border-bottom:2px solid #555; padding-bottom:10px; color: #fff;">Hierarchy Maintenance Report</h3>';

        // 1. 処理ログ（コンパクトに表示）
        if (!empty($log_messages)) {
            $output .= '<details style="margin-bottom:20px; background:#252525; border:1px solid #333;">';
            $output .= '<summary style="padding:10px; cursor:pointer; font-weight:bold; color:#aaa;">▶ 処理ログを表示</summary>';
            $output .= '<ul style="padding:10px 30px; font-size:12px; line-height:1.6; color:#bbb;">' . $log_messages . '</ul>';
            $output .= '</details>';
        }

        // 2. 統計
        $count_v = count(self::$mt_list['virtual']);
        $count_r = count(self::$mt_list['real']);
        $output .= '<p style="font-size:14px;">構成状況: <span style="color:#00ff00;">Real: ' . $count_r . '</span> / <span style="color:#ffae00;">Virtual: ' . $count_v . '</span></p>';

        // 3. ルート階層ごとのグルーピング
        $groups = [];
        foreach (self::$mt_list['virtual'] as $path => $node) {
            $parts = explode('≫', $path);
            $root = $parts[0];
            $groups[$root][$path] = $node;
        }

        if (!empty($groups)) {
            $output .= '<h4 style="color: #ffbb63ff; margin-top:30px;">⚠️ Virtual Node Groups (実体未作成)</h4>';

            foreach ($groups as $root_name => $items) {
                $group_count = count($items);
                // ルート階層ごとの折りたたみ
                $output .= '<details style="margin-bottom:5px; border:1px solid #444; background:#222;">';
                $output .= '<summary style="padding:10px; cursor:pointer; background:#333; color:#fff;">';
                $output .= '<strong>' . esc_html($root_name) . '</strong> <span style="font-size:11px; color:#aaa; margin-left:10px;">(' . $group_count . ' nodes)</span>';
                $output .= '</summary>';

                $output .= '<table style="width:100%; border-collapse:collapse; background:#111;">';
                foreach ($items as $path => $node) {
                    $output .= '<tr style="border-bottom:1px solid #222;">';
                    $output .= '<td style="padding:8px; color:#ffae00; background:#2b2b00; font-size:12px;">' . esc_html($path) . '</td>';
                    $output .= '<td style="padding:8px; text-align:right; width:100px;">';

                    // Create+ ボタン
                    $output .= '<form method="post" style="margin:0;">';
                    $output .= '<input type="hidden" name="target_title" value="' . esc_attr($path) . '">';
                    $output .= '<input type="submit" name="create_virtual_post" value="Create+" style="background:#900; color:#fff; border:none; padding:4px 8px; font-size:11px; cursor:pointer; border-radius:3px;">';
                    $output .= '</form>';

                    $output .= '</td></tr>';
                }
                $output .= '</table></details>';
            }
        } else {
            $output .= '<p style="color:#00ff00; padding:10px; background:#002200;">✅ クリーンアップの結果、孤立した仮想階層は解消されました。</p>';
        }

        $output .= '</div>';
        return $output;
    }



    /**
     * mt_: alert フラグがある Real レコードをルート別に表示。
     * wp_kx_1 と照合し、特定のショートコードがある場合はタイトルをグリーンにする。
     */
    private static function mt_list_alert_nodes() {
        global $wpdb;
        $output = "";
        $groups = [];
        $table_kx1 = $wpdb->prefix . 'kx_1';

        if (empty(self::$mt_list['real'])) {
            return "";
        }

        // 1. wp_kx_1 から ShortCODE 情報を一括取得してマップ化
        $kx1_results = $wpdb->get_results("SELECT id, json FROM $table_kx1", ARRAY_A);
        $kx1_map = [];
        foreach ($kx1_results as $row) {
            $j = json_decode($row['json'], true);
            if (isset($j['ShortCODE'])) {
                $kx1_map[(int)$row['id']] = $j['ShortCODE'];
            }
        }

        // 2. Realグループから alert 対象を抽出
        foreach (self::$mt_list['real'] as $path => $data) {
            if (empty($data['json'])) continue;

            $json_data = json_decode($data['json'], true);
            if (!$json_data || !isset($json_data['alert']) || $json_data['alert'] != 1) continue;

            $parts = explode('≫', $path);
            $root = $parts[0];
            $post_id = (int)$data['post_id'];

            // 下位ポスト数
            $desc_count = isset($json_data['descendants']) ? count($json_data['descendants']) : 0;

            // ShortCODE 照合 (例: kx_tp ならグリーン)
            //$is_shortcode_matched = (isset($kx1_map[$post_id]) && $kx1_map[$post_id] === 'kx_tp');

            // 修正ポイント：対象のショートコードを配列で定義し、いずれかに合致するか判定する 2025-12-29
            $target_shortcodes = ['kx_tp', 'kx_TEST'];
            $current_sc = isset($kx1_map[$post_id]) ? $kx1_map[$post_id] : '';
            $is_shortcode_matched = in_array($current_sc, $target_shortcodes, true);
            // ここまで

            $groups[$root][] = [
                'path'       => $path,
                'post_id'    => $post_id,
                'desc_count' => $desc_count,
                'is_matched' => $is_shortcode_matched
            ];
        }

        if (!empty($groups)) {
            $output .= '<div style="margin-top:30px; border:1px solid #fdff91ff; background:#1a1a1a; padding:15px; border-radius:8px;">';
            $output .= '<h4 style="color: #f3ff44ff; margin:0 0 15px 0; border-bottom:1px solid #444; padding-bottom:10px;">⚠️ [Real] タグ未設置アラート (ShortCODE 照合済み)</h4>';

            foreach ($groups as $root_name => $items) {
                $count = count($items);
                $output .= '<details style="margin-bottom:5px; border:1px solid #333; background:#222;">';
                $output .= '<summary style="padding:10px; cursor:pointer; background:#333; color:#fff; font-size:13px;">';
                $output .= '<strong>' . esc_html($root_name) . '</strong> <span style="font-size:11px; color:#aaa; margin-left:10px;">(' . $count . ' nodes)</span>';
                $output .= '</summary>';

                $output .= '<table style="width:100%; border-collapse:collapse; background:#111; font-size:13px;">';
                foreach ($items as $item) {
                    $permalink = get_permalink($item['post_id']);
                    // ショートコードが一致した場合はグリーン、それ以外は通常リンク色
                    $title_color = $item['is_matched'] ? '#00ff00' : '#00aaff';

                    $output .= '<tr style="border-bottom:1px solid #222;">';
                    $output .= '<td style="padding:10px;">';

                    if ($permalink) {
                        $output .= '<a href="' . esc_url($permalink) . '" target="_blank" style="color:' . $title_color . '; text-decoration:none; display:flex; justify-content:space-between; align-items:center;">';
                        $output .= '<span>' . esc_html($item['path']) . ($item['is_matched'] ? ' <small>[SC OK]</small>' : '') . '</span>';
                        $output .= '<span style="font-size:10px; color:#ffae00; background:#332200; padding:2px 6px; border-radius:10px; margin-left:10px;">Child: ' . $item['desc_count'] . '</span>';
                        $output .= '</a>';
                    } else {
                        $output .= esc_html($item['path']);
                    }

                    $output .= '</td></tr>';
                }
                $output .= '</table></details>';
            }
            $output .= '</div>';
        }

        return $output;
    }




    /**
     * 仮想階層を走査し、直下に実体が一つもない場合のみ JSON に警告状態を記録する
     */
    public static function maintenance_full_old() {
        global $wpdb;
        $h_table = $wpdb->prefix . 'kx_hierarchy';

        // すべての仮想ノードを取得
        $virtual_nodes = $wpdb->get_results("SELECT * FROM $h_table WHERE is_virtual = 1 ORDER BY full_path ASC");

        if ($virtual_nodes) {
            foreach ($virtual_nodes as $node) {
                // --- 1. 直下の子ノードに「実体」があるか確認 ---
                // parent_path が自分と一致し、かつ is_virtual が 0 のレコードを数える
                $real_child_count = $wpdb->get_var($wpdb->prepare(
                    "SELECT COUNT(*) FROM $h_table WHERE parent_path = %s AND is_virtual = 0",
                    $node->full_path
                ));

                // --- 2. JSON の構成と更新 ---
                $current_json = json_decode($node->json, true) ?: [];
                $updated = false;

                if ((int)$real_child_count === 0) {
                    // 直下に実体が一つもない場合：指定の形式をセット
                    if (($current_json['raretu'] ?? null) !== 0 || ($current_json['alert'] ?? null) !== 1) {
                        $current_json['raretu'] = 0;
                        $current_json['alert'] = 1;
                        $updated = true;
                    }
                } else {
                    // 実体がある場合：もし過去に alert が付いていたら削除する（任意）
                    if (isset($current_json['alert'])) {
                        unset($current_json['raretu']);
                        unset($current_json['alert']);
                        $updated = true;
                    }
                }

                if ($updated) {
                    $wpdb->update(
                        $h_table,
                        ['json' => json_encode($current_json, JSON_UNESCAPED_UNICODE)],
                        ['full_path' => $node->full_path] // id ではなく full_path で特定
                    );
                    $node->json = json_encode($current_json, JSON_UNESCAPED_UNICODE);
                }
            }
        }

        // --- 3. 表示生成 ---
        $output = "<h4 style='color:#fff; border-bottom:1px solid #444;'>Virtual Hierarchy List (Alert: No Real Children)</h4>";
        if (!$virtual_nodes) return $output . "<p style='color:#ccc;'>仮想階層はありません。</p>";

        $groups = [];
        foreach ($virtual_nodes as $node) {
            $parts = explode('≫', $node->full_path);
            $prefix = $parts[0];
            $groups[$prefix][] = $node;
        }

        foreach ($groups as $prefix => $nodes) {
            $output .= "<details style='margin-bottom:5px; border:1px solid #444;'>";
            $output .= "<summary style='padding:8px; background:#222; color:#eee; cursor:pointer;'>" . esc_html($prefix) . " (".count($nodes).")</summary>";
            $output .= '<table style="width:100%; border-collapse:collapse; font-family:monospace; font-size:12px; color:#ccc; background:#000;">';

            foreach ($nodes as $node) {
                $node_json = json_decode($node->json, true) ?: [];
                $is_alert = (isset($node_json['alert']) && $node_json['alert'] === 1);

                $row_style = $is_alert ? 'color:#ff4444; font-weight:bold;' : 'color:#888;';
                $alert_label = $is_alert ? ' [実体なしアラート]' : '';

                $output .= "<tr style='border-bottom:1px solid #222;'>";
                $output .= '<td style="padding:4px; vertical-align:top;' . $row_style . '">' . esc_html($node->full_path) . esc_html($alert_label) . '</td>';
                $output .= '<td style="padding:4px; text-align:right; vertical-align:top;">';
                $output .= '<form method="post"><input type="hidden" name="target_title" value="'.esc_attr($node->full_path).'"><input type="submit" name="create_virtual_post" value="Create+" style="background:#cc0000; color:#fff; border:none; padding:1px 4px; font-size:10px; cursor:pointer;"></form>';
                $output .= '</td></tr>';
            }
            $output .= '</table></details>';
        }
        return $output;
    }


    /**
     * 指定したポストIDに関連する独自DBレコードを抹消し、ログを出力する
     * * @param int    $post_id 投稿ID
     * @param string $reason  削除理由 ('trash' | 'mismatch' | 'missing' 等)
     */
    private static function purge_post_record($post_id, $reason = 'trash') {
        if (!$post_id) return;

        // 1. メタデータ層(wp_kx_1)の削除
        // 理由が 'trash'（ゴミ箱）の場合のみ実行。
        // パス不一致(mismatch)の場合はメタデータを残さないと、GhostON等の設定が消えてしまうため。
        if ($reason === 'trash' && function_exists('kx_db0')) {
            kx_db0(['id' => $post_id], 'delete');
        }

        // 2. 論理構造層(wp_kx_hierarchy)の削除
        // パスが古い、または実体がないため、階層レコードは理由を問わず削除。
        self::delete_hierarchy_record($post_id);

        // 3. 画面にログを残す
        $color = ($reason === 'trash') ? 'red' : 'orange';
        echo '<span style="color:'.$color.';">[post_id: '.$post_id.' | '.$reason.' Deleted]</span>';
    }



    /**
     * 履歴付き保存処理（集約関数）
     * @param string $path 階層パス（主キー）
     * @param array $data 保存するデータ
     * @param string $action_type 'i' (insert) か 'u' (update)
     */
    private static function save_with_log($path, $data, $action_type) {
        global $wpdb;
        $table = $wpdb->prefix . 'kx_hierarchy';

        // 1. 保存用メタデータの付与
        $data['text'] = Time::format() . $action_type;
        $data['time'] = time();

        // full_path が存在するか確認
        $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE full_path = %s", $path));

        if ($exists) {
            // UPDATE実行
            $result = $wpdb->update($table, $data, ['full_path' => $path]);
        } else {
            // INSERT実行
            $data['full_path'] = $path;
            $result = $wpdb->insert($table, $data);
        }

        // 2. キャッシュ同期 (組み込み)
        // DB保存が成功した場合（$resultが1またはtrue）、Dyキャッシュを最新データで更新する
        if ($result !== false) {
            $post_id = $data['post_id'] ?? null;
            if ($post_id) {
                // DBに書き込んだのと全く同じ内容（path, metaデータ含む）をキャッシュに流し込む
                Dy::set_content_cache($post_id, 'db_hierarchy', $data);
            }
        }

        return $result;
    }



    /**
     * 履歴付き保存処理（集約関数）
     * @param string $path 階層パス（主キー）
     * @param array $data 保存するデータ
     * @param string $action_type 'i' (insert) か 'u' (update)
     */
    /*
    private static function save_with_log($path, $data, $action_type) {
        //echo '++';

        global $wpdb;
        $table = $wpdb->prefix . 'kx_hierarchy';

        // textカラムに日時とフラグをセット (例: 2025/12/29 07:03:57u)
        $data['text'] = Time::format() . $action_type;
        $data['time'] = time();

        // full_path が存在するか確認して update か insert を実行
        $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE full_path = %s", $path));

        if ($exists) {
            return $wpdb->update($table, $data, ['full_path' => $path]);
        } else {
            $data['full_path'] = $path;
            return $wpdb->insert($table, $data);
        }
    }
    */


    /**
     * ゴミ箱入りのポストに関連する階層レコードを物理削除する
     * * @param int $post_id 投稿ID
     */
    public static function delete_hierarchy_record($post_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'kx_hierarchy';

        // 該当IDのレコードを削除
        $wpdb->delete($table, ['post_id' => $post_id], ['%d']);
    }

}