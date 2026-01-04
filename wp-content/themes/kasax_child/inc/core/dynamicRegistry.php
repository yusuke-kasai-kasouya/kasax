<?php
/**
 * KxDy クラス
 * D:\00_WP\xampp\htdocs\0\wp-content\themes\kasax_child\inc\core\DynamicRegistry.php
 *
 * このクラスは、アプリケーション内の設定を管理するためのシングルトンクラスです。
 * 静的メソッドを使用して、設定値の取得と保存を効率的に行います。
 *
 * 使用例:
 * - 設定値の取得: KxDy::get('キー名');
 * - 設定値の保存: KxDy::set('キー名', 値);
 *
 * 主な機能:
 * - 設定の初期化 (初回のみ)
 * - 設定値の取得と保存
 * - IDに基づくデータの動的な取得と保存
 *
 * KxDy::get('display_colors_css');
 * KxDy::set('display_colors_css');
 *
 */
namespace Kx\Core;

// これを追加
use Kx\Core\SystemConfig as Su;
use Kx\Core\DynamicRegistry as Dy;

class DynamicRegistry { //*** *** *** kxDy *** *** ***
    private static $instance = null;
    private static $settings = [];

    /**
    * コンストラクタ（初回のみ実行）
    * クラスが初めて作成される際に呼ばれるメソッド。
    * 設定を初期化する。
    */
    private function __construct() {
        self::$settings =
        [
            'test'    => 'KxDy_TEST',
            'content' => [],
            'shared' => [],

            'work'    => [],

            'trace'   =>
            [
            'kxx_sc_count'      => 0, // 現在のショートコードの階層の深さ。2025-12-23。
            'kxx_content_count' => 0, //kxx系のコンテンツの数。増えすぎた場合は排除される。2025-12-23。
            ],
        ];
    }



    /**
    * クラスのインスタンスを作成（シングルトンの仕組み）
    * 既にインスタンスが存在する場合は、新しく作らず同じものを使う。
    */
    private static function init() {
        if (self::$instance === null)
        {
            self::$instance = new self();
        }
    }



    /**
    * 設定の値を取得する関数
    *
    * @param string $key 取得したい設定のキー（例："content"）
    * @return mixed 設定されている値、または空文字（値がない場合）
    */
    public static function get($key) {
        self::init(); // ← ここで初期化してから取り出す
        return self::$settings[$key] ?? '';
    }



    /**
    * 設定の値を変更（保存）する関数
    *
    * @param string $key 設定するキー（例："content"）
    * @param mixed $value 設定したい値
    */
    public static function set($key,$value) {
        //echo '+';
        self::init();

        // 'content' を処理する場合
        if ( $key === 'content' && is_array($value) && !empty($value))
        {
            //$id = $value['id']; // 配列の最初のキー（get_the_ID() を想定）
            $id = $value['id'] ?? null;

            // IDが取得できなかった場合のガード（必要に応じて）
            if (!$id) {
                return; // または適切なエラー処理
            }


            // 'content' にこの ID が存在しなければ、データを取得して追加
            if (!isset(self::$settings[$key][$id]))
            {
                $fetchedData = self::kxdy_ID($id); // データ取得

                // データが正しく取得できたか確認
                if (!empty($fetchedData))
                {
                    self::$settings[$key][$id] = $fetchedData;
                }
                //var_dump(self::$settings['work']);
                //print_r(self::$settings['content']);
                //echo '<hr>';
            }
        }
        else
        {
            //echo $key.'++';
            // `content` 以外の通常のキー処理
            if (is_array($value))
            {
            // 既存の配列と統合する処理
            self::$settings[$key] = isset(self::$settings[$key])
            ? array_merge(self::$settings[$key], $value)
            : $value;
            //var_dump(self::$settings[$key]);
            }
            else
            {
            // 単一の値をセット
            self::$settings[$key] = $value;
            }
        }
        //var_dump(self::$settings);
        //print_r(self::$settings['content']);
        //echo '<hr>';
    }



