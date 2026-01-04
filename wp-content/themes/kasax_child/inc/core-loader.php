<?php
/**
 * https://underscores.me/
 * 上記ベースの「_0」ブランクテーマへの追記型子テーマ。
 * D:\00_WP\xampp\htdocs\0\wp-content\themes\kasax_child\inc\core-loader.php
 * 2025-12-27
 */

use Kx\Utils\Time;

//インクルードphp
//順番が大事
$libraries = [
	'add_shortcode.php',
	'add_shortcode_template.php',
	//'add.php', // スクリプト追記など。
	'materials.php',
	'outline.php',
	'class.php',
	//'kxx.php',
	'kxx10.php',
	'kxx30.php',
	'kxx40.php',
	//'setting.php',
	'change_any_texts.php',
	//'raretu.php',
	'edit_add.php',
	//'func_db.php',
	'func_ui.php',
	'func_update_error.php',
	'func_utils.php',
	'func_etc.php',
	'test.php'
];

foreach ($libraries as $library) {
	require_once locate_template("lib/{$library}", true);
}


/*
require_once locate_template(	'lib/add_shortcode.php', true);
require_once locate_template(	'lib/add_shortcode_template.php', true);
require_once locate_template(	'lib/add.php', true);	//スクリプト追記など。
require_once locate_template(	'lib/color.php', true);
require_once locate_template(	'lib/outline.php', true);
require_once locate_template(	'lib/class.php', true);
require_once locate_template(	'lib/kxx.php', true);
require_once locate_template(	'lib/kxx10.php', true);
require_once locate_template(	'lib/kxx30.php', true);
require_once locate_template(	'lib/kxx40.php', true);
require_once locate_template(	'lib/setting.php', true);
require_once locate_template(	'lib/change_any_texts.php', true);
require_once locate_template(	'lib/raretu.php', true);
require_once locate_template(	'lib/edit_add.php', true);
require_once locate_template(	'lib/functions3.php', true);
require_once locate_template(	'lib/test.php', true);
*/



//require_once (dirname(__FILE__) . '/../lib/php_css.php');
/**
 * 読み込むCSSを登録する
 * 順番
 * 他にもadd.phpにサイドバー用があり。
 *
 */
/*
function register_stylesheet() {

	//echo '++'.KxSu::get('display_1920');

	// 非共通。通常表示のみ。
	//wp_register_style('1', get_template_directory_uri() . '/../kasax_child/style/1.css');

	// メイン。エディター・管理、共通（解像度による切り替え）
	$styles =
	[
		'1' => '1.css', // 単独登録されていたスタイルを統合
		'2' => '2-' . (preg_match(KxSu::get('title_preg')['1920'], get_the_title()) ? '1920' : '1440') . '.css',
		'3' => '3.css',
		'4' => 'type_color_' . (KxSu::get('display_colors_css') == 'd' ? 'd' : 'n') . '.css',//色分け。
		'5' => 'kx_' .         (KxSu::get('display_colors_css') == 'd' ? 'd' : 'n') . '.css',//色分け。
		'6' => (current_user_can('level_10') || current_user_can('level_7')) ? 'l10.css' : 'l0.css',//LV10-0用
		'k1' => 'kanri.css'//管理画面
	];

	// スタイルを一括登録
	foreach ($styles as $key => $file) {
		wp_register_style($key, get_template_directory_uri() . '/../kasax_child/style/' . $file);
	}
}
	*/



//add_action('wp_enqueue_scripts', 'kx_add_stylesheet');
/**
 * //登録したCSSを以下の順番で読み込む
 * kx_add_stylesheetに名前変更、旧バージョンのWordpressに同じ名前がある。2023-02-26。
 *
 */
/*
function kx_add_stylesheet() {

	register_stylesheet();

	for ($i = 1; $i <= 6; $i++) :

		wp_enqueue_style( $i , '', array(), '1.0', false);

	endfor;
}
*/



//add_action( 'admin_enqueue_scripts', 'add_stylesheet_kanri' );
/**
 * 管理画面読み込み
 * 管理画面css
 *
 *
 */
/*
function add_stylesheet_kanri(){

	if( array_key_exists( 'page', $_GET)  && $_GET[ 'page' ]	== 'kx')
	{
		register_stylesheet();

		for ($i = 2; $i <= 5; $i++) :

			wp_enqueue_style( $i , '', array(), '1.0', false);

		endfor;

		wp_enqueue_style('k1', '', array(), '1.0', false);
	}
}
	*/



