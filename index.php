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
            $query = $pdo->prepare("SELECT * FROM posts where post_status = 'published'");
            $query->execute();
            ?>
            <h1 class="page-header">
                Main Page
            </h1>

            <!-- First Blog Post -->
            <?php
            $stmt = $pdo->prepare("SELECT count(post_id) as 'count' from posts where post_status = 'published'");
            $stmt->execute();
            $check = $stmt->fetch(PDO::FETCH_LAZY);
            if ($check["count"] == 0) {
                echo '<h1 class="text-center">No Published Posts Yet</h1>';
            }
                showPosts($query, true, true);
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