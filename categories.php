<?php
require_once ("includes/header.php");
if (isset($_GET["cat"])) {
    if (!checkId($_GET["cat"])) {
        header("Location: ./");
        return;
    }
}
$sql = "SELECT users.username as 'username', posts.* FROM posts ";
$sql .= "left join users on users.user_id = posts.post_author_id ";
$sql .= "where post_category_id = :id and post_status = 'published'";
$values = ["id" => [$_GET["cat"] => "str"]];
$posts = CrudPostsController::getInstance()->getRows($sql, $values);
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
            <h1 class="page-header">
                Main Page
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