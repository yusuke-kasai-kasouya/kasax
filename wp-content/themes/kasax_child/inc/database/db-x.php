<?php

use Kx\Utils\Time;
use Kx\Core\SystemConfig as Su;
use Kx\Core\DynamicRegistry as Dy;



/**
 * データベース0
 *
 *
 *
 *
 *
 */
class kxdb0 {

	public $kxdb0S1;
	public $result;
	public $json;
	public $output;
	public $table_name= 'wp_kx_0';


    /**
	 * Undocumented function
	 *
	 * @param [type] $args
	 * @param [type] $type
	 * @return void
	 */
	public function kxdb0_Main( $args , $type ){

		$this->kxdb0S1 = $args;
		$post_id = $args['id']??null;

        if( ($type == 'id' || $type == 'Select_ID' || $type === 'feed_dy') && $post_id )
        {
            // 1. まずDyキャッシュを確認
            $cached = Dy::get_content_cache($post_id, 'db_kx0');

            if ($cached !== null) {
							if( $type === 'feed_dy' )
							{
								return;
							}
                $this->output = $cached;
                $this->result = $cached;
            } else {
                // 2. キャッシュがない場合はDB読み込み
                // ※既存の kxdb0_ID() メソッドが行っていた「データ取得」の役割をここで代替
                $this->output = kx_db_Read(
                    $this->table_name,
                    ['id' => $post_id],
                    '*', null, null, 'AND', true
                );

                // 3. 取得結果をDyにキャッシュ保存
                if ($this->output) {
                    Dy::set_content_cache($post_id, 'db_kx0', $this->output);
                    $this->result = $this->output;

                    //$cached = Dy::get_content_cache($post_id, 'db_kx0');
                    //var_dump($cached);
                }
            }

            if ($type == 'id') {
                // キャッシュから読んだかDBから読んだかに関わらず、
                // 現在のポストに関連する他テーブルとの同期(統合更新)を走らせる
                $this->kxdb0_ID();
                kx_tougou_update($post_id);

            }
            return; // 処理完了
        }


		if( $type == 'id')
		{
			//$this->kxdb0_ID();
			//var_dump($this->result);
			//kx_tougou_update($this->kxdb0S1['id']);
		}
		elseif( $type == 'Select_ID')
		{
			/*
			$this->output =  kx_db_Read(
				$this->table_name,
				['id' => $this->kxdb0S1[ 'id' ] ],
				'*',
				null,
				null,
				'AND',
				true
			) ;
			 */
		}
		elseif( $type == 'Select_title')
		{
			$this->output =  kx_db_Read(
				$this->table_name,
				['title' => $this->kxdb0S1[ 'title' ] ],
				'*',
				null,
				null,
				'AND',
				true
			) ;
		}
		elseif( $type == 'header_bar')
		{
			$this->kxdb0_upper_title();
			$this->output = !empty($this->result[0]) ? $this->result[0] : null;
		}
		elseif( $type == 'clear')
		{
			$this->kxdb0_SELECT('id');

			if( !empty( $this->result[0] ) )
			{
				$this->kxdb0_SELECT('id');
				$args_check = !empty($this->result[0])
					? [
						'json'  => $this->result[0]->json,
						'title' => $this->result[0]->title,
					]
					: [];

				$this->kxdb0_json('clear');
				$this->kxdb0_Write('update',$this->kxdb0S1[ 'id' ],$this->json, $args_check);
			}

		}
		elseif( $type == 'raretu_read')
		{
			//echo $this->kxdb0S1[ 'id' ];
			//読み込みのみ。2025-04-02
			$this->kxdb0_SELECT('id');


			$_json = $this->kxdb0_json('raretu_read');

			$this->output['ids']     = $_json['ids'];
			$this->output['reload']  = $_json['reload'];
			$this->output['time'] = $this->result[0]->time;



			if( !empty( $this->kxdb0S1['characters'] ) )
			{
				$this->kxdb0_raretu_characters();
			}
			elseif( !empty( $this->kxdb0S1['Chara_Base_W'] ) )
			{
				$this->kxdb0_raretu_Chara_Base_W();
			}

			if( !empty($this->output['ids']) )
			{
				foreach( $this->output['ids'] as $_key => $_id )
				{
					if(
						get_post_status( $_id ) != 'publish' ||
						get_post_type( $_id )   != 'post'
					)
					{
						unset($this->output['ids'][$_key]  );
					}
				}
			}
			//print_r($this->output);
		}
		elseif(	$type == 'raretu_add')
		{
			$this->kxdb0_SELECT('id');
			if( !empty( $this->result[0] ) && get_post_type( $this->kxdb0S1[ 'id' ] ) == 'post')
			{
				$args_check=[
					'json'  => $this->result[0]->json,
					'title' => $this->result[0]->title,
				];
				$this->kxdb0_json('raretu_add');
				$this->kxdb0_Write('update',$this->kxdb0S1[ 'id' ],$this->json, $args_check);
			}
			//echo $this->kxdb0S1[ 'type' ];
			//echo '+'.get_the_title().'<br>';
		}
		elseif( $type == 'kx_temporary')
		{
			$this->kxdb0_SELECT('kx_temporary');
			$this->output = $this->result;
		}
		elseif( $type == 'delete' && !empty( $this->kxdb0S1[ 'id' ] ) )
		{
			$this->kxdb0_Write('delete',$this->kxdb0S1[ 'id' ],$this->json, [] );
		}
		elseif( $type == 'Maintenance')
		{
			//メンテナンス。
			$this->kxdb0_SELECT('full');
			$this->kxdb0_Maintenance();

			//echo '++';
			//echo count( $this->result );
			//echo '++<br>';
		}
	}


	/**
	 * 読み込み
	 *
	 * @return void
	 */
	public function kxdb0_SELECT( $s_type ){

		global $wpdb;
		if( $s_type == 'full')
		{
			$sql = "SELECT * FROM wp_kx_0";
			$this->result = $wpdb->get_results($sql, ARRAY_A); // 結果を連想配列で取得

		}
		elseif( $s_type == 'title')
		{
			$this->result = $wpdb->get_results(
				$wpdb->prepare(
						"SELECT *
						FROM wp_kx_0
						WHERE title = %s",
						$this->kxdb0S1['title']
				)
			);

		}
		elseif(  $s_type == 'id')
		{
			$this->result = $wpdb->get_results(
				$wpdb->prepare(
						"SELECT *
						FROM wp_kx_0
						WHERE id = %d",
						$this->kxdb0S1['id']
				)
			);

		}
		elseif( $s_type == 'kx_temporary' )
		{
			//AI最適化、未処理。2025-04-04
			$this->result = $wpdb->get_results( $wpdb->prepare(
				"SELECT *
					FROM wp_kx_0
					WHERE ".$this->kxdb0S1[ 'columu' ]." LIKE '".$this->kxdb0S1[ 'db_like' ]."'
					"
			) );
			//print_r($this->result);
		}

	}



	/**
	 * 上位ポスト検索。
	 *
	 * @return void
	 */
	public function kxdb0_upper_title(){

		$_title = get_the_title( $this->kxdb0S1[ 'id' ] );

		if( !preg_match('/≫/' , $_title ))
		{
			return;
		}

		$this->kxdb0S1['title'] = preg_replace('/≫'.end(explode('≫',$_title) ).'$/','',$_title );

		$this->kxdb0_SELECT('title');


	}


	/**
	 * id指定。
	 *
	 * @return void
	 */
	public function kxdb0_ID(){

		$this->kxdb0_SELECT('id');

		if( empty( $this->result[0] ) )
		{
			$w_type = 'insert';
			$args_check=[
				'json'  => '',
				'title' => '',
			];
		}
		else
		{
			if(
				$this->result[0]->title != get_the_title( $this->kxdb0S1[ 'id' ] )||
				!empty( $this->kxdb0S1[ 'raretu_time' ] )
				)
			{
				$this->kxdb0_SELECT('id');
				$w_type = 'update';
			}
			$args_check=[
				'json'  => $this->result[0]->json,
				'title' => $this->result[0]->title,
			];
		}

		$this->kxdb0_json('raretu_read');

		if(	!empty( $w_type )	&&
			get_post_type( $this->kxdb0S1[ 'id' ] ) == 'post' &&
			get_post_status( $this->kxdb0S1[ 'id' ] ) == 'publish'
		)
		{
			$this->kxdb0_Write( $w_type ,$this->kxdb0S1[ 'id' ],$this->json, $args_check);
		}
		if( !empty($this->kxdb0S1['no_update']))
		{
			unset($this->kxdb0S1['no_update']);
		}



		//*****************上位追記*別構成*****************
		unset( $this->result , $this->json);

		//上位の$this->resultの呼び出し。2025-04-02
		$this->kxdb0_upper_title();

		if( !empty( $this->result[0]))
		{
			$args_check=[
				'json'  => $this->result[0]->json,
				'title' => $this->result[0]->title,
			];
			$this->kxdb0S1[ 'down_id' ] = $this->kxdb0S1[ 'id' ];
			$this->kxdb0S1[ 'id' ] = $this->result[0]->id;

			if(	get_post_type( $this->kxdb0S1[ 'id' ] ) == 'post'
			)
			{
				$this->kxdb0_json('opne_contet_upper');

				$this->kxdb0_Write('update',$this->kxdb0S1[ 'id' ],$this->json, $args_check);
				if( !empty($this->kxdb0S1['no_update']))
				{
					unset($this->kxdb0S1['no_update']);
				}
			}
		}
	}



	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function kxdb0_json( $j_type ){

		if( !empty( $this->result[0]->json ) )
		{
			//json文字列を配列化。
			$_json_array = kx_json_decode( $this->result[0]->json );
		}
		else
		{
			$_json_array = [];
		}
		/*
		echo get_the_title( $this->kxdb0S1[ 'id' ]);
		echo '<br>+';
		var_dump($_json_array[ 'raretu_id' ]);
		echo '<br>+';

		echo '<hr>+';
		*/



		if( $j_type == 'opne_contet_upper')
		{
			//上位追加：raretu_upper_id
			$_json_array[ 'raretu_id' ][] = $this->kxdb0S1[ 'down_id' ];
			$_json_array[ 'raretu_id' ] = array_unique( $_json_array[ 'raretu_id' ]);
		}
		elseif( $j_type == 'clear')
		{
			unset($_json_array[ 'raretu_id' ]);
		}
		elseif(	$j_type == 'raretu_read' )
		{
			if (!empty( $_json_array[ 'raretu_id' ] ) )
			{
				$_reload = null;
				foreach( $_json_array[ 'raretu_id' ] as $key => $_id)
				{
					if(
						empty( $this->kxdb0S1[ 'tougou_sort' ] )
						&& !preg_match('/'.get_the_title( $this->kxdb0S1[ 'id' ]).'/',get_the_title($_id) ))
					{
						//echo get_the_title($_id);
						//echo '<br>+';
						unset( $_json_array[ 'raretu_id' ][$key]);
						$_reload = 1;
					}

				}
				unset( $key,$_id);
				sort($_json_array[ 'raretu_id' ]);

				return [
				'ids'    =>$_json_array[ 'raretu_id' ],
				'reload' => $_reload,
				] ;
			}
			else
			{
				return [
				'ids'    => null,
				'reload' => null,
				] ;
			}

		}
		elseif( $j_type == 'raretu_add')
		{
			$_json_array[ 'raretu_id' ] = $this->kxdb0S1[ 'ids' ];
		}



		if( !empty( $_json_array[ 'raretu_id' ] ))
		{
			foreach( $_json_array[ 'raretu_id' ] as $key => $_id):

				//echo get_the_title($_id);
				//echo '+<hr>';
				if( empty(get_the_title($_id) )	)
				{
					unset( $_json_array[ 'raretu_id' ][$key]);
				}
				elseif( preg_match( '/'.get_the_title( $this->kxdb0S1[ 'id' ] ).'/' ,get_the_title($_id ) ))
				{
					/*
					echo get_the_title( $this->kxdb0S1[ 'id' ] );
					echo '<br>';
					echo get_the_title($_id ) ;
					echo '<hr>';
					*/
				}


				if( !preg_match('/≫/' ,get_the_title($_id) ))
				{
					unset( $_json_array[ 'raretu_id' ][$key]);
				}

				if(
					get_post_status( $_id ) != 'publish' ||
					get_post_type( $_id )   != 'post'
				)
				{
					unset( $_json_array[ 'raretu_id' ][$key]);
				}

			endforeach;
		}

		if (
			isset($_json_array['raretu_id']) &&
			 is_array($_json_array['raretu_id'])
		)
		{
			sort($_json_array[ 'raretu_id' ]);
		}


		$this->json = $_json_array;
	}




	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function kxdb0_raretu_characters(){
		//$_title = preg_replace( '/≫共通w/','', get_the_title( $this->kxdb0S1['id'] ) );
		//$_titles[] =  $_title.'≫来歴';


		preg_match( '/(∬\d{1,}≫c)(\d\w{1,}\d)≫.*/' , get_the_title( $this->kxdb0S1['id'] ) ,$matches );

		$_titles[] = $matches[1].$matches[2].'≫来歴';

		foreach(explode( ',' , $this->kxdb0S1['characters'] ) as $_c_num )
		{

			$_titles[] =  $matches[1].$_c_num.'≫＼c'.$matches[2].'≫来歴';
		}

		//var_dump($_titles);

		unset( $this->kxdb0S1 , $this->result );

		$_mergedArray = [];
		foreach( $_titles as $value )
		{
			$value =  preg_replace( '/来歴≫来歴/', '来歴' , $value);
			//echo $value;
			//echo '<br>';
			$this->kxdb0S1['title'] = $value;
			$this->kxdb0_SELECT('title');

			//print_r($this->result[0]->json);
			//echo '<br>';

			if( !empty($this->result[0]->json) && !empty( $_mergedArray ) )
			{
				$_json = kx_json_decode( $this->result[0]->json );
				if( !empty ($_json['raretu_id'] ) )
				{
					$_mergedArray = array_unique(array_merge( $_mergedArray, kx_json_decode( $this->result[0]->json )['raretu_id'] ) );
				}

				unset( $_json);
			}
			elseif( !empty( $_mergedArray ) )
			{
				echo 'ERROR_来歴ポストが無い'.$value;
				echo '<hr>';

			}
			else
			{
				//echo '<hr>+';
				//var_dump($this->result[0]);
				//print_r($this->result[0]);
				//$_array = kx_json_decode( $this->result[0]->json );
				//var_dump($_array['raretu_id']);
				//$_mergedArray = $_array['raretu_id'];
				$_mergedArray = kx_json_decode( $this->result[0]->json )['raretu_id'];
			}

		}

		if( !empty( $this->output['ids'] ))
		{
			$this->output['ids'] = array_unique(array_merge( $_mergedArray, $this->output['ids'] ));
		}
		else
		{
			$this->output['ids'] = $_mergedArray;
		}
		//print_r($this->output['ids']);
		//$this->kxdb0_SELECT('title');
		//print_r($_array);
		//echo '+';
		//preg_match( '/∬\d{1,}≫c(\d\w{1,}\d)≫.*/' , $_title ,$matches );
		//echo $matches[1];
		//var_dump($this->output);
	}


	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function kxdb0_raretu_Chara_Base_W(){

		foreach($this->kxdb0S1['Chara_Base_W'] as $_title)
		{
			$this->kxdb0S1['title'] = $_title;
			$this->kxdb0_SELECT('title');


			if( !empty($this->result[0]->json) && !empty( $_mergedArray ) )
			{
				$_json = kx_json_decode( $this->result[0]->json );
				if( !empty ($_json['raretu_id'] ) )
				{
					$_mergedArray = array_unique(array_merge( $_mergedArray, kx_json_decode( $this->result[0]->json )['raretu_id'] ) );
				}

				unset( $_json);
			}
			elseif( !empty( $_mergedArray ) )
			{
				echo 'NoPost';
				echo '<hr>';
				var_dump($this->kxdb0S1);
			}
			else
			{
				$_mergedArray = kx_json_decode( $this->result[0]->json )['raretu_id'];
			}
		}

		if( !empty( $this->output['ids'] ))
		{
			$this->output['ids'] = array_unique(array_merge( $_mergedArray, $this->output['ids'] ));
		}
		else
		{
			$this->output['ids'] = $_mergedArray;
		}

		//var_dump($this->output);

	}