    /**
     * キャッシュからデータを取得する。存在しない場合は自動的に補充する。
     * * @param int    $post_id    投稿ID
     * @param string $sub_key    特定のサブキーのみ返したい場合に指定
     * @return mixed             指定されたデータ、または content[$post_id] 配列全体
     */
    public static function get_content_cache($post_id, $sub_key = null) {
        // 1. 初期化チェック
        self::init();

        // 2. キャッシュが存在しない場合は補充
        if (!isset(self::$settings['content'][$post_id])) {

            // 重要：無限ループ防止のため、一時的に空配列を入れて「取得中」であることを示す
            self::$settings['content'][$post_id] = ['loading' => true];

            $fetchedData = self::kxdy_ID($post_id);

            if (!empty($fetchedData)) {
                // ★★ 修正箇所：set()を経由せず、静的プロパティを直接書き換える ★★
                self::$settings['content'][$post_id] = $fetchedData;
            } else {
                // データがない場合も、何度もDBを見に行かないよう null を入れておく
                self::$settings['content'][$post_id] = null;
            }
        }

        // 3. 値の返却
        $target = self::$settings['content'][$post_id] ?? null;

        if ($sub_key && is_array($target)) {
            return $target[$sub_key] ?? null;
        }

        return $target;
    }



    /**
     * 取得したDBデータをDyキャッシュに保存する
     * 未使用：2025-12-30。一応置いておく。
     * * @param int|string $post_id    投稿ID
     * @param string     $table_type テーブル識別子
     * @param mixed      $data       保存するデータ（連想配列やオブジェクト）
     */
    public static function set_content_cache($post_id, $table_type, $data) {
        $content = self::get('content');



        // 多次元配列を構築して保存
        $content[$post_id][$table_type] = $data;

        //var_dump($data);
        //var_dump($content);

        self::set('content', $content);
    }




    /**
     * キャッシュ・ファーストでのデータ取得 (Cache-Aside実装)
     * * @param int    $post_id    ポストID
     * @param string $type       キャッシュタイプ ('db_kx0' など)
     * @param string $table_name 取得先テーブル名 (キャッシュがない場合に使用)
     * @return array|null        取得データ
     */
    public static function get_and_cache_data($post_id, $type = 'db_kx0', $table_name = 'wp_kx_0') {
        // 1. メモリキャッシュ(Dy)を確認
        $cached = self::get_content_cache($post_id, $type);
        if ($cached !== null) {
            return $cached;
        }

        // 2. DBから読み込み (kx_db_Readはグローバル関数と想定)
        $data = kx_db_Read(
            $table_name,
            ['id' => $post_id],
            '*', null, null, 'AND', true
        );

        // 3. 取得できた場合はDyに保存
        if ($data) {
            self::set_content_cache($post_id, $type, $data);
            return $data;
        }

        return null;
    }





    /**
    * Undocumented function
    * // ID から関連するデータを取得するメソッド（仮のデータ取得処理）
    *
    * @param [type] $id
    * @return void
    */
    private static function kxdy_ID($id) {

        global $wpdb;

        // 1. 初期化
        $_array = [
            'db_kx0'     => null,
            'db_kx1'     => null,
            'raretu_ids' => null,
        ];

        // 2. wp_kx_0 から直接レコードを「連想配列」として取得
        // get_row の第3引数に ARRAY_A を指定することで、オブジェクトではなく配列で返る
        $row0 = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM wp_kx_0 WHERE id = %d", $id),
            ARRAY_A
        );

        if ($row0) {
            $_array['db_kx0'] = $row0;

            // 配列なので $row0['json'] でアクセス可能
            if (!empty($row0['json']) && strpos($row0['json'], 'raretu_id') !== false) {
                $_array['raretu_ids'] = 1;
            }
        }

