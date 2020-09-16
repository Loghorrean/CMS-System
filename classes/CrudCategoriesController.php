<?php
require_once "Database.php";
require_once "Traits.php";
class CrudCategoriesController extends Database {
    use basicPdoFunctions;

    public function InsertCategory($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "INSERT into category (cat_title) VALUES (:cat_ttl)";
        $this->run($sql, $values);
    }

    public function UpdateCategory($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "UPDATE category SET cat_title = :ttl where category.cat_id = :id";
        $this->run($sql, $values);
    }

    public function DeleteCategory($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "DELETE from category where cat_id = :id";
        $this->run($sql, $values);
    }

    public function __destruct() {
        echo "<br>CrudCategoriesController destructed!<br>";
    }
}