	/**
	 * メンテ用。
	 *
	 * @return void
	 */
	public function kxdb0_Maintenance(){

		// タイトルごとの件数を集計
		foreach ($this->result as $value)
		{
			$title = $value['title'];
			if (!isset($title_counts[$title]))
			{
					$title_counts[$title] = [];
			}
			$title_counts[$title][] = $value['id']; // IDを保存
		}

		// 重複しているタイトルを取得
		$duplicates = array_filter($title_counts, function($ids){
			return count($ids) > 1; // IDが複数ある場合に抽出
		});


		// 重複タイトルを出力
		$str1 = '';
		if (!empty($duplicates))
		{
			wp_enqueue_script(
				'javascript',
				get_stylesheet_directory_uri().'/../kasax_child/js/javascript.js',
				array( 'jquery' ),
				'1.0',
				true
			);

			$str1 .= '<div class="question" style="color:red;">重複しているタイトル:'. count($duplicates) . '件</div>';
			$str1 .= '<div class="answer" style=" background-color: black;z-inde:4;">';

			foreach ($duplicates as $title => $ids)
			{
					$str1 .= 'タイトル:<span style="color:red;"> ' . $title . '</span> | 件数: ' . count($ids) . '<br>';
					$str1 .= '投稿リンク:<br>';
					foreach ($ids as $id)
					{
							$link = get_permalink($id); // WordPressの投稿リンク取得
							$str1 .= '<a href="' . $link . '" target="_blank">' . $link . '</a><br>';
					}
					$str1 .= '<br>';
			}
			$str1 .= '</div><hr>';
		}
		else
		{
			$str1 .= '<div>★DB kx_0 重複しているタイトルはありません。</div>';
		}



		$str2 = '';
		foreach( $this->result as $value ):

			$_post_type = get_post_type( $value['id'] ); // 投稿タイプを取得

			if(
				empty( get_the_title( $value['id'] ) ) ||
				get_post_status($value['id']) != 'publish' ||
				$_post_type == 'page' // 固定ページの場合も削除
			){
				$this->kxdb0S1['id'] = $value['id'];
				$args_check=[
					'json'  => $value['json'],
					'title' => $value['title'],
				];
				$this->kxdb0_Write('delete',$this->kxdb0S1[ 'id' ],$this->json,$args_check);

				unset( $this->kxdb0S1[ 'id' ] );

				$str2 .= '<br>';
				$str2 .= '削除-kx_0:';
				$str2 .= $value['title'];
			}

		endforeach;

		$this->output[ 'string' ]  = '★DB kx_0 Maintenance★COUNT0：' . count( $this->result ).$str2.$str1 ;
	}



	/**
	 * 書き込み
	 *
	 * @param [type] $args
	 * @param [type] $type
	 * @return void
	 */
	public function kxdb0_Write( $w_type ,$id ,$json ,$check_args ){

		if( !empty( $this->result[0]->json ) )
		{
			if( $this->result[0]->json == $this->json )
			{
				return;
			}
		}


		//***不要キーの削除の処理***
		$_check = ['raretu_id'];

		if (!empty($json) && (is_array($json) || is_object($json)))
		{
			foreach ($json as $key => $value)
			{
					if (!in_array($key, $_check))
					{
							unset($json[$key]);
					}

					if (empty($json[$key]))
					{
							unset($json[$key]);
					}
			}
		}//***不要キーの削除の処理***


		$_json = kx_json_encode( $json );

		//echo $_json;
		//echo '<br>';

		if(
			$check_args['json'] == $_json &&
			$check_args['title'] == get_the_title($id) &&
			$w_type != 'delete'
			)
		{
			return;
		}
		else
		{
			/*
			echo $check_args['json'] .'→'. $_json ;
			echo '<br>';
			echo $check_args['title'] ;//.'+++'. get_the_title($id) ;
			echo '<br>';
			echo $w_type;
			echo '<hr>';
			*/
		}

		$_title = get_the_title( $id );


		global $wpdb;

		if( $w_type == 'insert')
		{
			$sql_rsl = $wpdb->query(
				$wpdb->prepare(
						"INSERT INTO wp_kx_0 (id, title, json, text, time)
						VALUES (%d, %s, %s, %s, %d)",
						$id,
						$_title,
						$_json,
						Time::format() . 'i0',
						time()
				)
			);

		}
		elseif( $w_type == 'update')
		{
			$sql_rsl = $wpdb->query(
				$wpdb->prepare(
						"UPDATE wp_kx_0
						SET
								id = %d,
								title = %s,
								json = %s,
								text = %s,
								time = %d
						WHERE id = %d",
						$id, // id
						$_title,              // title
						$_json, // json
						Time::format() . 'u0',      // text
						time(),               // time
						$id  // WHERE id
				)
			);
		}
		elseif( $w_type == 'delete')
		{
			$sql_rsl = $wpdb->query(
				$wpdb->prepare(
						"DELETE FROM wp_kx_0 WHERE id = %d",
						$id
				)
			);
		}

		if ($sql_rsl === false) {
			echo "SQLクエリに失敗しましたkx0: " . $wpdb->last_error;
			echo '<br>';
		}
        else{
            //キャッシュ更新。2025-12-31
            $updated_data = (object)[
                'id'    => $id,
                'title' => $_title,
                'json'  => $_json,
                'text'  => Time::format() . ($w_type == 'insert' ? 'i0' : 'u0'),
                'time'  => time()
            ];
            Dy::set_content_cache($id, 'db_kx0', [$updated_data]);
        }
	}


} //end kxdb0 wp_kx_0




/**
 * データベース class
 * kx_1
 */
class kxdb1 {

	//初期代入要素。2023-03-02
	public $kxdb1S1;
	public $result;
	public $json;
	public $write;
	public $output;

	public $table_name = 'wp_kx_1';

	/**
	 * kx_1系のメインプログラム。
	 * 2023-06-24
	 *
	 * @param [type] $args
	 * @param [type] $type
	 * @return void
	 */
	public function kxdb1_Main( $args , $type){

		$this->kxdb1S1 = $args; //基本設定。2023-03-02

		$post_id = $args['id'] ?? null;

		if(($type === 'id' || $type === 'feed_dy') && $post_id)
		{
			// 1. まずDyキャッシュを確認
            $cached = Dy::get_content_cache($post_id, 'db_kx1');
            if ($cached !== null && $type === 'feed_dy')
            {
                return; // 既にロード済みなら終了
            }

			// 2. キャッシュがない、または 'id' 指定ならDBから取得
            $data = kx_db_Read($this->table_name, ['id' => $post_id]);
            $this->result = $data;

            if ($data)
            {
                // DBから読んだ結果をDyにセット
                Dy::set_content_cache($post_id, 'db_kx1', $data);
            }

			if ($type === 'id') {
                $this->kxdb1_ID();
            }
		}
		elseif( $type == 'SelectID' )
		{
			$this->kxdb1_SELECT( ['id' => $this->kxdb1S1[ 'id' ] ] );
			if( !empty( $this->result[0]->json ) )
			{
				$this->output = kx_json_decode( $this->result[0]->json);
			}
		}
		elseif( $type == 'consolidated_to' )
		{
			$this->consolidated_to();
		}
		elseif( $type == 'Maintenance' )
		{

			//メンテナンス用
			$this->kxdb1_SELECT( ['full' => 1 ] );

			if( !empty( $this->result ) )
			{
				$this->kxdb1_Maintenance( ['full' => 1 ] );
			}

			$this->output['string']  = '★DB kx_1 Maintenance' ;
			$this->output['string'] .= '★COUNT1：';
			$this->output['string'] .= count( $this->result );
		}
		else
		{
			echo '★kxdb1_type_ERROR★';

		}

		return;
	}






	/**
	 * DBからの呼び出し。
	 *
	 * @param string $input_type
	 * @return $this->result
	 */
	public function kxdb1_SELECT( $args ){

		global $wpdb;

		if( !empty( $args['id'] ) )
		{		//idによる呼び出し。

			$this->result = $wpdb->get_results(
				$wpdb->prepare(
						"SELECT *
						FROM wp_kx_1
						WHERE id = %d",
						$args['id']
				)
			);

		}
		elseif( !empty($args['full'])  )
		{
			//全部呼び出し

			$this->result = $wpdb->get_results(
				"SELECT * FROM wp_kx_1"
			);

		}
		elseif( !empty( $args['title'] )  )
		{
			//タイトル検索呼び出し。

			if( preg_match( '/%/' , $args['title'] ) )
			{
				$Equal = 'like';
			}
			else
			{
				$Equal = '=';
			}

			if(
				empty( $this->result )
				||(
					!empty( $this->result[0] )
					&& get_the_title( $this->result[0]->id ) == $args['title']
				)
			){
				//AI最適化未処理。2025-04-04
				$this->result = $wpdb->get_results( $wpdb->prepare(
					"SELECT *
					FROM wp_kx_1
					WHERE
					title ". $Equal ." '". $args['title'] . "'
					"
				) );

				if( $Equal == '=' ){

					//$this->kx1_set = 'input';
				}
			}
		}

	}







