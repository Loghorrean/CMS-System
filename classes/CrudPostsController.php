<?php
require_once "Database.php";
require_once "Traits.php";
class CrudPostsController extends Database {
    use basicPdoFunctions;

    public function __destruct() {
        echo "<br>CrudPostsController destructed!<br>";
    }
}