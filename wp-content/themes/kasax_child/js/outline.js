
jQuery(function($) {
	$('a[href^="#"]').click(function(){

		//づらすサイズ
		var adjust = 60;

		var speed = 300;
    var href= $(this).attr("href");
    var target = $(	href == "#" || href == "" ? 'html' : href	);
    var position = target.offset(	).top	- adjust;
		$("html, body").animate({scrollTop:position}, speed, "swing");

		return false;

  });
} )

/*
jQuery(function($){
	var headerH = 500; //ヘッダーの高さ
	$(window).on("load", function(){
		if(location.hash !== ""){
			var targetOffset = $(location.hash).offset().top;
			$(window).scrollTop(targetOffset - headerH);
		}
	});
});
*/