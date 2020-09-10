<?php
require_once("includes/admin_header.php");
$select_all = $pdo->prepare("Select * from users");
$select_all->execute(); // select_all contains all rows from the category table

if (!isset($_SESSION["user_id"])) {
    header("Location: ../");
    exit();
}

if (isset($_POST["submit_delete"])) {
    deleteUser($_POST["user_id"], $pdo);
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
                        Users
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
                    case 'add_user':
                        require("includes/add_user.php");
                        break;
                    case 'edit_user':
                        require("includes/edit_user.php");
                        break;
                    default:
                        require("includes/view_all_users.php");
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
