<?php
require_once("includes/admin_header.php");
$sql = "SELECT category.cat_title as 'cat_title', users.username as 'post_author', posts.* from posts ";
$sql .= "left join category on posts.post_category_id = category.cat_id ";
$sql .= "left join users on posts.post_author_id = users.user_id order by posts.post_id DESC";
$select_all = $pdo->prepare($sql);
$select_all->execute(); // select_all contains all rows from the category table

if (!isset($_SESSION["user_id"])) {
    header("Location: ../");
    exit();
}

if (isset($_POST["submitBulk"]) && isset($_POST["checkBoxArray"])) {
    $bulk_option = $_POST["bulkOptions"];
    switch($bulk_option) {
        case "published":
            foreach ($_POST["checkBoxArray"] as $p_id) {
                setPostStatus("published", $p_id, $pdo);
                header("Location: posts.php");
            }
            break;
        case "draft" :
            foreach ($_POST["checkBoxArray"] as $p_id) {
                setPostStatus("draft", $p_id, $pdo);
                header("Location: posts.php");
            }
            break;
        case "delete":
            foreach ($_POST["checkBoxArray"] as $p_id) {
                deletePost($p_id, $pdo);
                header("Location: posts.php");
            }
            break;
    }
}
if (isset($_POST["submit_delete"])) {
    deletePost($_POST["post_id"], $pdo);
    $_SESSION["success"] = "Post deleted";
    header("Location: posts.php");
    exit();
}
?>


<body>
    <div id="wrapper">
        <?php
        require_once("includes/admin_navigation.php");
        ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Posts
                        </h1>
                    </div>
                    <?php
                    showError();
                    showSuccess();
                    if (isset($_GET["source"]))  {
                        $source = $_GET["source"];
                    }
                    else {
                        $source = '';
                    }
                    switch ($source) {
                        case 'add_post':
                            require("includes/add_post.php");
                            break;
                        case 'edit_post':
                            require("includes/edit_post.php");
                            break;
                        default:
                            require("includes/view_all_posts.php");
                            break;
                    }
                    ?>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <?php
    require_once("includes/admin_footer.php");
    ?>