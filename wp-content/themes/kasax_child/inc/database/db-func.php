<?php

use Kx\Utils\Time;

add_action('after_switch_theme', 'create_custom_tables');
/**
 * // テーブルを作成する関数
 * // テーブル作成関数をテーマ有効化時に実行
 *
 * @return void
 */
// 汎用的なテーブル作成関数
function create_custom_tables() {
	global $wpdb; // WordPressのデータベースアクセスオブジェクト
	$charset_collate = $wpdb->get_charset_collate();

	// 作成したいテーブルの定義を配列で用意
	$tables = [
			'kx_0' => [
					'sql' => "id mediumint(9) NOT NULL,
										title varchar(255) NOT NULL,
										json text DEFAULT NULL,
										text text DEFAULT NULL,
										time int(11) NOT NULL,
										PRIMARY KEY  (id)"
			],
			'kx_1' => [
					'sql' => "id mediumint(9) NOT NULL,
										title varchar(255) NOT NULL,
										json text DEFAULT NULL,
										text text DEFAULT NULL,
										time int(11) NOT NULL,
										PRIMARY KEY  (id)"
			],
			'kx_shared_title' => [
					'sql' => "title varchar(255) NOT NULL,
										id_lesson mediumint(9) NOT NULL,
										id_sens mediumint(9) NOT NULL,
										id_study mediumint(9) NOT NULL,
										id_data mediumint(9) NOT NULL,
										date text DEFAULT NULL,
										json text DEFAULT NULL,
										text text DEFAULT NULL,
										time int(11) NOT NULL,
										PRIMARY KEY  (title)"
			],
			'kx_works' => [
					'sql' => "title varchar(255) NOT NULL,
										id_sens mediumint(9) NOT NULL,
										id_study mediumint(9) NOT NULL,
										id_data mediumint(9) NOT NULL,
										date text DEFAULT NULL,
										json text DEFAULT NULL,
										text text DEFAULT NULL,
										time int(11) NOT NULL,
										PRIMARY KEY  (title)"
			],
      'kx_hierarchy' =>// 【新規追加】階層マッピングテーブル
      [
          'sql' => "full_path varchar(255) NOT NULL,
                    post_id mediumint(9) DEFAULT 0,
                    parent_path varchar(255) DEFAULT NULL,
                    level tinyint(4) NOT NULL,
                    is_virtual tinyint(1) DEFAULT 1,
                    json text DEFAULT NULL,
                    text text DEFAULT NULL,
                    time int(11) NOT NULL,
                    PRIMARY KEY  (full_path)"
			],
			'kx_temporary' =>
			[
					'sql' => "type varchar(255) NOT NULL,
										text1 varchar(255) NULL,
										text2 varchar(255) NULL,
										text3 varchar(255) NULL,
										text4 varchar(255) NULL,
										text5 varchar(255) NULL,
										text6 varchar(255) NULL,
										json text DEFAULT NULL,
										text text DEFAULT NULL,
										time int(11) NOT NULL,
										PRIMARY KEY  (type)"
			]
	];

	// テーブルごとに作成処理を実行
	foreach ($tables as $table_name => $table_data) {
			$full_table_name = $wpdb->prefix . $table_name;
			$sql = "CREATE TABLE IF NOT EXISTS $full_table_name ({$table_data['sql']}) $charset_collate;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
	}
}




/**
 * db_kxX統合系
 * 出力なし。処理用。
 *
 * @param [type] $args
 * @param [type] $type
 */
function kx_dbX($args, $type) {
	// 'id' が存在し、かつ有効な場合にのみチェックを実行
	if (isset($args['id']) && !empty($args['id']))
	{
		$post_status = get_post_status($args['id']);
		$post_type = get_post_type($args['id']);
		$post_title = get_the_title($args['id']);

		// 投稿が公開されていない、またはタイプが「post」でない場合、処理を終了
		if ($post_status !== 'publish' || $post_type !== 'post' || !$post_title) {
			return;
		}
	}

	// 必要な処理を実行
	kx_db0($args, $type);
	kx_db1($args, $type);
	kx_db_SharedTitle($args, $type);
	kx_db_Woks($args, $type);
	\Kx\Database\Hierarchy::sync($args, $type);
	//kxdbC_main($args, $type); //* 不採用。2025-04-11。あまり速度変わらず。
	//kx_db2($args, $type);
}




/**
 * db_kx0系
 *
 * @param [type] $args
 * @param [type] $type
 * @return void
 */
function kx_db0(	$args , $type  ){

	//echo $type;

	$kxdb0 = new kxdb0;
	$kxdb0->kxdb0_Main( $args , $type  );

	if( !empty( $kxdb0->output ) )
	{
		return $kxdb0->output;
	}
}




/**
 * 指定されたタイトルをデータベースから検索し、結果を統合する関数
 *
 * @param array $args 検索条件を含む配列。'title' キーには検索するタイトル（文字列または配列）が含まれる。
 * @return array 検索結果を統合した連想配列。キーはタイトル、値はデータベースの検索結果オブジェクト。
 */
