<?php
require_once("includes/admin_header.php");
$select_all = $pdo->prepare("select category.cat_title as 'cat_title', posts.* from posts left join category on posts.post_category_id = category.cat_id");
$select_all->execute(); // select_all contains all rows from the category table
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