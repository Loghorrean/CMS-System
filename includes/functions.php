<?php

/* Functions to show error and success messages */

function showError() { // showing error messages
    if (isset($_SESSION["error"])) {
        echo '<p class="text-danger">'.$_SESSION["error"].'</p>';
        unset($_SESSION["error"]);
    }
}


function showSuccess() { // showing success messages
    if (isset($_SESSION["success"])) {
        echo '<p class="text-success">'.$_SESSION["success"].'</p>';
        unset($_SESSION["success"]);
    }
}


/* Functions to find an object in the database, returns false if the object is absent or pdo object otherwise */



function findCategoriesById($cat_id, $pdo) {
    $query = $pdo->prepare("SELECT category.*, count(cat_id) as 'count' from category where cat_id = :id");
    $query->bindParam(":id", $cat_id);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_LAZY);
    if ($row["count"] == "0") {
        $_SESSION["error"] = "No category with such id!";
        header("categories.php");
        return false;
    }
    else {
        return $row;
    }
}

function findPostsById($p_id, $pdo) {
    $query = $pdo->prepare("SELECT posts.*, count(post_id) as 'count' from posts where post_id = :id");
    $query->bindParam(":id", $p_id);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_LAZY);
    if ($row["count"] == "0") {
        $_SESSION["error"] = "No post with such id!";
        header("posts.php");
        return false;
    }
    else {
        return $row;
    }
}

function findCommentsById($com_id, $pdo) {
    $query = $pdo->prepare("SELECT comments.*, count(comment_id) as 'count' from comments where comment_id = :id");
    $query->bindParam(":id", $com_id);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_LAZY);
    if ($row["count"] == "0") {
        $_SESSION["error"] = "No comment with such id!";
        header("Location: comments.php");
        return false;
    }
    else {
        return $row;
    }
}

function findUsersById($u_id, $pdo) {
    $query = $pdo->prepare("SELECT users.*, count(user_id) as 'count' from users where user_id = :id");
    $query->bindParam(":id", $u_id);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_LAZY);
    if ($row["count"] == "0") {
        $_SESSION["error"] = "No user with such id!";
        header("Location: users.php");
        return false;
    }
    else {
        return $row;
    }
}


/* Checker functions */


function checkId($id) { // checking the id of the table
    if (empty($id)) {
        $_SESSION["error"] = "No id!";
        return false;
    }
    if (!is_numeric($id)) {
        $_SESSION["error"] = "Id should be a number!";
        return false;
    }
    if ($id < 0) {
        $_SESSION["error"] = "Id must be a positive integer!";
        return false;
    }
    return true;
}

function checkMail(string $mail) {
    if (empty($mail)) {
        $_SESSION["error"] = "No mail given";
        return false;
    }
    if (!preg_match("/.+@.+\..+/i", $mail)) {
        $_SESSION["error"] = "Wrong mail format (must include @ and .)";
        return false;
    }
    return true;
}

function checkPassword(string $password) {
    $check = true;
    $errors = array();
    if (empty($password)) {
        $_SESSION["error"] = "No password given";
        return false;
    }
    if (strlen($password) < 9) {
        $errors[] = "Password is too short<br>";
        $check = false;
    }
    if (!preg_match("/[0-9]+/", $password)) {
        $errors[] = "Password must include at least one number<br>";
        $check = false;
    }
    if (!preg_match("/[A-Z]+/", $password)) {
        $errors[] = "Password must include at least one capital letter (A, B, C...)<br>";
        $check = false;
    }
    if (!$check) {
        foreach($errors as $error) {
            $_SESSION["error"] .= $error;
        }
        return false;
    }
    else {
        return true;
    }
}

function filterInput($value) {
    $value = trim($value);
    $value = stripslashes($value);
    return $value;
}


/* Insert functions */