add_action('wp_ajax_my_action', 'my_action');
add_action('wp_ajax_nopriv_my_action', 'my_action');
function my_action() {
  // Ajaxで送信されたデータを取得する
  $data = $_POST['data'];

  // ここに処理を記述する

  // 処理が終了したら、結果を返す
  echo $result;

  // WordPressのAjax APIを使用して呼び出されるため、処理が完了したら、必ずexitを実行する
  exit;
}









add_filter('pre_get_document_title', 'kxAddF_title_browser');
/**
 * ブラウザーのタブのタイトルを変更。
 * H1-Browser-タブ（フック）
 * @return void
 */
function kxAddF_title_browser(){

	if( array_key_exists( 's' , $_GET ) ) //$_GET['s']
	{
		return	'” '.get_search_query ().' ” 検索';
	}
	elseif( array_key_exists(	'cat', $_GET) 	)	//$_GET['cat']
	{
		return	'カテゴリー';
	}
	elseif( array_key_exists(	'tag', $_GET) 	)	//	elseif(	$_GET['tag']	) :
	{
		return	'タグ';
	}
	else
	{
		return	kx_header_title( get_the_title() ) . get_bloginfo( 'name' );
	}
}



add_filter( 'the_content' , 'kxad_the_content',9);
/**
 * contents介入
 * A1. 司令塔（メインフィルタ）
 *
 * @param [type] $text
 * @return void
 */
function kxad_the_content( $text ){
	//2025-12-30
	//if( !is_singular() || !in_the_loop() )  return $text;
	//if( !in_the_loop()  )  return $text;
	//echo is_singular();
	//echo in_the_loop();

	$post_id = get_the_ID();



	$cache_key = 'kxad_the_content_' . $post_id;

	// --- 1. KxDyから記事のメタデータを取得 ---
  KxDy::set('content', ['id' => $post_id]);
  $_KxDy = KxDy::get('content')[$post_id];

	//$data = Dy::get_and_cache_data($post_id);
	//var_dump($_KxDy);
	//echo '+';
	//echo KxDy::get_title($post_id);
	//echo '<br>';

	// --- コンパイル実行 ---
  // DB更新
	kx_dbX( [ 'id' => $post_id ] , 'id' );

	// Dyクラスのインスタンスから content と shared の中身を抽出
	/*
	echo '<pre style="background:#f4f4f4; color:#333; padding:10px; border:1px solid #ccc; font-size:12px;">';
	echo '<strong>■ Dy Cache: content (実体層)</strong><br>';
	var_dump(\Kx\Core\DynamicRegistry::get('content'));

	echo '<hr>';

	echo '<strong>■ Dy Cache: shared (概念・横軸層)</strong><br>';
	var_dump(\Kx\Core\DynamicRegistry::get('shared'));
	echo '</pre>';
	*/


	//$post_id のキャッシュデータから "consolidated_from" の有無を確認する


	// --- 2.  キャッシュ判定の分離
	$should_cache = kxad_the_content_cache_post( $post_id, $_KxDy );




	//echo '+';
	//echo KxDy::get_title($post_id);
	//echo '<br>';


	// --- 3. キャッシュ対象であれば get_transient ---
	if ( $should_cache  ) {//&& !$has_consolidated_from
        $cached_html = get_transient( $cache_key );
        if ( $cached_html !== false && trim(strip_tags($cached_html)) !== '' ) {
            return $cached_html;
        }
	}


	// 本文変換の分離（ここが一番肥大化するので外に出す）
	$final_text = kxad_the_content_compile( $text );


	// 4. 保存時も同じ条件を使用
	if ( $should_cache ) {
			set_transient( $cache_key, $final_text, 60 * DAY_IN_SECONDS );
	}

	return $final_text;

	//return '<span class="__kxad_content">' . $text . '</span>';
}



/**
 * 判定ロジック（拡張時はここだけいじれば良い）
 *
 * @param [type] $post_id
 * @param [type] $_KxDy
 * @return void
 */
