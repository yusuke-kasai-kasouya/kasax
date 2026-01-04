<div id="sticky-element" style="background:red;">
  
  <table style="border-collapse:collapse;background:hsl(0,0%,5%);">
    <tr>
      <?php echo $retB; ?>
    </tr>
  </table>
</div>


<script>
//制作中。2023-07-02

// ページの読み込みが完了したら実行
window.addEventListener('load', function() {
  // 要素の参照を取得
  var stickyElement = document.getElementById('sticky-element');

  // スクロールイベントを監視
  window.addEventListener('scroll', function() {
    // 現在のスクロール位置を取得
    var scrollPosition = window.scrollY || window.pageYOffset;

    // スクロール位置に応じて要素の表示/非表示を切り替え
    if (scrollPosition >150) {
      stickyElement.style.display = 'block';
    } else {
      stickyElement.style.display = 'none';
    }
  });
});
</script>