# SESSION
	$_SESSION系。

## kxx（SESSION）

### count
	$_SESSION[ 'kxx' ][ 'count' ]削除済み。2025-12-23
	コンテンツのカウント。


### sc_count
	$_SESSION[ 'kxx' ][ 'sc_count' ]	削除済み。2025-12-23。

### kx_t
	$_SESSION[ 'kxx' ][ 'kx_t' ]
	$tの保存。


### DB_IDs_Memory
	$_SESSION[ 'kxx' ][ 'DB_IDs_Memory' ]

	オンの場合。
	$_SESSION[ 'kxx' ][ 'DB_IDs_Memory' ][ 'on' ] = 1

### wwx time_Memory
$_SESSION[ 'kxx' ][ 'wwx time_Memory' ]

### count_err_DB
	$_SESSION[ 'kxx' ][ 'count_err_DB' ]
	DB系ErrorのCOUNT。


## raretu（SESSION）
	$_SESSION[ 'raretu' ]


## count系（SESSION）
	$_SESSION[ 'update_c' ]++;

## $_SESSION[ 'add_new' ]

	可変数値用count
	$_SESSION[ 'add_new' ]	++;
	$kahen	= $_SESSION[ 'add_new' ];
	$kahen	= $_SESSION[ 'add_new' ];


## $_SESSION[ 'kxError' ][ 'count' ]
エラーcount


## $_SESSION['count_gnavi']
gnavi_count用

$_SESSION[ 'count_gnavi' ]	++;

$_SESSION[ 'count_gnavi' ]


# Memo
### $_SESSION['memo']['etc_chara']

## post_set
$_SESSION[ 'post_set' ][ $id ]
各ポストに使用


## TEST
$_SESSION['test']
何でもテスト用。
使ったら消す。

## color
$_SESSION['color']

色替え用・記憶用
## raretu

羅列用配列型

### sys
month_no	月表示なし。


### [989]

読者視点・count



### ...[gakunen]

## ..reference_on
reference_on	参照ON。
full抜粋モードへ	$_SESSION['reference_on']	=1;


## ..update_c
アップデートカウント

## ..h2

$_SESSION[ 'Heading' ][ id/n（ポストid、テンプレートの場合はn） ] = [
	通し番号 => [
		h_x	=>	深度
		daimei	=>	題名
	]
]

例：'<h3 id=ww'.$通し番号.'>題名</h3>';


## ..h2_count
$_SESSION[ 'Heading_count' ][　id/n ] =[
	 'raretu_count'	=>	--
	 'wwt'	=>	--
	 'wwr'	=>	--
]