function kx_db0_Template_Base($args) {
    // タイトルが未定義または空の場合は処理をスキップ
    if(!isset($args) && empty($args['title'] && empty($args['titles'])) )
		{
			return []; // 空の配列を返す
    }

    // タイトルを配列として処理
    $titles = !empty($args['titles']) && is_array($args['titles']) ? $args['titles'] : [$args['title']];
    $index = [];

    foreach ($titles as $title) {
        // データベース検索
        $db = kx_db0(['title' => $title], 'Select_title');

        // 検索結果が無効ならスキップ
        if (empty($db) || !is_array($db)) {
            continue;
        }

				//var_dump($db);
				//echo '<hr>';


        foreach ($db as $item) {
            if (!isset($item->title) || !isset($item->id)) {
                continue; // 必須データがない場合はスキップ
            }

						//echo $item->title;
						//echo '<br>';


            if (isset($index[$item->title])) {
                // 同じタイトルがすでに存在する場合、WordPressのリンクを出力
                $permalink = get_permalink($item->id);
                echo "重複タイトル: <a href='{$permalink}'>{$item->title}</a><br>";
            }

            $index[$item->title] = $item;
        }
    }

    return $index;
}





/**
 * Undocumented function
 *
 * @param [type] $title
 * @param [type] $index
 * @return void
 */
function kx_db0_Template_ID( $title , $index ){
	//echo $title;

	if (isset($index[$title])){

		//var_dump($index[$title]->id);
		return $index[$title]->id;

	}


	//echo $title;
	// 部分一致の処理
    $matchedIds = [];
    foreach ($index as $key => $item) {
        if (strpos($key, $title) !== false) { // タイトルが含まれているかチェック
            $matchedIds[] = $item->id;
        }
    }

    // IDを ',' で結合して返す
    return !empty($matchedIds) ? implode(',', $matchedIds) : NULL;


}



/**
 * 指定IDから再帰的に下位の raretu_id を取得し、配列に格納する。
 *
 * データベースから対象IDのJSONを取得し、
 * raretu_id が存在する場合はそれを再帰的にたどって、すべての階層のIDを収集する。
 *
 * @param int $id 現在処理対象となるID
 * @param array<int> &$collected_ids 収集されたID一覧（参照渡し）
 *
 * @return void
 */
function kx_db0_raretu_get_all_sub_ids( $id, &$collected_ids = []) {

    $result = kx_db0(['id' => $id], 'Select_ID');

	if (!empty($result[0]->json)) {
		$json = json_decode($result[0]->json, true);

		if (isset($json['raretu_id']) && is_array($json['raretu_id'])) {
			foreach ($json['raretu_id'] as $sub_id) {
				if (!in_array($sub_id, $collected_ids)) {
					$collected_ids[] = $sub_id;
					kx_db0_raretu_get_all_sub_ids($sub_id, $collected_ids);  // 再帰呼び出し
				}
			}
		}
	}
}




/**
 * データベース関連
 * データベース、kx_1系テーブル。2022-12-29
 * type
 * upper：上位リンク取得。
 * kxx：kxx系タイトル検索、id取得。
 * Maintenance：メンテナンス。
 * ghost：ゴーストコピー表示用。
 * format_check：ゴーストコピーのチェック。
 * base_id：
 * content：表示時のアップデート。
 *
 * @param array $args
 * @param string $type
 * @return string 文字列を出力。
 */
function kx_db1(	$args , $type = null ){

	$kxdb1 = new kxdb1;
	$kxdb1->kxdb1_Main( $args , $type  );

	if( !empty( $kxdb1->output ) )
	{
		return $kxdb1->output;
	}
}



/**
 * db_kx2系
 * 使用終了。2025-04-05
 * 一応保存するが、特に使い道はなし。
 *
 * @param [type] $args
 * @param [type] $type
 * @return void
 */
function kx_db2( $args , $type ){

	$kxdb0 = new kxdb2;
	$kxdb0->kxdb2_Main( $args , $type);

	if( !empty( $kxdb0->output ) )
	{
		return $kxdb0->output;
	}
}






/**
 * 投稿データをもとに、データベースへの読み込み・更新・挿入を行う共通関数。
 *
 * 【主な処理の流れ】
 * 1. 投稿のタイトルからDB検索用タイトル（"≫〜＠概要"を除去）を生成
 * 2. 指定のテーブルから既存データを読み込む
 * 3. 既存データがあるかどうかで、"insert" or "update" を判定
 * 4. 投稿本文に "raretu" ショートコードが含まれていない場合は、本文から `date`・`json` を再生成
 * 5. DBに書き込むためのデータを整形し、`title_base` によるパターンマッチで補足IDを追加
 * 6. insert または update に応じて、DBへ書き込みを実行
 *
 * @param array $source 投稿に関する情報を含む連想配列
 *                      例：['id' => 投稿ID, 'DBtitle' => DB検索用タイトル, 'title_base' => タイトルベース]
 * @param string $table_name 書き込み対象のDBテーブル名（例: 'kx_shared_title'、'kx_works' など）
 * @param string $json_type kx_db_json() で使用する、JSON出力形式の指定（用途別識別名）
 * @param array $pattern_keys タイトルベースとIDフィールドの対応パターンの連想配列
 *                             例：['/^γ/' => 'id_sens', '/^σ/' => 'id_study']
 *
 * @return array 書き込みに使ったデータ配列（確認・デバッグ用途などに活用可能）
 */