	/**
	 * dbのcontent指定処理。2023-03-02
	 *
	 * @return void
	 */
	public function kxdb1_ID(){

		//idを使いdbから呼び出し。

		if( !empty( $this->result[0] ))
		{
			//$_check_args['json'] = $this->result[0]->json;
			//$_check_args['title'] = $this->result[0]->title;

			$this->json = kx_json_decode( $this->result[0]->json );
			$_w_type = 'update';
			$old_result = $this->result[0];
		}
		else
		{
			//echo $this->kxdb1S1[ 'id' ];
			//var_dump($this->result);
			//$_check_args['json']  = '';
			//$_check_args['title'] = '';

			$this->json = [];
			$_w_type = 'insert';
			$old_result = NULL;
		}

		//content呼び出し。2025-04-20
		$_content	 = get_post( $this->kxdb1S1[ 'id' ] )->post_content;


		//***[kx_format id=]の処理***
		if( preg_match('/\[kx_format.*id=(\d{1,}).*\]/',$_content,$matches )) //formatSCがある。
		{
			unset( $this->json);
			$this->json['GhostON'] =  $matches[1] ;

			if(
				!empty( get_the_title($matches[1]) ) &&
				get_post_status( $matches[1] ) == 'publish' &&
				get_post_type( $matches[1] )   == 'post'
			){
				$this->kxdb1_kx_format( $matches[1] , $this->kxdb1S1[ 'id' ] );
			}
			$_unset_on = 1;
		}
		else
		{
			//echo $this->kxdb1S1[ 'id' ].'+<br>';
			if( !empty( $this->json['GhostON'] ))
			{
				unset( $this->json['GhostON'] );
				$_unset_on = 1;
			}
		}	//***[kx_format id=]の処理***


		//********* ShortCODE *********
		if( preg_match('/\[raretu.*\]/',$_content)) //formatSCがある。
		{
			$this->json['ShortCODE'] = 'raretu';
			if( preg_match('/\[raretu.*tougou=(\d{1,}).*\]/',$_content,$matches )) //formatSCがある。
			{
				$this->json['consolidated_to'] = $matches[1];
				kx_db1(['id' => $matches[1] , 'consolidated_from' => $this->kxdb1S1[ 'id' ] ], 'id');
			}
			else
			{
				unset($this->json['consolidated_to']);
			}
		}
		elseif( preg_match('/\[kx_tp.*\]/',$_content)) //formatSCがある。
		{
			$this->json['ShortCODE'] = 'kx_tp';
		}
		elseif( preg_match('/\[kx_format.*\]/',$_content)) //formatSCがある。
		{
			$this->json['ShortCODE'] = 'kx_format';
		}
		else
		{
			if( !empty( $this->json['consolidated_to'] ))
			{
				unset( $this->json['consolidated_to'] );
				$_unset_on = 1;
			}

			if( !empty( $this->json['ShortCODE'] ))
			{
				unset( $this->json['ShortCODE'] );
				$_unset_on = 1;
			}
		}	//********* ShortCODE *********


		//統合ID追加
		if( !empty( $this->kxdb1S1[ 'consolidated_from' ]))
		{
			$_result = kx_db1(['id' => $this->kxdb1S1[ 'consolidated_from' ]] , 'SelectID');

			if (!empty($_result) && !empty($_result['consolidated_to']))
			{
				$this->json['consolidated_from'] = $this->kxdb1S1[ 'consolidated_from' ];
			}
			else
			{
				unset($this->json['consolidated_from']);
			}
		}

		//***consolidated_fromの処理***
		if (!empty($this->json['consolidated_from']) )
		{
			if( $this->kxdb1S1[ 'id' ] != kx_db1(['id' => $this->json['consolidated_from'] ], 'SelectID')['consolidated_to'])
			{
				unset($this->json['consolidated_from']);
			}
		}



		//***BaseIDの処理***
		if (!empty($this->json['BaseID']) && is_array($this->json['BaseID']) )
		{

			foreach ($this->json['BaseID'] as $key => $value )
			{
				$this->kxdb1_SELECT( ['id' => $value ] );

				if (empty($this->result) || empty($this->result[0]->json))
				{
					unset( $this->json['BaseID'][$key] );
					$_unset_on = 1;
				}
				else
				{
					$_arrayIDs = kx_json_decode( $this->result[0]->json );
					if (
						isset($_arrayIDs['GhostON']) &&
						//is_array($_arrayIDs['GhostON']) &&
						$_arrayIDs['GhostON'] != $this->kxdb1S1['id']
					)
					{
						unset( $this->json['BaseID'][$key] );
						$_unset_on = 1;
					}
					elseif (!isset($_arrayIDs['GhostON']) 	)
					{
						unset($this->json['BaseID'][$key]);
						$_unset_on = 1;
						//echo $key;
						//echo '++';
					}

				}

				if( empty($this->json['BaseID']) )
				{
					unset( $this->json['BaseID'] );
					$_unset_on = 1;
				}
			}
		}
		elseif( empty($this->json['BaseID'])  )
		{
			unset( $this->json['BaseID'] );
			$_unset_on = 1;
		}

		//***BaseIDの処理***
		unset( $key , $value );


		//***タグの処理***
		$this->kxdb1_TAG( $_content);
		//var_dump($this->json);
		//echo '+';

		if(	!empty( $this->json['概要'] )	)
		{
			//echo get_the_title( $this->kxdb1S1[ 'id']);
			//echo get_the_title( $this->json['概要']);
			//echo '<hr>';
			//echo $this->kxdb1S1[ 'id'] .'<br>'. $this->json['概要'];
			//echo '<hr>';
			if(!preg_match( '/'.get_the_title( $this->kxdb1S1[ 'id'] ) .'/', get_the_title( $this->json['概要']) ))
			{
				unset($this->json['概要']);
			}
			elseif( $this->kxdb1S1[ 'id'] == $this->json['概要'] )
			{
				unset($this->json['概要']);
			}
		}


		kx_array_sort_filtered($this->json , KxSu::get('DBjson_pickup')['kx_1'],'unsetON');
		//var_dump($this->json);
		//echo '<br>';
		if(
			(isset($this->json) && is_array($this->json) && !empty($this->json) )||
			(!empty($_unset_on) && $_w_type == 'update')
		) {

            $write_data = [
                'id'    => $this->kxdb1S1[ 'id' ],
                'title' => get_the_title($this->kxdb1S1[ 'id' ]),
                'json'  => kx_json_encode($this->json)
            ];

            // Dyキャッシュを最新化
            Dy::set_content_cache($this->kxdb1S1['id'], 'db_kx1', $write_data);


			kx_db_Write(
				$_w_type,
				$old_result ,
				$this->table_name,
				$write_data ,
				['id' =>$this->kxdb1S1[ 'id' ] ]
			);
		}


	}



	/**
	 * ベース側の処理。2025-04-04
	 *
	 * @param [type] $id
	 * @return void
	 */
	public function kxdb1_kx_format( $id , $ghostID  ){

		$this->kxdb1_SELECT( ['id' => $id ] );

		if( !empty( $this->result[0] ))
		{
			//$_check_args['json'] = $this->result[0]->json;
			//$_check_args['title'] = $this->result[0]->title;
			$_array = kx_json_decode( $this->result[0]->json );
			$_w_type = 'update';
			$old_result = $this->result[0];
		}
		else
		{

			$_check_args['json'] = '';
			$_check_args['title'] = '';
			$_array = [];
			$_w_type = 'insert';
			$old_result = NULL;
		}


		if( !empty( $_array['BaseID'] ))
		{
			if (!in_array( $ghostID, $_array['BaseID'] ) )
			{
				$_array['BaseID'][] = $ghostID;
			}
		}
		else
		{
			$_array['BaseID'] = [$ghostID];
		}


		//if( !empty( $_array))
		//{
		//	$this->kxdb1_Write( $_w_type , $id  , $_array ,$_check_args);
		//}

		if(
			(isset($_array) && is_array($_array) && !empty($_array) )
		) {
			kx_db_Write(
				$_w_type,
				$old_result ,
				$this->table_name,
				[
					'id'    => $id,
					'title' => get_the_title($id),
					'json'  => kx_json_encode($_array)
				] ,
				['id' => $id]
			);
		}


	}



	/**
	 * コンテンツのタグ関連処理。
	 * 2023-03-07
	 *
	 * @return void
	 */
	public function kxdb1_TAG($_content){

		if ( preg_match( '/^(.*)≫.*＠概要$/' , get_the_title( $this->kxdb1S1[ 'id'] ) , $matches ) )
		{
			if ( !empty( $this->json['タグ'] ))//概要ページにタグは不要。
			{
				unset( $this->json['タグ'] );
				$_unset_on = 1;
			}

				//var_dump( $this->json);


			if ( !empty( $this->json['概要'] ))//概要ページにタグは不要。
			{
				unset( $this->json['概要'] );
				$_unset_on = 1;
			}

			//上位検索kx1
			//$this->kxdb1_SELECT( [ 'title'=> $matches[1] ] );
			$result  = kx_db_Read($this->table_name, [ 'title'=> $matches[1] ]);

			//echo $matches[1];
			//echo '<br>';
			//echo $this->result[0]->title;
			//echo '<br>';

			//var_dump($result);

			if ( empty( $result[0] ))
			{
				//kx0
				$result  = kx_db_Read('wp_kx_0', [ 'title'=> $matches[1] ]);

				$w_type = 'insert';
				$old_result = [];
				//$_check_args['json']  = '';
				//$_check_args['title'] = '';

			}
			else
			{
				$w_type = 'update';
				$old_result = $result[0];
				//$_check_args['json'] = $this->result[0]->json;
				//$_check_args['title'] = $this->result[0]->title;

			}

			//echo $this->result[0]->id;

			if ( empty( $result[0] ))
			{
				kx_CLASS_error( 'ERROR：概要の上位が無い'.get_the_title( $this->kxdb1S1[ 'id'] ) );
				return;
			}

			$_array = kx_json_decode( $result[0]->json );


			if (!is_array($_array))
			{
				$_array = [];
			}

			$_array = kx_db_json_TAG( $_content , $_array ,'gaiyou' );


			if(
				preg_match('/'.$result[0]->title .'/', get_the_title( $this->kxdb1S1[ 'id'] )) &&
				$result[0]->title != get_the_title( $this->kxdb1S1[ 'id'])
				)
			{
				$_array['概要'] = $this->kxdb1S1['id'];
			}
			else
			{
				unset($_array['概要']);
				$_unset_on = 1;
			}

			//var_dump($_array);

			/*
			echo $_array['概要'];
			echo '<br>';
			echo $this->kxdb1S1['id'];
			echo '<br>';
			echo $this->result[0]->id;
			echo '<hr>';
			*/


			//var_dump( $_array);


			//$this->kxdb1_Write( $_w_type , $this->result[0]->id , $_array ,$_check_args );
			if(
				(isset($_array) && is_array($_array) && !empty($_array) )||
				(!empty($_unset_on) && $w_type == 'update')
			) {
				kx_db_Write(
					$w_type,
					$old_result ,
					$this->table_name,
					[
						'id'    => $result[0]->id,
						'title' => get_the_title($result[0]->id),
						'json'  => kx_json_encode($_array)
					] ,
					['id' => $result[0]->id]
				);
			}

			unset( $this->result );

		}//概要
		else
		{
			$this->json = kx_db_json_TAG( $_content , $this->json );
			//var_dump($this->json);
			//echo '<hr>';
		}
	}




	/**
	 * Undocumented function
	 *
	 * @param [type] $j_type
	 * @return void
	 */
	public function kxdb1_json( $j_type, $json = null ){


		//配列をjson化
		if( !empty( $args[ 'json' ] ) )
		{
			$this->kxdb1S1[ 'json' ] = kx_json_encode( $args['json'] );
		}


		if( !empty( $json ) )
		{
			//json文字列をを配列化。
			$_json_array = kx_json_decode( $json );
		}
		else
		{
			$_json_array = [];
		}

		if( $j_type == 'Maintenance')
		{

			if( !empty( $_json_array['raretu_id'] ))
			{
				unset( $_json_array['raretu_id'] );
			}
		}

		if (empty( $_json_array ))
		{
			$json = NULL;
		}
		else
		{
			$json = kx_json_encode( $_json_array );
		}
		return $json;
	}



	/**
	 * base_idのidを配列化して出力。
	 *
	 * @return void
	 */
	public function kxdb1_GHOST_check(){

		$_arr = kx_json_decode( $this->result->json );

		if( !empty( $_arr[ 'base_id'] ) )
		{
			$this->output[ 'base_id'] = $_arr[ 'base_id'];
		}
	}



