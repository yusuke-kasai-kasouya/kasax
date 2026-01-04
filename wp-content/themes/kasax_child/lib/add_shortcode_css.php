<?php
/**
 * css
 */

	if(	$t	== 'd'	)	//■ ダークモード
	{
		$name 				= 'ダーク・モード';
		$bg_body 			= 'hsl(0,0%,5%)';
		$bg_main 			= 'hsl(0,0%,7.5%)';
		$bg_usui1 		= '#222';

		$color_main				= 'hsl(0,0%,85%)';
		$color_inversion	= '#111';
		$color_decoration_kosa1		= 75;

		$color_link				= 'hsla(240,100%,80%,1)';
		$color_a_violet		= 'hsla(300,100%,80%,1)';

		$text_shadow_n	= 'hsla(0,100%,100%,.25)';
		//$text_shadow_i	= 'hsla(0,100%,0%,1)';
	}
	else
	{
		//■ normal
		$name 				= 'ノーマル・モード';
		$bg_body 				= '#f7f8f8';
		$bg_main 				= '#f8f8f8';
		$bg_usui1 			= '#eee';

		$color_main				= '#000';
		$color_inversion	= '#fff';
		$color_decoration_kosa1		= 40;

		$color_link				= 'hsla(240,100%,27%,1)';
		$color_a_violet		= 'hsla(300,100%,30%,1)';

		$text_shadow_n		= 'hsla(0,100%,0%,.25)';
	}

	// 色分け系
	$kakudo =[0,30,45,60,90,120,135,150,180,210,225,240,270,300,315,330];

	//■シャドウ型
	$shadow1	= [
		[15,40],
		[50,30],
		[50,50],
		[50,60],
		[50,70],
		[50,80],
	];

	$shadow2	= [
		'1px 1px 2px,',
		'-1px 1px 2px,',
		'1px -1px 2px,',
		'-1px -1px 2px,',
		'2px -0px 2px;',
	];

	$_sd_ue_px ='-1px';	//Shadow
	$_sd_sita_px ='2px';	//Shadow

?>

/*php出力<?php echo $name; ?>*/
.__kxol_box,
body {
	color: <?php echo $color_main; ?>;
}

body,
.__kxol_box,
::-webkit-scrollbar-track {
	background-color: <?php echo $bg_body; ?>;
}

::-webkit-scrollbar-thumb {
	background: <?php echo $color_link; ?>;
}


<?php //■■■ 文字色関係 ?>

a.__color_normal,
a:link.__color_normal,
.__color_normal a,
.__color_normal a:link,
.__color_normal{
	color: <?php echo $color_main; ?>;
}

.__a_violet_kx a,
.__a_violet_kx a:link,
.__a_violet_kx a:visited,
.__a_violet_kx{
	color: <?php echo $color_a_violet; ?>;
}

.__hidden_box .option-input01,
.__hidden_box .option-input02,
.__a_inversion a,
.__a_inversion a:link,
.__a_inversion a:visited,
.__a_inversion,
.__color_inversion a:link,
.__color_inversion a,
a.__color_inversion,
a:link.__color_inversion,
.__color_inversion{
	color: <?php echo 	$color_inversion; ?>;
}


.__text_shadow_normal{
	text-shadow:
	<?php echo $text_shadow_n; ?> 0px 0px 1px,
	<?php echo $text_shadow_n; ?> 0px 0px 2px,
	<?php echo $text_shadow_n; ?> 0px 0px 4px,
	<?php echo $text_shadow_n; ?> 1px 1px 0px,
	<?php echo $text_shadow_n; ?> -1px 1px 0px,
	<?php echo $text_shadow_n; ?> 1px -1px 0px,
	<?php echo $text_shadow_n; ?> -1px -1px 0px;
}


<?php //■■■ 文字装飾関係 ?>

<?php //■■■ 【】墨付きカッコ。青系 ?>
.__kakko_sumi{
	color:			hsla(240,100%,<?php echo 	$color_decoration_kosa1; ?>%,1);
	font-weight:	bold;
}


<?php //■■■ background-color main ?>
.__background_normal,
hr,
hr._kx,
.__hr_more,
.content-area,
.__navi_back_l2,
.__error_main_red,
.__error_main_blue,
.__error_main_darkviolet  {
  background-color: <?php echo $bg_main; ?>;
}

pre
{
  background-color: <?php echo $bg_usui1; ?>;
}

<?php //■■■リンク ?>
a:link,
a:visited {	color:<?php echo $color_link; ?>;}



.__hr_more,
hr._kx,
hr {
	border-bottom: 1px solid <?php echo $bg_usui1; ?>;
}




.__hr_more  {
  border-top: 10px solid <?php echo $bg_main; ?>;
}



