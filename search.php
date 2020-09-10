<?php
require_once("includes/db.php");
require_once ("includes/header.php");
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
                $search = htmlspecialchars($_POST["search"]);
                $sql = "SELECT users.username as 'username', posts.* from posts ";
                $sql .= "left join users on users.user_id = posts.post_author_id ";
                $sql .= "where post_tags LIKE :srch";
                $stmt = $pdo->prepare($sql);
                $keyword = '%'.$search.'%';
                $stmt->bindParam(":srch", $keyword);
                $stmt->execute();
            }
            else {
                header("Location: ./");
            }
            ?>
            <h1 class="page-header">
                My little CMS
            </h1>

            <!-- First Blog Post -->
            <?php
            $query = $pdo->prepare("SELECT count(post_id) as count from posts where post_tags LIKE :srch");
            $keyword = '%'.$search.'%';
            $query->bindParam(":srch", $keyword);
            $query->execute();
            $count = $query->fetch(PDO::FETCH_LAZY);
            if ($count["count"] == 0) {
                echo "<h1>No results</h1>";
            }
            else {
                showPosts($stmt, true, true);
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