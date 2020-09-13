<?php
if (isset($_GET["u_id"])) {
    if (!checkId($_GET["u_id"])) {
        header("Location: users.php");
        exit();
    }
    $row = findUsersById($_GET["u_id"], $pdo);
}
if (isset($_POST["edit_user"])) {
    $values = [":nam" => $_POST["username"], ":fname" => $_POST["user_firstname"], ":lname" => $_POST["user_lastname"],
        ":mail" => $_POST["user_email"], ":role" => $_POST["user_role"], ":id" => $_POST["user_id"]];
    editUser($values, $pdo);
}
?>
<form action="" method="POST" enctype="multipart/form-data">
    <div class = "form-group">
        <label for = "username">Username</label>
        <input type="text" id = "username" class = "form-control" name="username" value="<?=$row["username"]?>">
    </div>
    <div class = "form-group">
        <label for = "user_role">User Role</label><br>
        <select name="user_role" id = "user_role">
            <option value="admin" <?=$selected = $row["user_role"] == "admin" ? "selected" : ""?>>Admin</option>
            <option value="modifier" <?=$selected = $row["user_role"] == "modifier" ? "selected" : ""?>>Modifier</option>
            <option value="subscriber" <?=$selected = $row["user_role"] == "subscriber" ? "selected" : ""?>>Subscriber</option>
        </select>
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
        <input type="submit" name="edit_user" value = "Edit User" class = "btn btn-primary">
    </div>
</form>