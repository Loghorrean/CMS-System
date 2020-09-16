<?php
require_once "Database.php";
require_once "Traits.php";
class CrudUsersController extends Database {

    use basicPdoFunctions;

    public function __destruct() {
        echo "<br>CrudUsersController destructed!<br>";
    }
}