	//2026-01-03
	/**
   * 投稿の集約・統合メタデータをDBに記録する。
   * * [仕様]
   * - 統合先 (Target):
   * 'consolidated_ids' に全ての統合対象IDリストを保存。
   * 'consolidated_from' に統合元の代表ID (id_base) を保存。
   * - 統合元 (Source):
   * 'consolidated_to' に統合先のIDを保存。
   */
  public function consolidated_to(){
    // 引数の整理
    $src_id_base = $this->kxdb1S1['id'];              // 統合元の代表（id_base）
    $target_id   = $this->kxdb1S1['consolidated_to']; // 統合先ID
    $source_ids  = (array)$this->kxdb1S1['ids'];      // 統合対象の全リスト

    if ( empty($target_id) || empty($src_id_base) ) return;

    // --- A. 統合先 (Target) への書き込み ---
    $target_data = kx_db_Read($this->table_name, ['id' => $target_id]);
    $target_json_raw = !empty($target_data[0]->json) ? $target_data[0]->json : '{}';
    $target_json_arr = kx_json_decode($target_json_raw);

    // 1. 全ての統合元IDを配列にマージ
    $existing_ids = isset($target_json_arr['consolidated_ids']) ? (array)$target_json_arr['consolidated_ids'] : [];
    $target_json_arr['consolidated_ids'] = array_values(array_unique(array_merge($existing_ids, $source_ids)));

    // 2. 代表となる統合元IDを保存 (今回追加)
    $target_json_arr['consolidated_from'] = $src_id_base;

    // 比較用引数をセットして保存（Warning回避）
    $write_args_target = [
        'json'  => $target_json_raw,
        'title' => get_the_title($target_id)
    ];
    $this->kxdb1_Write('update', $target_id, $target_json_arr, $write_args_target);


    // --- B. 統合元 (Source) への書き込み ---
    $src_data = kx_db_Read($this->table_name, ['id' => $src_id_base]);
    $src_json_raw = !empty($src_data[0]->json) ? $src_data[0]->json : '{}';
    $src_json_arr = kx_json_decode($src_json_raw);

    // 統合先へのポインタをセット
    $src_json_arr['consolidated_to'] = $target_id;

    // 比較用引数をセットして保存（Warning回避）
    $write_args_src = [
        'json'  => $src_json_raw,
        'title' => get_the_title($src_id_base)
    ];
    $this->kxdb1_Write('update', $src_id_base, $src_json_arr, $write_args_src);
  }




	/**
	 * DBメンテンナンス用。
	 *
	 * @return void
	 */
	public function kxdb1_Maintenance(){

		foreach( $this->result as $value ):

			//$this->db_UP = $value;

			$this->kxdb1S1[ 'id' ] 	= $value->id;

			$_title = get_the_title( $value->id );

			$_json = $this->kxdb1_json( 'Maintenance',$value->json );

			$_args[	'json' ] = $value->json;
			$_args[	'title' ] = $value->title;

			if(
				empty( $_title )||
				get_post_status( $value->id ) != 'publish' ||
				get_post_type( $value->id )   != 'post' ||
				empty( $_json ) ||
				$value->id == 0
			){


				$this->kxdb1_Write( 'delete' ,$value->id ,$value->json , $_args );

				echo '削除-kx1:';
				echo $value->title;
				echo '<br>';
			}
			elseif(	$_title != $value->title	)
			{

				$this->kxdb1_Write( 'update' ,$value->id ,kx_json_decode($value->json)  , $_args );
			}

		endforeach;


	}





	/**
	 * データベース変更。書き込み。タイプ別。
	 *
	 * @return void
	 */
	public function kxdb1_Write( $w_type , $id , $json ,$args ){
		//echo $w_type.$id;
		//echo '<br>';

		//***不要キーの削除の処理***
		if( !empty($json) )
		{
			if (is_string($json)) {
        // JSON をデコードして配列に変換
        $json = kx_json_decode($json);
			}
			elseif (!is_array($json)) {
        return '<hr>ERROR_kxdb1_Write<hr>';
    	}

			//並び替えと削除。
			kx_array_sort_filtered($json , KxSu::get('DBjson_pickup')['kx_1'],'unsetON');

			//foreach( $json as $key => $value )
			//{
				/* 多分いらない。上記で役目を果たしてる。
				if(!in_array($key,KxSu::get('DBjson_pickup')['kx_1']) ) {
					unset($json[$key]);
				}
				*/
				/*
				if( empty($json[$key] ))
				{
					unset($json[$key] );
				}
					*/
			//}//***不要キーの削除の処理***
			//$json = array_replace(array_flip(KxSu::get('DBjson_pickup')['kx_1']), $json);
			//print_r($sortedItems);
			//並び替え。
			/*
			$sorted = [];
			foreach (KxSu::get('DBjson_pickup')['kx_1'] as $key) {
				if (array_key_exists($key, $json)) {
						$sorted[$key] = $json[$key];
				}
			}
			$json = $sorted;
			*/
		}


		//***タグがない場合の概要削除***
		if(	empty( $json['タグ'] ) &&	!empty( $json['概要'] )	)
		{
			unset( $json['概要'] );
		}

		if( empty( $json ) || empty(get_the_title( $id ) ) )
		{
			if( $w_type == 'insert' )
			{
				return;
			}
			$w_type = 'delete';
		}

		$_json = kx_json_encode( $json );

		if(
			$args['json'] == $_json &&//★
			$args['title'] == get_the_title($id) &&
			$w_type != 'delete')
		{
			return;
		}


		global $wpdb;

		if( $w_type == 'insert' )
		{
			$sql_rsl = $wpdb->query(
				$wpdb->prepare(
					"INSERT INTO wp_kx_1 (id, title, json, text, time)
					VALUES (%d, %s, %s, %s, %d)",
					$id,
					get_the_title($id),
					$_json,
					Time::format() . 'i1',
					time()
				)
			);
		}
		elseif( $w_type == 'update' ) //更新。2023-02-16
		{
			$sql_rsl = $wpdb->query(
				$wpdb->prepare(
						"UPDATE wp_kx_1
						SET
								title = %s,
								json = %s,
								text = %s,
								time = %d
						WHERE id = %d",
						get_the_title($id),
						$_json,
						Time::format() . 'u1',
						time(),
						$id
				)
		);
		}
		elseif( $w_type == 'delete' )
		{
			$sql_rsl = $wpdb->query(
				$wpdb->prepare(
						"DELETE FROM wp_kx_1 WHERE id = %d",
						$id
				)
		);
		}

		if ($sql_rsl === false) {//★
			echo "kxdb1_Write：SQLクエリに失敗しましたKx1: " . $wpdb->last_error;
			echo '<br>';
		}
	}

	} //kxdb1



/**
 * データベース class
 * kx_2
 */
class kxdb2 {

//初期代入要素。2023-03-02
public $kxdb2S1;
public $result;
public $json;
public $date;
public $write;
public $output;

/**
 * kx_2系のメインプログラム。
 * 2025-04-04
 *
 * @param [type] $args
 * @param [type] $type
 * @return void
 */
public function kxdb2_Main( $args , $type){

	$this->kxdb2S1 = $args; //基本設定。2025-04-04

	if( $type == 'id')
	{
		if( !empty($this->kxdb2_processTitle($this->kxdb2S1['id'])) )
		{
			$this->kxdb2_SELECT( ['id' => $this->kxdb2S1[ 'id' ] ] );
			$this->kxdb2_ID();
		}
	}
	elseif( $type == 'Maintenance' )
	{

		//メンテナンス用
		$this->kxdb2_SELECT( ['full' => 1 ] );

		if( !empty( $this->result ) )
		{
			$this->kxdb2_Maintenance( ['full' => 1 ] );
		}

		$this->output['string']  = '★DB kx_2 Maintenance' ;
		$this->output['string'] .= '★COUNT1：';
		$this->output['string'] .= count( $this->result );
	}
	elseif( $type == 'SelectID' )
	{



		//^(?:[^≫]+≫){2}[^≫]+$
		preg_match( '/'.(KxSu::get('titile_search')['kx_2']).'[^≫]+/' , get_the_title( $this->kxdb2S1['id'] ) , $matches );
		//echo $matches[0];


		//$_title = preg_replace( '/≫共通w/','', get_the_title( $this->kxdb2S1['id'] ) );

		$this->kxdb2_SELECT( ['title' => $matches[0] ] );

		if( !empty( $this->result[0]->json ) )
		{
			$this->output['json']  = kx_json_decode($this->result[0]->json);

		}

		if( !empty( $this->result[0]->date ) )
		{

			$this->output['date'] = kx_json_decode($this->result[0]->date);
		}

		if( !empty( $this->result[0]->title ) )
		{
			$this->output['title'] = $this->result[0]->title;
		}


	}
}


/**
 * タイトル選別
 *
 * @return void
 */
public function kxdb2_processTitle($id){


	$title = get_the_title($id);
	$search = KxSu::get('titile_search')['kx_2'];


	// 検索パターン
	$patterns =
	[
		'basic' => "/$search/i",
		'character' => "/$search.*≫登場人物≫/i",
		'character_summary' => "/$search.*≫登場人物≫.*≫.*概要$/i",
		'character_sub' => "/$search.*≫登場人物≫.*≫/i",
		'character_other' => "/$search.*≫登場人物≫.*/i",
		'general_summary' => "/$search.*≫.*概要$/i",
		'deep_summary' => "/$search.*≫.*≫.*概要$/i",
		'no_structure' => "/$search.*≫/i"
	];

	// 条件分岐
	if (!preg_match($patterns['basic'], $title)) {
		return;
	}

	if (preg_match($patterns['character'], $title)) {
		if (preg_match($patterns['character_summary'], $title))
		{
			$ok = 1;
		}
		elseif (preg_match($patterns['character_sub'], $title))
		{
			return;
		} else {
			$ok = 1;
		}
	}
	elseif (preg_match($patterns['general_summary'], $title))
	{
		if (preg_match($patterns['deep_summary'], $title))
		{
			return;
		}
			else
		{
			$ok = 1;
		}
	}
	elseif (preg_match($patterns['no_structure'], $title))
	{
		return;
	}
	else
	{
		$ok = 1;
	}

	// 処理実行
	if (!empty($ok)) {
			$this->kxdb2_SELECT(['id' => $this->kxdb2S1['id']]);
			$this->kxdb2_ID();
	} else {
			return;
	}

	/*
	if( !empty( $ok))
	{
		echo $title;
		echo '<br>';
	}
		*/

	return $ok;
}



/**
 * DBからの呼び出し。
 *
 * @param string $input_type
 * @return $this->result
 */
public function kxdb2_SELECT( $args ){

	global $wpdb;

	if( !empty( $args['id'] ) )
	{		//idによる呼び出し。

		$this->result = $wpdb->get_results(
			$wpdb->prepare(
					"SELECT *
					FROM kx_2
					WHERE id = %d",
					$args['id']
			)
		);

	}
	elseif( !empty($args['full'])  )
	{
		//全部呼び出し

		$this->result = $wpdb->get_results(
			"SELECT * FROM kx_2"
		);

	}
	elseif( !empty( $args['title'] )  )
	{
		//タイトル検索呼び出し。

		if( preg_match( '/%/' , $args['title'] ) )
		{
			$Equal = 'like';
		}
		else
		{
			$Equal = '=';
		}

		if(
			empty( $this->result )	||
			(
				!empty( $this->result[0] ) &&
				get_the_title( $this->result[0]->id ) == $args['title']
			)
		){
			//AI最適化未処理。2025-04-04
			$this->result = $wpdb->get_results( $wpdb->prepare(
				"SELECT *
				FROM kx_2
				WHERE
				title ". $Equal ." '". $args['title'] . "'
				"
			) );

			if( $Equal == '=' ){

				//$this->kx1_set = 'input';
			}
		}
	}

}







/**
 * dbのcontent指定処理。2023-03-02
 *
 * @return void
 */
public function kxdb2_ID(){

	$_check_args['json'] = '[]';
	$_check_args['date'] = '[]';
	$_check_args['title'] = '';
	$this->json = [];
	$this->date = [];

	if ( preg_match( '/^(.*)≫.*＠概要$/' , get_the_title( $this->kxdb2S1[ 'id'] ) , $matches ))
	{
		unset($this->result	);

		//上位検索kx1
		$this->kxdb2_SELECT( [ 'title'=> $matches[1] ] );

		if ( empty( $this->result[0] ))
		{
			//kx0
			global $wpdb;
			$this->result = $wpdb->get_results( $wpdb->prepare(
				"SELECT *
				FROM wp_kx_0
				WHERE title = %s",
				$matches[1]
			));
			$_w_type = 'insert';
			$_id = $this->result[0]->id;

		}
		else
		{
			$_check_args['json'] = $this->result[0]->json;
			$_check_args['date'] = $this->result[0]->date;
			$_check_args['title'] = $this->result[0]->title;
			$this->json = kx_json_decode( $this->result[0]->json );
			$this->date = kx_json_decode( $this->result[0]->date );
			$_id = $this->result[0]->id;
			$_w_type = 'update';
		}

		if ( empty( $this->result[0] ))
		{
			kx_CLASS_error( 'ERROR：概要の上位が無い' );
			return;
		}

	}//概要
	else
	{
		if( !empty( $this->result[0] ))
		{
			//echo '+';
			//echo '<hr>';
			$_check_args['json'] = $this->result[0]->json;
			$_check_args['date'] = $this->result[0]->date;
			$_check_args['title'] = $this->result[0]->title;
			$this->json = kx_json_decode( $this->result[0]->json );
			$this->date = kx_json_decode( $this->result[0]->date );
			$_id = $this->result[0]->id;
			$_w_type = 'update';
		}
		else
		{
			$_w_type = 'insert';
			$_id = $this->kxdb2S1['id'];
		}
	}


	if( !empty( $this->result[0] ))
	{
		// 文字列を配列化
		if (!is_array($this->json))
		{
			$this->json = [$this->json];
		}

		if (!is_array($this->date))
		{
			$this->date = [$this->date];
		}
	}



	$_content	 = get_post( $this->kxdb2S1[ 'id' ] )->post_content;

	if( preg_match( '/\[.*raretu.*\]/' , $_content ) )
	{
		return;
	}

	//***dateの処理****
	$this->kxdb_date( $_content );



	foreach( KxSu::get('DBjson_pickup')['Works'] as $value_json):
		if( preg_match( '/'.$value_json.'：(.*)($|\r\n|\n|\r)/' , $_content ,$matches) )
		{
			//改行を削除して追記。2024-10-26
			$this->json[ $value_json] = trim($matches[1]);
		}
		unset( $matches);
	endforeach;


	//***タグの処理***
	//$this->kxdb2_TAG( $_content);

	//var_dump($_check_args);

	$this->kxdb2_Write( $_w_type , $_id , $this->date , $this->json ,$_check_args);
}



/**
 * date処理
 *
 * @return void
 */
public function kxdb_date($_content){

	foreach(explode( 'Date：' , $_content) as $_vaslue_date):
		if( preg_match( '/^(.*)：(\d{4})(年|\/)(\d{1,2}|)(月|\/|)(\d{1,2}|)/' , $_vaslue_date ,$matches ) )
		{
			$this->date[ $matches[1] ] = $matches[2] .'_' . sprintf('%02d', $matches[4])  .'_' .sprintf('%02d', $matches[6]);
		}
		unset( $matches);

		if( preg_match( '/^(.*)：(\d{4})Q(\d)/' , $_vaslue_date ,$matches ) )
		{
			if( $matches[3] == 1 ):
				$_month = 01;
			elseif( $matches[3] == 2 ):
				$_month = 04;
			elseif( $matches[3] == 3 ):
				$_month = 07;
			elseif( $matches[3] == 4 ):
				$_month = 10;
			endif;

			$this->date[ $matches[1] ] = $matches[2] .'/' . $_month  .'/00';
		}
		unset( $matches);

	endforeach;


	$this->date = array_filter($this->date , function($item) {
    return preg_match('/_\d\d_/', $item); // 「_\d\d_」に一致するかチェック
	});

}



/**
 * DBメンテンナンス用。
 *
 * @return void
 */
public function kxdb2_Maintenance(){

	foreach( $this->result as $value ):

		$_title = get_the_title( $value->id );

		$_args[	'date' ] = $value->date;
		$_args[	'json' ] = $value->json;
		$_args[	'title' ] = $value->title;

		if(
			empty( $_title )||
			preg_match( '/概要$/',$_title )||
			get_post_status( $value->id ) != 'publish' ||
			get_post_type( $value->id )   != 'post'
		){

			$this->kxdb2_Write( 'delete' ,$value->id ,$value->date ,$value->json , $_args );

			echo '削除-kx2:';
			echo $value->title;
			echo '<br>';
		}
		elseif(	$_title != $value->title	)
		{

			$this->kxdb2_Write( 'update' ,$value->id ,$value->date ,$value->json , $_args );
		}

	endforeach;


}



/**
 * データベース変更。書き込み。タイプ別。
 *
 * @return void
 */
public function kxdb2_Write( $w_type , $id ,$date, $json ,$check_args){


	$_date = kx_json_encode( $date );
	$_json = kx_json_encode( $json );

	if(
		$check_args['json'] == $_json &&
		$check_args['date'] == $_date &&
		$check_args['title'] == get_the_title($id) &&
		$w_type != 'delete'
		)
	{

		return;
	}
	else
	{

		/*
		echo $_check_args['json'] .'+++'. $_json ;
		echo '<br>';
		echo $_check_args['date'] .'+++'. $_date ;
		echo '<br>';
		echo $_check_args['title'] .'+++'. get_the_title($id) ;
		echo '<br>';
		echo $w_type;
		echo '<hr>';
		*/

	}


	global $wpdb;

	if( $w_type == 'insert' )
	{
		$sql_rsl = $wpdb->query(
			$wpdb->prepare(
				"INSERT INTO kx_2 (id, title, date, json, text, time)
				VALUES (%d, %s, %s, %s, %s, %d)",
				$id,
				get_the_title($id),
				$_date,
				$_json,
				Time::format() . 'ii',
				time()
			)
		);
	}
	elseif( $w_type == 'update' ) //更新。2023-02-16
	{
		$sql_rsl = $wpdb->query(
			$wpdb->prepare(
					"UPDATE kx_2
					SET
							title = %s,
							date = %s,
							json = %s,
							text = %s,
							time = %d
					WHERE id = %d",
					get_the_title($id),
					$_date,
					$_json,
					Time::format() . 'uu',
					time(),
					$id
			)
	);
	}
	elseif( $w_type == 'delete' )
	{
		$sql_rsl = $wpdb->query(
			$wpdb->prepare(
					"DELETE FROM kx_2 WHERE id = %d",
					$id
			)
	);
	}

	if ($sql_rsl === false) {
		echo "KX2-SQL失敗：" . $wpdb->last_error;
		echo ':'.$w_type;
		echo ':'.get_the_title($id);
		 '<br>';
	}
}

}






