<?php
require_once("includes/db.php");
require_once ("includes/header.php");
checkUsersCookie();
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
            $sql .= "left join users on users.user_id = posts.post_author_id where post_status = 'published'";
            $query = $pdo->prepare($sql);
            $query->execute();
            ?>
            <h1 class="page-header">
                Main Page
            </h1>
            <!-- First Blog Post -->
            <?php
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