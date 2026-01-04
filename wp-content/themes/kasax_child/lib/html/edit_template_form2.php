<?php if( !empty( $this->kxedOUT[ 'template_form_html2' ] ) ): ?>

  <?php foreach( $this->kxedOUT[ 'template_form_html2' ] as $_k => $_v	): if( is_array($_v)): //arrayを確認しないとErrorになる。 ?>

    <?php if( !empty( $_v['f'] )): echo $_v['f']; endif; ?>

    <?php
     if( $_k == 'db_json_arr'):

        if( is_array( $_v[ 'base_id' ] ) ):

          $i = 1;
          foreach( $_v[ 'base_id' ] as $_id ):

             echo '<div class="__color_normal" style="margin:0 0 0 10px;">';
             echo $i.'&nbsp;.&nbsp;';
             echo '<a href="' . get_permalink( $_id ) . '">';
             echo  'ID' . $_id .'：Title（';
             echo  get_the_title($_id);
             echo '）';
             echo '</a>';
             echo '</div>';
             $i++;

          endforeach;

        endif;

      endif;

    ?>

    <?php if( $_v[ 'on' ] ): ?>

      <?php if( preg_match( '/(\[.*)(\[.*)/' ,  $_v['value'] ,  $matches  ) ): ?>

        <?php for ($i = 1; $i <= 2; $i++): ?>

          <?php
            if( preg_match( '/raretu/'          , $matches[$i] )   )
            {
              $name = 'raretu';
            }
            else
            {
              $name = $_v['name'].$i;
            }
          ?>

          <div style="width:50px;display: inline-block;">

            <?php echo $name; ?>

          </div>


          <input
            type	= "text"
            name	= "short_code<?php echo $_k.$i; ?>"
            value	= '<?php echo $matches[$i]; ?>'
            class	= ""
            style	= "width:<?php echo $_v['width']; ?>px;"
          >

        <?php endfor; ?>


      <?php elseif( $_v['name'] ): ?>

        <div style="width:50px;display: inline-block;">

          <?php echo $_v['name']; ?>

        </div>

        <input
          type	= "text"
          name	= "short_code<?php echo $_k; ?>"
          value	= '<?php echo $_v['value']; ?>'
          class	= ""
          style	= "width:<?php echo $_v['width']; ?>px;"
        >

      <?php endif;  unset(  $matches  , $i ,  $matches_fb ); ?>


      <?php if( $_v['name'] ==  'ID' ): ?>

        <div>

          <?php

            if( empty( $id_arr ) ):

              $id_arr = $_v[ 'value' ];

            endif;

            $_arrID = explode( ',' , $id_arr );

            echo '<div style="margin-top:10px;">■　LINK　■　'.count( $_arrID ).'件</div>';


           $i = 1;
           foreach( $_arrID as $_id_sc ):

              echo '<div class="__color_normal" style="margin:0 0 0 10px;">';
              echo $i.'&nbsp;.&nbsp;';
              echo '<a href="' . get_permalink( $_id_sc  ) . '">';
              echo  'ID' . $_id_sc .'：Title（';
              echo  get_the_title($_id_sc);
              echo '）';
              echo '</a>';
              echo '</div>';
              $i++;

           endforeach;

          ?>

        </div>

      <?php endif; ?>

    <?php else: ?>

      <!-- <?php echo $_v['value']; ?> 隠蔽送信要素　-->
      <input type="hidden" name="short_code<?php echo $_k; ?>"	value="<?php echo $_v['value']; ?>">

    <?php endif; ?>

  <?php endif; endforeach; unset(  $_k	, $_v ); ?>

<?php else: ?>

  <input
    type="text" name="short_code<?php echo $_k; ?>"
    value="<?php echo $_v['value']; ?>"
    class=""
    style="<?php echo $volume['style'] ?><?php echo $this->kxedSetting[ 'sbi' ];?>"
  >

<?php endif; ?>
