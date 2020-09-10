<?php
require_once("includes/header.php");
if (isset($_GET["p_id"])) {
    if (!checkId($_GET["p_id"])) {
        header("Location: index.php");
        return;
    }
    $query = $pdo->prepare("SELECT * from posts where post_id = :id");
    $query->bindParam(":id", $_GET["p_id"]);
    $query->execute();
}
if (isset($_POST["create_comment"])) {
    $values = ["post_id" => $_GET["p_id"], "comment_email" => $_POST["comment_email"]];
    $values["comment_author"] = $_POST["comment_author"];
    $values["comment_content"] = $_POST["comment_content"];
    if (!checkMail($_POST["comment_email"])) {
        header("Location: post.php?p_id={$values["post_id"]}");
        return;
    }
    insertComment($values, $pdo);
    return;
}
// uploading some comments
$sql = "SELECT * from comments where comment_post_id = :id ";
$sql .= "and comment_status = 'Approved' Order By comment_id DESC";
$comments = $pdo->prepare($sql);
$comments->bindParam(":id", $_GET["p_id"]);
$comments->execute();
?>
    <!-- Navigation -->
<?php
require_once("includes/navigation.php");
?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <?php
                $stmt = $pdo->prepare("SELECT count(post_id) as 'count' from posts where post_status = 'published' and post_id = :id");
                $stmt->bindParam(":id", $_REQUEST["p_id"]);
                $stmt->execute();
                $check = $stmt->fetch(PDO::FETCH_LAZY);
                if ($check["count"] == 0) {
                    $_SESSION["error"] = "Post is not available or does not exist";
                    header("Location: ./");
                    exit();
                }
                else {
                    showPosts($query, false, false);
                }
                ?>
                <!-- Comments Form -->
                <div class="well">
                    <?php
                    showError();
                    showSuccess();
                    ?>
                    <h4>Leave a Comment:</h4>
                    <form action="" method="POST" role="form">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" class="form-control" name="comment_author" id="comment_author">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input type="text" class="form-control" name="comment_email" id="comment_email">
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Comment</label>
                            <textarea class="form-control" rows="3" name="comment_content" id="comment_content"></textarea>
                        </div>
                        <button type="submit" onclick="return doCommentsValidate();" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php
                while ($comment = $comments->fetch(PDO::FETCH_LAZY)) {
                ?>
                <div class = "media">
                    <a class="pull-left" href="#"><img class="media-object" src = "http://placehold.it/64x64" alt = "Loading image"></a>
                    <div class = "media-body">
                        <h4 class="media-heading"><?=$comment["comment_author"]?>
                            <small><?=$comment["comment_date"]?></small>
                        </h4>
                        <?=$comment["comment_content"]?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php
            require_once("includes/sidebar.php");
            ?>
        </div>
        <!-- /.row -->

        <hr>
<?php
require_once ("includes/footer.php");
?>