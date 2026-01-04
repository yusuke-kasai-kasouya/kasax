<script>

  //読み込み
  jQuery(function($){

    //ボタンをクリックした時の処理
    $(document).on('click', '#gnavi2<?php echo $_id; ?> a', function(event) {

      //処理のブロック
      event.preventDefault();

      //.gnavi aのhrefにあるリンク先を保存
      var link = $(this).attr("href");

      //alert(idd);

      //リンク先が今と同じであれば遷移させない
      if(link == lastpage){

        return false;

      }else{

        $content.fadeOut(1, function() {

          getPage(link);
        });
        //今のリンク先を保存
        lastpage = link;
      }

      // 遷移可能であればローディング表示させる
      $("#loader").show();

    });

    //ページを表示させる場所の設定
    //var $content = $('.displayArea73334');
    var $content = $('.displayArea<?php echo $_id; ?>');
    //

    //初期表示
    var lastpage = "";

    //ページを取得してくる
    function getPage(elm){

      $.ajax({

        //type: 'GET',  //別でgetを使用
        type: 'post', // getかpostを指定(デフォルトは前者)
        url: elm,
        dataType: 'html',

        //dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
        data: { // 送信データを指定(getの場合は自動的にurlの後ろにクエリとして付加される)

          id: $('.id').val(),

        },


        success: function(data){
          $("#loader").fadeOut();
          $content.html(data).fadeIn(500);
        },

        error:function() {
          alert('問題が発生しました(2)：<?php echo $_id; ?>');
        }

      });
    }

  });


</script>




