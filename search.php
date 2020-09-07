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
                $stmt = $pdo->prepare("SELECT * from posts where post_tags LIKE :srch");
                $keyword = '%'.$search.'%';
                $stmt->bindParam(":srch", $keyword);
                $stmt->execute();
            }
            ?>
            <h1 class="page-header">
                My little CMS
            </h1>

            <!-- First Blog Post -->
            <?php
            $query = $pdo->prepare("SELECT count(post_id) as count_posts from posts where post_tags LIKE :srch");
            $keyword = '%'.$search.'%';
            $query->bindParam(":srch", $keyword);
            $query->execute();
            $count = $query->fetch(PDO::FETCH_LAZY);
            if ($count["count_posts"] == 0) {
                echo "<h1>No results</h1>";
            }
            else {
                while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                    ?>
                    <h2>
                        <a href="#"><?=htmlspecialchars($row["post_title"])?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?=htmlspecialchars($row["post_author"])?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?=htmlspecialchars($row["post_date"])?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?=htmlspecialchars($row["post_image"])?>" alt="Loading...">
                    <hr>
                    <p><?=htmlspecialchars($row["post_content"])?></p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
                <?php } 
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