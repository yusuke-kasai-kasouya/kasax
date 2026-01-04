<div
  id="fulltime<?php echo $this->kxra_memory[ 'wwr_fulltime_count' ]; ?>"
  style="	position:relative;	top: -40px;"
>
</div>

<td style="width:1px;vertical-align:top;">



	<div style="text-align:center;right:0;z-index:3;width:1px;">

    <!-- スイッチ -->
    <div class="question_fulltime __color_white __hover_div __radius_l_10" style="margin-top:40px; position:absolute;width:20px;right:5px;background:hsla(0,0%,0%,.2);">
      E<?php echo $this->kxra_memory[ 'wwr_fulltime_count' ]; ?>
    </div>

    <!-- 引き出し -->
    <div class="answer_fulltime answer_fulltime_css __radius_10" style=margin-top:60px;z-index:3>

      <!-- Form -->
      <form
        method ="post"
        action ="wp-content/themes/kasax_child/kxEdit_fulltime.php"
        style ="text-align:left;"
      >

        <input type="hidden" name="id" value="<?php echo $this->kxraM[ 'wwr_time_edit' ][ 'str_ids' ]; ?>">

        <input type="hidden" name="url" value="<?php echo $this->kxraM[ 'wwr_time_edit' ][ 'url' ]; ?>">

        <div>
          Time-Change_raretu＿<?php echo $this->kxra_memory[ 'wwr_fulltime_count' ]; ?>
        </div>

        <div>
          <input
            type="text"
            name="time"
            value="<?php echo $this->kxra_memory[ 'wwr_new_time' ]; ?>"
            style="width:200px;"
          >
        </div>


        <div style="margin:20px 0 0 0 ;">
          <input type="checkbox" name="plot_code_change_on" value="title_change_on">
          plot_code_change
        </div>

        <div>
          <input
            type="text"
            name="wwr_plot_code_base"
            value="<?php echo $this->kxra_memory[ 'wwr_plot_code_base' ]; ?>"
            style="width:200px;"
          >
        </div>


        <!-- タイトルchange -->
        <div style="margin:20px 0 0 0 ;">
          <input type="checkbox" name="title_change_on" value="title_change_on">
          title_change
        </div>

        <?php echo $this->kxraM[ 'wwr_time_edit' ][ 'end_title' ]; ?>

        <div>

          <input
            type="text"
            name="title_change"
            value="<?php echo $this->kxraM[ 'wwr_time_edit' ][ 'end_title' ]; ?>"
            style="width:auto;"
          >
        </div>

        <div>
          <input type="submit" name="back" value="✔" class="question_fulltime __btn2" style="width:100%;height:20px;padding:3px 10px 4px 10px;">
        </div>

      </form>

    </div>

    <?php if( !empty($this->kxraM[ 'c800_on' ] ) ) : ?>

      <div class="question_fulltime __color_white __hover_div __radius_l_10" style="margin-top:60px; position:absolute;width:20px;right:5px;background:hsla(0,0%,0%,.2);">

        c8

      </div>

      <div class="answer_fulltime answer_fulltime_css __radius_10" style=margin-top:80px;z-index:3>

        <!-- Form -->
        <form
          method ="post"
          action ="wp-content/themes/kasax_child/kxEdit_fulltime_c800.php"
          style ="text-align:left;"
        >

          <div>

            <input type="hidden" name="url" value="<?php echo $this->kxraM[ 'wwr_time_edit' ][ 'url' ]; ?>">

            <input type="hidden" name="cat" value="<?php echo $this->kxraS1[ 'cat' ]; ?>">

            <input type="hidden" name="time_base" value="<?php echo $this->kxra_memory[ 'wwr_new_time' ]; ?>">

            <div>
              C800-Time-Change_raretu＿<?php echo $this->kxra_memory[ 'wwr_fulltime_count' ]; ?>
            </div>

            <input
              type="text"
              name="time"
              value="<?php echo $this->kxra_memory[ 'wwr_new_time' ]; ?>"
              style="width:200px;"
            >

          </div>

          <div>

            <input type="submit" name="back" value="✔" class="question_fulltime __btn2" style="width:100%;height:20px;padding:3px 10px 4px 10px;">

          </div>

        </div>

      </form>

    <?php endif; ?>

  </div>
</td>