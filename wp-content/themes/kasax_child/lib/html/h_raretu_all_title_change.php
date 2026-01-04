<?php
/**
 * 全タイトル置換
 * h_raretu_all_title_change
 */



  $str_id_arr = '';
  foreach( $this->kxra_arr_id[ 'title_change_ids' ] as $value ):
    $str_id_arr .= $value.',';
  endforeach;

  /*
  $str_id_to_text ='';
  foreach( $this->kxra_arr_id[ 'sort' ]['arr_id'] as $value ):
    $str_id_to_text .= $value.',';
  endforeach;
  $str_id_to_text = rtrim($str_id_to_text, ',');
  */



  $title_end = end( explode( '≫' ,  $this->kxraS1[ 'title_base' ] ) );

  $str_id_arr = substr( $str_id_arr , 0, -1);

  //不明php8
  $anchor = $anchor ?? null;

  $url	 = (empty($_SERVER["HTTPS"] ) ? "http://" : "https://") ;
  $url	.= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'#'.$anchor;

  //$type = ( !empty($this->kxraS1[ 'tougou' ]) ) ? ['tougou'=>$this->kxraS1[ 'tougou' ]]:null;

?>

<!-- 全体・最上部 -->

<div class="_op_a" style="font-size:x-small;">
  ▽
</div>

<div class="_op_z __background_normal" style="padding:5px;z-index:2;text-align:left;right:0;">

  <?php if( empty( $this->kxraS0[ 'db' ] ) && empty( $this->kxraS0[ 'table_name' ] )  ): ?>

    <p>▽フォルダタイトル・全置換：<?php echo $this->kxraS1[ 'id_base' ]; ?></p>

    <p><?php echo preg_replace( '/' . $title_end . '$/' ,'<span style="color:yellow;">$0</span>' ,$this->kxraS1[ 'title_base' ] ); ?></p>
    <p>
      <a href="<?php echo get_stylesheet_directory_uri(); ?>/lib/php/all_title_change.php?id_base=<?php echo urlencode($this->kxraS1['id_base']); ?>&title_base=<?php echo urlencode($this->kxraS1['title_base']); ?>&ids=<?php echo urlencode($str_id_arr); ?>&title_end=<?php echo urlencode($title_end); ?>" target="_blank">
        ▶ 別ページで全タイトル置換を実行
      </a>
    </p>

    <hr>
  <?php endif; ?>

  <?php
    echo kx_render_export_text_button( $this->kxra_arr_id[ 'sort' ]['arr_id'] ,$this->kxraS1[ 'id_base' ] ,null , null);

  ?>

</div>
<!-- 最下部・全体 -->

