<?php use Kx\Utils\Time; // ファイルの先頭で宣言 ?>

<form action="wp-content/themes/kasax_child/kx_insert_post.php" method="post" >
    <input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" style="display:block;">
    <input type="hidden" name="reload" value="1" style="display:block;">
    <input type="hidden" name="post_type" value="post" style="display:block;">

    title：
    <input type="text" name="title_light" value="<?php echo $title; ?>" style="width:300px;font-size:small; display:block;">

    <span style="display:block;">
        content：
    </span>
    <textarea
					type				= "text"
					name				= "text"
					style				= "width:500px"
				><?php echo '＿' . Time::format() . '＿'; ?></textarea>



    <span style="display:block;">
        <input type="submit" value="新規E">
    </span>

</form>
