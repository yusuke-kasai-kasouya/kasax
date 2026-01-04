<?php

  //wpのシステム読み込み
  require_once ('../../../../../wp-blog-header.php');

  KxDy::kxdy_trace_count('kxx_sc_count', 1);

  global $post;

  $post		 = get_post( $_GET[ 'id' ] );
  $content = $post->post_content;
  $content = preg_replace(  '/\[(kx_tp|kx(_base|)_format|raretu).*?\]/'  ,'' ,$content);

  echo  $content;

  KxDy::kxdy_trace_count('kxx_sc_count', -1);

?>