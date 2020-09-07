<?php
require_once("includes/admin_header.php");
$select_all = $pdo->prepare("Select comments.*, posts.post_title as 'post_title' from comments inner join posts on comments.comment_post_id = posts.post_id");
$select_all->execute(); // select_all contains all rows from the category table

if (isset($_POST["submit_delete"])) {
    deleteComment($_POST["comment_id"], $_POST["comment_post_id"], $pdo);
    return;
}
if (isset($_POST["submit_approve"])) {
    approveComment($_POST["comment_id"], $pdo);
    return;
}
if (isset($_POST["submit_unapprove"])) {
    unapproveComment($_POST["comment_id"], $pdo);
    return;
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
                        Comments
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
                    case 'edit_comment':
                        require("includes/edit_comment.php");
                        break;
                    default:
                        require("includes/view_all_comments.php");
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