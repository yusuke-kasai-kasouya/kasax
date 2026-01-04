<?php
  /*
    Template Name: jsonTEST
    メモ書き禁止
    テスト中
    API。テンプレート化
  */

  #$id =  $_GET[ 'id' ] ;
  $cat =  $_GET['cat'] ;
  $tag =  $_GET['tag'] ;

  if(!$cat):

    $cat=17;

  endif;

  #echo $id;

  $args = [
    'cat'				      => $cat,
    'tag'				      => $tag,
    'orderby' 	      => 'title',
    'order'			      => 'asc',
    'posts_per_page'	=> -1,
  ];

  /*
  $args = array(
    //'include'     => '991',
    //'include'     => '991,8140',
    'include'     => $id,
    'numberposts' => 3,
    'orderby'     => 'post_date',
    'order'       => 'DESC',
  );
  */

  $posts = get_posts($args);

  if($posts): foreach($posts as $post):
    setup_postdata($post);
    $json[] = $post;
    #$json[] = get_the_title();

  endforeach; endif;

  header("Content-Type: application/json; charset=utf-8");
  echo json_encode($json);

?>