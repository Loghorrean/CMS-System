<?php
require_once("includes/db.php");
require_once ("includes/header.php");
checkUsersCookie($pdo);
?>
<!-- Navigation -->
<?php
require_once("includes/navigation.php");
$sql = "SELECT users.username as 'username', posts.* from posts ";
$sql .= "left join users on users.user_id = posts.post_author_id where post_status = 'published'";
$query = $pdo->prepare($sql);
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