function kx_db_ID_Common($source, $table_name, $json_type, $pattern_keys) {

	$_title = preg_replace('/≫[^≫]*＠概要/', '', $source['DBtitle']);

	// 取得カラム定義
	$select_columns = ['title', 'date', 'id_sens', 'id_study', 'id_data', 'json'];
	if ($table_name === 'wp_kx_shared_title')
	{
		$select_columns[] = 'id_lesson';
	}

	// DB 読み取り
	$result = kx_db_Read($table_name, ['title' => $_title], $select_columns);

	//var_dump($result);
	//echo '+<hr>';

	// 初期化
	$date      = [];
	$id_sens   = [];
	$id_study  = [];
	$id_data   = [];
	$id_lesson = []; // shared_title 用
	$json      = [];
	$_w_type   = 'insert';

	if (!empty($result))
	{
		$_old_result = $result[0];
		$date = kx_json_decode($_old_result->date);
		$id_sens = $_old_result->id_sens ?? [];
		$id_study = $_old_result->id_study ?? [];
		$id_data = $_old_result->id_data ?? [];
		$json = kx_json_decode($_old_result->json);
		$id_lesson = $_old_result->id_lesson ?? [];
		$_w_type = 'update';
	}

	// コンテンツ取得・raretuチェック
	$_content = get_post($source['id'])->post_content;
	if (
		!preg_match('/\[.*raretu.*\]/', $_content) &&
		preg_match( '/δ/' , get_the_title( $source['id']  ))
	)
	{
		//echo $source['DBtitle'];
		//echo '<br>';

		if (
			preg_match('/δ≫芸術・作品≫list≫(.*?)≫登場人物/',get_the_title( $source['id'] ), $matches) &&
			$table_name == 'wp_kx_works'
		)
		{

			$_result  = kx_db_Woks( ['title' => get_the_title( $source['id'] ) ] , 'select_title' );

			if(preg_match('/Date：/', $_content))
			{
				$date = kx_db_date($_content,$table_name);
			}
			elseif(!empty( $_result->date ))
			{
				$_result_date = $_result->date;
				//$_result_date = kx_json_encode($_result_date);
				$_result_date =  kx_json_decode($_result_date);

				sort($_result_date);
				//var_dump($_result_date[0]);
				$date = [$_result_date[0]];
			}
			else
			{
				$date = kx_db_date($_content,$table_name);
			}


		}
		else
		{
			$date = kx_db_date($_content,$table_name);
		}




		$json = kx_db_json($_content, $source['DBtitle'], $json_type);
		kx_db_json_gaiyou_add( $json,$source['id']  );
	}
	elseif( preg_match('/\[.*raretu.*\]/', $_content) )
	{
		if(empty( $json['概要'] ))
		{
			$json = null;//リセット。
			$date = null;
		}
		elseif( !preg_match( '/'.$result[0]->title.'.*概要$/' , get_the_title($json['概要']) ) )
		{
			echo $result[0]->title;
			echo '<br>';
			echo get_the_title($json['概要']);
			echo '<hr>';
			unset($json['概要']);
		}
		elseif( get_post_status( $json['概要'] ) != 'publish' )
		{
			unset($json['概要']);
		}

	}
	else
	{
		unset($date);
		unset($json);
	}

	// 書き込みデータ準備
	/*
	$data_write =
	[
		'title' => $_title,
		'date' => kx_json_encode($date),
		'id_sens' => $id_sens,
		'id_study' => $id_study,
		'id_data' => $id_data,
		'json' => kx_json_encode($json)
	];
	*/

	$data_write = [
    'title' => $_title,
    'id_sens' => $id_sens,
    'id_study' => $id_study,
    'id_data' => $id_data,
	];

	//echo $_title;
	//echo '<br>';

	if (isset($date)) {
			$data_write['date'] = kx_json_encode($date);
	}

	if (isset($json)) {
			$data_write['json'] = kx_json_encode($json);
	}


	if ($table_name === 'wp_kx_shared_title')
	{
		$data_write['id_lesson'] = $id_lesson;
	}

	// title_base の判定による ID 追加
	if (!preg_match('/^(.*)≫.*＠概要$/', $source['DBtitle'])) {
		foreach ($pattern_keys as $pattern => $key) {
			if (preg_match($pattern, $source['title_base'])) {
				$data_write[$key] = $source['id'];
				break;
			}
		}
	}

	// DB 書き込み処理
	if ($_w_type === 'insert') {
			kx_db_Write('insert', null, $table_name, $data_write);
	} else {
			$where = ['title' => $_title];
			kx_db_Write('update', $_old_result, $table_name, $data_write, $where);
	}

	// 必要に応じて戻り値を返す（たとえば書き込んだデータなど）
	return $data_write;
}




/**
 * DB、JSON操作を行い、JSON配列を出力する関数。
 *
 * 指定された引数を基にJSON配列を操作し、必要なデータを追加または削除して返します。
 *
 * @param array $args 入力データの配列。投稿内容やその他の情報を含む。
 * @param array $json_arr 操作対象のJSON配列。
 * @param string $type 概要の有無など。
 * @return array 操作後のJSON配列を返します。
 */
function kx_db_json_TAG(	$content , $json_arr, $type = null ){

	//var_dump($content);
	//echo '<br>';
	//var_dump($json_arr);
	//echo '<br>';
	//echo '<hr>';
	//タグの処理。2023-06-24
	if ( !empty( $json_arr[ 'GhostON' ] )  )
	{
		unset( $json_arr[ 'タグ' ] );
	}
	elseif ( preg_match( '/タグ：(.*)(\r\n|$)/' , $content , $matches ))
	{
		$json_arr[ 'タグ' ] = $matches[1];
		//var_dump($json_arr);
		//echo '<br>';
	}
	elseif(  $type == 'gaiyou')
	{
		unset( $json_arr[ 'タグ' ] );
	}
	elseif ( !empty( $json_arr[ '概要' ] )  )
	{
		//スルー
	}
	else
	{
		unset( $json_arr[ 'タグ' ] );
	}
	unset( $matches );

	return $json_arr;
}