/**
 * 4カテゴリーシェア型タイトルのDB。
 * 2023-03-01
 */
class kxdbST {

    public $kxdbStS0;
    public $kxdbStS1;

    public $date;

    public $id_lesson;
    public $id_sens;
    public $id_study;
    public $id_data;
    public $json;

    public $result;


    public $dbst_del;
    public $search_value_date_on;
    public $search_value;
    public $ids;
    public $dbst_Sc;

    public $table_name = 'wp_kx_shared_title';

    /**
     * メイン
     *
     * @param [type] $args
     * @return void
     */
    public function kxdbST_Main( $args , $type ){

        //echo $order;
        //echo'<br>';

        //排除。
        if ( $this->kxdbST_should_exclude_post( $args, $type ) === false) {
            return;
        }

        $this->kxdbStS0 = $args;
        $this->kxdbStS1 = $args;

        if( $type == 'Maintenance' )
        {
            $this->kxdbStS1['output'] = '無し';
            $this->kxdbST_Select(  $type );
            $this->kxdbST_ids( $type );
            return $this->kxdbStS1['output'];
        }
        elseif( $type == 'id' )
        {
            $this->kxdbStS1[ 'title_base' ] = get_the_title( $this->kxdbStS1[ 'id' ] );
            $this->kxdbStS1[ 'DBtitle' ] = preg_replace( KxSu::get('title_preg')['SharedTitleDB']  , '' , $this->kxdbStS1[ 'title_base' ]);


            //$this->kxdbST_ID();

            //echo '+++'.$this->kxdbStS1[ 'title_base' ];
            //echo '<hr>';

            kx_db_ID_Common(
                $this->kxdbStS1,
                'wp_kx_shared_title',
                'ShareTitle',
                [
                    '/^Β/' => 'id_lesson',
                    '/^δ/' => 'id_data',
                    '/^γ/' => 'id_sens',
                    '/^σ/' => 'id_study'
                ]
            );

            $this->feed_dy($args);

            return;
        }
        elseif( $type == 'select_title')
        {

            $this->kxdbST_Select( $type );

            if( !empty($this->result))
            {
                $this->kxdbST_ids( $type );
                $this->date = $this->result[0]->date;
                $this->json = $this->result[0]->json;
            }


            return;
        }
				elseif( $type ==  'feed_dy' )
				{
					$this->feed_dy( $args );
					return;
				}

        //基本設定。

        $this->kxdbST_set1();

        //取得。
        $this->kxdbST_Select( $type );
        //echo $this->kxdbStS0[ 'title_share' ];
        //var_dump($this->result);
        //echo $order.'+<hr>';

        //$title = preg_replace( KxSu::get('title_preg')['SharedTitleDB'] , '', $title);
        //$result =  kx_db_Read('wp_kx_shared_title',['title' => $title]);

        //echo '<hr>++'.$title;
        //var_dump($result);
        //echo '++<hr>';

        //カラム名。研究など4種類系統処理。2022-12-29
        if( !empty( $this->kxdbStS1[ 'id_name' ] ) )
        {
            $_name = $this->kxdbStS1[ 'id_name' ];
        }


        if( $type == 'select_side_float' )
        {
            if(
                empty( $this->result )
                || $this->result[0]->$_name !=  $this->kxdbStS0[ 'id' ]
            ){
                //新規作成
                //id違い


                $this->kxdbST_Write( $type );
                $this->kxdbST_Select( $type );

                //elseif(  ):
                //$this->kxdbST_Write( $type );
            }

            $this->kxdbST_ids( $type );

            $this->date = $this->result[0]->date;
            $this->json = $this->result[0]->json;
        }
        elseif( $type == 'select_side_float_full' )
        {
            $this->kxdbST_ids( $type );
        }
        elseif( $type == 'search' )
        {
            $this->kxdbST_id_search();
        }
    }




    /**
     * Undocumented function
     *
     * @param [type] $args
     * @param [type] $type
     * @return void
     */
    public function kxdbST_should_exclude_post( $args, $type ) {
    // タイトルが規定にマッチする場合
    if ( ! empty( $args['title'] ) && preg_match( KxSu::get( 'title_preg' )['SharedTitleDB'], $args['title'] ) ) {
        return true;
    }

    // raretu が存在する場合
    if ( ! empty( $args['raretu'] ) ) {
        return true;
    }

    // type が 'select_all' の場合
    if ( $type === 'select_all' ) {
        return true;
    }

    // id が存在し、公開済みの投稿で、タイトルが規定にマッチする場合
    if ( ! empty( $args['id'] ) && get_post_status( $args['id'] ) === 'publish' && get_post_type( $args['id'] ) === 'post' && preg_match( KxSu::get('title_preg')['SharedTitleDB'], get_the_title( $args['id'] ) ) ) {
        return true;
    }

    // type が 'Maintenance' の場合
    if ( $type === 'Maintenance' ) {
        return true;
    }

    // 上記のいずれの条件にも当てはまらない場合は除外する
    return false;

    /*
    //排除。
        if (
            (
                !empty( $args[ 'title' ] ) && //タイトルがある。
                preg_match( KxSu::get('title_preg')['SharedTitleDB']  , $args[ 'title' ] ) //規定にマッチ。
            )||
            !empty( $args[ 'raretu' ] )|| //raretuがある場合。
            $type == 'select_all'||
            (
                !empty( $args[ 'id' ] )&& //idがある場合。
                get_post_status( $args[ 'id' ] ) == 'publish' &&
                get_post_type( $args[ 'id' ] )   == 'post' &&
                preg_match( KxSu::get('title_preg')['SharedTitleDB']  , get_the_title($args[ 'id' ]) ) //規定にマッチ。
            )||
            (
                $type == 'Maintenance' //メンテナスの場合。
            )
        ){
            //OK;
        }
        else
        {
            return;
        }
    */

    }







    /**
     * 基本設定
     *
     * @return void
     */
    public function kxdbST_set1(){

        switch ( $this->kxdbStS0['title_top'] ) {
        case 'Β':
            $this->kxdbStS1['id_name'] = 'id_lesson';
            break;
        case 'γ':
            $this->kxdbStS1['id_name'] = 'id_sens';
            break;
        case 'σ':
            $this->kxdbStS1['id_name'] = 'id_study';
            break;
        case 'δ':
            $this->kxdbStS1['id_name'] = 'id_data';
            break;
        default:
            echo 'error-line' . __LINE__;
            echo $this->kxdbStS0['title_top'];
            break;
        }

    /*
        if( $this->kxdbStS0[ 'title_top' ] == 'Β' )
        {
            $this->kxdbStS1[ 'id_name' ] = 'id_lesson';
        }
        elseif( $this->kxdbStS0[ 'title_top' ] == 'γ' )
        {
            $this->kxdbStS1[ 'id_name' ] = 'id_sens';
        }
        elseif( $this->kxdbStS0[ 'title_top' ] == 'σ' )
        {
            $this->kxdbStS1[ 'id_name' ] = 'id_study';
        }
        elseif( $this->kxdbStS0[ 'title_top' ] == 'δ' )
        {
            $this->kxdbStS1[ 'id_name' ] = 'id_data';
        }
        else
        {
            echo 'error-line'.__line__;
            echo $this->kxdbStS0[ 'title_top' ];
        }
            */

    }


    /**
     * ids配列出力
     *
     * @return void
     */
    public function kxdbST_id_search(){

        foreach( $this->result as  $_arr  ):

            //カラムの名前取得。2023-03-01
            $_name = $this->kxdbStS1[ 'id_name' ];

            if( empty( $_arr->date ))
            {
                $_arr->date = 'n/a';
            }
            else
            {
                $this->search_value_date_on = 1;
            }

            $this->search_value[ $_arr->$_name] = $_arr->date;
        endforeach;
    }



