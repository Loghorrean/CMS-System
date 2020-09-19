<?php
require_once "Database.php";
require_once "CrudController.php";
require_once "CrudCommentsController.php";
class CrudPostsController extends Database implements CrudController {

    use basicPdoFunctions;

    public function Insert($values = []) {
        echo "<br>Insert post<br>";
        try {
            $sql = "INSERT into posts (post_category_id, post_title, post_author_id, post_date, post_image, post_content, post_tags, post_status) ";
            $sql .= "VALUES (:cat_id, :ttl, :auth_id, now(), :img, :cont, :tag, :stat)";
            $this->run($sql, $values);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Update($values = []) {
        try {
            $sql = "UPDATE posts set post_category_id = :cat_id, post_title = :ttl, post_author_id = :auth_id, ";
            $sql .= "post_date = now(), post_image = :img, post_content = :cnt, post_tags = :tags, post_status = :stat ";
            $sql .= "WHERE post_id = :id";
            $this->run($sql, $values);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Delete($values = []) {
        try {
            $sql = "DELETE from posts where post_id = :id";
            $this->run($sql, $values);
            $comments = CrudCommentsController::getInstance();
            $sql = "DELETE from comments where comment_post_id = :id";
            $comments->sql($sql, $values);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function __destruct() {

    }
}
