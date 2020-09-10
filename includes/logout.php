<?php
session_start();
session_destroy();
setcookie("login", "", time() - 1, "/");
setcookie("key", "", time() - 1, "/");
header("Location: ../");
?>