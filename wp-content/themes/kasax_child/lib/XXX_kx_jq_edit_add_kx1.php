<script>
jQuery(function($){

  //click系
  $('.a<?php echo $js; ?>').on('click',function(){
    $("#loader").show();

    var $content = $('.displayArea3<?php echo $this->kxedS1[ 'id_js' ]; ?>');

    $content.fadeOut(600, function() {
      getPage('wp-content/themes/kasax_child/lib/php/p_hyouji.php?id=<?php echo $id; ?>');
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


  /**
   * テキスト・置換
   * js_target_title
   * に置換予定。使っていない？2020-07-23
   */
  $('.a<?php echo $js; ?>').on('click',function(){

    target_t = document.getElementsByClassName("t<?php echo $js; ?>");
    for (var i = 0; i < target_t.length; i++) {
      target_t[i].innerText =  '✅✅' + document.forms.f<?php echo $kahen; ?>.titlearea<?php echo $kahen; ?>.value;
    }

  });

});
</script>