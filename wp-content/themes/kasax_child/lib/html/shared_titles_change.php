<?php
/**
 * shared_titles_change
 */

  $_ids_title = preg_replace('/^[^≫]+≫/','',get_the_title( $this->kxedOUT[ 'id' ]));

  $result =  kx_db0(	['title' =>$_ids_title ] , 'Select_title'  );

  $_ids_hyouji = count($result);

  $_str_ids ='';
  //$_ids = [];
  foreach( $result as $value ):
    $_str_ids .= $value->id.',';
    //$_ids[] = $value->id;
  endforeach;

  $_str_ids = substr( $_str_ids , 0, -1);


?>

<!-- 全体・最上部 -->

<span class="_op_a" style="color:darkred;">
  <?php echo kx_intToRoman(count( $_db_arr[ 'ids' ] )); ?>
</span>

<div class="_op_z __background_normal" style="padding:5px;z-index:2;text-align:left;right:0;width:550px;direction: ltr;">


  <p>■リンク一覧</p>
  <div style="margin-left:40px;">

    <?php foreach ( $_db_arr['ids'] as $id ) : ?>
      <?php
        $url   = get_permalink( $id );
        $title = explode('≫',get_the_title( $id ))[0] ;
      ?>
      <div>
        <a href="<?php echo esc_url( $url ); ?>">
          -<?php echo esc_html( $title ); ?> (ID: <?php echo $id; ?>)-
        </a>
      </div>
    <?php endforeach;unset($id); ?>
  </div>
  <hr>



  <p>■sharedタイトル全置換</p>
  <p>全<?php echo count( $result); ?>件</p>
  <p><?php echo $_str_ids; ?></p>

  <form
    method  = "post"
    action  = "wp-content/themes/kasax_child/lib/php/update_posts0.php"
    style   = "text-align:left;"
    class   = ""
    target="_blank"
  >
    <input type="hidden" name="type" value="shared_titles_change">

    <div style="margin-left:20px;">

      <div style="display:inline-block;width:90px;">
        Title：
      </div>

      <div style="display:inline-block;"><?php echo $_ids_title; ?></div>

    </div>

    <div style="margin-left:20px;">
      <div style="display:inline-block;width:90px;">
        Title：
      </div>

      <div style="display:inline-block;">

        <input type="hidden" name="ids" value="<?php echo $_str_ids; ?>">
        <input type="hidden" name="Title1" value="<?php echo $_ids_title; ?>">
        <input type="text"   name="Title2" value="<?php echo $_ids_title; ?>" style="width:400px;">

      </div>

    </div>


    <div>
      <input type="submit" name="back" value="置換" class="question_fulltime __btn2" style="width:50%;height:20px;padding:3px 10px 4px 20px;margin-top:10px;margin-left:115px;">
    </div>

  </form>




</div>
<!-- 最下部・全体 -->

