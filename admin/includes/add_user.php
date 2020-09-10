<?php
if (isset($_POST["add_user"])) {
    if (!checkMail($_POST["user_email"])) {
        header("Location: users.php?source=add_user");
        return;
    }
    if (!checkPassword($_POST["user_password"])) {
        header("Location: users.php?source=add_user");
        return;
    }
    insertUser($pdo);
}
?>
<form action="" method="POST" enctype="multipart/form-data">
    <div class = "form-group">
        <label for = "username">Username</label>
        <input type="text" class = "form-control" name="username" id = "username">
    </div>
    <div class = "form-group">
        <label for = "user_role">User Role</label>
        <select name="user_role" id="user_role">
            <option disabled>Choose a role</option>
            <option value="admin">Admin</option>
            <option value="modifier">Modifier</option>
            <option value="user">User</option>
        </select>
    </div>
<!--    <div class = "form-group">-->
<!--        <label for = "user_image">User Image</label>-->
<!--        <input type="file" name="user_image" id="user_image">-->
<!--    </div>-->
    <div class = "form-group">
        <label for = "user_firstname">First Name</label>
        <input type="text" class = "form-control" name="user_firstname" id = "user_firstname">
    </div>
    <div class = "form-group">
        <label for = "user_lastname">Last Name</label><br>
        <input type="text" class = "form-control" name="user_lastname" id = "user_lastname">
    </div>
    <div class = "form-group">
        <label for = "user_email">Email</label><br>
        <input type="text" class = "form-control" name="user_email" id = "user_email">
    </div>
    <div class = "form-group">
        <label for = "user_password">Password</label><br>
        <input type="text" class = "form-control" name="user_password" id = "user_password">
    </div>
    <div class = "form-group">
        <input onclick = "return doUsersValidate();" type="submit" name="add_user" value = "Add User" class = "btn btn-primary">
    </div>
</form>