function kxad_the_content_cache_post( $post_id, $_KxDy ){
	// raretu判定
	if ( !empty($_KxDy['raretu_ids']) ) return false;
	if ( isset($_KxDy['db_kx1']['ShortCODE']) && $_KxDy['db_kx1']['ShortCODE'] === 'raretu' ) return false;

	// GhostON判定。うまくいかない原因の記載漏れ。再調査必要。2026-01-04
	if ( !empty($_KxDy['db_kx1']['GhostON']) ) return false;

	//tougou判定。何故かうまくいかない。原因未調査。応急処置。2026-01-04
	if (isset($_KxDy['db_kx1']['json'])) {
        $json_raw = $_KxDy['db_kx1']['json'];

        // jsonカラムが文字列(JSON)か配列かを判定してデコード
        $json_data = is_array($json_raw) ? $json_raw : json_decode($json_raw, true);

        // consolidated_from の存在チェックと値の取得
        if (isset($json_data['consolidated_from']) && !empty($json_data['consolidated_from'])) {
            return false;
        }
	}
	return true;
}

/**
 * A3. 本文変換ロジック（Parsedownや数式保護を担当）
 */
function kxad_the_content_compile( $text ) {

  //表関連が先。
	$text = kx_change_any_texts1st( $text );

	if (!preg_match('/\[kx_tp .*?\]/', $text)) {
			if (!preg_match('/<(html|body)[\s>]/i', $text)) {
					// 数式保護
					$latex_formulas = [];
					$text = preg_replace_callback('/\$([\s\S]*?)\$/', function ($matches) use (&$latex_formulas) {
							$index = count($latex_formulas);
							$latex_formulas[] = $matches[0];
							return "＿MATHJAX＿TEMP＿NUMBER＿{$index}＿";
					}, $text);

					// Markdownパース
					$parsedown = new KxParsedown();
					$parsedown->setBreaksEnabled(true);
					$text = $parsedown->text($text);

					// 数式復元
					foreach ($latex_formulas as $index => $formula) {
							$text = str_replace("＿MATHJAX＿TEMP＿NUMBER＿{$index}＿", $formula, $text);
					}
					//$text = mathjaxScript($text);
			}
	}

	if (strpos($text, "<table>") !== false) $text = kx_change_any_texts_table($text);
	$text = kx_change_any_texts($text);

	return '<span class="__kxad_content">' . $text . '</span>';
}



add_action('init', 'kxad_delete_old_revisions');
/**
 * リビジョンの削除。
 *
 * @return void
 */
