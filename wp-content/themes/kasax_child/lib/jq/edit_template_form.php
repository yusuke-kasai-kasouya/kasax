<?php
/**
 *エディター用。
 *
 */

	//$this->kxedS1[ 'type' ] = NULL;
 	if(	!empty( $this->kxedS1[ 'kx30_on' ] ) )
	{
		$this->kxedS1[ 'type' ]	  = 'kx30';		//※※※廃止予定?※※※
		$this->kxedS1[ 'id_js' ]	= $this->kxedOUT[ 'id' ];
	}


	if( !empty( $_SESSION[ 'reference_on' ] ) ) //	$_SESSION[ 'reference_on' ]
	{
		$more	= 1;
	}
	else
	{
		$more = NULL;
	}
?>

<script>

	jQuery(function($){

		/**
		 * 本文データの更新。保存時。
		 */
		$('._j_s<?php echo $this->kxedS1[ 'id_js' ] . '_'.$this->kxedOUT[ 'kahen' ]; ?>').on('click',function(){
			$("#loader").show();

			var $content = $('.displayArea3<?php echo $this->kxedS1[ 'id_js' ]; ?>');

			$content.delay(125).fadeOut(600, function() {
				getPage('wp-content/themes/kasax_child/lib/php/p_hyouji.php?id=<?php echo $this->kxedOUT[ 'id' ]; ?>&more=<?php echo $more;	?>&type=<?php echo $this->kxedS1[ 'type' ] ?>&delay=0');
				//※※※$line1廃止予定※※※
			});

			function getPage(elm){

				$.ajax({

					type: 'post',
					url: elm,
					dataType: 'html',
					data: {
						id: $('.id').val(),
					},

					success: function(data){
						$("#loader").fadeOut();
						$content.html(data).fadeIn(600);
					},

					error:function() {
						alert('問題が発生しました。');
					}

				});
			}

		});


		<?php
			if( !empty( $this->kxedS1[ 'ghost_on' ] )	)
			{
				$title_edit	= $this->kxedOUT[ 'title_end_g' ];
			}
			else
			{
				$title_edit	= $this->kxedOUT[ 'title_end' ];
			}
		?>


		/**
		 * ページ内同一エディット共通化。一度だけ。
		 * 現在不使用。2021-08-18
		 */

		/*
		$('._j_s<?php echo $this->kxedS1[ 'id_js' ] . '_'.$this->kxedOUT[ 'kahen' ]; ?>').on('click',function(){

		target_t = document.getElementsByClassName("_j_b_e<?php echo $this->kxedOUT[ 'id' ]; ?>");

		for (var i = 0; i < target_t.length; i++) {

			target_t[i].innerText = document.forms.f<?php echo $this->kxedOUT[ 'kahen' ]; ?>.textarea<?php echo $this->kxedOUT[ 'kahen' ]; ?>.value;

		}

		});
		*/





		/**
		 * タイトル置換・コンテンツ内
		 */
		$('._j_s<?php echo $this->kxedS1[ 'id_js' ] . '_'.$this->kxedOUT[ 'kahen' ]; ?>').on('click',function(){

			target_t = document.getElementsByClassName("js_target_title<?php echo $this->kxedS1[ 'id_js' ] . '_'.$title_edit; ?>");

			for (var i = 0; i < target_t.length; i++) {
				<?php if(	!empty( $_SESSION[ 'reference_on' ] ) ): ?>

					//target_t[i].innerText =  '🔴更新🔴';
					target_t[i].innerText = '✅' + document.forms.f<?php echo $this->kxedOUT[ 'kahen' ]; ?>.titlearea<?php echo $this->kxedOUT[ 'kahen' ]; ?>.value + '(ref)🔴';

				<?php elseif( !empty( $this->kxedS1[ 'ghost_on' ] ) ): ?>

					target_t[i].innerText = '✅' + document.forms.f_g<?php echo $this->kxedOUT[ 'kahen' ]; ?>.titlearea_g<?php echo $this->kxedOUT[ 'kahen' ]; ?>.value + ' 🟣';

				<?php else: ?>

					target_t[i].innerText = '✅' + document.forms.f<?php echo $this->kxedOUT[ 'kahen' ]; ?>.titlearea<?php echo $this->kxedOUT[ 'kahen' ]; ?>.value + ' 🟢';

				<?php endif; ?>

			}

		});


		<?php if(	$this->kxedS1[ 'id_b_js' ] != $this->kxedS1[ 'id_js' ] ): ?>

			/**
			* outline置換
			*/
			$('._j_b_s<?php echo $this->kxedS1[ 'id_b_js' ] . $this->kxedOUT[ 'kahen' ]; ?>').on('click',function(){

				target_t = document.getElementsByClassName("js_target_title<?php echo $this->kxedS1[ 'id_b_js' ] . '_'.$title_edit; ?>");

				for (var i = 0; i < target_t.length; i++) {
					<?php if( $this->kxedS1[ 'ghost_on' ] ): ?>

						target_t[i].innerText = '✅' + document.forms.f_g<?php echo $this->kxedOUT[ 'kahen' ]; ?>.titlearea_g<?php echo $this->kxedOUT[ 'kahen' ]; ?>.value + '🟪';


					<?php else: ?>

						target_t[i].innerText = '✅' + document.forms.f<?php echo $this->kxedOUT[ 'kahen' ]; ?>.titlearea<?php echo $this->kxedOUT[ 'kahen' ]; ?>.value + '🟩';

					<?php endif; ?>

				}

			});

		<?php endif; ?>





	});



	//エディットボタンを押したときの反応。
	jQuery(function ($) {

		$("._op_a<?php echo $this->kxedOUT[ 'kahen' ] ?>").click(function () {
			$("#_op_a<?php echo $this->kxedOUT[ 'kahen' ] ?>").next().slideToggle(100);
		});

		//■■■　　編集用contents読み込み　■■■
			$(document).on('click', '._js_edit<?php echo $this->kxedOUT[ 'id' ]; ?> a', function(event) {


				//処理のブロック
				event.preventDefault();

				//.gnavi aのhrefにあるリンク先を保存
				var link = $(this).attr("href");

				$content.fadeOut(1, function() {

					getPage(link);

				});

				//今のリンク先を保存
				//lastpage = link;


				// 遷移可能であればローディング表示させる
				$("#loader").show();

			});

			//ページを表示させる場所の設定
			//var $content = $('.displayArea73334');
			var $content = $('.displayArea_edit<?php echo $this->kxedOUT[ 'kahen' ] . $this->kxedOUT[ 'id' ]; ?>');
			//

			//初期表示
			var lastpage = "";

			//ページを取得してくる
			function getPage(elm){

				$.ajax({

					type: 'post', // getかpostを指定(デフォルトは前者)
					url: elm,
					dataType: 'html',

					//dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
					data: { // 送信データを指定(getの場合は自動的にurlの後ろにクエリとして付加される)

						id: $('.id').val(),

					},

					success: function(data){

						$("#loader").fadeOut();

						$content.html(data).fadeIn(125);//絵文字対応前。#2025-02-06

						//var html = data.content; // 絵文字を含むコンテンツ。ただし、概要で改行が無効化してしまう。2025-02-06
      			//$content.html(html).fadeIn(125);


					},

					error:function() {
						alert('問題が発生しました。');
					}

				});
			}
		//■■■　　編集用contents読み込み　■■■


		});



		/**
		 * 高さ系・追従
		 */
		jQuery(function() {

			var $textarea = jQuery('#textarea<?php echo $this->kxedOUT[ 'kahen' ]; ?>');
			var lineHeight = parseInt($textarea.css('lineHeight'));

			$textarea.on('input', function(e) {

				var lines = (jQuery(this).val() + '\n').match(/\n/g).length;
				jQuery(this).height(lineHeight * lines);

			});

		});

</script>