    /**
     * ids配列出力
     *
     * @return void
     */
    public function kxdbST_ids( $order ){

        if( $order == 'Maintenance' )
        {
            $_count_max = 99999;
        }
        else
        {
            $_count_max = 10;
        }

        if( !empty( $this->result )	)
        {
            if(
                $order == 'select_side_float_full' ||
                $order == 'Maintenance'
            )
            {

                $_count = count( $this->result );

                $this->ids = null;
                if( $_count < $_count_max )
                {
                    foreach( $this->result as  $_arr  )
                    {
                        $_id_null = 1;
                        foreach( $_arr as  $key => $value  )
                        {
                            if( preg_match( '/^id/' , $key ) && !empty( $value ) )
                            {
                                $_title_top = array_search($key, KxSu::get('DBshare_title1_column') );
                                //echo '+';
                                //echo $_title_top . '≫'. $_arr->title;
                                //echo '----';
                                //echo get_the_title($value);

                                if(
                                    //get_the_title($value)  &&
                                    get_the_title($value) == $_title_top . '≫'. $_arr->title &&
                                    get_post_status($value ) == 'publish' &&
                                    get_post_type( $value)   == 'post'
                                )
                                {


                                    $this->ids[] = $value;

                                    $this->kxdbST_title_check( $_arr , $key , $value );

                                    unset( $_id_null );
                                }
                                else
                                {
                                    echo 'kxdbST_ID_削除A：'. $key.$_arr->title .'<br>';
                                    $this->kxdbStS1['output'] = 'あり';
                                    kx_db_Write(
                                        'update',
                                        $_arr,
                                        $this->table_name,
                                        [$key => 0],
                                        ['title' => $_arr->title],
                                    );
                                }
                            }
                        }

                        if( !empty( $_id_null ) )
                        {
                            //var_dump($_arr);
                            $this->dbst_del[ 'title' ] = $_arr->title;
                            //$this->kxdbST_Delete();
                            echo 'kxdbST_Titile_削除B：'. $_arr->title .'<br>';
                            $this->kxdbStS1['output'] = 'あり';
                            kx_db_Write(
                                'delete',
                                null,
                                $this->table_name,
                                null ,
                                ['title' => $_arr->title],
                            );
                        }
                    }
                }
                else
                {
                    $this->ids = $_count;
                }
            }
            else
            {
                foreach( $this->result[0] as $key => $value  ):

                    if( preg_match( '/^id/' , $key ) && !empty( $value ) )
                    {
                        $this->ids[ $key ] = $value;
                        $this->kxdbST_title_check( $this->result[0] , $key , $value  );
                    }

                endforeach;
            }
        }
        else
        {
            echo '■■ERROR■■'. __LINE__;
        }
    }



		/**
     * Dyキャッシュの 'shared' キーにデータを注入する
     * ※ 'db_kx_shared' スロットの存在をチェック基準とする
     */
    private function feed_dy($args) {
        global $wpdb;

        // 1. タイトルの特定
        if (isset($args['id'])) {
            $title_base = get_the_title($args['id']);
            if (empty($title_base)) return;
            $title = preg_replace(Su::get('title_preg')['SharedTitleDB'], '', $title_base);
        } else {
            $title = $args['title'] ?? '';
        }

        if (empty($title)) return;

        // 2. キャッシュ確認：'db_kx_shared' が既にセットされているかチェック
        $current_shared = Dy::get('shared') ?: [];
        if (isset($current_shared[$title]['db_kx_shared'])) {
            return; // 既に Shared Title データが注入済みなら終了
        }

        // 3. 各テーブルからデータを取得
        $shared_data = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM wp_kx_shared_title WHERE title = %s", $title),
            ARRAY_A
        );

        $works_data = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM wp_kx_works WHERE title = %s", $title),
            ARRAY_A
        );

        // 4. Dy用の構造に整形
        // データがDBにない場合でも空配列を入れ、重複クエリを防ぐ（ネガティブキャッシュ）
        $current_shared[$title] = [
            'db_kx_shared' => $shared_data ?: [],
            'db_kx_works'  => $works_data ?: [],
        ];

        // 5. Dyへセット
        Dy::set('shared', $current_shared);
    }


    /**
     * idのタトルチェック。
     *
     * @param [type] $id
     * @return void
     */
    public function kxdbST_title_check( $args , $column ,$id ){


        $true_share_title = preg_replace( '/'.KxSu::get('titile_search')[ 'SharedTitleDB' ] .'≫/' , '' , get_the_title( $id ) );


        //タイトル違いのID削除。
        if( $true_share_title != $args->title )
        {
            $this->dbst_Sc[ 'WHERE_title' ] =  $args->title;
            $this->dbst_Sc[ 'id_name' ] =  $column;
            $this->kxdbST_Write( 'title_check_id_Delete' );
        }


        if(
            get_post_status( $id ) != 'publish' ||
            get_post_type( $id )   != 'post'
        )
        {
            //echo $args->title;
            //echo '<br>';
            //echo $column;
            //echo '<br>';
            echo get_post_status( $id );
            echo '：';
            echo get_post_type( $id );
            echo '：';
            echo get_the_title($id).'<br>';

            $this->dbst_Sc[ 'WHERE_title' ] =  $args->title;
            $this->dbst_Sc[ 'id_name' ] =  $column;
            $this->dbst_Sc[ 'id' ] = 0;
            $this->kxdbST_Write( 'title_check' );
        }
    }



    /**
     * DBの呼び出し。
     *
     * @return void
     */
    public function kxdbST_Select( $order ){

        global $wpdb;

        if( $order ==  'Maintenance')
        {
            $_type = 'full';
        }
        elseif( $order == 'select_side_float_full' || $order == 'select_◆'  )
        {
            $_type = 'like';
        }
        elseif( $order == 'search' )
        {
            $_type = 'search';
        }
        elseif( $order == 'delete' )
        {
            return;
        }
        else
        {
            $_type = 'normal';
        }


        if( $_type == 'normal' ):

            $this->result = $wpdb->get_results(
                "SELECT *
                FROM wp_kx_shared_title
                WHERE title = '" . $this->kxdbStS0[ 'title_share' ] . "'
                "
            );

            //echo $order.'+<hr>';
            //echo $this->kxdbStS0[ 'title_share' ];
            //echo '+<hr>';
            //var_dump($this->result);
            //echo $order.'+<hr>';

        elseif( $_type == 'search' ):
            //raretのショートコードからは通常はこちらに来る。2023-03-01

            if(
                !empty( $this->kxdbStS0[ 'select2_AND' ] )
                && $this->kxdbStS0[ 'select2_AND' ] == 'AND'
                && !empty( $this->kxdbStS0[ 'Column2' ] )
                && !empty( $this->kxdbStS0[ 'select2' ] )
            ){
                $_and = $this->kxdbStS0[ 'select2_AND' ] ." ". $this->kxdbStS0[ 'Column2' ] ." LIKE '" . $this->kxdbStS0[ 'select2' ] ."'";

            }
            elseif( !empty( $this->kxdbStS0[ 'Column2' ] ) && !empty( $this->kxdbStS0[ 'select2' ] ) )
            {
                $_and = "OR ". $this->kxdbStS0[ 'Column2' ] ." LIKE '" . $this->kxdbStS0[ 'select2' ] ."'";
            }
            else
            {
                $_and = null;
            }

            $this->result = $wpdb->get_results(
                "SELECT *
                FROM wp_kx_shared_title
                WHERE ".$this->kxdbStS0[ 'Column' ]." LIKE '" . $this->kxdbStS0[ 'select1' ] ."'
                ".$_and."
                "
            );



        elseif( $_type == 'like' ):

            $this->result = $wpdb->get_results(
                "SELECT *
                FROM wp_kx_shared_title
                WHERE title LIKE '" . $this->kxdbStS0[ 'title_share' ] . "%'
                "
            );

        elseif( $_type == 'full' ):

            $this->result = $wpdb->get_results( $wpdb->prepare(
                "SELECT *
                FROM wp_kx_shared_title
                "
            ) );

        endif;


    }




    /**
     * 書き込み
     *
     * @return void
     */
    public function kxdbST_Write( $order ){

        global $wpdb;

        $_memo = '';
        $old_result = NULL;

        if( $order == 'title_check')
        {
            $_write_type = 'update';

            //$_title 				= $this->dbst_Sc[ 'WHERE_title' ];
            $_WHERE_title   = $this->dbst_Sc[ 'WHERE_title' ];
            //$_set 					= $this->dbst_Sc[ 'id_name' ] .'=' . $this->dbst_Sc[ 'id' ] ;
        }
        elseif( $order == 'title_check_id_Delete' )
        {
            $_write_type = 'update';
            //$_title 				= $this->dbst_Sc[ 'WHERE_title' ];
            $_WHERE_title   = $this->dbst_Sc[ 'WHERE_title' ];
            //$_set 					= $this->dbst_Sc[ 'id_name' ] .'=0';
        }
        else
        {
            if( empty( $this->result ) )
            {
                $_write_type = 'insert';
                //echo $order.'+<hr>';
            }
            else
            {
                $_write_type = 'update';
                $old_result = $this->result[0];

                $_name = $this->kxdbStS1[ 'id_name' ];

                if( $order == 'id' && preg_match( '/^δ≫/' , $this->kxdbStS0[ 'title_base' ] ) )
                {
                    //$_memo .= 's';

                    //スルーしない。書き込みする。

                }
                elseif( empty($this->result[0]->json))
                {
                    //$_memo .= 'j';
                    //スルーしない。書き込みする。
                    //jsonがない場合は保存。

                    if( preg_match( '/00.*＠概要$/' , $this->kxdbStS0[ 'title_base' ] ) )
                    {
                        //概要の場合は保存しない。2022/06/11
                        return;
                    }
                }
                elseif( $this->kxdbStS0[ 'id' ] == $this->result[0]->$_name  && !empty($this->result[0]->json) )
                {
                    //既存。排除。
                    return;
                }
                else
                {
                    //$_memo .= 'e';
                }
            }


            if( !empty( $this->result[0]->json ))
            {
                $_json_arr = kx_json_decode( $this->result[0]->json );
                $_data     = kx_json_decode( $this->result[0]->json );
            }
            else
            {
                $_json_arr = [];
                $_data = [];
            }

            //$_set = '';


            //postから抽出。δのみ。
            if(	preg_match( '/^δ≫/' , $this->kxdbStS0[ 'title_base' ] )	)
            {
                global $post;
                $post = get_post( $this->kxdbStS0[ 'id' ] );
                //$content = $post->post_content;

                if( !preg_match( '/\[.*raretu.*\]/' , $post->post_content  ) )
                {
                    //Dateの入力。2023-06-21
                    if( preg_match( '/Date：(\d{1,4})(年|\/)(\d{1,2}|)(月|\/|)(\d{1,2}|)/' , $post->post_content ,$matches ) )
                    {
                        $_data['date'] = sprintf('%04d', $matches[1]).'_'.sprintf('%02d', $matches[3]).'_'.sprintf('%02d', $matches[5]);
                        $_date = $_data['date'];//旧

                        //$_set .= "date='";
                        //$_set .= $_date;
                        //$_set .= "',";
                    }
                    else
                    {
                        unset($_data['date']);
                        //$_set .= "date='n/a',";
                    }
                    unset( $matches );

                    //json。タグ。2022-12-29
                    $_json_arr = [];
                    $_json_arr = kx_db_json_TAG(	$post->post_content , $_json_arr );


                    //var_dump($_json_arr);
                    //echo '<hr>';
                }
            }


            //***不要キーの削除の処理***
            $_check = ['タグ'];
            if (!empty($_json_arr) && (is_array($_json_arr) || is_object($_json_arr)))
            {

                foreach ($_json_arr as $key => $value)
                {
                    if (!in_array($key, $_check))
                    {
                        unset($_json_arr[$key]);
                    }

                    if (empty($_json_arr[$key]))
                    {
                            unset($_json_arr[$key]);
                    }
                }

            }//***不要キーの削除の処理***

            if( !empty($_json_arr) && is_array( $_json_arr ) )
            {
                $_data['json'] = $_json_arr;
                //$_set  .= "json='". kx_json_encode( $_json_arr ) . "',";
            }
            else
            {
                //$_set  .= "json='',";
                unset( 	$_data['json'] );
            }

            //echo $_write_type;
            //var_dump($_data);
            //echo '<hr>';


            $_data['title'] = $this->kxdbStS0[ 'title_share' ];

            if( preg_match( '/^δ≫.*≫00.*＠概要$/' , $this->kxdbStS0[ 'title_base' ] )	)
            {
                //概要保存に介入。

                $_set = preg_replace( '/,$/' , '' , $_set);


                $_data['title'] = preg_replace( '/≫00.*＠概要$/' , '' , $this->kxdbStS0[ 'title_share' ] );
                $this->kxdbStS0[ 'title_share' ] = $_data['title'];

                $_set = '';
            }

            //$_title 				= $this->kxdbStS0[ 'title_share' ];
            $_WHERE_title  = $this->kxdbStS0[ 'title_share' ];
            $_set 				.= $this->kxdbStS1[ 'id_name' ] .'=' . $this->kxdbStS0[ 'id' ] ;

            //$_data[$this->kxdbStS1[ 'id_name' ]] = $this->kxdbStS0[ 'id' ];
            unset($_data[$this->kxdbStS1[ 'id_name' ]]);


            $_set = preg_replace( '/,$/' , '' , $_set);
        }

        if( empty( $_data['title'] ) )
        {
            $_write_type = 'delete';
            $_data = NULL;
        }

        kx_db_Write( $_write_type,$old_result,$this->table_name, $_data , ['title'=>$_WHERE_title] );
    }


}//*** *** *** kxdbST・classEND。2023-03-01 *** *** ***






