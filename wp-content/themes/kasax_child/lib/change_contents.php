<?php

	//  ■■パターン選択
	//$select = 'title_only_0';
	$select = 'title_only_1';
	//$select = 'title_only_T4';
	//$select = 'time1';
	//$select = 'content_on_1';

  $set  = [
    '説明'  =>  [
			//'on' 			     			  =>	'ON' ,
      'search1'         =>  'WPの通常全文検索' ,
      'title_search'    =>  '/タイトル絞り込み・正規表現・必須・無いと不機能・2020-10-26/',
      'title_replace_1' =>  '/置換対象・正規表現/',		//	注意[.]c≫
	    'title_replace_2' =>  '置換後の文字列・中身が無いとエラー',
    ],

		'title_only_0'  =>  [	//便利タイプ
			//'on' 			 			  =>	'ON' ,
			'search0'         =>  '∮≫登場人物・人名' ,
      'title_replace_2' =>  '∮≫人名',
		],


		'title_only_1'  =>  [
			//'on'	     			  =>	'ON' ,
      'search1'         =>  '∬10≫0構成≫題材' ,
      'title_search'    =>  '/∬10≫0構成≫題材≫/',
      'title_replace_1' =>  '/(∬10≫0構成≫題材≫.*〈Idea)〉/',
			'title_replace_2' =>  '$1+〉',
		],


    'title_only_1c'  =>  [
			//'on'	     			  =>	'ON' ,
      'search1'         =>  '∬10≫c' ,
      'title_search'    =>  '/∬10≫c(\d\w{1,}\d)≫＼c(\d\w{1,}\d)≫〇Com/',
      'title_replace_1' =>  '/∬10≫c(\d\w{1,}\d)≫＼c(\d\w{1,}\d)≫〇Com≫(.*$)/',
			'title_replace_2' =>  '∬10≫c$1≫2構成≫c$2≫$3',
		],

		'title_only_2c'  =>  [
			//'on' 			     			  =>	'ON' ,
			'search1'         =>  '∬10≫c' ,
			'title_search'    =>  '/∬10≫c(\d\w{1,}\d)≫2構成≫〇/',
      'title_replace_1' =>  '/∬10≫c(\d\w{1,}\d)≫2構成≫〇/',
	    'title_replace_2' =>  '∬10≫c$1≫2構成≫〇',
		],

		'title_only_9'  =>  [
			//'on' 			     			  =>	'ON' ,
      'search1'         =>  '∬10≫c' ,
      'title_search'    =>  '/∬.*≫c.*≫＼c.*概要/',
      'title_replace_1' =>  '/∬10≫c(\d\w{1,}\d)≫＼c(\d\w{1,}\d)≫00＠概要/',
	    'title_replace_2' =>  '∬10≫c$1≫＼c$2≫〇Com≫B4',
    ],

    'title_only_T4'  =>  [
			//'on'	     			  =>	'ON' ,
      'search1'         =>  '≫芸術・作品≫分類≫登場人物≫ハードボイルド' ,
      'title_search'    =>  '/(σ|γ|Β|δ)≫芸術・作品≫分類≫登場人物≫ハードボイルド/',
      'title_replace_1' =>  '/(σ|γ|Β|δ)≫芸術・作品≫分類≫登場人物≫ハードボイルド/',
	    'title_replace_2' =>  						'$1≫芸術・作品≫分類≫登場人物≫属性≫ハードボイルド',
		],

		'title_only_etc'  =>  [
			//'on' 			     			  =>	'ON' ,
      'search1'         =>  '∮≫' ,
      'title_search'    =>  '/∮≫/',
      'title_replace_1' =>  '/∮≫(世界観|出来事)/',
	    'title_replace_2' =>  '∮≫舞台',
		],

		'content_on_1'  =>  [
			//'on' 			     			  =>	'ON' ,
			'content_on'					=>	'ON',
      'search1'         		=>	'∬10≫' ,
      'title_search'    		=>	'/∬10≫/',
			'content_replace_1'		=>	'/〚(謎|理由|オチ)〛/',
			'content_replace_1d'	=>	'/⊕/',	//拒絶・必須・⊕
			'content_replace_2'		=>	'$1＿',
		],


		'time1'  =>  [
			//'on' 			     			  =>	'ON' ,
      'search1'         		=>	'∫≫' ,
      'title_search'    		=>	'/≫/',
			'content_on'					=>	'ON',
			'content_replace_1'		=>	'/\‘([0-1]\d)(\d{2,})(\d{2,})\'/',	//‘060327D27'
			'content_replace_1d'	=>	'/⊕/',	//拒絶・必須・⊕
			'content_replace_2'		=>	'20$1-$2-$3',
		],

		'time2'  =>  [
			//'on' 			     			  =>	'ON' ,
      'search1'         		=>	'∫≫' ,
      'title_search'    		=>	'/≫/',
			'content_on'					=>	'ON',
			'content_replace_1'		=>	'/\‘([0-1]\d)\/(\d{2,})\/(\d{2,})(.*?)\'/',
			'content_replace_1d'	=>	'/⊕/',	//拒絶・必須・⊕
			'content_replace_2'		=>	'20$1-$2-$3$4',
		],

		'time3'  =>  [
			//'on' 			     			  =>	'ON' ,
			'search1'      			  =>	'∫≫' ,
      'title_search'   		  =>	'/≫/',
			'content_on'					=>	'ON',
			'content_replace_1'		=>	'/\‘([0-1]\d)_(\d{2,})_(\d{2,})(.*?)\'/',
			'content_replace_1d'	=>	'/⊕/',	//拒絶・必須・⊕
			'content_replace_2'		=>	'20$1-$2-$3$4',
		],

		'time4'  =>  [
			//'on' 			     			  =>	'ON' ,
			'search1'      			  =>	'∫≫' ,
      'title_search'   		  =>	'/≫/',
			'content_on'					=>	'ON',
			'content_replace_1'		=>	'/\‘([0-1]\d)(\d{2,})(\d{2,})(.*?)\'/',
			'content_replace_1d'	=>	'/⊕/',	//拒絶・必須・⊕
			'content_replace_2'		=>	'20$1-$2-$3$4',
		],

		'time192'  =>  [
			//'on' 			     			  =>	'ON' ,
      'search1'         		=>	'∫≫' ,
      'title_search'    		=>	'/≫/',
			'content_on'					=>	'ON',
			'content_replace_1'		=>	'/\‘(9\d)\/(\d{2,})\/(\d{2,})(.*?)\'/',
			'content_replace_1d'	=>	'/⊕/',	//拒絶・必須・⊕
			'content_replace_2'		=>	'19$1-$2-$3$4',
		],

		'time194'  =>  [
			//'on' 			     			  =>	'ON' ,
			'search1'      			  =>	'∫≫' ,
      'title_search'   		  =>	'/≫/',
			'content_on'					=>	'ON',
			'content_replace_1'		=>	'/\‘(9\d)(\d{2,})(\d{2,})(.*?)\'/',
			'content_replace_1d'	=>	'/⊕/',	//拒絶・必須・⊕
			'content_replace_2'		=>	'19$1-$2-$3$4',
		],

	];


  if( $set[$select] ):

		extract(  $set[$select] );

		$arr = $set[$select];

	else:

		return	'■エラー■select無し■';

	endif;

	//便利タイプ
	if(	$search0	):

		$search1         =  $search0;
		$title_search    =  '/'.$search0.'/';
		$title_replace_1 =  '/'.$search0.'/';

		$arr[ 'search1' ] 		 		= $search1;
		$arr[ 'title_search' ] 		= $title_search;
		$arr[ 'title_replace_1' ]	= $title_replace_1;

	endif;

	if(	$type	):  //offタイプ。ショートコード由来。

		$on										= '';
		$ppp									= 10;

	else:

		$ppp									= 3;

	endif;

	$arr[ 'on' ] 		 		= $on;
	$arr[ 'ppp' ] 	 		= $ppp;



	//■■■■■
	//　■■■　一段目

	echo '+SELECTOR：'.$select.'<br>';
	echo '+一段目検索文字：'.$search1.'<br>';

	echo kx_ChangePOST_Form( $arr );

	return;