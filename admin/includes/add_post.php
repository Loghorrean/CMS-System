<?php
if (isset($_POST["create_post"])) {
    $post_image = $_FILES["post_image"]["name"];
    $post_image_temp = $_FILES["post_image"]["tmp_name"];
    move_uploaded_file($post_image_temp, "../images/$post_image");
    $values = ["post_title" => $_POST["post_title"], "post_cat_id" => $_POST["post_category_id"],
    "post_author" => $_POST["post_author"], "post_image" => $post_image, "post_tags" => $_POST["post_tags"],
    "post_content" => $_POST["content"], "post_status" => $_POST["post_status"]];
	insertPost($values, $pdo);
}
$query = $pdo->prepare("SELECT * from category");
$query->execute();
?>
<form action="" method="POST" enctype="multipart/form-data">
	<div class = "form-group">
		<label for = "post_title">Post Title</label>
		<input type="text" class = "form-control" name="post_title" id="post_title">
	</div>
    <div class = "form-group">
        <label for = "post_category_id">Post Category</label><br>
        <select name="post_category_id" id = "post_category_id">
            <?php
            while ($category = $query->fetch(PDO::FETCH_LAZY)) {
                $cat_id = $category["cat_id"];
                $cat_title = $category["cat_title"];
                echo "<option value = '{$cat_id}'>$cat_title</option>";
            }
            ?>
        </select>
    </div>
	<div class = "form-group">
		<label for = "post_author">Post Author</label>
		<input type="text" class = "form-control" name="post_author" id = "post_author">
	</div>
	<div class = "form-group">
		<label for = "post_image">Post Image</label>
		<input type="file" name="post_image">
	</div>
	<div class = "form-group">
		<label for = "post_tags">Post Tags</label>
		<input type="text" class = "form-control" name="post_tags" id = "post_tags">
	</div>
	<div class = "form-group">
		<label for = "body">Post Content</label><br>
		<textarea class = "form_control" id = "body" cols = "30" rows = "20" name = "post_content"></textarea>
	</div>
	<div class = "form-group">
		<label for = "post_status">Post Status</label>
        <select name="post_status" id = "post_status">
            <option value = "published">Published</option>
            <option value = "draft">Draft</option>
        </select>
	</div>
	<div class = "form-group">
		<input type="submit" name="create_post" value = "Create Post" class = "btn btn-primary">
	</div>
</form>