<?php
/**
 *
 */

?>

<script>


/**
 * header-bar-relation/関連用用
 */
jQuery(function ($) {

  $(document).on('click', '.gnavi_number<?php echo $gnavi_count; ?> a', function(event) {
    event.preventDefault();
    var link = $(this).attr("href");
    if(link == lastpage){

      return false;

    }else{

      $content.fadeOut(600, function() {

        getPage(link);
      });

      lastpage = link;
    }

    $("#loader").show();

  });


  var $content = $('.displayArea_gnavi_number<?php echo $gnavi_count; ?>');

  var lastpage = "";

  function getPage(elm){

    $.ajax({
      type: 'post',
      url: elm,
      dataType: 'html',
      data: {
        text: $('.text').val(),
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



</script>

