<?php
// .【上】
// .PHPオブジェクト指向テスト
//https://qiita.com/mpyw/items/41230bec5c02142ae691
class Robot {

	private $name = '';
	private $title99 = 'タイトル99';

	public function setName($name) {
			$this->name = (string)filter_var($name);
	}
	public function getName() {
			return $this->name;
	}

	public function gettitle99($aaa) {
			return $this->title99.$aaa;
	}

}


add_shortcode( 'test','shortcode_test' );
/**
 * ショートコードテスト・TEST
 *
 * @param [type] $atts
 * @return void
 */
function shortcode_test( $atts ) {
	extract( shortcode_atts( array(
			'id'     => '',
			'text'     => '',
	), $atts ) );
	echo 'TEST_SC';


$atts = shortcode_atts(
        array('file' => 'E:/0/00/Seisaku/S0000-Ksy_0000.txt'),
        $atts,
        'plainfile'
    );

    $file = $atts['file'];

    if (!file_exists($file)) {
        return "<p>ファイルが見つかりません: {$file}</p>";
    }

    // ファイル内容を読み込み
    $content = file_get_contents($file);
		$content = mb_convert_encoding($content, 'UTF-8', 'SJIS-win');
		//echo $content;

		$content = preg_replace('/^\.\s*/m', '## ', $content);
		$parsedown = new KxParsedown();
			$parsedown->setBreaksEnabled(true);
			$content = $parsedown->text($content);

		//$content = kx_change_any_texts(	$content	);

		$content = kx_session_raretu_Heading_content($content);


    // HTMLエスケープして安全に表示（そのままテキスト出力）
		return  $content ;
		//return  esc_html($content) ;
    //return '<pre>' . esc_html($content) . '</pre>';


	$array= ( kx_CLASS_kxx(
	[
		't' 				=>	90,
		'cat'				=>	1162,
		'search'		=>	'来歴≫',
		'tag'				=>	'来歴',//'c' . $this->kxtpS1[ 'kxtt' ][ 'character_number' ],
		//'cat_not'		=>	'1191',
		'tag_not'		=>	'≫来歴≫',
		//'ppp'		=>	6,
		//'db_input'	=>	1,
	] ,'array_ids')	);

	//print_r($array['array_ids']);

	echo '<hr>';
	//echo count($array['array_ids']);

	echo '<hr>';
	$s = 0;
	$max_reload = 20;
	foreach( $array['array_ids'] as $id){

		$s++;

		//$post = get_post($id);
		//echo get_the_title( $id ).'<br>';
		//$current_post = get_post( $post_id, ARRAY_A ); // 元の投稿データを取得

		$my_post = array(
			'ID'						=> $id,
			'post_title'		=> get_the_title( $id ),
			//'post_content'	=> $_post_content,
		) ;

		//アップデート
		wp_update_post( $my_post ) ;

		//wp_insert_post( $post_data );

		if ($s >= $max_reload) {


			echo "<script>  	window.location.reload();		</script>";

			break; // 5回でループを終了
			exit(); // スクリプトを終了
		}

		/*
		$my_post = array(
			'ID'						=> $id,
			'post_title'		=> get_the_title( $id ),
			//'post_content'	=> $_post_content,
		) ;

		//アップデート
		//wp_update_post( $my_post ) ;




		$_new_title = str_replace( '∬13' ,'∬14' , get_the_title( $id ) );
		$_new_title = str_replace( 'Sys0138' ,'Sys0148' , $_new_title );

		echo $_new_title.'<br>';



		preg_match( '/∬14≫c\d\w{1,}\d/' , $_new_title , $matches);
		echo $matches[0].'<br>';

		$args1 = array(
			'title' => $matches[0], // タイトルで検索
			'cat' => 1169,
			'post_type' => 'post', // 投稿タイプを指定 (post, page, カスタム投稿タイプなど)
			'posts_per_page' => 1 // 1件だけ取得すれば良い
		);

		$query = new WP_Query($args1);

		if ($query->have_posts()) {
			// 投稿が存在する場合
			echo 'キャラクターが存在します<br>';

			$args2 = array(
				'title' => $_new_title, // タイトルで検索
				'cat' => 1169,
				'post_type' => 'post', // 投稿タイプを指定 (post, page, カスタム投稿タイプなど)
				'posts_per_page' => 1 // 1件だけ取得すれば良い
			);

			$query = new WP_Query($args2);

			if ($query->have_posts()) {
				// 投稿が存在する場合
				echo '投稿は存在します。';
			} else {
				// 投稿が存在しない場合
				echo '投稿は存在しません。新規作成します。';
				//新規追加
				$post = [
					'post_title'  	=> $_new_title,
					'post_status'   => 'publish',
					'post_type'     => 'post',
					'post_content'	=> $post->post_content,
				] ;

				//wp_insert_post( $post );
				unset($post);

			}

		} else {
			echo '<span style="color:red">キャラクターが存在しません</span><br>';
		}

		echo '<hr>';
		*/
	}






}