/**
 * 作品データベース登録
 */
class kxdbW {

public $kxdbW_S0;

public $date;
public $id_sens;
public $id_study;
public $id_data;
public $json;

public $result;
public $output;

public $work_title;

public $result_Maintenance;
public $select;

/**
 * メイン。
 *
 * @param [type] $type
 * @return void
 */
public function kxdbW_Main( $args , $type ){

	$args[ 'order' ] = $type;

	//排除。
	if ( $this->kxdbW_should_exclude_post( $args, $type ) === false) {
    return;
	}

	$this->kxdbW_S0 = $args;


	if( $type == 'id' )
	{
		$this->kxdbW_S0[ 'title_base' ] = get_the_title( $this->kxdbW_S0[ 'id' ] );

		$_id_type = $this->kxdbW_processTitle( KxSu::get('titile_search')['worksDB'] ) ;

		if( !empty( $_id_type  ) )
		{
			//echo $_id_type.'<br>';
			$this->kxdbW_S0[ 'DBtitle' ] = preg_replace( KxSu::get('title_preg')['worksDB']  , '' , $this->kxdbW_S0[ 'title_base' ]);
			//$this->kxdbW_ID();

			kx_db_ID_Common(
				$this->kxdbW_S0,
				'wp_kx_works',
				'Works',
				[
					'/^δ/' => 'id_data',
					'/^γ/' => 'id_sens',
					'/^σ/' => 'id_study'
				]
			);
		}
		return;
	}
	elseif( $type == 'Maintenance' )
	{
		$this->kxdbW_Maintenance();
		return;
	}
	elseif($type ==  'feed_dy')
	{
		//未実装
		return;
	}


	$this->work_title = preg_replace( KxSu::get('title_preg')['worksDB']  , '' , $args['title'] );
	$this->work_title = preg_replace( '/≫.*$/'  , '' , $this->work_title );

	$this->kxdbW_Select();

	switch ($args['order']) {
    case 'select_title':
			if (!empty($this->result)) {
					$this->select = $this->result[0];
			}
			break;

    case 'select_search':
			$this->select = !empty($this->result) ? $this->result : ['NULL'];
			break;

    case 'delete':
			echo '削除dbW：'. $this->kxdbW_S0['title'];

			global $wpdb;
			$sql_rsl = $wpdb->query( $wpdb->prepare(
				"DELETE FROM wp_kx_works
				WHERE title='". $this->kxdbW_S0['title'] ."'"

			) );

			break;

    default:
			echo 'KxDB_W' . $args['order'] . '<hr>';
			break;
	}

}



// 排除条件を関数として定義
/**
 * Undocumented function
 *
 * @param [type] $args
 * @param [type] $type
 * @return void
 */
public function kxdbW_should_exclude_post( $args, $type ) {
	// タイトルが規定にマッチする場合
	if ( ! empty( $args['title'] ) && preg_match( KxSu::get( 'title_preg' )['worksDB'], $args['title'] ) ) {
			return true;
	}

	// raretu が存在する場合
	if ( ! empty( $args['raretu'] ) ) {
			return true;
	}

	// type が 'select_all' の場合
	if ( $type === 'select_all' ) {
			return true;
	}

	// id が存在し、公開済みの投稿の場合
	if ( ! empty( $args['id'] ) && get_post_status( $args['id'] ) === 'publish' && get_post_type( $args['id'] ) === 'post' ) {
			return true;
	}

	// order が 'Maintenance' の場合
	if ( ! empty( $args['order'] ) && $args['order'] === 'Maintenance' ) {
			return true;
	}

	// 上記のいずれの条件にも当てはまらない場合は除外しない
	return false;


	//旧：排除。
	/*
	if (
		(
			!empty( $args[ 'title' ] ) && //タイトルがある。
			preg_match( KxSu::get('title_preg')['worksDB']  , $args[ 'title' ] ) //規定にマッチ。
		)||
		!empty( $args[ 'raretu' ] )|| //raretuがある場合。
		$type == 'select_all'||
		(
			!empty( $args[ 'id' ] )&& //idがある場合。
			get_post_status( $args[ 'id' ] ) == 'publish' &&
			get_post_type( $args[ 'id' ] )   == 'post'
		)||
		(
			!empty( $args[ 'order' ] )
			&& $args[ 'order' ] == 'Maintenance' //メンテナスの場合。
		)
	){
		//OK;
	}
	else
	{
		return;
	}
		*/
}



/**
 * セレクト。
 *
 * @param [type] $s_type 配列。
 * @return void
 */
public function kxdbW_Select( $s_type = null){

	global $wpdb;

	if(
		!empty( $s_type['title'] ) ||
		$this->kxdbW_S0[ 'order' ]  == 'select_title'	||
		$this->kxdbW_S0[ 'order' ]  == 'write'||
		$this->kxdbW_S0[ 'order' ]  == 'write_id'
	){

		if( !empty( $this->work_title ) )
		{
			$s_type['title'] = $this->work_title;
		}

		$this->result = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT *
				FROM wp_kx_works
				WHERE title = %s", // プレースホルダー %s を使用
				$s_type['title'] // プレースホルダーに挿入する値
			)
		);
	}
	elseif(
		$s_type == 'full' ||
		$this->kxdbW_S0[ 'order' ]  == 'select_all'	||
		$this->kxdbW_S0[ 'order' ]  == 'Maintenance'
	)
	{

		$this->result = $wpdb->get_results(
			"SELECT *
			FROM wp_kx_works
			"
		);
	}
	elseif( $this->kxdbW_S0[ 'order' ]  == 'select_search' )
	{
		if( !empty( $this->kxdbW_S0[ 'Column2' ] ) && !empty( $this->kxdbW_S0[ 'select2' ] ) )
		{
			//$_and =  $this->kxdbW_S0[ 'select2_AND' ] . ' '. $this->kxdbW_S0[ 'Column2' ] ." LIKE '" . $this->kxdbW_S0[ 'select2' ] ."'";
			//$_and = 'AND ' . $this->kxdbW_S0[ 'Column2' ] ." LIKE '" . $this->kxdbW_S0[ 'select2' ] ."'";
			$_and = "AND ". $this->kxdbW_S0[ 'Column2' ] ." LIKE '" . $this->kxdbW_S0[ 'select2' ] ."'";
			//echo $_and;
		}
		else
		{
			$_and = null;
		}

		$this->result = $wpdb->get_results(
			"SELECT *
			FROM wp_kx_works
			WHERE ". $this->kxdbW_S0[ 'Column' ] ." LIKE '" . $this->kxdbW_S0[ 'select1' ] . "'
			".$_and."
			"
		);
		//print_r($this->result);
	}
}




/**
 * タイトル選別
 *
 * @return void
 */
public function kxdbW_processTitle($search ){

	$title = $this->kxdbW_S0[ 'title_base' ];

	$ok = null;


	// 検索パターン
	$patterns =
	[
		'basic' => "/$search/i",
		'character' => "/$search.*≫登場人物≫/i",
		'character_summary' => "/$search.*≫登場人物≫.*≫.*概要$/i",
		'character_sub' => "/$search.*≫登場人物≫.*≫/i",
		'character_other' => "/$search.*≫登場人物≫.*/i",
		'general_summary' => "/$search.*≫.*概要$/i",
		'deep_summary' => "/$search.*≫.*≫.*概要$/i",
		'no_structure' => "/$search.*≫/i"
	];

	// 条件分岐
	if (!preg_match($patterns['basic'], $title)) {
		return;
	}

	if (preg_match($patterns['character'], $title)) {
		if (preg_match($patterns['character_summary'], $title))
		{
			$ok = 1;
		}
		elseif (preg_match($patterns['character_sub'], $title))
		{
			return;
		} else {
			$ok = 1;
		}
	}
	elseif (preg_match($patterns['general_summary'], $title))
	{
		if (preg_match($patterns['deep_summary'], $title))
		{
			return;
		}
			else
		{
			$ok = 1;
		}
	}
	elseif (preg_match($patterns['no_structure'], $title))
	{
		return;
	}
	else
	{
		//echo $title;
		//echo '<br>';
		$ok = 1;
	}


	if( preg_match( '/概要$/' , $title ) )
	{
		$ok = 1;
	}
	else
	{
		$ok = 2;
	}

	// 処理実行
	if (!empty($ok)) {
		//$this->kxdb2_SELECT(['id' => $this->kxdb2S1['id']]);
		//$this->kxdb2_ID();
	}

	return $ok;
}





/**
 * Maintenance
 *
 * @return void
 */
public function kxdbW_Maintenance(){

	$this->kxdbW_Select();
	$_on2 = false;

	foreach( $this->result as $value ):
		//print_r( $value );
		unset( $_on);
		foreach (['id_sens', 'id_study', 'id_data'] as $field) {
			if (!empty($value->$field) )
			{
				if(
					get_post_status($value->$field) != 'publish' ||
					get_post_type($value->$field)   != 'post'
				)
				{
					unset($value->$field);
					$_on = 1;
				}
				elseif (empty(get_the_title($value->$field)))
				{
					$_on = 1;
				}

				if(!empty(get_the_title($value->$field)) && !preg_match('/'.$value->title.'/',get_the_title($value->$field) ) )
				{
					//echo $value->title;
					//echo '：：';
					//echo get_the_title($value->$field);
					//echo '<br>';
					$_on = 'delete';
				}
			}
		}

		if( empty( $value->id_sens ) && empty( $value->id_study ) && empty( $value->id_data ))
		{
			$_on = 'delete';
			echo '<削除works：>';
			echo $value->title.'<br>';
			$_on2 =  true;
		}

		if( !empty( $_on ) && $_on == 'delete')
		{
			kx_db_Write( 'delete','', 'wp_kx_works', '', ['title' => $value->title ] );

		}
		elseif( !empty( $_on ) )
		{
			//print_r($this->result_Maintenance);
			//echo'<hr>';
			$this->result_Maintenance = $value;
			$this->kxdbW_Maintenance_write();

			$_on2 =  true;
		}


	endforeach;

	$this->select = $_on2
	? "★DB kx_w Maintenance★あり<br>"
	: "★DB kx_w Maintenance★無し：" . count($this->result) ;
}






/**
 * 書き込み。
 *
 * @param [type] $string
 * @return void
 */
public function kxdbW_Maintenance_write(){

	//print_r( $this->result[0] );
	//echo '<br>';

	$_change_title = $this->result_Maintenance->title;

	$_arr = [
		'id_sens'  => $this->result_Maintenance->id_sens ,
		'id_study' => $this->result_Maintenance->id_study ,
		'id_data'  => $this->result_Maintenance->id_data ,
	];


	echo 'kxdbW_write_ID書き換え：';
	echo $_change_title;
	echo '<br>';


	$_data = null;
	foreach( $_arr as $_key => $_id ):

		if(
			!empty( $_id )
			&& !preg_match( '/^'. $_change_title .'$/' , end( explode(  '≫' , get_the_title( $_id )) )  )
		)
		{
			echo $_id;
			echo '⇒0<br>';
			/*
			echo $_change_title;
			echo '：';
			echo end( explode(  '≫' , get_the_title( $_id )) );
			echo '<br>';
			*/
			$_id = 0;
		}

		$_data .= $_key."='".$_id."'," ;

	endforeach;

	$_data = preg_replace( '/\,$/' , '' , $_data);

	echo $_data;
	echo '<hr>';

	//return;

	global $wpdb;
	$sql_rsl = $wpdb->query(
		"UPDATE wp_kx_works
		SET
		title = '". $_change_title ."'
		,text = 'UPDATE_A'
		,". $_data ."
		,time = '" .			time()."m'
		WHERE title = '". $_change_title ."'
		"
	);



}


} //*** *** *** kxdbW *** *** ***









/**
 * 一時保存テーブル (wp_kx_temporary) に対して、指定された条件でデータの読み込み、更新、または新規登録を行います。
 *
 * @param string $where_type 検索条件となる 'type' カラムの値。
 * @param array $data 保存または更新するデータ（連想配列形式でカラム名 => 値）。
 * @return bool 処理が成功した場合は true、失敗した場合は false を返します。
 * 更新時に既存のデータと同一だった場合も true を返します。
 */
