<?php
  /**
   * bar。
   */
?>

<div class="__kxra_bar__ __kxra_wwr_top" style="<?php echo $this->kxraM[ 'bar_style5000' ]; ?>">

  <!-- 年齢・学年 -->
  <span class="__radius_10 <?php echo $this->kxraM[ 'bar_class_year' ]; ?>" style="<?php echo $this->kxraM[ 'bar_style1' ]; ?>"><?php echo $this->kxraM[ 'gakunen' ];?></span>

	<!-- 月 -->
	<span
		class="__radius_10 <?php echo $this->kxraM[ 'bar_class_month' ]	?>"
		style="color:#fff; <?php echo $this->kxraM[ 'bar_style_month' ]?>"
  ><?php echo $this->kxraS_post[ 'time_month' ] . $this->kxraM[ 'bar_unit_month' ]; ?></span>

  <!-- 日時 -->
	<span	class="__radius_10 <?php echo $this->kxraM[ 'bar_class_day' ]	?>"	style="<?php echo $this->kxraM[ 'bar_style_day' ] ?>;"	><?php echo $this->kxraS_post['time_day'];  ?></span>


	<!-- 題名 -->
	<span
    class = "__radius_25 js_target_title<?php echo $this->kxraM[ 'bar_ID' ] . '_'.$this->kxraS_post['daimei'] ?>"
    style = "margin:0 0 0 50px; padding:0 10px 0 10px;"
  >

    <?php echo $this->kxraS_post['daimei']; ?>

  </span>

  <?php echo $this->kxraM[ 'plot' ]; ?>

</div>