/**
 * 本文アップデート。
 *
 * @return void
 */
function kxTEST_search_UPDATE(){

	$args = [
		'cat'								=>	76 ,
		//'tag'							=>	'c209',
		'orderby'        		=>	$orderby,
		'order'       			=>	$order,
		'posts_per_page'		=>	-1,
		'post_type'					=>	'post',	//投稿ページのみ

		's'									=>	"\n　",
		'category__not_in'	=>	$category__not_in,
		'tag__not_in' 			=>	$tag_not_ids,
	];
	$the_query = new WP_Query( $args );

	// ■The Loop■

	$s=0;
	$s2=0;
	while ( $the_query->have_posts() ) :

		$s2++;

		$the_query->the_post();

		$post= get_post( get_the_ID() );

		if( preg_match( '/\n　/' , $post->post_content ) ):

			$s++;

			$on = 1;

			$ret[] = get_the_ID();

			//echo get_the_ID().'<br>';

			$link 			= get_permalink( get_the_ID() );
			$edit_link	= get_edit_post_link( get_the_ID() );

			// ..表示開始
			$ret = '';
			$ret .='<div>';

			$ret .='<spna class="__margin_bottom4 __margin_top5 '.$c_text1.'">';
			$ret .='<a href="' . $link . '">' . get_the_ID();
			$ret .='</a>';
			$ret .='</spna>';

			$ret .='<spna class="__xsmall __margin_left25 '.$edit_class.'">';
			$ret .='<a href="' . $edit_link . '">Edit';
			$ret .='</a>';
			$ret .='</spna>';

			$ret .='</div>';

			echo $ret;
			unset($ret);


			$my_post = array(
				'ID'					=> get_the_ID(),
			) ;
			wp_update_post( $my_post ) ;


			if( $s > 3):

				break;

			endif;


		endif;

	endwhile;

	echo $s2.'count：';

	if( $on) :

		echo
		'<head>
			<meta http-equiv="refresh" content="0; URL=">
		</head>';

	else:

		echo 'END';

	endif;

}



// ..コピーテスト成功版
add_shortcode('showcatposts', 'show_Cat_Posts_func');
function show_Cat_Posts_func($atts) {
	global $post;
	$ret = "";

	extract(shortcode_atts(array(
		'cat' => 1, // デフォルトカテゴリーID = 1
		'show' => 3 // デフォルト表示件数 = 3
	), $atts));

	$cat = rtrim($cat, ",");
	// get_postsで指定カテゴリーの記事を指定件数取得
	$args = array(
		'cat' => $cat,
		'posts_per_page' => $show
	);
	$my_posts = get_posts($args);

	// 上記条件の投稿があるなら$retに出力、マークアップはお好みで
	if ($my_posts) {
		// カテゴリーを配列に
		$cat = explode(",", $cat);
		$catnames = "";
		foreach ($cat as $catID) : // カテゴリー名取得ループ
			$catnames .= get_the_category_by_ID($catID).", ";
		endforeach;
		$catnames = rtrim($catnames, ", ");

		$ret .= '<aside class="showcatposts">'."\n";
		$ret .= '<h2 class="showcatposts-title">カテゴリー「'.$catnames.'」'."の最新記事（".$show."件）</h2>\n";
		$ret .= '<ul class="showcatposts-list">'."\n";
		foreach ($my_posts as $post) : // ループスタート
			setup_postdata($post); // get_the_title() などのテンプレートタグを使えるようにする
			$ret .= '<li id="post-'.get_the_ID().'" '.get_post_class().'><a href="'.get_permalink().'">'.get_the_title()."</a></li>\n";
		endforeach; // ループ終わり
		$ret .= "</ul>\n";
		$ret .= "</aside>\n";
	}
	// クエリのリセット
	wp_reset_postdata();
	return $ret;
}



