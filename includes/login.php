<?php
require_once("db.php");
session_start();
if (isset($_POST["login"])) {
    $salt = "XyZzy12*_";
    $password = hash("md5", $salt.$_POST["password"]);
    $query = $pdo->prepare("SELECT * from users where username = :nam and user_password = :pass");
    $query->bindParam(":nam", $_POST["username"]);
    $query->bindParam(":pass", $password);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_LAZY);
    if ($row !== false) {
        $_SESSION["name"] = $row["username"];
        $_SESSION["user_role"] = $row["user_role"];
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["success"] = "You are logged in!";
        header("Location: ../");
        return;
    }
    else {
        $_SESSION["error"] = "Incorrect password";
        header("Location: ../");
    }
}
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: ../");
}
?>