/**
 * 指定された内容を解析し、配列化する関数
 *
 * @param string $_content 入力された文章
 * @return array 配列化されたデータ
 */
function kx_db_json($content , $DBtitle , $json_type ){

	$_array = [];


	if( preg_match( '/≫登場人物≫/' , $DBtitle ) ) //$this->kxdbW_S0[  'DBtitle' ]
	{
		//echo $this->kxdbW_S0[  'DBtitle' ];
		$_array[ 'キャラ' ] = preg_replace( '/≫登場人物≫.*/' , '' , $DBtitle );
	}


	 // 対象となるキー（読み取る項目）

	 //var_dump($kxst->work_list[$pickup]) ;

	 //var_dump($kxst->work_list);

	 // 結果を格納する配列


	 // 行単位に分割
	 $lines = explode(PHP_EOL, $content);

	 // 各行を解析
	 foreach ($lines as $line)
	 {
			// 「キー：値」の形式を抽出
			if (preg_match('/^(.*)：(.*)$/', $line, $matches))
			{
				$key = trim($matches[1]); // キー（例: 監督, シリーズなど）
				$value = trim($matches[2]); // 値（例: 宮崎駿, ルパンなど）

				// 指定されたキーのみを処理
				if (in_array($key, KxSu::get('DBjson_pickup')[$json_type]))
				{
					// 同じキーが複数回出現した場合は配列として追加
					if (isset($_array[$key]))
					{
						// 既存のキーの場合、値を上書き
						$_array[$key] = $value;
					} else {
						// キーが存在しない場合、新たに追加
						$_array[$key] = $value;
					}
				}
			}
		}

		// $_array に含まれるキーのうち、$kxst->work_list[$pickup] に存在するものだけを保持
		// array_flip() を使って $kxst->work_list[$pickup] の値をキーに変換し、array_intersect_key() でフィルタリング
		$_array = array_intersect_key($_array, array_flip(KxSu::get('DBjson_pickup')[$json_type]));

		//var_dump($_array);


	 //$this->json = $result;
	 return $_array;

}



/**
 * 指定されたコンテンツから日付情報を抽出し、適切なフォーマットに変換する関数
 *
 * @param string $content    処理対象の文字列（Date：が含まれるデータ）
 * @param string $table_name 処理対象のテーブル名
 * @return mixed             kx_shared_title の場合はフォーマット済みの日付文字列、その他のテーブルの場合は連想配列、該当データがない場合は NULL
 */
function kx_db_date($content, $table_name) {

	$dates = [];
	// その他のテーブルの場合の処理
	foreach (explode('Date：', $content) as $date_str)
	{
		//echo $date_str;
		//echo '<br>';
		// 年月日形式のデータ（例：イベント：2025年04月06日）を抽出
		if (preg_match('/^(.*)：'.KxSu::get('base_preg')['date_s'].'/', $date_str, $matches))
		{
			//var_dump($matches);
			$year = $matches[2];
			$month = sprintf('%02d', $matches[4] ?: 0);
			$day = sprintf('%02d', $matches[6] ?: 0);
			$dates[$matches[1]] = "{$year}_{$month}_{$day}";
		}
		elseif (preg_match('/^'.KxSu::get('base_preg')['date_s'].'/', $date_str, $matches)) {
			$year = $matches[1];
			$month = sprintf('%02d', $matches[3] ?: 0); // 月が空の場合は 00 を設定
			$day = sprintf('%02d', $matches[5] ?: 0);   // 日が空の場合は 00 を設定
			$formatted_date = "{$year}_{$month}_{$day}";
			// フォーマットが適切な場合のみ返却、該当しない場合は NULL
			//return (preg_match('/_\d\d_/', $formatted_date)) ? $formatted_date : [];
			$dates[0] = "{$year}_{$month}_{$day}";
		}
		//echo '<br>';

		// クォーター（四半期）形式（例：売上：2025Q2）を処理
		if (preg_match('/^(.*)：(\d{4})Q(\d)/', $date_str, $matches))
		{
			$quarters = [1 => '01', 2 => '04', 3 => '07', 4 => '10']; // 四半期の開始月を定義
			$month = $quarters[$matches[3]] ?? '00';
			$dates[$matches[1]] = "{$matches[2]}/{$month}/00";
		}
	}

	// 不適切なフォーマットのデータをフィルタリング
	return array_filter($dates, fn($item) => preg_match('/_\d\d_/', $item));
}









/**
 * jsonに概要の有無を追加。
 *
 * @param [type] $title
 * @param [type] $array
 * @param [type] $id
 * @return void
 */
function kx_db_json_gaiyou_add( &$array , $id  ){

	if (preg_match('/概要$/',get_the_title($id) ) )
	{
		$array['概要'] = $id;
	}
	elseif(	!empty( $array['概要'] ) 	)
	{
		unset($array['概要']);
	}
}





/**
 * worksDBシステム
 *
 * @param [type] $args
 * @return void
 */
