<?php
require_once ("includes/header.php");
if (isset($_GET["auth_name"])) {
    $auth_name = filterInput($_GET["auth_name"]);
    $query = $pdo->prepare("SELECT * from users where username = :name");
    $query->execute(array(":name" => $auth_name));
    if (!$row = $query->fetch(PDO::FETCH_LAZY)) {
        header("Location: ./");
        exit();
    }
    $query = NULL;
}
else {
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
            $sql = "SELECT users.username as 'username', posts.*, (select count(post_id) from posts where post_status = 'published') as 'count' from posts ";
            $sql .= "left join users on users.user_id = posts.post_author_id where post_status = 'published' and users.username = :name";
            $query = $pdo->prepare($sql);
            $query->execute(array(":name" => $auth_name));
            ?>
            <h1 class="page-header">
                Posts made by <?=$auth_name?>
            </h1>
            <!-- First Blog Post -->
            <?php
            $counter = 0;
            while ($row = $query->fetch(PDO::FETCH_LAZY)) {
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