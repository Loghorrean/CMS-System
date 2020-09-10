<?php
require_once("includes/header.php");
if (isset($_GET["p_id"])) {
    if (!checkId($_GET["p_id"])) {
        header("Location: ./");
        exit();
    }
    $sql = "SELECT users.username as 'username', posts.*, (SELECT count(post_id) from posts where post_id = :id and post_status = 'published') as 'count' from posts ";
    $sql .= "left join users on users.user_id = posts.post_author_id where post_id = :id and post_status = 'published'";
    $query = $pdo->prepare($sql);
    $query->bindParam(":id", $_GET["p_id"]);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_LAZY);
    if ($row["count"] == 0) {
        header("Location: ./");
        exit();
    }
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
                $post_content = $row["post_content"];
                showPost($row, $post_content);
                if (showEditButton($pdo)) {
                    echo '<a class="btn btn-primary" style="" href="admin/posts.php?source=edit_post&p_id=' . $_GET["p_id"] . '">Edit Post</a>';
                }
                ?>
                <!-- Comments Form -->
                    <?php
                    showError();
                    showSuccess();
                    ?>
                    <?php
                    if (isset($_SESSION["user_id"])) { ?>
                        <div class="well">
                            <h4>Leave a Comment:</h4>
                            <form action="" method="POST" role="form">
                                <div class="form-group">
                                    <label for="comment_content">Text</label>
                                    <textarea class="form-control" rows="3" name="comment_content" id="comment_content"></textarea>
                                </div>
                                <button type="submit" onclick="return doCommentsValidate();" class="btn btn-primary" name="create_comment">Comment!</button>
                            </form>
                        </div>
                        <?php } ?>
                <!-- Posted Comments -->

                <!-- Comment -->
                <h3>Comment section</h3>
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