function kx_db_Woks( $args , $type ){

	$kxdbW = new kxdbW;
	$kxdbW->kxdbW_Main( $args , $type );

	if( !empty( $kxdbW->select)  )//$args[ 'order' ] == 'select_search'
	{
		return $kxdbW->select;
	}
}





/**
 * タイトルShareDBシステム
 *
 * @param [type] $args
 * @return void
 */
function kx_db_SharedTitle( $args = NULL , $order ){

	if( !empty( $args[ 'id' ] ) )
	{
		$args[ 'title_base' ] = get_the_title( $args[ 'id' ] );
	}

	if( $order != 'Maintenance' && (  is_page( $args['id'] ) || !preg_match( '/≫/' , $args[ 'title_base' ] ) ) )
	{
		//ページは排除。2023-03-02
		//ツリーの最上位は排除。2023-03-02。
		return;
	}

	$kxdbST = new kxdbST;

	if( $order == 'Maintenance' )
	{
		return '★DB kxST Maintenance★'.$kxdbST->kxdbST_Main( $args , $order ).'：'.count($kxdbST->result);
	}


	//4シェア型。2023-02-25
	if( preg_match( '/'.KxSu::get('titile_search')[ 'SharedTitleDB' ].'/' , $args[ 'title_base' ]  , $matches ) )
	{
		$args[ 'title_top' ] 	 = $matches[0];
		$args[ 'title_share' ] = preg_replace( '/^'.$matches[0].'≫/' , '' , $args[ 'title_base' ] );

		$kxdbST->kxdbST_Main( $args , $order );
	}


	if( $order == 'id')
	{
		return ;
	}
	else
	{
		$ret=[];
		if( !empty( $kxdbST->ids ))
		{
			$ret[ 'ids' ] = $kxdbST->ids;
		}

		if( !empty( $kxdbST->date ))
		{
			$ret[ 'date' ] = $kxdbST->date;
		}

		if( !empty( $kxdbST->json ))
		{
			$ret[ 'json' ] = $kxdbST->json;
		}
		return  $ret;
	}
}





/**
 * dbメンテナンス起動。
 *
 * @return void
 */
function kx_db_Maintenance(){

	kx_db_MaintenanceD_csv( "DB_daily_start" );

	$ret = '';
	$ret .= kx_db0( [ 'non' ] , 'Maintenance' )['string'];
	$ret .= '<br>';
	$ret .= kx_db1( [ 'non' ] , 'Maintenance' )['string'];
	$ret .= '<br>';
	$ret .= kx_db_Woks( [] , 'Maintenance');
	$ret .= '<br>';
	$ret .= kx_db_SharedTitle( [] , 'Maintenance' );

	//$ret .= kx_db2( [ 'non' ] , 'Maintenance' )['string'];
	//$ret .= '<br>';
	//$ret .= '<br>';
	//$ret .= kx_db_MaintenanceD_sql();
	//$ret .= kxdbC_main( [] , 'Maintenance');


	kx_db_MaintenanceD_csv( "DB_daily_start" );

	return $ret;
}



/**
 * 指定したテーブルをバックアップし、CSVにもデータを記録する関数
 * 機能停止。バックアップできてない。2025-04-08
 *
 * この関数は、指定した複数のテーブルのデータをSQLファイルとしてエクスポートし、
 * さらに現在時刻のデータをCSV形式で指定したファイルに追記します。
 *
 * 注意: バックアップファイルの保存先とCSVファイルのパスは固定値で設定されています。
 * 必要に応じて、動的に変更できるようカスタマイズしてください。
 *
 * @global wpdb $wpdb WordPress データベースアクセスオブジェクト
 * @return void
 */
function kx_db_MaintenanceD_sql(){
	global $wpdb;

	/*

	// タイムゾーンを日本時間（Asia/Tokyo）に設定
	$datetime = new DateTime("now", new DateTimeZone("Asia/Tokyo"));

	$ret = '';
	foreach(['kx_0','kx_1','kx_works' ,'kx_shared_title','wp_kx_temporary'] as $table_name)
	{
		$table_name = $table_name; // バックアップしたいテーブル名
		$backup_file = "D:\\00_WP\\CSV_backup\\" .$table_name . "_" . $datetime->format("Ymd_H") . ".sql"; // 保存先ファイルパス

		// SQLコマンドを構築してデータをエクスポート
		$results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

		if (!empty($results))
		{
			// バックアップファイルを作成
			$file_handle = fopen($backup_file, "w");

			foreach ($results as $row)
			{
				$values = array_map('esc_sql', array_values($row));
				$sql = "INSERT INTO `$table_name` VALUES ('" . implode("', '", $values) . "');\n";
				fwrite($file_handle, $sql);
			}
			fclose($file_handle);

			$ret .= 'DB_'.$table_name.':'.count($results).'<br>';
		}
	}
	//csv 書き込み。2025-04-03
	return $ret;
	*/
}



/**
 * CSVファイルにメンテナンス情報を記録する関数
 *
 * 指定された文字列（イベント名など）と現在の日時をCSVファイルに追記します。
 * ファイルの競合を防ぐために、排他ロックをかけて安全に書き込みます。
 *
 * @param string $string 書き込むイベント名などの文字列
 * @return void
 */

