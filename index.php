<?php
require_once("includes/db.php");
require_once ("includes/header.php");
//$user_controller = CrudUsersController::getInstance();
checkUsersCookie($pdo);
?>
<!-- Navigation -->
<?php
require_once("includes/navigation.php");
if (isset($_GET["page"])) {
    if (!checkId($_GET["page"])) {
        header("Location: ./");
        return;
    }
    else {
        $page = $_GET["page"];
    }
    if ($page == "" || $page == 1) {
        $page_1 = 0;
    }
    else {
        $page_1 = ($page * 5) - 5;
    }
}
else {
    $page_1 = 0;
}
$post_controller = CrudPostsController::getInstance();
$count_posts = ceil($post_controller->getRow("SELECT count(*) as 'count' from posts")["count"] / POST_PER_PAGE);
$sql = "SELECT users.username as 'username', posts.* from posts ";
$sql .= "left join users on users.user_id = posts.post_author_id where post_status = 'published' LIMIT :page, 5";
$posts = $post_controller->getRows($sql, ["page" => [$page_1 => "int"]]);
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
                <?php
                for($i = 1; $i <= $count_posts; $i++) {
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                }
                ?>
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