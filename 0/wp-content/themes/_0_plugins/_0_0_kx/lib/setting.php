<?php
/**
 * 管理画面にCSSを追加します。
 */


function my_admin_script(){
	// jQuery のコードだった場合
	//wp_enqueue_script( 'my_admin_script', get_template_directory_uri().'/javascript2.js', array('jquery'));

	wp_enqueue_script( 'my_admin_script', plugins_url( 'kx/js/kxp_jq.js') , array('jquery'));

}
add_action( 'admin_enqueue_scripts', 'my_admin_script' );



// 1つ目、アクションフック
add_action( 'admin_menu', 'add_plugin_admin_menu' );

// 2つ目、アクションフックで呼ばれる関数
function add_plugin_admin_menu() {
	add_options_page(
		'kx', // page_title（オプションページのHTMLのタイトル）
		'kx管理', // menu_title（メニューで表示されるタイトル）
		'administrator', // capability
		'kx', // menu_slug（URLのスラッグこの例だとoptions-general.php?page=hello-world）
		'display_plugin_admin_page' // function
	);
}

// 3つ目、設定画面用のHTML
function display_plugin_admin_page() {
	//echo '<div style="background:black;">';


	echo '<div class="wrap"">';
	echo 'kx管理画面';
	//echo do_shortcode('[KxErrorLogs]');
	//echo '</div>';
	echo '<div style=margin:20px;>';
	//echo do_shortcode('[kx t=94 search="＞" sys=edit_link_on sys=delete,edit_link_on]'); //all=on
	//echo '<hr>';
	echo do_shortcode('[kx t=90 search="xxx" orderby="ID" sys=delete,edit_link_on]');
	//echo do_shortcode('[KxMaintenance]');
	echo '</div>';
	//echo '</div>';

}
?>