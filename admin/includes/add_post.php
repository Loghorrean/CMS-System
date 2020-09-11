<?php
define("MAX_FILE_SIZE", 5000000);
if (isset($_POST["create_post"])) {
    $upload_dir = "../images/"; // upload directory
    $allowed_types = ["image/jpeg", "image/jpg", "image/png"]; // types that can be uploaded
    $post_image = basename($_FILES["post_image"]["name"]); // original file name
    $post_image_temp = $_FILES["post_image"]["tmp_name"]; // temporary file name on client's computer
    $post_image_type = $_FILES["post_image"]["type"]; // type of uploaded file
    $post_image_size = $_FILES["post_image"]["size"]; // size of uploaded file
    $checked = false;
    if ($post_image_size > MAX_FILE_SIZE) {
        $_SESSION["error"] = "Invalid file size (max = 5mb)!";
        header("Location: posts.php");
        exit();
    }
    for ($i = 0; $i < count($allowed_types); $i++) {
        if ($post_image_type == $allowed_types[$i]) {
            $checked = true;
            break;
        }
    }
    if (!$checked) {
        $_SESSION["error"] = "Invalid file type!";
        header("Location: posts.php");
        exit();
    }
    move_uploaded_file($post_image_temp, $upload_dir.$post_image);
    $values = [":cat_id" => $_POST["post_category_id"], ":ttl" => $_POST["post_title"],
    ":auth_id" => $_SESSION["user_id"], ":img" => $post_image, ":cnt" => $_POST["post_content"],
    ":tag" => $_POST["post_content"], ":stat" => $_POST["post_status"]];
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