        // 3. wp_kx_1 も同様に取得（こちらも配列で保持）
        $_array['db_kx1'] = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM wp_kx_1 WHERE id = %d", $id),
            ARRAY_A
        );

        // タイトル処理（既存のメソッドへ配列を渡す）
        self::kxdy_title($id, $_array);

        return $_array;

        /*



        // データベースから取得
        $_result = kx_db0( ['id'=> $id] , 'Select_ID' );

        // $_result[0] が存在するかチェックして代入
        if ( is_array($_result) && isset($_result[0]) ) {
            // $_array['db_kx0'] に「1レコード分のオブジェクト」を代入
            $_array['db_kx0'] = $_result[0];
        } else {
            $_array['db_kx0'] = null;

        }

        // ...

        //var_dump(self::$settings);
        //print_r(self::$settings['content']);
        //echo '<hr>';
        //$_array_db_kx0 = kx_db0( ['id'=> $id] , 'Select_ID' );
        //var_dump($_array_db_kx0);

        //$_array['db_kx0'] = kx_db0( ['id'=> $id] , 'Select_ID' );

        //$_array['db_kx0'] = $_array_db_kx0[0] ?? null;

        if(!empty( $_array_db_kx0[0]->json ) && preg_match('/raretu_id/',$_array_db_kx0[0]->json  ) )
        {
            $_array['raretu_ids'] = 1;
        }

        $_array['db_kx1'] = kx_db1( ['id'=> $id] , 'SelectID' );

        self::kxdy_title( $id,$_array );

        return $_array;
        */
    }




    /**
    * Undocumented function
    *
    * @param [type] $key
    * @param [type] $value
    * @return void
    */
    /*
    public function setDB($key, $value) {
        $this->settings[$key] = $value;
        update_option('kxsu_settings', $this->settings); // 永続的に変更

    }
    */





    /**
    *
    *
    * @param [type] $type
    * @return void
    */
    private static function kxdy_title( $id,&$_array ){

        $_title = get_the_title($id);
        $_array['title'] = $_title;
        $_array['title_array'] = explode('≫',$_title);
        $_array['title_count']   = count($_array['title_array']);

        //echo $_title;

        $_array['title_type'] = 'ETC';

        // 正規表現マッチングを実行
        $parsed_match_data = kx_preg_match_pattern_s(Su::get('title_array'), $_title);
        //$match_result = kx_preg_match_pattern_s(['Shared'  =>	'/σ/'], $_title);
        //var_dump(KxSu::get('title_array'));
        //var_dump($match_result);
        //echo '<hr>';



        // マッチした場合の処理
        if ($parsed_match_data !== false)
        {
            $_array['title_type'] = $parsed_match_data['key'] ;

            switch ($parsed_match_data['key'])
            {
            case 'works':
                // 'works' にマッチした場合の処理

            $_array['chara_num'] = $parsed_match_data['matches'][2];
            self::kxdy_title_work( $parsed_match_data['matches'][4] ,$parsed_match_data['matches'][5], $_array['title_array'] );
            self::kxdy_title_character( $_array['chara_num'] , $_array['title_array']);

            break;


            case 'character':
            // 'character' にマッチした場合の処理

            //var_dump($match_result);
            //echo $parsed_match_data['matches'][2];

            $_array['chara_num'] = $parsed_match_data['matches'][2];
            self::kxdy_title_character( $_array['chara_num'] , $_array['title_array'] );

            case 'create':
            //self::kxdy_Create_ids( $id );
            break;


            case 'Shared':
            //echo '<hr>+<hr>';
            break;

            case 'Shared_works':
            break;
            }
        }
        return $_array;
    }




    /**
    * Undocumented function
    *
    * @param [type] $code
    * @param [type] $title_array
    * @return void
    */
    private static function kxdy_title_work( $code3 , $code_num , $title_array ){


        $_arr = kx_json_arr( get_stylesheet_directory() . "/data/json/sakuhin.json"	);

        if( !empty( $_arr[ strtolower( $code ) ][ $code_num ] ) )
        {
            //$_array_Dy[$title_array[0]][$code3.$code_num] = $_arr[ strtolower( $code ) ][ $code_num ] ;;
            //KxDy::set('work',$_array_Dy);
        }

    }



    /**
    * Undocumented function
    *
    * @param [type] $id
    * @return void
    */
    private static function kxdy_title_character( $number , $title_array ){

        $_arr = Su::get('configs')['characters'];

        //var_dump(kxSu::get('configs')['characters']);
        //var_dump(kxSu::get('configs')['characters']);


        if( !empty( $_arr[ $title_array[0] ][ $number ] ) )
        {
            //キャラクター配列。2023-08-05

            self::$settings['work'][$title_array[0]]['c'.$number] =
        [
            'name' => $_arr[$title_array[0]][$number][0],
            'name_counter' => $_arr[$title_array[0]][$number][1],
        ];
            //var_dump($_character_array);
        }
    }



    /**
    * Undocumented function
    *
    * @param [type] $id
    * @return void
    */
    private static function kxdy_Create_ids( $id ){

        if( get_queried_object_id() != $id)
        {
            return;
        }

        preg_match(Su::get('title_preg')['worksCREATE'],get_the_title($id), $matches);

        if( !$matches)
        {
            return;
        }

        //var_dump($matches);
        //return;

        $title = $matches[1];
        $result = kx_db_Read('wp_kx_create', ['title' => $title ], 'json') ;
        //var_dump($result[0]);

        if( !empty($result[0]) )
        {
            //r_dump($title_array);
            //ho '+<hr>';

            $json = kx_json_decode($result[0]->json);

            if(isset($json['ids']) && is_array($json['ids']))
            {
            $arr_get = Dy::get('work');

            if( empty($arr_get[$matches[2]][$matches[3]]['ids']) )
            {
                $arr[$matches[2]][$matches[3]]['ids'] = $json['ids'];

                if (isset($arr_get ) &&	is_array($arr_get))				{
                    Dy::set('work',array_replace_recursive($arr_get , $arr ));

                    //$arr_get[$title_array[0]][$title_array[1]]['ids']  = array_unique($arr_get[$title_array[0]][$title_array[1]]['ids']); // 重複を削除
                    //var_dump(KxDy::get('work'));
                    //echo '+<hr>';
                }
            }
            //return $arr;
            }
        }
    }


    /**
    * trace カウントを増減させる
    * @param string $key   カウントしたいキー名 (例: 'kxx_sc_count')
    * @param int    $delta 増分 (1 でプラス、-1 でマイナス)
    */
    public static function kxdy_trace_count($key, $delta = 1) {
        $_trace = self::get('trace');

        if (!is_array($_trace)) { $_trace = []; }

        // もし $delta が「厳密に 0」ならリセット処理にする
        if ($delta === 0) {
            $_trace[$key] = 0;
        } else {
            // 通常の増減処理
            if (!isset($_trace[$key])) {
                $_trace[$key] = 0;
            }
            $_trace[$key] += $delta;
        }

        // マイナスガード
        if (($_trace[$key] ?? 0) < 0) {
            $_trace[$key] = 0;
        }

        self::set('trace', $_trace);
    }



    /**
     * ポストIDからタイトルを取得する（キャッシュ・ファースト）
     * 1. キャッシュ確認 ＆ DB補充
     * 2. なければエラー表示
     *
     * @param int $post_id 投稿ID
     * @return string タイトル文字列（失敗時は空文字）
     */
    public static function get_title($post_id) {

        // IDが無効な場合
        if (!$post_id && $post_id !== 0) { // 0は仮想ノードの可能性があるため
            echo "<span style='color:red; font-size:12px;'>Dy Error: ID無し</span>";
            return '';
        }

        // キャッシュ確認。なければ内部でkxdy_ID()を呼び出しDBから補充
        $data = self::get_content_cache($post_id);

        // 正常系：タイトルが存在する場合
        if (isset($data['title'])) {
            return $data['title'];
        }

        // 異常系：取得失敗時のエラー表示
        // 管理者のみ表示するように制限すると、フロントエンドの見た目を壊さずデバッグできます
        if ( current_user_can('manage_options') ) {
            echo '<span style="color:red; font-size:12px;">';
            echo "[KxDy Error: ID({$post_id})のタイトルをDB/WPから取得不能]";
            echo '</span>';
        }

        return '';
    }


}//*** *** *** *** *** *** kxSu*** *** ***  *** *** ***

// 1. 短縮名 Dy:: でアクセス可能にする
if (!class_exists('Dy')) {
    class_alias(\Kx\Core\DynamicRegistry::class, 'Dy');
}

// 2. 既存の KxDy:: 呼び出し（1.4万件の互換性）を維持する
if (!class_exists('KxDy')) {
    class_alias(\Kx\Core\DynamicRegistry::class, 'KxDy');
}