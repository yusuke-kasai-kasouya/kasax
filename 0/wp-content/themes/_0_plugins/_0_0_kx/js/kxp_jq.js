jQuery(function ($) {

  //■■■click・Edit
  $(".answer_d").css("display", "none");
  // 質問の答えをあらかじめ非表示

  //質問をクリック
  $(".question_d").click(function () {

    //$(".question2").not(this).removeClass("open2");
    //クリックしたquestion以外の全てのopenを取る

    $(".question_d").not(this).next().slideUp(300);
    //クリックされたquestion以外のanswerを閉じる

    //$(this).toggleClass("open2");
    //thisにopenクラスを付与

    $(this).next().slideToggle(100);
    //thisのcontentを展開、開いていれば閉じる

  });


  //■■■✘
  $(".answer_d2").css("display", "none");
  // 質問の答えをあらかじめ非表示

  //質問をクリック
  $(".question_d2").click(function () {

    //$(".question2").not(this).removeClass("open2");
    //クリックしたquestion以外の全てのopenを取る

    $(".question_d2").not(this).next().slideUp(300);
    //クリックされたquestion以外のanswerを閉じる

    //$(this).toggleClass("open2");
    //thisにopenクラスを付与

    $(this).next().slideToggle(100);
    //thisのcontentを展開、開いていれば閉じる

  });


});

