<?php
require_once("includes/admin_header.php");
if (!isset($_SESSION["user_id"])) {
    $_SESSION["error"] = "You are not logged in!";
    header("Location: ../");
    exit();
}
$row = findUsersById($_SESSION["user_id"], $pdo);
if (isset($_POST["edit_profile"])) {
    $values = ["user_id" => $_POST["user_id"], "username" => $_POST["username"], "role" => $_POST["user_role"],
        "firstname" => $_POST["user_firstname"], "lastname" => $_POST["user_lastname"], "email" => $_POST["user_email"]];
    $path = "profile.php";
    editUser($values, $pdo, $path);
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
                        Profile
                    </h1>
                </div>
                <?php
                showError();
                showSuccess();
                ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class = "form-group">
                        <label for = "username">Username</label>
                        <input type="text" id = "username" class = "form-control" name="username" value="<?=$row["username"]?>">
                    </div>
                    <div class = "form-group">
                        <label for = "user_firstname">First Name</label>
                        <input type="text" id = "user_firstname" class = "form-control" name="user_firstname" value="<?=htmlspecialchars($row["user_firstname"])?>">
                    </div>
                    <!--    <div class = "form-group">-->
                    <!--        <label for = "post_image">Post Image</label><br>-->
                    <!--        <img width = "200" src="../images/--><?//=htmlspecialchars($row["post_image"])?><!--" alt = "Loading image">-->
                    <!--        <input type="file" name="post_image">-->
                    <!--    </div>-->
                    <div class = "form-group">
                        <label for = "user_lastname">Last Name</label>
                        <input type="text" id = "user_lastname" class = "form-control" name="user_lastname" value="<?=htmlspecialchars($row["user_lastname"])?>">
                    </div>
                    <div class = "form-group">
                        <label for = "user_email">Email</label><br>
                        <input type="text" id = "user_email" class = "form-control" name="user_email" value="<?=htmlspecialchars($row["user_email"])?>">
                    </div>
                    <div class = "form-group">
                        <input type = "hidden" name = "user_id" value = "<?=$row["user_id"]?>">
                        <input type = "hidden" name = "user_role" value = "<?=$row["user_role"]?>">
                        <input type="submit" name="edit_profile" value = "Edit User" class = "btn btn-primary">
                    </div>
                </form>
                <form action = "password_change.php" method = "POST">
                    <div class = "form-group">
                        <input type="submit" name="edit_password" value="Edit password" class = "btn btn-primary">
                    </div>
                </form>
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
