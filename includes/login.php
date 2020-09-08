<?php
session_start();
require_once("db.php");
if (isset($_POST["login"])) {
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $_SESSION["error"] = "All fields are required!";
        header("Location: ../");
        exit();
    }
    else {
        $query = $pdo->prepare("SELECT * from users where username = :nam");
        $query->bindParam(":nam", $_POST["username"]);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_LAZY);
        if (!empty($user)) {
            $salt = $user["randSalt"];
            $password = hash("md5", $salt . $_POST["password"]);
            if ($user["user_password"] === $password) {
                $_SESSION["name"] = $user["username"];
                $_SESSION["user_role"] = $user["user_role"];
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["success"] = "You are logged in!";
                header("Location: ../");
                exit();
            } else {
                $_SESSION["error"] = "Incorrect password";
                header("Location: ../");
                exit();
            }
        }
        else {
            $_SESSION["error"] = "No such user!";
            header("Location: ../");
            exit();
        }
    }
}
if (isset($_POST["logout"])) {
    header("Location: logout.php");
}
?>
