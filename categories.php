<?php
require_once ("includes/header.php");
if (isset($_GET["cat"])) {
    if (!checkId($_GET["cat"])) {
        header("Location: ./");
        return;
    }
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
            $stmt = $pdo->prepare("SELECT * FROM posts where post_category_id = :id");
            $stmt->bindParam(":id", $_GET["cat"]);
            $stmt->execute();
            ?>
            <h1 class="page-header">
                My little CMS
            </h1>

            <!-- First Blog Post -->
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                ?>
                <h2>
                    <a href="post.php?p_id=<?=$row["post_id"]?>"><?=htmlspecialchars($row["post_title"])?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?=htmlspecialchars($row["post_author"])?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?=htmlspecialchars($row["post_date"])?></p>
                <hr>
                <a href = "post.php?p_id=<?=$row["post_id"]?>"><img class="img-responsive" src="images/<?=$row["post_image"]?>" alt="Loading..."></a>
                <hr>
                <p><?=htmlspecialchars($row["post_content"])?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
            <?php } ?>
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