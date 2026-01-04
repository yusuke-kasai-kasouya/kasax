<div class="<?php echo $this->kxedS1[ 'rtl' ]; ?>" style="text-align:right;display: inline-block;">
	<span id="<?php echo $this->kxedOUT[ 'anchor' ]; ?>">
  </span>


  <div
    id = "_op_a<?php echo $this->kxedOUT[ 'kahen' ]; ?>"
    class = "_op_a<?php echo $this->kxedOUT[ 'kahen' ] . ' _js_edit'	.	$this->kxedOUT[ 'id' ]; ?>"
    style = "display: inline-block;cursor: pointer;"
  >
		<input type="hidden" class="id" value="<?php echo $this->kxedOUT[ 'id' ]; ?>">

    <?php if( preg_match( $this->kxedSetting[ 'yomikomi' ]	, $this->kxedOUT[ 'title' ] ) )://読み込み型編集。 ?>

      <a tabindex="-1" href="wp-content/themes/kasax_child/lib/php/p_hyouji_edit.php?id=<?php echo $this->kxedOUT[ 'id' ] .'&type=' . $this->kxedS1[ 'type' ] .'&width_hyouji=' . $this->kxedS1[ 'width_hyouji' ]; ?>">

    <?php endif; ?>