<?php

	//　■　margin/padding　■　左右  ■
	foreach (range(1,40) as $_n) :
		echo '.__margin_left'.$_n.'{margin-left:'.$_n.'px;}';
		echo '.__margin_right'.$_n.'{margin-right:'.$_n.'px;}'."\n";
		echo '.__padding_left'.$_n.'{padding-left:'.$_n.'px;}';
		echo '.__padding_right'.$_n.'{padding-right:'.$_n.'px;}'."\n";
	endforeach;

		// ...上下
	foreach (range(1,15) as $_n) :
		echo '.__margin_top'.$_n.'{margin-top:'.$_n.'px;}';
		echo '.__margin_top-'.$_n.'{margin-top:-'.$_n.'px;}';	//マイナス
		echo '.__margin_bottom'.$_n.'{margin-bottom:'.$_n.'px;}'."\n";
	endforeach;

	// ■■■色分け系■■■
	foreach ($kakudo as $_n) :
		echo	'.__color_'			.$_n.	'{ color:hsla('.$_n.',100%,33%,1);}'."\n";
		echo	'.__color_50_'	.$_n.	'{ color:hsla('.$_n.',100%,50%,1);}'."\n";
		echo	'.__color_42_'	.$_n.	'{ color:hsla('.$_n.',100%,42%,1);}'."\n";
		echo	'.__color_33_'	.$_n.	'{ color:hsla('.$_n.',100%,33%,1);}'."\n";
		echo	'.__color_25_'	.$_n.	'{ color:hsla('.$_n.',100%,25%,1);}'."\n";
		echo	'.__bg_100_98_'	.$_n.	'{background-color:hsla('.$_n.',100%,98%,1);}';
		echo	'.__bg_100_97_'	.$_n.	'{background-color:hsla('.$_n.',100%,97%,1);}';
		echo	'.__bg_100_95_'	.$_n.	'{background-color:hsla('.$_n.',100%,95%,1);}';
		echo	'.__bg_100_90_'	.$_n.	'{background-color:hsla('.$_n.',100%,90%,1);}';	//2018/11/11
		echo	'.__bg_100_80_'	.$_n.	'{background-color:hsla('.$_n.',100%,80%,1);}';
		echo	'.__bg_100_50_'	.$_n.	'{background-color:hsla('.$_n.',100%,50%,1);}';
		echo	'.__bg_100_33_'	.$_n.	'{background-color:hsla('.$_n.',100%,33%,1);}';
		echo	'.__bg_100_25_'	.$_n.	'{background-color:hsla('.$_n.',100%,25%,1);}';
		echo	'.__bg_075_25_'	.$_n.	'{background-color:hsla('.$_n.',75%,25%,1);}';
		echo	'.__bg_100_50_' .$_n . 'u50{background-color:hsla(' . $_n .',100%,50%,.25);}';
		echo	'.__border_lur_'.$_n.	'{';
		echo	'border-bottom-width:0px;border-top-width:1px;border-left-width:2px;';
		echo	'border-right-width:2px;border-style:solid;border-color:hsla('.$_n.',50%,50%,1);';
		echo	'}';

		foreach($shadow1	as $_v1):

			echo	'.__shadow_'.$_v1[0].'_'.$_v1[1].'_'.$_n.'{';
			echo	'color:'.$color_inversion.';';
			echo	'text-shadow:';

			foreach($shadow2	as $_v2):

				echo	'hsla('.$_n.','.$_v1[0].'%,'.$_v1[1].'%,1) '.$_v2;

			endforeach;

			echo	'font-weight:bold;';
			echo	'}';

		endforeach;

		echo	"\n";

		// ...border
		echo	'.__border_'.$_n.'	{border:1px solid hsla('.$_n.',50%,50%,1);}';
		echo	'.__border_2_'.$_n.'	{border: 2px ridge hsla('.$_n.',100%,50%,1);}';
		echo	"\n";

		// 色分け

		$_iro_base = kx_CLASS_kxcl( 'base' , 'array' );
		foreach( $_iro_base as $_k => $iro_b ):
			if ( $_k =='無し' )
			{
				//
			}
			else
			{
				$_s	 = $iro_b[ '彩度' ];
				$_m	 = $iro_b[ '明度' ];
				$_u	 = $iro_b[ '薄型' ];
				echo kx_css_irowake($_n,$_s,$_m,$_u,$_sd_ue_px,$_sd_sita_px,$bg_main);
			}
		endforeach;
	endforeach;

	$_n	 = 0 ;
	$_s	 = $_iro_base[ '無し' ][ '彩度' ];
	$_m	 = $_iro_base[ '無し' ][ '明度' ];
	$_u	 = $_iro_base[ '無し' ][ '薄型' ];
	echo kx_css_irowake($_n,$_s,$_m,$_u,$_sd_ue_px,$_sd_sita_px,$bg_main);
	echo	"\n";


	$_anchor ='';
	for ($i = 0; $i <= 400; $i++) :
		$_anchor	.= '#anchor'.$i.'	,';
	endfor;
	$_anchor = rtrim($_anchor, ',');
	echo	$_anchor.'{	margin-top:-150px;  padding-top:150px; } ';
	echo	"\n";

	$absolute ='';
	for ($i = 0; $i <= 400; $i++) :
		$absolute	.= '.__absolute_js'.$i.'	,';
	endfor;
	for ($i = 1000; $i <= 1400; $i++) :
		$absolute	.= '.__absolute_js'.$i.'	,';
	endfor;
	$absolute = rtrim(	$absolute	, ',');
	echo	$absolute.'{	position:absolute; }';
	echo	"\n";

	$textarea	='';
	for ($i = 0; $i <= 400; $i++) :
		$textarea	.= '#textarea'.$i.' ,';
	endfor;
	for ($i = 1000; $i <= 1400; $i++) :
		$textarea	.= '#textarea'.$i.' ,';
	endfor;
	$textarea = rtrim(	$textarea	, ',');

	echo	$textarea."\n".'{max-height:41em;} ';//min-height:250px;
	echo	"\n";

?>

/*php出力<?php echo $name; ?>*/