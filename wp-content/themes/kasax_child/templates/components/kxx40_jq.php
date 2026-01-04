<?php
  /**
   *
   */

  if( !empty( $_SESSION['__js_hober'] )):

    $_random  = (int)$_SESSION['__js_hober'];

  else:

    $_SESSION['__js_hober'] = 0;

  endif;

  $_SESSION['__js_hober']++;


  if( empty( $_random )):

    $_random  = NULL;

  endif;

?>

<script>


  jQuery(function ($) {

  <?php if( !empty( $navi_on ) ): ?>

    //hover・遅延
    $('#__js_hober_40_navi<?php echo $_random ?>').on({

      'mouseenter':function(){
        sethover = setTimeout(function(){
          $('#__js_hober_40_navi<?php echo $_random ?>').children('.__js_hober_40_navi').fadeIn(300);
        },500);
      },

      'mouseleave':function(){
        $('#__js_hober_40_navi<?php echo $_random ?>').children('.__js_hober_40_navi').fadeOut(300);

        clearTimeout(sethover);

      }

    });

  <?php elseif( !empty( $this->l7_js_off ) ): ?>

    //スルー

  <?php else: ?>

    //hover・遅延
    $('#__js_hober_40<?php echo $_random ?>').on({

      'mouseenter':function(){
        sethover = setTimeout(function(){
          $('#__js_hober_40<?php echo $_random ?>').next().fadeIn(300);
        },500);
      },

      'mouseleave':function(){
        $('#__js_hober_40<?php echo $_random ?>').next().fadeOut(300);

        clearTimeout(sethover);
      }

    });

  <?php endif; ?>


});
</script>

