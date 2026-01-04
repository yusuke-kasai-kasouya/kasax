<?php
/*
Template Name: json
メモ書き禁止
テスト中
API。テンプレート化
*/

  $post = get_post(7);

  $str = $post->post_content;
  $str = preg_replace( '/\r\n|\n/' , '' , $str);

  header("Content-Type: application/json; charset=utf-8");
  echo $str;

  //echo $post->post_content;
  //setup_postdata($post);
  //$json[] = $post;
  #$json[] = get_the_title();


  //echo json_encode($json);

  //echo'[{"ID":7,"post_author":"2","post_date":"2018-04-06 02:11:02","post_date_gmt":"2018-04-05 17:11:02","post_content":"xxx\nYYY\nZZZ","post_title":"xxx\u226bZZZ","post_excerpt":"","post_status":"publish","comment_status":"closed","ping_status":"closed","post_password":"","post_name":"%e2%88%ac10%e2%89%ab1%e6%a7%8b%e6%88%90%e2%89%ab%e9%a1%8c%e6%9d%90%e2%89%ab%e3%80%8e%e5%b1%85%e5%a0%b4%e6%89%80%e3%80%8f-3","to_ping":"","pinged":"","post_modified":"2020-12-26 12:02:33","post_modified_gmt":"2020-12-26 03:02:33","post_content_filtered":"","post_parent":0,"guid":"http:\/\/192.168.1.14:4001\/0\/?p=32681","menu_order":0,"post_type":"post","post_mime_type":"","comment_count":"0","filter":"raw"}]';

?>