function kx_db_MaintenanceD_csv( $string ){
	//csv書き込み
	$file = "D:\\00_WP\\CSV_backup\\schedule.csv"; // 書き込むCSVファイルのパス

	$timestamp = date("Y-m-d H:i:s"); // 現在の時刻を取得
	$data = array($timestamp, $string); // CSVに書き込むデータ（時刻と固定文字列）

	// ファイルを「追記モード（a）」で開く
	$file_handle = fopen($file, "a");

	// ファイルが正常に開けたか確認
	if( $file_handle )
	{
		flock($file_handle, LOCK_EX); // 排他ロックをかける
		fputcsv($file_handle, $data); // CSV形式でデータを書き込む
    flock($file_handle, LOCK_UN); // ロック解除
    fclose($file_handle); // ファイルを閉じる
	}
}



add_action('wp_ajax_kx_hierarchy_action', 'kx_hierarchy_ajax_handler');
/**
 * Ajaxハンドラ（func_db.php 内）
 */
function kx_hierarchy_ajax_handler() {
    $mode = isset($_GET['mode']) ? $_GET['mode'] : '';
    $base = isset($_GET['base']) ? $_GET['base'] : '';

    if (empty($base)) {
        echo "ベースタイトルが空です。";
        wp_die();
    }

    // 1. メンテ機能の実行
    if ($mode === 'repair_sub') {
        \Kx\Database\Hierarchy::repair_hierarchy($base, false);
    } elseif ($mode === 'repair_all') {
        \Kx\Database\Hierarchy::repair_hierarchy($base, true);
    }

    // --- 修正ポイント：再帰フラグの判定を「full」時も true にする ---
    // $mode が 'full'（子階層表示ボタン）または 'repair_all' の場合に再帰表示（全下位表示）とする
    $recursive = ($mode === 'full' || $mode === 'repair_all');

    // 3. ツリー生成を呼び出す
    echo \Kx\Database\Hierarchy::get_full_tree_text($base, "", $recursive);

    wp_die();
}

/**
 * 表示用関数：raretu.php から呼び出されるUI生成
 */
function kx_db_Hierarchy_render_ui($base_title) {
    if (empty($base_title)) return '<p>No Title Base.</p>';

    $js_title = esc_js($base_title);
    $unique_id = 'kx_h_out_' . md5($base_title); // IDの衝突回避

    $html = '<div class="kx-hierarchy-ui" style="background:#1e1e1e; color:#ccc; padding:15px; border-radius:5px; font-family:monospace; margin-bottom:20px;">';
    $html .= '<div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #444; padding-bottom:10px; margin-bottom:10px;">';
    $html .= '<strong style="color:#569cd6;">' . esc_html($base_title) . '</strong>';
    $html .= '</div>';
		$html .= '<div>';
    $html .= '<button onclick="kx_h_ajax(\'full\', \''.$js_title.'\', \''.$unique_id.'\')" style="cursor:pointer; font-size:12px;">全下位表示</button> ';
    $html .= '<button onclick="kx_h_ajax(\'repair_sub\', \''.$js_title.'\', \''.$unique_id.'\')" style="cursor:pointer; font-size:12px; background:#0e639c; color:#fff; border:none;">子階層表示/追記（メンテ）</button> ';
    $html .= '<button onclick="kx_h_ajax(\'repair_all\', \''.$js_title.'\', \''.$unique_id.'\')" style="cursor:pointer; font-size:12px; background:#a31515; color:#fff; border:none;">全下位表示/追記（メンテ）</button>';
		$html .= '</div>';
		//$html .= '</div></div>';
    $html .= '<pre id="'.$unique_id.'" style="margin:0; white-space:pre-wrap; line-height:1.4; color:#9cdcfe;">ボタンを押すと階層を読み込みます...</pre>';

    // JS: Ajax送信処理
    // func_db.php 内の該当箇所を差し替え
$admin_ajax_url = admin_url('admin-ajax.php'); // PHP側で正しいURLを取得

$html .= '<script>
if(typeof kx_h_ajax !== "function"){
    function kx_h_ajax(mode, base, targetId) {
        const out = document.getElementById(targetId);
        out.innerText = "処理中...";

        // PHPから渡された正しい絶対パスを使用
        const url = "' . esc_js($admin_ajax_url) . '";

        const params = new URLSearchParams({
            action: "kx_hierarchy_action",
            mode: mode,
            base: base
        });

        fetch(url + "?" + params.toString())
					.then(res => {
							if (!res.ok) throw new Error("HTTP error " + res.status);
							return res.text();
					})
					.then(data => {
							// innerText から innerHTML に変更
							out.innerHTML = data || "階層データが見つかりませんでした。";
					})
					.catch(err => {
							out.innerText = "通信エラー: " + err.message;
					});
    }
}
</script>';
$html .= '</div>';

    return $html;
}






//まだ未使用。2025-04-11
/**
 * 再帰的に配列をユニーク化する関数
 *
 * @param array $array 対象の配列
 * @return array ユニーク化された配列
 */
function recursive_unique(array $array) {
	$serialized_array = array_map('serialize', $array); // 配列をシリアライズして比較
	$unique_serialized_array = array_unique($serialized_array); // ユニーク化
	$unique_array = array_map('unserialize', $unique_serialized_array); // 元の形式に戻す

	foreach ($unique_array as &$item) {
			if (is_array($item)) {
					$item = recursive_unique($item); // 再帰的にネストされた配列を処理
			}
	}

	return $unique_array;
}



