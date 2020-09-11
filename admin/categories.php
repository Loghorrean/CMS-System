<?php
require_once("includes/admin_header.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: ../");
    exit();
}

$select_all = $pdo->prepare("SELECT * from category");
$select_all->execute(); // select_all contains all rows from the category table

if (isset($_POST["submit_add"])) { // add button
    if (empty($_POST["cat_title"])) {
        $_SESSION["error"] = "This field should not be empty!";
        header("Location: categories.php");
        return;
    }
    insertCategory($_POST["cat_title"], $pdo);
    return;
}


if (isset($_POST["submit_edit"])) { // edit button
    if (empty($_POST["cat_title"])) {
        $_SESSION["error"] = "This field should not be empty!";
        header("Location: categories.php");
        return;
    }
    $values = [":ttl" => $_POST["cat_title"], ":id" => $_POST["cat_id"]];
    editCategory($values, $pdo);
    return;
}


if (isset($_POST["submit_delete"])) { //delete button
    deleteCategory($_POST["cat_id"], $pdo);
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
                            Categories
                        </h1>
                    </div>
                    <div class = "col-xs-6">
                        <form action="" method = "POST">
                            <?php
                            showError();
                            showSuccess();
                            ?>
                            <div class = "form-group">
                                <label for = "cat_title">Add Category Title</label>
                                <input class = "form-control" type="text" name="cat_title">
                            </div>
                            <div class = "form-group">
                                <input class = "btn brn-primary" type="submit" name="submit_add" value = "Add category">
                            </div>
                        </form>
                        <form action="" method = "POST">
                            <?php
                            if (isset($_GET["edit"])) {
                                showEditCategoryForm($_GET["edit"], $pdo);
                            }
                            if (isset($_GET["delete"])) {
                                showDeleteCategoryForm($_GET["delete"], $pdo);
                            }
                            ?>
                        </form>
                    </div><!-- Add, delete and edit category forms -->
                    <div class = "col-xs-6">
                        <table class = "table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Category Id</th>
                                    <th>Category Title</th>
                                    <th>Delete field</th>
                                    <th>Edit field</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $select_all->fetch(PDO::FETCH_LAZY)) {
                                ?>
                                <tr>
                                    <td><?=$row["cat_id"]?></td>
                                    <td><?=$row["cat_title"]?></td>
                                    <td><a href="categories.php?delete=<?=$row['cat_id']?>">Delete</a></td>
                                    <td><a href="categories.php?edit=<?=$row['cat_id']?>">Edit</a></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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