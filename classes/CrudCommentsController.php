<?php
require_once "Database.php";
require_once "CrudPostsController.php";
require_once "Traits.php";
class CrudCommentsController extends Database {

    use basicPdoFunctions;

    public function __destruct()
    {
        echo "<br>CrudCommentsController destructed!<br>";
    }

    public function insertComment($values = []) {
        if (empty($values)) {
            die("Vi eblan, znachenia pustie");
        }
        $sql = "INSERT into comments (comment_post_id, comment_author_id, comment_content, comment_status, comment_date) ";
        $sql .= "VALUES (:post_id, :auth_id, :cont, :stat, now())";
        $this->run($sql, $values);
        $user = CrudPostsController::getInstance();
        $sql = "UPDATE posts SET post_comment_count = post_comment_count + 1 where post_id = :id";
        $user->run($sql, ["id" => $values["post_id"]]);
    }

    public function deleteComment($values = []) {
        if (empty($values)) {
            die("Vi eblan");
        }
        $sql = "DELETE from comments where comment_id = :id";
        $this->run($sql, ["id" => $values["id"]]);
        $user = CrudPostsController::getInstance();
        $sql = "UPDATE posts SET post_comment_count = post_comment_count - 1 where post_id = :post_id";
        $user->run($sql, ["post_id" => $values["post_id"]]);
    }
}


$cr2 = CrudCommentsController::getInstance();
$cr2->insertComment(["post_id" => 1, "auth_id" => 7, "cont" => "Huynia", "stat" => "approved"]);
$cr2->deleteComment(["id" => 50, "post_id" => 1]);