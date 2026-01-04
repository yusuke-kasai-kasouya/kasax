<script>
  jQuery(function($){


    //■■■高さ調整系・調整中2020-03-16
    var $textarea = $('#textarea<?php echo $id; ?>');
    var lineHeight = parseInt($textarea.css('lineHeight'));

    $textarea.on('input', function(e) {
      var lines = ($(this).val() + '\n').match(/\n/g).length;
      $(this).height(lineHeight * lines);
    });


    /**
    * ■■■ click系 ■■■
    */
    $('.a<?php echo $id; ?>').on('click',function(){

      target = document.getElementsByClassName("e<?php echo $id; ?>");
      //array = Array.prototype.slice.call(checkBoxes);//配列に変換
      for (var i = 0; i < target.length; i++) {
        target[i].innerText =  '🔻✅' + document.forms.f<?php echo $kahen; ?>.textarea<?php echo $kahen; ?>.value;
      }

    });

  });
</script>