<?php
require_once("includes/db.php");
require_once ("includes/header.php");
if (empty($_POST["search"])) {
    header("Location: ./");
    exit();
}
?>
<!-- Navigation -->
<?php
require_once("includes/navigation.php");
?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            if (isset($_POST["submit"])) {
                $keyword = '%'.htmlspecialchars($_POST["search"]).'%';
                $sql = "SELECT users.username as 'username', posts.* from posts ";
                $sql .= "left join users on users.user_id = posts.post_author_id ";
                $sql .= "where post_tags LIKE :srch and post_status = 'published'";
                $posts = CrudPostsController::getInstance()->getRows($sql, ["srch" => [$keyword => "str"]]);
            }
            else {
                header("Location: ./");
            }
            ?>
            <h1 class="page-header">
                Search Page<?=$theme = ", theme - ".htmlspecialchars($_POST["search"]) ?? ""?>
            </h1>

            <!-- First Blog Post -->
            <?php
            if (empty($posts)) {
                echo '<h1 class="text-center">No Published Posts Yet</h1>';
            }
            else {
                foreach($posts as $post) {
                    $post["post_content"] = (strlen($post["post_content"]) > 35) ? substr($post["post_content"], 0, 35)."..." : $post["post_content"];
                    showPost($post, true);
                }
            }
            ?>
            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

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