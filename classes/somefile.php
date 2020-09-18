<?php
require_once "Database.php";
require_once "Traits.php";
require_once "CrudPostsController.php";
require_once "CrudCommentsController.php";

$post = CrudPostsController::getInstance();
$values = ["cat_id" => "63", "ttl" => "OOP", "auth_id" => "7", "img" => "php_image.png", "cont" => "Making my crud OOP", "tag" => "php, selenium", "stat" => "Published"];
$post->Insert($values);
$comment = CrudCommentsController::getInstance();
$values = ["post_id" => 23, "auth_id" => 7, "cont" => "Comment", "stat" => "Unapproved"];
$comment->Insert($values);
$values = ["id" => 23];
$post->Delete($values);