//まだ未使用。2025-04-11
/**
* データベースの読み込み→追記処理→自動書き込み（INSERT/UPDATE）を行い、
* JSONカラム「json」内の配列を再帰的に統合、ユニーク化、ソート化する関数
*
* @param string $table_name 操作対象のテーブル名
* @param array $where 読み込み時のWHERE条件
* @param array $data 追加または更新するデータ
* @return string 処理結果
*/
function kx_db_AutoProcessWithJson($table_name, $where = [], $data = []) {
	global $wpdb;

	// データを読み込む
	$read_results = kx_db_Read($table_name, $where);

	// JSONデータの統合・ユニーク化・ソート化（再帰的に処理）
	if (!empty($read_results) && isset($read_results[0]->json)) {
			$existing_json = json_decode($read_results[0]->json, true); // 現在のJSONデータをデコード
			$new_json = isset($data['json']) ? json_decode($data['json'], true) : []; // 新規のJSONデータをデコード

			if (is_array($existing_json) && is_array($new_json)) {
					$merged_array = array_merge($existing_json, $new_json); // 配列を統合
					$unique_array = recursive_unique($merged_array); // 再帰的ユニーク化
					sort($unique_array); // ソート化
					$data['json'] = json_encode($unique_array); // 再度JSON形式にエンコードしてデータに保存
			}
	}

	// 書き込み処理を自動で選択（データが存在しない場合はINSERT、存在する場合はUPDATE）
	if (empty($read_results)) {
			// INSERT処理
			$write_result = kx_db_Write('insert', null, $table_name, $data);
	} else {
			// UPDATE処理
			$write_result = kx_db_Write('update', $read_results[0], $table_name, $data, $where);
	}

	return $write_result;
}











/**
 * データベースからデータを読み込むための関数
 *
 * この関数は指定されたテーブルからデータを取得します。
 * WHERE条件や取得カラム、並び順、件数制限などを柔軟に設定できます。
 * 条件の結合方法（AND または OR）や、部分一致検索（LIKE）のオプションも指定可能です。
 *
 * @param string $table_name 読み込み対象のテーブル名。
 * @param array $where WHERE条件を指定する連想配列（例: ['title' => 'example']）。
 * @param string|array $select_columns 取得するカラム名（例: '*' ですべてのカラム、または ['title', 'date'] のように特定カラムを指定）。
 * @param int|null $limit 取得するデータの件数制限（例: 10 を指定すると10件だけ取得）。
 * @param string|null $order_by 並び順を指定する文字列（例: 'date DESC' で降順に並び替え）。
 * @param string $condition_operator WHERE条件を結合する演算子（デフォルトは 'AND'）。
 * @param bool $use_like 部分一致検索を行うかどうか（デフォルトは false）。falseが完全一致。
 * @return array 読み込んだデータを配列形式（連想配列）で返す。データが見つからない場合は空配列を返す。
 */
function kx_db_Read($table_name, $where = [], $select_columns = '*', $limit = null, $order_by = null, $condition_operator = 'AND', $use_like = false) {
	global $wpdb;

	// SELECTカラムの準備
	if (is_array($select_columns))
	{
		$select_columns = implode(',', $select_columns);
	}


	// 基本クエリの構築
	$query = "SELECT $select_columns FROM $table_name";

	// WHERE条件の構築
	$where_conditions = [];
	$query_params = [];
	if (!empty($where)) {
			foreach ($where as $column => $value) {
				if (is_array($value))
				{
					$column_conditions = [];
					foreach ($value as $v) {
							if ($use_like) {
									$column_conditions[] = "$column LIKE %s";
									$query_params[] = '%' . $v . '%';
							} else {
									$column_conditions[] = "$column = %s";
									$query_params[] = $v;
							}
					}
					$where_conditions[] = '(' . implode(" OR ", $column_conditions) . ')';
				}
				else
				{
						if ($use_like) {
								$where_conditions[] = "$column LIKE %s";
								$query_params[] = '%' . $value . '%';
						} else {
								$where_conditions[] = "$column = %s";
								$query_params[] = $value;
						}
				}
			}
			$query .= " WHERE " . implode(" $condition_operator ", $where_conditions);
	}

	// ORDER BYの追加
	if (!empty($order_by)) {
			$query .= " ORDER BY $order_by";
	}

	// LIMITの追加
	if (!empty($limit)) {
			$query .= " LIMIT %d";
			$query_params[] = $limit;
	}

	// クエリの準備と実行
	$prepared_query = $wpdb->prepare($query, $query_params);
	$results = $wpdb->get_results($prepared_query);

	// 結果の処理
	if (empty($results)) {
		return;
	}

	return $results;
}