function kxdbTemp($where_type, $data){

  $table_name = 'wp_kx_temporary';
  $where  = ['type' => $where_type ];

  $results = kx_db_Read(
    $table_name, $where
  );

  //print_r($results[0]);
  //echo '+++<hr>';

  if (!empty($results) && isset($results[0]))
  {
    $w_type = 'update';

    $sql_rsl = kx_db_Write(
      $w_type, $results[0], $table_name,
      $data ,
      $where,
    );

  }
  else
  {
    $w_type = 'insert';

    $sql_rsl = kx_db_Write(
      $w_type, null, $table_name,
      $data ,
      //$where,
    );
  }

	if ($sql_rsl === '処理に成功しました' || $sql_rsl === '既存のデータと同じため、保存を中止しました' )
  {
		return true;
  }
  else
  {
		return false;
  }
}



/**
 * 投稿を特定の条件に基づいて更新する関数
 * この関数は 'wp_kx_temporary' データベーステーブルからデータを読み取り、
 * タイトルの置換や処理時間の追跡、残りアイテムの管理を行いつつ投稿を更新します。
 *
 * @param string|null $type 更新タイプ（例: 'Update_ON'）
 * @return string 更新処理の結果やステータス
 */
function kxdbTemp_update_posts($type = NULL){


	$table_name = 'wp_kx_temporary';
  $where  = ['type' => 'update_posts'];

  $results = kx_db_Read(
    $table_name, $where
  );


	$text3 = null;
	$text4 = null;
	if( !empty($results[0]->text1) && !empty( $results[0]->text2) &&  $results[0]->text1 != $results[0]->text2)
	{
		$_update_on = 1;
		$_update_title_on = 1;

		$_str1 = 'Title：'.$results[0]->text1;
		$_str2 = 'Title：'.$results[0]->text2;
	}
	elseif( !empty($results[0]->text3) && !empty( $results[0]->text4) )
	{
		$_update_on = 1;
		$_update_content_on = 1;
		$text3 = $results[0]->text3;
		$text4 = $results[0]->text4;

		$_str1 = 'Content：'.$results[0]->text3;
		$_str2 = 'Content：'.$results[0]->text4;

	}


	$_ids = kx_json_decode($results[0]->json);

	if(empty($_update_on) || empty( $_ids ))
	{
		return'Updateなし';
	}

	$remaining_count = count($_ids); // 初期残りアイテム数
	echo '残り'.$remaining_count.'件<br>';


	if( $type === 'Update_ON')
	{
		$start_time = microtime(true);
		$processed_count = 0;
	}

	if(!empty($results[0]->text6) )
		{
			$_time = $results[0]->text6 * $remaining_count;
			$_time60 = $_time / 60;

			echo round( $_time60).'分（'.round($_time).'秒）<hr>';

		}



	$str = '';
	if( !empty($results[0]->text5) )
	{
		$str .= $results[0]->text5;
		$str .= '<hr>';
	}


	$str .= '前';
	$str .= $_str1;
	$str .= '<br>';
	$str .= '後';
	$str .= $_str2;
	$str .= '<hr>';


	$s = 0;
	foreach( $_ids as $key => $id)
	{
		$s++;

		if( !empty($_update_title_on))
		{
			$_title = preg_replace('/'.$results[0]->text1.'/', $results[0]->text2 , get_the_title($id));

			$str .= '置換前：';
			$str .= get_the_title($id);
			$str .= '<br>';
			$str .= '置換後：';
			$str .= $_title;
			$str .= '<hr>';

			$_update_on = 1;
			$_update_title_on = 1;
		}

		if( !empty($_update_content_on))
		{
			$_update_content_on_update = 0;
			$post = get_post( $id );
			$_content_old =  $post->post_content;;
			$_content_new = preg_replace( $text3, $text4, $_content_old );

			if( $_content_old != $_content_new)
			{
				$_update_content_on_update = 1;
				//echo '+';
			}
			//echo '+';
			//echo $_content_new;
			//echo '<br>';
		}



		if( $type === 'Update_ON' && !empty( $_update_on ))
		{
			$processed_count = $s;

			if ($processed_count % 5 === 0) { // 5件ごとに残り時間を概算
					$elapsed_time = microtime(true) - $start_time;
					$average_time_per_item = $elapsed_time / $processed_count;
					$remaining_items = $remaining_count - $processed_count;
					$estimated_remaining_time = $remaining_items * $average_time_per_item;

					$elapsed_time = round($elapsed_time);
					$estimated_remaining_time = round($estimated_remaining_time);
					$estimated_remaining_time60 = $estimated_remaining_time / 60;
					$estimated_remaining_time60 = round($estimated_remaining_time60 , 1);

					$text5 = "処理: {$processed_count}件の時間: {$elapsed_time}秒<br>予測残り時間: {$estimated_remaining_time60}分（ {$estimated_remaining_time}秒）";
					// 必要に応じてこの情報をフロントエンドにAjaxなどで送信して表示することも可能
			}

			$_post[ 'ID' ]	= $id;

			if( !empty( $_update_title_on ) )
			{
				$_post['post_title']		= $_title;
			}

			if( !empty( $_update_content_on ) && !empty($_update_content_on_update) && $_update_content_on_update == 1 )
			{
				$_post['post_content']	= $_content_new;
			}

			wp_update_post(	$_post	);


			unset( $_ids[$key]);
			if ($s === 5)
			{
				$data = [
					'type' => 'update_posts',
					'text1' => $results[0]->text1,
					'text2' => $results[0]->text2,
					'text3' => $text3,
					'text4' => $text4,
					'text5' => $text5,
					'text6' => $average_time_per_item,
					'json'  => kx_json_encode( $_ids ),
				];
				kxdbTemp('update_posts', $data );

        echo '<script>setTimeout(function(){ location.reload(); }, 10);</script>'; // わずかな遅延を入れてリロード
        break; // ループを終了
    	}

		}

	}

	if( empty($_ids ))
	{
		$data = [
		'type' => 'update_posts',
		'text1' => $results[0]->text1,
		'text2' => $results[0]->text2,
		'text3' => null,
		'text4' => null,
		'text5' => null,
		'json'  => null,
		];
		kxdbTemp('update_posts', $data );

		$str = '';
		$str .= '前';
		$str .= $results[0]->text1;
		$str .= '<br>';
		$str .= '後';
		$str .= $results[0]->text2;
		$str .= '<hr>';
		return $str.'処理終了';
	}
	else
	{
		return $str;
	}

}





/**
 * Undocumented function
 * 不採用。2025-04-11。あまり速度変わらず。
 *
 * @return void
 */
function kxdbC_main($args, $type)
{
	$table_name = 'wp_kx_create';

	if(
		isset($type, $args['id']) && // $type と $args['id'] の存在確認
    $type === 'id' &&
    !empty($args['id']) &&
    preg_match(KxSu::get('title_preg')['worksCREATE'],get_the_title($args['id']), $matches)&&
		preg_match(KxSu::get('title_preg')['worksCREATE2'],get_the_title($args['id']))
	){
		kxdbC_ID($args['id'],$matches[1],$table_name);
	}
	elseif ($type === 'Maintenance')
	{
    $results = kx_db_Read($table_name);
    $ss = 0; // 全体の削除件数をカウント

    foreach ($results as $key1 => $row) {
        $json = kx_json_decode($row->json);

        if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
            continue; // JSONが無効な場合は次のループへ
        }

        if (is_array($json) && isset($json['ids']) && is_array($json['ids']))
				{
						$s = kxdb_filter_invalid_posts( $json, 'ids');

            if ($s !== 0) {
                kx_db_Write('update', $results[$key1], $table_name, ['json' => kx_json_encode($json)], ['title' => $row->title]);
            }
            $ss += $s; // 全体件数に加算
        }
    }

    return '★DB：'.$table_name.'：削除' . $ss;
	}

}





/**
 * 指定されたJSONキー内の投稿IDをチェックし、無効な投稿を削除する関数
 *
 * @param array &$json JSONデコードされた配列（参照渡し）
 * @param string $key_name 投稿IDが格納されたキー名 (例: 'ids')
 * @return int 削除された投稿の件数
 */
function kxdb_filter_invalid_posts(&$json, $key_name) {
	$s = 0; // 削除件数を初期化

	if (isset($json[$key_name]) && is_array($json[$key_name])) {
			foreach ($json[$key_name] as $key2 => $id) {
					$post = get_post($id);
					if (!$post || ($post->post_status !== 'publish' || $post->post_type !== 'post')) {
							unset($json[$key_name][$key2]); // 無効な投稿を削除
							$s++;
					}
			}
	}

	return $s; // 削除件数を返す
}








//* 不採用。2025-04-11。あまり速度変わらず。
function kxdbC_ID($id,$title,$table_name)
{

	$result =  kx_db_Read($table_name,['title' => $title]);

	if(!empty($result[0]))
	{
		$w_type = 'update';
		$old_result = $result[0];

		$json = kx_json_decode($result[0]->json);
		$json['ids'][] = $id;
		$json['ids'] =  array_unique($json['ids']);
		//$json = kx_array_sort_filtered($json, KxSu::get('DBjson_pickup')['Create'],'unsetON');

	}
	else
	{
		$w_type = 'insert';
		$json = [];
		$old_result = NULL;
	}

	kx_db_Write(
		$w_type,
		$old_result,
		$table_name,
		[
			'title' => $title,
			'json' => kx_json_encode( $json )
		] ,
		['title' => $title]
	);

}


//* 不採用。2025-04-11。あまり速度変わらず。
function kxdbC_Select($id)
{
	$table_name = 'wp_kx_create';
	$result =  kx_db_Read($table_name,['title' => $title]);
}






/**
 * テーブルの全件読み出しと削除処理を実行する関数
 *
 * この関数は指定されたテーブルから全件を読み出し、各`id`を使って削除処理を実行します。
 *
 * @param string $table_name 操作対象のテーブル名
 * @return void
 */
function kxdb_Maintenance($table_name) {
	// 全件読み出し
	$results = kx_db_Read($table_name);

	if (empty($results)) {
			echo $table_name.'テーブルにはデータが存在しません。<br>';
			return;
	}

	var_dump($results);

	// 各`id`について削除処理を実行
	$s=0;
	foreach ($results as $row) {
			$id = $row->id; // `id`を取得
			$delete_result = kxdb_delete_check_content($id, $table_name);

			if ($delete_result === true) {
					echo "ID: $id '：'.$row->id.'：削除<br>";
					$s++;
			} else {
					//echo "ID: $id の削除に失敗しました。<br>";
			}
	}
	return '★'.$table_name.'メンテナンス。'.$s.'件<br>';
}




/**
 * JSONデータ内の指定されたキーの投稿を確認し、削除件数を返す関数
 *
 * @param array $json JSONデコードされた配列
 * @param string $key_name チェックするキー名 (例: 'ids')
 * @param string $table_name 操作対象のテーブル名
 * @param object $row 現在の処理中の行データ
 * @param mixed $results 全データリストの参照
 * @param int $key1 処理中データのインデックス
 * @return int 削除された投稿の件数
 */
function process_json_ids(&$json, $key_name, $table_name, &$results, $key1, $row) {
	$s = 0; // 削除件数を初期化

	if (is_array($json) && isset($json[$key_name]) && is_array($json[$key_name])) {
			foreach ($json[$key_name] as $key2 => $id) {
					$post = get_post($id);
					if (!$post || ($post->post_status !== 'publish' || $post->post_type !== 'post')) {
							unset($json[$key_name][$key2]); // 無効な投稿を削除
							$s++;
					}
			}

			if ($s !== 0) {
					kx_db_Write('update', $results[$key1], $table_name, ['json' => kx_json_encode($json)], ['title' => $row->title]);
			}
	}

	return $s; // 削除件数を返す
}





/**
 * 投稿またはページを削除する関数
 *
 * この関数は、指定された投稿IDをもとに、公開状態ではない投稿やページを削除します。
 * また、投稿やページが存在しない場合もデータベースの削除処理を試みます。
 *
 * @param int $post_id 削除対象の投稿またはページのID
 * @param string $table_name 操作対象のテーブル名
 * @return bool 削除成功時はtrue、失敗時はfalse
 */
function kxdb_delete_check_content($post_id, $table_name) {
	global $wpdb; // WordPressのグローバルデータベースオブジェクト

	// 投稿またはページが存在するか確認
	$post = get_post($post_id);

	// 投稿またはページの状態にかかわらず削除処理を進める
	if (!$post || ($post->post_status !== 'publish' || $post->post_type !== 'post')) {
			// kx_db_Write関数を利用してデータベースの削除処理を実行
			$result = kx_db_Write(
					'delete',       // 削除タイプ
					null,           // $old_resultは必要なし
					$table_name,    // 対象のテーブル名
					[],             // データは不要
					['id' => $post_id], // WHERE条件
					[],             // データ型フォーマット
					['%d']          // WHERE条件の型フォーマット
			);

		return true; // 削除成功

	}

	// 公開状態の投稿やページは削除対象外
	return false; // 削除失敗
}













