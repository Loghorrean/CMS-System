<?php
if (isset($_GET["p_id"])) {
    if (!checkId($_GET["p_id"])) {
        header("Location: posts.php");
        return;
    }
    $row = findPostsById($_GET["p_id"], $pdo);
}
if (isset($_POST["edit_post"])) {
    $upload_dir = "../images/"; // upload directory
    $post_image = uploadFile($upload_dir, "post_image", "posts.php", MAX_FILE_SIZE, ["jpeg", "jpg", "png"]);
    if (empty($post_image)) {
        $query = $pdo->prepare("SELECT post_image from posts where post_id = :id");
        $query->bindParam(":id", $_REQUEST["post_id"]);
        $query->execute();
        $post_image = $query->fetch(PDO::FETCH_LAZY)["post_image"];
    }
    $values = ["post_id" => $_POST["post_id"], "title" => $_POST["post_title"], "cat_id" => $_POST["post_category_id"],
    "post_author_id" => $_SESSION["user_id"], "image" => $post_image, "tags" => $_POST["post_tags"],
    "content" => $_POST["post_content"], "status" => $_POST["post_status"]];
    editPost($values, $pdo);
}
$query = $pdo->prepare("SELECT * from posts where post_id = :id"); // to fill the edit post form with values
$query->bindParam(":id", $_GET["p_id"]);
$query->execute();
$row = $query->fetch(PDO::FETCH_LAZY);
$post_status = $row["post_status"];
$post_cat_id = $row["post_category_id"];
$categories = $pdo->prepare("SELECT * from category"); // to dynamically view categories
$categories->execute();
?>
<form action="" method="POST" enctype="multipart/form-data">
    <div class = "form-group">
        <label for = "post_title">Post Title</label>
        <input type="text" id = "post_title" class = "form-control" name="post_title" value="<?=$row["post_title"]?>">
    </div>
    <div class = "form-group">
        <label for = "post_category_id">Post Category</label><br>
        <select name="post_category_id" id = "post_category_id">
            <?php
            while ($category = $categories->fetch(PDO::FETCH_LAZY)) { // categories
                $cat_id = $category["cat_id"];
                $cat_title = $category["cat_title"];
                $selected = $cat_id == $post_cat_id ? "selected" : "";
                echo "<option value = '{$cat_id}' $selected>$cat_title</option>";
            }
            ?>
        </select>
    </div>
    <div class = "form-group">
        <label for = "post_image">Post Image</label><br>
        <img width = "200" src="../images/<?=htmlspecialchars($row["post_image"])?>" alt = "Loading image">
        <input type="file" name="post_image">
    </div>
    <div class = "form-group">
        <label for = "post_tags">Post Tags</label>
        <input type="text" id = "post_tags" class = "form-control" name="post_tags" value="<?=htmlspecialchars($row["post_tags"])?>">
    </div>
    <div class = "form-group">
        <label for = "post_content">Post Content</label><br>
        <textarea class = "form_control" id = "post_content" cols = "90" rows = "10" name = "post_content"><?=htmlspecialchars($row["post_content"])?></textarea>
    </div>
    <div class = "form-group">
        <label for = "post_status">Post Status</label><br>
        <select id="post_status" name="post_status">
            <option value="draft" <?=$selected = $post_status == "draft" ? "selected" : ""?>>Draft</option>
            <option value="published" <?=$selected = $post_status == "published" ? "selected" : ""?>>Published</option>
        </select>
<!--        <input type="text" id = "post_status" class = "form-control" name="post_status" value="--><?//=htmlspecialchars($row["post_status"])?><!--">-->
    </div>
    <div class = "form-group">
        <input type = "hidden" name = "post_id" value = "<?=$row["post_id"]?>">
        <input type="submit" name="edit_post" value = "Edit Post" class = "btn btn-primary">
    </div>
</form>