function insertPost($values, $pdo) { // adding a post
    foreach($values as &$v) {
        $v = filterInput($v);
    }
    unset($v);
    try {
        $sql = "INSERT into posts (post_category_id, post_title, post_author_id, post_date, post_image, post_content, post_tags, post_status) ";
        $sql .= "VALUES (:cat_id, :ttl, :auth_id, now(), :img, :cnt, :tag, :stat)";
        $query = $pdo->prepare($sql);
        $query->execute($values);
        $query = NULL;
        $_SESSION["success"] = "Post added!";
        header("Location: posts.php");
        exit();
    } catch(PDOException $e) {
        $_SESSION["error"] = "SQL exception: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}


function insertCategory(string $cat_title, $pdo) { // adding a category
	try {
        $query = $pdo->prepare("INSERT into category (cat_title) VALUES (:ttl)");
        $query->bindParam(":ttl", $cat_title);
        $query->execute();
        $query = NULL;
        $_SESSION["success"] = "New category inserted!";
        header("Location: categories.php");
        exit();
    }   catch (PDOException $e) {
        $_SESSION["error"] = "SQL exception: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}


/* Delete functions */


function deleteCategory(int $cat_id, $pdo) { // deleting a category
	try {
        $query = $pdo->prepare("DELETE from category where cat_id = :id");
        $query->bindParam(":id", $cat_id);
        $query->execute();
        $query = NULL;
        $_SESSION["success"] = "Category deleted!";
        header("Location: categories.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}

function deletePost(int $p_id, $pdo) {
    try {
        $query = $pdo->prepare("DELETE from posts where post_id = :id");
        $query->bindParam(":id", $p_id);
        $query->execute();
        $query = NULL;
        return;
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}


/* Edit functions */


function editCategory($values, $pdo) { // editing a category
    foreach($values as &$v) {
        $v = filterInput($v);
    }
    unset($v);
	try {
        $query = $pdo->prepare("UPDATE category SET cat_title = :ttl where category.cat_id = :id");
        $query->execute($values);
        $query = NULL;
        $_SESSION["success"] = "Category successfully edited!";
        header("Location: categories.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
	}
}

function editPost(array $values, $pdo) { // editing a post
    foreach ($values as &$v) {
        $v = filterInput($v);
    }
    unset($v);
    try {
        $sql = "UPDATE posts SET post_category_id = :cat_id, post_title = :ttl, post_author_id = :auth, post_date = now(), ";
        $sql .= "post_image = :img, post_content = :cnt, post_tags = :tgs, post_status = :stat ";
        $sql .= "where post_id = :id";
        $query = $pdo->prepare($sql);
        $query->execute($values);
        $query = NUll;
        $_SESSION["success"] = "Post edited";
        header("Location: posts.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}

function editUser($values, $pdo, $path = "users.php") {
    foreach($values as &$v) {
        $v = filterInput($v);
    }
    unset($v);
    try {
        $sql = "UPDATE users SET username = :nam, user_firstname = :fname, user_lastname = :lname, ";
        $sql .= "user_email = :mail, user_role = :role where user_id = :id";
        $query = $pdo->prepare($sql);
        $query->execute($values);
        $query = NULL;
        $_SESSION["success"] = "User edited";
        header("Location: {$path}");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}


/* Functions that create forms to confirm an action */


function showEditCategoryForm($cat_id, $pdo) { // showing the form to edit a category
    if (!checkId($cat_id)) {
        header("Location: categories.php");
        exit();
    }
    $row = findCategoriesById($cat_id, $pdo);
	echo '<div class = "form-group">';
		echo '<label for = "cat_title">Edit Category Title (id = '.$row["cat_id"].')</label>';
		echo '<input class = "form-control" type="text" value = "'.$row["cat_title"].'" name="cat_title">';
		echo '<input type="hidden" value = "'.$row['cat_id'].'" name="cat_id">';
	echo '</div>';
	echo '<div class = "form-group">';
		echo '<input class = "btn brn-primary" type="submit" name="submit_edit" value = "Edit category">';
	echo '</div>';
}

function showDeleteCategoryForm($cat_id, $pdo) { // showing the form to delete a category
    if (!checkId($cat_id)) {
        header("Location: categories.php");
        exit();
    }
    $row = findCategoriesById($cat_id, $pdo);
    echo '<div class = "form-group">';
        echo '<label for "cat_title">Delete Category (id = '.$row["cat_id"].')</label>';
        echo '<input type="hidden" value = "'.$row['cat_id'].'" name="cat_id">';
    echo '</div>';
    echo '<div class = "form-group">';
        echo '<input class = "btn brn-primary" type="submit" name="submit_delete" value = "Delete category">';
    echo '</div>';

}

function showDeletePostForm($post_id, $pdo) { // showing the form to delete a post
    if(!checkId($post_id)) {
        header("Location: posts.php");
        exit();
    }
    $row = findPostsById($post_id, $pdo);
    echo '<form action = "" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for "post_title">Delete Post (id = '.$row["post_id"].')</label>';
    echo '<input type="hidden" value = "'.$row['post_id'].'" name="post_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_delete" value = "Delete post">';
    echo '</div>';
    echo '</form>';
}

function showPost($row, $read_more = false) {
    echo '<h2><a href="post.php?p_id=' . $row["post_id"] . '">' . htmlspecialchars($row["post_title"]) . '</a></h2>';
    echo '<p class = "lead">by <a href="author.php?auth_name='.$row["username"].'">' . htmlspecialchars($row["username"]) . '</a></p><hr>';
    echo '<p><span class="glyphicon glyphicon-time"></span> Posted on ' . htmlspecialchars($row["post_date"]) . '</p><hr>';
    echo '<a href="post.php?p_id=' . $row["post_id"] . '"><img class="img-responsive" src="images/' . $row["post_image"] . '" alt="Loading..."></a><hr>';
    echo '<p style="font-weight: 700">' . $row["post_content"] . '</p>';
    if ($read_more) {
        echo '<a class="btn btn-primary" href="post.php?p_id='.$row["post_id"].'">Read More ';
        echo '<span class="glyphicon glyphicon-chevron-right"></span>';
        echo '</a>';
    }
}

function insertComment(array $values, $pdo) { // inserting a comment
    foreach($values as &$v) {
        $v = filterInput($v);
    }
    unset($v);
    try {
        $sql = "INSERT INTO comments (comment_post_id, comment_author_id, ";
        $sql .= "comment_content, comment_status, comment_date";
        $sql .= ") VALUES (:p_id, :auth_id, :cont, 'Unapproved', now())";
        $query = $pdo->prepare($sql);
        $query->execute($values);
        $query = $pdo->prepare("UPDATE posts SET post_comment_count = post_comment_count + 1 where post_id = :p_id");
        $query->bindParam("p_id", $values[":p_id"]);
        $query->execute();
        $_SESSION["success"] = "Comment is waiting to be approved!";
        header("Location: post.php?p_id={$values[":p_id"]}");
        exit();
    }
    catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}

function showDeleteCommentForm($com_id, $pdo) { // showing a form to delete a comment
    if (!checkId($com_id)) {
        header("Location: comments.php");
        exit();
    }
    $row = findCommentsById($com_id, $pdo);
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for="post_title">Delete Comment (id = '.$row["comment_id"].')</label>';
    echo '<input type="hidden" value="'.$row["comment_id"].'" name="comment_id">';
    echo '<input type="hidden" value="'.$row["comment_post_id"].'" name="comment_post_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_delete" value = "Delete comment">';
    echo '</div>';
}

function deleteComment($com_id, $com_post_id, $pdo) { // deleting a comment
    try {
        $query = $pdo->prepare("DELETE from comments where comment_id = :id");
        $query->execute(array(":id" => $com_id));
        $query = $pdo->prepare("UPDATE posts SET post_comment_count = post_comment_count - 1 where post_id = :id");
        $query->execute(array(":id" => $com_post_id));
        $query = NULL;
        $_SESSION["success"] = "Comment deleted!";
        header("Location: comments.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}

function showApproveForm($com_id, $pdo) { // showing the form to approve comment
    if (!checkId($com_id)) {
        header("Location: comments.php");
        exit();
    }
    $row = findCommentsById($com_id, $pdo);
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for="post_title">Approve Comment (id = '.$row["comment_id"].')</label>';
    echo '<input type="hidden" value="'.$row["comment_id"].'" name="comment_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_approve" value = "Approve comment">';
    echo '</div>';
}

function approveComment($com_id, $pdo) {
    try {
        $query = $pdo->prepare("UPDATE comments set comment_status = 'Approved' where comment_id = :id");
        $query->execute(array(":id" => $com_id));
        $_SESSION["success"] = "Comment approved!";
        header("Location: comments.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}

function showUnapproveForm($com_id, $pdo) { // showing the form to unapprove comment
    if (!checkId($com_id)) {
        header("Location: comments.php");
        exit();
    }
    $row = findCommentsById($com_id, $pdo);
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for="post_title">Unapprove Comment (id = '.$row["comment_id"].')</label>';
    echo '<input type="hidden" value="'.$row["comment_id"].'" name="comment_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_unapprove" value = "Unapprove comment">';
    echo '</div>';
}

function unapproveComment($com_id, $pdo) {
    try {
        $query = $pdo->prepare("UPDATE comments set comment_status = 'Unapproved' where comment_id = :id");
        $query->execute(array(":id" => $com_id));
        $_SESSION["success"] = "Comment unapproved!";
        header("Location: comments.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}

function insertUser($values, $pdo) {
    $sql = "INSERT into users (username, user_password, user_firstname, user_lastname, user_email, user_role, randSalt) ";
    $sql .= "VALUES (:nm, :pwd, :fname, :lname, :mail, :role, :salt)";
    try {
        $query = $pdo->prepare($sql);
        $query->execute($values);
        $_SESSION["success"] = "User added";
        header("Location: users.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}

function showDeleteUserForm($u_id, $pdo) {
    if (!checkId($u_id)) {
        header("Location: users.php");
        return;
    }
    $row = findUsersById($u_id, $pdo);
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for "user_title">Delete User (id = '.$row["user_id"].')</label>';
    echo '<input type="hidden" value = "'.$row['user_id'].'" name="user_id" id = "user_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_delete" value = "Delete user">';
    echo '</div>';
    echo '</form>';
}

function deleteUser($u_id, $pdo) {
    try {
        $query = $pdo->prepare("DELETE from users where user_id = :id");
        $query->execute(array(":id", $u_id));
        $query = NULL;
        $_SESSION["success"] = "User deleted";
        header("Location: users.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}

function generateSalt()
{
    $salt = '';
    $saltLength = 8;
    for($i=0; $i<$saltLength; $i++) {
        $salt .= chr(mt_rand(33,126));
    }
    return $salt;
}

function setPostStatus(string $post_status, int $p_id, $pdo) {
    try {
        $query = $pdo->prepare("UPDATE posts set post_status = :stat where post_id = :id");
        $query->execute(array(":stat" => $post_status, ":id" => $p_id));
        return true;
    } catch (PDOException $e) {
        $_SESSION["error"] = "Something went wrong: {$e->getMessage()}";
        error_log($e->getMessage());
        exit();
    }
}

function showEditButton($pdo) {
    if (isset($_SESSION["user_id"]) && isset($_GET["p_id"])) {
        $stmt = $pdo->prepare("SELECT post_author_id from posts where post_id = :id");
        $stmt->execute(array(":id" => $_GET["p_id"]));
        $user = $stmt->fetch(PDO::FETCH_LAZY);
        if ($_SESSION["user_id"] == $user["post_author_id"] || $_SESSION["user_role"] == "admin") {
            return true;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }
}

function checkUsersCookie($pdo) {
    if (empty($_SESSION["user_id"])) {
        if (!empty($_COOKIE["login"]) && !empty($_COOKIE["key"])) {
            $login = $_COOKIE["login"];
            $key = $_COOKIE["key"];
            $query = $pdo->prepare("SELECT * from users where username = :nam and cookie = :cook");
            $query->execute(array(":nam" => $login, ":cook" => $key));
            $user = $query->fetch(PDO::FETCH_LAZY);
            if (!empty($user)) {
                $_SESSION["name"] = $user["username"];
                $_SESSION["user_role"] = $user["user_role"];
                $_SESSION["user_id"] = $user["user_id"];
                header("Location: /");
            }
        }
    }
}

function checkUserExistance($pdo, $username) {
    $query = $pdo->prepare("SELECT * from users where username = :name");
    $query->bindParam(":name", $username);
    $query->execute();
    $checkuser = $query->fetch(PDO::FETCH_LAZY);
    if ($checkuser) {
        $_SESSION["error"] = "Username is already taken, try another";
        return false;
    } else {
        return true;
    }
}

function registerUser($pdo, $values) {
    $username = $values[":name"];
    $sql = "INSERT into users (username, user_password, user_email, user_role, randSalt) ";
    $sql .= "VALUES (:name, :pass, :mail, 'subscriber', :salt)";
    $query = $pdo->prepare($sql);
    $query->execute($values);
    $query = NULL;
    $_SESSION["success"] = "Successful registration";
    $_SESSION["user_id"] = $pdo->lastInsertId();
    $_SESSION["user_role"] = "subscriber";
    $_SESSION["name"] = $username;
    return true;
}

function checkFileSize(int $fileSize, int $maxSize) {
    if ($fileSize > $maxSize) {
        $maxSizeMb = floor($maxSize / 1024 / 1024);
        $_SESSION["error"] = "Invalid file size (max = {$maxSizeMb})!";
        return false;
    }
    return true;
}

function checkFileType(string $fileType, array $types) {
    $checked = false;
    for($i = 0; $i < count($types); $i++) {
        if ($fileType == $types[$i]) {
            $checked = true;
            break;
        }
    }
    return $checked;
}

function uploadFile(string $uploadDir, string $fileSelect, string $page, int $maxFileSize = 5000000, array $allowedTypes) {
    if (!empty($_FILES[$fileSelect]["name"])) {
        $post_image = basename($_FILES[$fileSelect]["name"]);
        $target_file = $uploadDir . $post_image;
        $post_image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // type of uploaded file
        $post_image_temp = $_FILES[$fileSelect]["tmp_name"]; // temporary file name on client's computer
        $post_image_size = $_FILES[$fileSelect]["size"]; // size of uploaded file
        if (!checkFileSize($post_image_size, $maxFileSize)) {
            header("Location: ".$page);
            exit();
        }
        if (!checkFileType($post_image_type, $allowedTypes)) {
            $_SESSION["error"] = "Unallowed file type!";
            header("Location: ".$page);
            exit();
        }
        move_uploaded_file($post_image_temp, $target_file);
        return $post_image;
    }
}