/**
 * データベースに対して指定された操作（INSERT、UPDATE、DELETE）を実行する関数
 *
 * この関数は、指定された内容をデータベースに保存、更新、または削除します。
 * 特にアップデート処理の場合には、既存データと新規データを比較し、内容が同一であれば保存を中止します。
 *
 * @param string $w_type 実行する操作の種類を指定します。
 *                       有効な値は以下です:
 *                       - 'insert': 新規データを挿入します。
 *                       - 'update': 既存データを更新します。同一データの場合は保存を中止します。
 *                       - 'delete': データを削除します。
 * @param object|null $old_result 更新時に既存データを渡すためのオブジェクト形式のデータ。
 *                                このデータは、アップデート処理で新しいデータと比較されます。
 *                                内容が同一の場合は保存を中止します。
 * @param string $table_name 操作対象のテーブル名を指定します。
 * @param array $data 挿入または更新するデータを連想配列形式で指定します。
 *                    例: ['title' => 'example', 'date' => '2023-01-01']。
 * @param array $where 条件を指定する連想配列（主に更新・削除時に使用）。
 *                     例: ['id' => 1]。
 * @param array $format データの型フォーマット（主に挿入・更新時に使用）。
 *                      各値は以下の型を表す文字列を指定します:
 *                      - '%s': 文字列型
 *                      - '%d': 数値型
 *                      - '%f': 浮動小数点型
 * @param array $where_format WHERE条件の型フォーマット。
 *                            データ型の例: '%s', '%d'。
 * @param array $exclude_columns 更新時に比較対象から除外するカラムを指定します。
 *                               デフォルト値は ['time']。
 *                               例: ['time', 'last_updated']。
 * @return string 処理結果を示すメッセージを返します。
 *                - '処理に成功しました': 操作が正常に完了した場合。
 *                - 'データが空です': `$data` が空の場合。
 *                - '既存データが存在しません': 更新時に `$old_result` が提供されない場合。
 *                - '既存のデータと同じため、保存を中止しました': 更新時にデータが同一の場合。
 *                - '対象データが見つかりませんでした': 削除や更新時に対象が存在しない場合。
 *                - '無効な書き込みタイプです': `$w_type` が無効な値の場合。
 */
function kx_db_Write($w_type, $old_result = null, $table_name, $data , $where = [], $format = [], $where_format = [], $exclude_columns = ['time', 'text']) {
	global $wpdb; // グローバル変数を使用

	//echo '<hr>';echo '<hr>';echo '<hr>';echo '<hr>';
	//echo $w_type;
	//var_dump($data);
	//echo '<hr>';


	// 空データのチェック
	if ($w_type !== 'delete' && empty($data))
	{
    return 'データが空です';
	}

	if (!is_array($data)) {
    $data = [];//delete用対応。
	}

	// アップデートの場合、既存データと比較して同一なら保存を中止
	if ($w_type === 'update') {
			// 既存データが正しく設定されているか確認
			if (!isset($old_result) || empty($old_result)) {
				return '既存データが存在しません';
			}

			// 既存データの形式を判定し、配列へ変換
			if (is_object($old_result)) {
				$old_result = get_object_vars($old_result); // stdClass を連想配列に変換
			}

			// 双方フィルタリング。いらない配列削除。2025-04-06
			$filtered_existing_data = array_diff_key($old_result, array_flip($exclude_columns));
			$filtered_new_data      = array_diff_key($data, array_flip($exclude_columns));

			// 差分チェック：異なる項目があるか
			$difference = array_udiff_assoc($filtered_new_data, $filtered_existing_data, function($a, $b) {
				return ($a == $b) ? 0 : 1; // 型の違いを無視して比較
			});

			if (empty($difference)) {
				return '既存のデータと同じため、保存を中止しました';
			}

			/*
			// 既存データの形式を判定
			if (is_object($old_result)) {
					// オブジェクト形式の場合は配列に変換して処理
					$filtered_existing_data = array_diff_key(get_object_vars($old_result), array_flip($exclude_columns));
			} elseif (is_array($old_result)) {
					// 配列形式の場合はそのまま処理
					$filtered_existing_data = array_diff_key($old_result, array_flip($exclude_columns));
			} else {
					// 想定外の形式の場合はエラー
					return '既存データの形式が不正です';
			}

			// 新しいデータから除外カラムを削除して比較
			$filtered_new_data = array_diff_key($data, array_flip($exclude_columns));

			// 同一かどうか確認
			if ($filtered_existing_data == $filtered_new_data) {
					return '既存のデータと同じため、保存を中止しました';
			}
					*/

			/*
			echo 'O：';
			var_dump($filtered_existing_data);
			echo '<hr>';
			echo 'N：';
			var_dump($filtered_new_data);
			echo '<hr>';
			*/

	}

	$result = false; // 初期値を設定

	$data['text'] = Time::format() . substr(ucfirst($w_type), 0, 1);
	$data['time'] = time();

	//echo '+';


	// INSERT処理
	if ($w_type === 'insert') {
			$result = $wpdb->insert(
					$table_name,
					$data, // 挿入するデータ
					array_fill(0, count($data), '%s') // データ型
			);
	}
	// UPDATE処理
	elseif ($w_type === 'update')
	{
		//echo '<hr>';
		//var_dump($data) ;
		//echo '<hr>';

			$result = $wpdb->update(
					$table_name,
					$data, // 更新するデータ
					$where, // WHERE条件
					$format, // データ型
					$where_format // WHERE条件の型
			);
	}
	// DELETE処理
	elseif ($w_type === 'delete') {
			$result = $wpdb->delete(
			$table_name,
			$where, // WHERE条件
			$where_format // WHERE条件の型
			);
	} else {
			return '無効な書き込みタイプです';
	}

	// 処理結果の確認
	if ($result === false) {
		echo "SQL失敗4：Table=". $table_name.'：'. $wpdb->last_error;
		echo ':'.$w_type;
		echo '<br>';
		//echo ':'.get_the_title($id);
		'<br>';
		return '処理に失敗しました';
	} elseif ($result === 0) {
		//echo '対象データが見つかりませんでした';
		return '対象データが見つかりませんでした';
	}
	return '処理に成功しました';
}