function kxad_delete_old_revisions() {
  global $wpdb;

  // リビジョンの保存期間を設定します。
  $days = 60;

  // リビジョンの保存期間を過ぎたリビジョンを削除します。
  $wpdb->query("
    DELETE FROM {$wpdb->prefix}posts
    WHERE post_type = 'revision'
    AND post_date < CURRENT_TIMESTAMP - INTERVAL $days DAY
  ");
}




add_filter( 'auth_cookie_expiration', 'my_auth_cookie_expiration');
/**
 * クッキーの有効期限を変更
 */
function my_auth_cookie_expiration( $expirein)
{
	return 315360000;
	// return 86400;    // 1日間有効  (秒数で指定)
	// return 15768000; // 半年間有効 (秒数で指定)
	// return 31536000; // 1年間有効  (秒数で指定)
}



//add_filter( 'tiny_mce_before_init', 'override_mce_options' );
/**
 * このコードは、WordPressのテキストエディタ「TinyMCE」に関するフィルターを追加するためのものです。2023-02-26ChatGPT。
 *
 * @param [type] $init_array
 * @return void
 */
/*
無効化。2023-08-27
function override_mce_options( $init_array ) {
	global $allowedposttags;

	$init_array['valid_elements']          = '*[*]';
	$init_array['extended_valid_elements'] = '*[*]';
	$init_array['valid_children']          = '+a[' . implode( '|', array_keys( $allowedposttags ) ) . ']';
	$init_array['indent']                  = true;
	$init_array['wpautop']                 = false;
	$init_array['force_p_newlines']        = false;

	return $init_array;
}
*/



/**
 * オート保存時間変更
 */
/*
無効化。2023-08-27
add_filter( 'block_editor_settings', function( $editor_settings ){
  $editor_settings['autosaveInterval'] = 360; // 自動保存360秒
  return $editor_settings;
});
*/



add_action( 'admin_init', 'update_nag_hide' );
/**
 * 非表示「～更新してください」
 *
 * @return void
 */
function update_nag_hide() {
	remove_action( 'admin_notices', 'update_nag', 3 );
  remove_action( 'admin_notices', 'maintenance_nag', 10 );
}



//add_action( 'wp_insert_post_data', 'kx_insert_post_data_content' );
add_filter( 'wp_insert_post_data', 'kx_insert_post_data_content', 10, 2 );
/**
 * 保存介入
 * タイトル記号正規化 ＋ 重複回避（〈2〉形式） ＋ 本文置換
 * * @param array $data 保存される投稿データ
 * @param array $postarr 編集画面等から渡される生の投稿データ（ID判定に必要）
 */
function kx_insert_post_data_content ( $data, $postarr ) { // ★修正点2：引数を追加

	foreach ( KxSu::get('add_save_conent') as $key => $v )
	{

		//「date」日付の場合。2023-02-26。
		if( $v[0] == 'date' )
		{
			$replace = '' . Time::format( 'tokyo', $v[1] ) . '';
		}
		else
		{
			if( !empty( $v[1] ) )
			{
				$replace = $v[1];
			}
			else
			{
				$replace = NULL;
			}
		}

		$data[ 'post_content' ] = preg_replace( $key , $replace, $data[ 'post_content' ] );

		//$data['post_title'] 	= mb_strtolower($data['post_title'] );

	}

	// --- 2. タイトルの記号正規化（既存処理） ---
	// 先に記号を統一してから重複判定にかける
	$data[ 'post_title' ] = str_replace(
		array_keys(KxSu::get('add_save_title')),
		array_values(KxSu::get('add_save_title')),
		$data['post_title']
	);



	// ★★ 追記：同名タイトル保存禁止・自動枝番付与（〈2〉形式） ★★
	// ゴミ箱、自動保存、リビジョンの場合はスキップ
	if ( !in_array($data['post_status'], ['trash', 'inherit']) && $data['post_type'] !== 'revision' ) {
		global $wpdb;

		$original_title = $data['post_title'];
		$post_id        = isset($postarr['ID']) ? $postarr['ID'] : 0;
		$post_type      = $data['post_type'];

		// 重複チェッククエリ：タイトルそのまま、または末尾に〈数字〉がついているものを検索
		// 貴殿の仕様に合わせて「〈」と「〉」を使用
		//$title_pattern = '^' . preg_quote($original_title) . '($|【[0-9]+】$)';
		$title_pattern = '^' . preg_quote($original_title) . '($|〈[0-9]+〉$)';

		$query = "SELECT post_title FROM $wpdb->posts WHERE post_title REGEXP %s AND ID != %d AND post_type = %s AND post_status NOT IN ('trash', 'inherit') LIMIT 1";
		$duplicate_exists = $wpdb->get_var($wpdb->prepare($query, $title_pattern, $post_id, $post_type));

		if ($duplicate_exists) {
			$suffix = 2;
			while (true) {
				// ★★ ここで枝番を「〈2〉」形式で生成 ★★
				$new_title = $original_title . "〈{$suffix}〉";

				$check_query = "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND ID != %d AND post_type = %s LIMIT 1";
				if (!$wpdb->get_var($wpdb->prepare($check_query, $new_title, $post_id, $post_type))) {
					$data['post_title'] = $new_title;
					$data['post_name']  = ''; // スラッグ再生成（重複回避）
					break;
				}
				$suffix++;
			}
		}
	}
	// ★★ 追記終了 ★★



	return $data;
}


add_action('init', function() {
    if (isset($_POST['create_virtual_post']) && !empty($_POST['target_title'])) {
        if (!current_user_can('edit_posts')) return;

        $title = sanitize_text_field($_POST['target_title']);
        $existing_posts = get_posts([
						'title'                  => $title,
						'post_type'              => 'post',
						'post_status'            => 'publish', // または 'any'
						'posts_per_page'         => 1,
						'update_post_term_cache' => false,
						'update_post_meta_cache' => false,
						'orderby'                => 'ID',
						'order'                  => 'ASC',
				]);
				$existing = !empty($existing_posts) ? $existing_posts[0] : null;

        if (!$existing) {
            $post_id = wp_insert_post([
                'post_title'   => $title,
                'post_content' => '[raretu]',
                'post_status'  => 'publish',
                'post_type'    => 'post',
            ]);

            if (!is_wp_error($post_id)) {
                // 重要：ここで階層テーブルを同期
                if (class_exists('\Kx\Database\Hierarchy')) {
                    \Kx\Database\Hierarchy::sync(['id' => $post_id, 'title' => $title], 'insert');
                }

                // 成功パラメータを付けてリダイレクト（二重送信防止）
                $redirect_url = add_query_arg('kx_created', '1', wp_get_referer() ?: home_url());
                wp_safe_redirect($redirect_url);
                exit;
            }
        }
    }
});


add_action( 'save_post', 'kxAdd_save_post' );
/**
 * 保存介入
 *
 * @param [type] $post_id
 * @return void
 */
function kxAdd_save_post( $post_id ){
	delete_transient( 'kxad_the_content_' . $post_id );

	$new_post = get_post( $post_id );

	kxAdd_save_post_Category(KxSu::get('title_preg')['array_add_category'] , $new_post->post_title , $post_id );
	kxAdd_save_post_Tag(KxSu::get('title_preg')['array_add_tag'], $new_post->post_title , $post_id );

	kx_dbX( [ 'id' => $post_id ] , 'id' );

	if( get_post_status( $post_id ) == 'publish'  ) //||!empty( get_the_title( $post_id ) )
	{
		//jsonバックアップ。
		$file_json = 'D:\00_WP\CSV_backup\post_backup.json';
		$json1	= file_get_contents( $file_json );
		$json2	= mb_convert_encoding(  $json1 , 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'  );

		$arr_json = json_decode(  $json2 , true  );

		$arr_json[ $post_id ] = [
			'post_title' 	 => $new_post->post_title ,
			'post_content' => $new_post->post_content,
			'time' => time(),
			//'date' => kx_time( '' , "Y-m-d H:i:s" ),
			'date' => Time::format( '', "Y-m-d H:i:s" ),
		];

		file_put_contents( $file_json , json_encode ( $arr_json , JSON_UNESCAPED_UNICODE ) );


		//csvバックアップ。
		$file = 'D:\00_WP\CSV_backup\\'. $post_id .'.csv';
		$fp 	= fopen( $file , 'w');
		fputcsv( $fp, [ $new_post->post_title , $new_post->post_content ]);
		fclose( $fp );
	}
}




/**
 * Category自動追記
 *
 * @param array $arr
 * @param string $title
 * @return void
 */
function kxAdd_save_post_Category( $arr , $title , $post_id ){

	//　カテゴリー・新規追記
	foreach( $arr as $value ):

		$pattern	= $value[0];
		if( preg_match ( $pattern ,$title, $matches) )
		{
			$term = term_exists(	$matches[0]	, 'category');
			if( $term == 0 && $term == null)
			{
        require_once ( 'D:/00_WP/xampp/htdocs/0/wp-admin/includes/taxonomy.php' );

				$args = array(
					'cat_name' 							=> $matches[0],
					'category_description'	=> 'AUTO',
					'category_nicename' 		=> $matches[0],
					'category_parent' 			=> $catnum,
				);

				wp_insert_category( $args );
			}
		}

	endforeach;
	unset( $value );


	/* 全てのカテゴリーをチェック */
	foreach( get_terms( "category", "fields=all&get=all" ) as $value ):

		/* カテゴリーと同じキーワードが含まれていたら、既存のカテゴリから新規のカテゴリに変更 */
		if(	preg_match(	'#^'.$value->name.'#i' ,	$title ))
		{
			wp_remove_object_terms( $post_id,1, 'category' );
	    wp_add_object_terms( $post_id, $value->name, 'category' );
		}
		elseif(	preg_match(	'#〈'.$value->name.'〉#i' ,$title ))
		{
			wp_remove_object_terms( $post_id,1, 'category' );
	    wp_add_object_terms( $post_id, $value->name, 'category' );
		}
		else
		{
			wp_remove_object_terms( $post_id, $value->name, 'category' );
		}

	endforeach;
	unset( $value );

	/* カテゴリーがない場合は、デフォルトに設定 */
	$catcheck = get_the_category( $post_id );
	if( is_array( $catcheck ) && !empty( $catcheck[0] ) && is_null( $catcheck[0] ) )
	{
		//旧型のCheck。2023/08/29
	  wp_add_object_terms( $post_id , 1, 'category' );
	}
	elseif(is_array( $catcheck ) && empty( $catcheck[0] ) )
	{
		//2023年以降のCheck方法。2023-08-29
		wp_add_object_terms( $post_id , 1, 'category' );
	}
}



/**
 * 投稿タイトルに基づいてタグを自動的に追加・削除する関数。
 *
 * @param array $arr タグを追加するための正規表現パターンを含む配列。
 * @param string $title 投稿のタイトル。
 * @param int $post_id 投稿のID。
 *
 * 動作概要:
 * 1. `$arr` に指定された正規表現に基づいてタイトルを解析し、該当するタグを投稿に追加します。
 * 2. 既存のすべてのタグを取得し、一度投稿からすべて削除します。
 * 3. タイトルと一致する既存のタグを再度投稿に追加します。
 *
 * この関数は、タグ管理を自動化することで投稿の内容に合ったタグ付けを行い、検索性や分類を向上させる目的で使用されます。
 * 特記事項:
 * - `$arr` に指定された正規表現がなくても、既存のタグ名がタイトルに含まれている場合、そのタグは自動的に再追加されます。
 * - タグを完全にリセットして再構築するため、大量のタグが存在する場合にはパフォーマンスに注意が必要です。
 */
function kxAdd_save_post_Tag( $arr , $title ,$post_id ){

	//　tag追記・配列指定型
	foreach( $arr as $value ):

		if( preg_match( $value[0] ,$title, $matches) )
		{
			preg_match( $value[1] ,$matches[0], $matches);
			wp_add_object_terms( $post_id, $matches[0], 'post_tag' );
		}

	endforeach;
	unset( $value );


	//全tagでforeachを回す。
	foreach( get_terms( "post_tag", "fields=all&get=all" ) as $value ):

		//id指定したpostのタグを順次消す。全部消える。2023-02-26。
		wp_remove_object_terms( $post_id , $value->name, 'post_tag' );

		if(	preg_match(	'#'.$value->name.'#i' ,$title ))
		{
			//一致条件だけ追記。
			wp_add_object_terms( $post_id, $value->name, 'post_tag' );
		}

	endforeach;
	unset( $value );

}


//add_action('draft_to_trash',   'kxAdd_trash_post_include');
//add_action('future_to_trash',  'kxAdd_trash_post_include');
//add_action( 'wp_trash_post', 'kxAdd_trash_post_include' );//起動しなかった。たぶん。2022-12-28

//add_action( 'trash_post', 'kxAdd_trash_post_include' );//これも駄目だった。2025-04-11。

add_action( 'publish_to_trash', 'kxAdd_trash_post_include');
/**
 * 削除フック。
 * データベース削除。
 * publish_to_trashは、投稿がゴミ箱に移動する際に発生するアクションフック。2023-02-26ChatGPT。
 *
 */
function kxAdd_trash_post_include( $post_ID ) {
	//echo 'TEST-OK-id:'. $post_ID->ID;
	//time_sleep_until (100);
	kx_db0(	[ 'id' =>  $post_ID->ID ] , 'id' );


	$file_json = 'D:\00_WP\CSV_backup\post_delete.json';
	$json1	= file_get_contents( $file_json );
	$json2	= mb_convert_encoding(  $json1 , 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'  );

	$arr_json = json_decode(  $json2 , true  );

	$arr_json[ $post_ID->ID ] = [
		'post_title' 	 => get_the_title( $post_ID->ID ) ,
		'time' => time(),
		//'date' => kx_time( '' , "Y-m-d H:i:s" ),
		'date' => Time::format( '', "Y-m-d H:i:s" ),
	];

	file_put_contents( $file_json , json_encode ( $arr_json , JSON_UNESCAPED_UNICODE ) );


	//csvバックアップ。
	$file = 'D:\00_WP\CSV_backup\\Delete'. $post_ID->ID .'.csv';
	$fp 	= fopen( $file , 'w');
	fputcsv( $fp, [ get_the_title( $post_ID->ID ) ]);
	fclose( $fp );

}



add_action( 'wp_enqueue_scripts', 'kasax_javascript_include' );
/**
 * java読み込み
 * wp_enqueue_scriptsはWordPressがフロントエンドのページを表示するときに必ず実行される。2023-02-26ChatGPT。
 *
 */
function kasax_javascript_include(){

	wp_enqueue_script(
		'javascript',
		get_stylesheet_directory_uri().'/../kasax_child/js/javascript.js',
		 array( 'jquery' ),
		'1.0',
		true
	);

	//ショートコード生成のjQueryファイル。2023-02-26
	wp_enqueue_script(
		'ks_js',
		get_stylesheet_directory_uri().'/../kasax_child/js/js_kx.js',
		 array( 'jquery' ),
		'1.0',
		true
	);


}


/**
 * 何かの上書き。消すとERRORになる。2020-06-24
 * 2022-12-28。多分今は不要だと思う。
 * 2023-02-26。コメントアウト実行。
 *
 * @return string
 */
/*
function insert_custom_css() {

	if (is_page() || is_single()) {
		if (have_posts()) :
			 while (have_posts()) :
			 	the_post();
				echo '<style type="text/css">'.get_post_meta(get_the_ID(), '_custom_css', true).'</style>';
			endwhile;
		endif;
		rewind_posts();
	}

}
*/




//add_action( 'pre_get_posts', 'KxCustom_search_order' );
/**
 * 不使用。2025-06-20
 * 検索結果のソート順を変更する
 *
 * 検索クエリに対してタイトル昇順（A→Z）での並び替えを適用する。
 * 管理画面とメインクエリ以外では動作しない。
 *
 * @param WP_Query $query 検索クエリオブジェクト
 * @return void
 */
/*
function KxCustom_search_order( $query ) {
    if ( !is_admin() && $query->is_main_query() && $query->is_search() ) {
        // 並び替えの条件を指定
        //$query->set( 'orderby', 'modified' ); // 例: 最終更新日で並び替え
        //$query->set( 'order', 'DESC' );       // 昇順: ASC / 降順: DESC
				$query->set( 'orderby', 'title' ); // タイトルで並べる
        $query->set( 'order', 'ASC' );     // 昇順（A→Z）

        // 他にも並べ替えに使えるキー例:
        // 'date' → 投稿日
        // 'title' → タイトル
        // 'comment_count' → コメント数
        // 'meta_value' → カスタムフィールド（＋meta_keyを指定）
    }
}
		*/


add_filter( 'posts_clauses', 'KxPrioritize_title_endswith_search', 10, 2 );
/**
 * タイトル末尾一致を優先する検索順位調整
 *
 * 検索語がタイトルの末尾に一致する投稿に高いスコアを与え、
 * 検索結果の優先順位を制御する。条件に応じてカスタムスコアを付与し、
 * ORDER BY句に反映する。メインクエリの検索時にのみ適用。
 *
 * @param array     $clauses SQLクエリの各句（SELECT, WHERE, ORDER BYなど）
 * @param WP_Query  $query   検索クエリオブジェクト
 * @return array    修正後のクエリ句配列
 */
function KxPrioritize_title_endswith_search( $clauses, $query ) {
    global $wpdb;

    if ( is_admin() || !$query->is_main_query() || !$query->is_search() ) {
        return $clauses;
    }

    $search_term = $query->get('s');
    if ( empty( $search_term ) ) return $clauses;

    // スコアリング: 文末一致 → スコア1、部分一致 → 2、完全一致 → 3、それ以外 → 4
    $search_esc = $wpdb->esc_like( $search_term );
    $clauses['fields'] .= ",
        CASE
            WHEN {$wpdb->posts}.post_title LIKE " . $wpdb->prepare( '%s', '%' . $search_esc ) . " THEN 1
            WHEN {$wpdb->posts}.post_title LIKE " . $wpdb->prepare( '%s', '%' . $search_esc . '%' ) . " THEN 2
            WHEN {$wpdb->posts}.post_title = " . $wpdb->prepare( '%s', $search_esc ) . " THEN 3
            ELSE 4
        END AS custom_relevance,
        CHAR_LENGTH({$wpdb->posts}.post_title) AS title_length";

    // スコア → タイトルの長さ（短い順）→ 投稿日（新しい順）
    $clauses['orderby'] = "custom_relevance ASC, title_length ASC, {$wpdb->posts}.post_date DESC";

    return $clauses;
}


