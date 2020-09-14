<?php
require_once("includes/db.php");
require_once ("includes/header.php");
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
$query = $pdo->prepare("SELECT count(*) as 'count' from posts");
$count_posts = $query->execute();
$count_posts = $query->fetch(PDO::FETCH_LAZY)["count"];
$count_posts = ceil($count_posts / 5);
$sql = "SELECT users.username as 'username', posts.* from posts ";
$sql .= "left join users on users.user_id = posts.post_author_id where post_status = 'published' LIMIT :page, 5";
$query = $pdo->prepare($sql);
$query->bindParam(":page", $page_1, PDO::PARAM_INT);
$query->execute();
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
            $counter = 0;
            while ($row = $query->fetch(PDO::FETCH_LAZY)) {
                $row["post_content"] = substr($row["post_content"], 0, 50)."...";
                showPost($row, true);
                $counter++;
            }
            if ($counter == 0) {
                echo '<h1 class="text-center">No Published Posts Yet</h1>';
            }
            ?>
            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <?php
                for($i = 1; $i <= $count_posts; $i++) {
                    if (isset($_GET["page"]) && $i == $_GET["page"]) {
                        $current_page = 
                    }
                    else {
                        $current_page =
                    }
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