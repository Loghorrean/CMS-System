<table class = "table table-bordered table-hover">
    <thead>
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Password</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Image</th>
        <th>Role</th>
        <th>Delete user</th>
        <th>Edit user</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = $select_all->fetch(PDO::FETCH_LAZY)) {
        ?>
        <tr>
            <td><?=htmlspecialchars($row["user_id"])?></td>
            <td><?=htmlspecialchars($row["username"])?></td>
            <td><?=htmlspecialchars($row["user_password"])?></td>
            <td><?=htmlspecialchars($row["user_firstname"])?></td>
            <td><?=htmlspecialchars($row["user_lastname"])?></td>
            <td><?=htmlspecialchars($row["user_email"])?></td>
            <td><?=htmlspecialchars($row["user_image"])?></td>
            <td><?=htmlspecialchars($row["user_role"])?></td>
            <td><a href="users.php?delete=<?=$row["user_id"]?>">Delete</a></td>
            <td><a href="users.php?source=edit_user&u_id=<?=$row["user_id"]?>">Edit</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php
if (isset($_GET["delete"])) {
    showDeleteUserForm($_GET["delete"], $pdo);
}
?>