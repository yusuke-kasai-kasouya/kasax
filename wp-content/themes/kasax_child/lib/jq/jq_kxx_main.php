<script>

  jQuery(function($){

    /**
     * kxjq_yomi_main
     * 主にリロード用。
     */
    $(document).on('click', '._kxjq_yomi_main<?php echo $_id; ?> a', function(event) {
      //ボタンをクリックした時の処理
      //$(".contents").on('click', '.gnavi a', function(event) {

      //var id = $('.id').val();  //実験要素。
      //var idd = "<?php //echo $idd; ?>";  //実験要素。

      //処理のブロック
      event.preventDefault();

      //.gnavi aのhrefにあるリンク先を保存
      var link = $(this).attr("href");
      //alert(idd);

      $content.fadeOut(600, function() {

        getPage(link);
      });
      //今のリンク先を保存
      lastpage = link;


      // 遷移可能であればローディング表示させる
      $("#loader").show();

    });

    //ページを表示させる場所の設定
    //var $content = $('.displayArea73334');
    var $content = $('.displayArea3<?php echo $_id; ?>');
    //

    //初期表示
    var lastpage = "";

    //ページを取得してくる
    function getPage(elm){

      $.ajax({

        //type: 'GET',  //別で使っている。
        type: 'post', // getかpostを指定(デフォルトは前者)
        url: elm,
        dataType: 'html',

        //dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
        data: { // 送信データを指定(getの場合は自動的にurlの後ろにクエリとして付加される)
            //text: $('.text').val(),
            id: $('.id').val(),
            //id: $id.val(),


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