// .test2 開閉テストShortCODE
add_shortcode('kasax_test2', 'kasax_test2');
function kasax_test_kaihei2($atts, $content=null) {
$str=<<<eot
<!-- 折り畳み展開ポインタ -->
<div onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none')?'block':'none';">
<a style="cursor:pointer;">▼ クリックで展開</a>
</div>
<!--// 折り畳み展開ポインタ -->
<!-- 折り畳まれ部分 -->
<div id="open" style="display:none;clear:both;">
<!--ここの部分が折りたたまれる＆展開される部分になります。
自由に記述してください。-->
</div>
<!--// 折り畳まれ部分 -->
eot;
	return $str;
}
// .■java　読み込み



/*
// ..テスト系js-test_js
add_action( 'wp_enqueue_scripts', 'kasax_javascript_test' );
function kasax_javascript_test() {

	wp_enqueue_script(
		'test_js2',
		get_stylesheet_directory_uri().'/../kasax_child/js/test_js2.js',
		 array( 'jquery' ),
		'1.0',
		true
	);
	$ex_array1 = array(
	        'text'	=> '日本語入力テスト',
					'url'		=> 'Google+A+',
					'idd'		=> 'kx_id4',
	    );
	wp_localize_script( 'test_js2', 'ex_js2', $ex_array1 );

}
*/



// ..test 成功中 my_script
$dummy_option		= update_option( 'example_value', 'hello world+du1' );
$dummy_option2	= update_option( 'example_value2', 'color:red;' );
//$dummy_option3	= update_option( 'example_value3', 'hello world+du3' );


/*
add_action( 'wp_enqueue_scripts', 'my_load_scripts' );
function my_load_scripts() {
	$dummy_option		 = get_option( 'example_value' );
	$dummy_option2	 = get_option( 'example_value2' );
	$dummy_option3	 = get_option( 'example_value3' );
	$dummy_option4	 = get_option( 'example_value4' );
	wp_enqueue_script(
	'my_script', get_template_directory_uri() . '/../kasax_child/js/test_js.js',
	 array( 'jquery' ) );
	wp_localize_script( 'my_script', 'my_script_vars', array(
		'val'		=> $dummy_option,
		'css'		=> $dummy_option2,
		't185'	=> $dummy_option3,
		'test'	=> $dummy_option3,
		'test2'	=> ['鯖','鰹','鰯'],
//		'test3'	=> [1,185,132],
		'test3'	=> $dummy_option4,
	)
	);
}
	*/




// ..成功中
add_action( 'wp_head', 'ex_array' );
function ex_array() {
    $ex_array = array(
        'text' => 'example_te66xt',
        'url'   => 'https://memocarilog.info/'
    );
    $ex_array = json_encode( $ex_array, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );
	echo '<script type="text/javascript">var ex_js = ' .$ex_array. '</script>'.PHP_EOL;
//	echo '<span id="hoge" style="display:none">aaaaaa</span>';

}


// ..旧
function my_scripts_method() {
  wp_enqueue_script(
    'test',
    get_stylesheet_directory_uri().'/../kasax_child/js/test.js',
    array( 'jquery' ),
    '1.0',
    true
  );

}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );




add_action( 'wp_enqueue_scripts', 'my_scripts_method2' );
/**
 * Undocumented function
 *
 * @return void
 */
function my_scripts_method2() {
  wp_enqueue_script(
    'javascript',
    get_stylesheet_directory_uri().'/js/javascript.js',
    array( 'jquery' ),
    '1.0',
    true
  );
}




//add_action( 'wp_enqueue_scripts', 'kasax_hidden02' );
/**
 * test java
 *
 * @return void
 */
/*
function kasax_hidden02() {
  wp_enqueue_script(
    'kasax_hidden_test',
    get_stylesheet_directory_uri().'/../kasax_child/js/kasax_hidden_test.js',
    array( 'jquery' ),
    '1.0',
    true
  );
}
*/




/**
 * Undocumented function
 *
 * @param [type] $atts
 * @param [type] $content
 * @return void
 */
function kasax_test_java1($atts, $content=null) {
$str=<<<eot
<script type="text/javascript">
alert("JavaScriptも実行できます。");
</script>
eot;
	return $str;
}


?>