<?php
include "../../php/db.php";
include "../../php/session.php";
include "./NewArticleHandler.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $username = $_SESSION['username'];
   $password = $_SESSION['password'];
   $title = $_POST['title'];
   $content = $_POST['content'];
   $tags = $_POST['tags'];
   $image = $_POST['image'];

   if (empty($username) || empty($password)) {
      http_response_code(401);
      header('Content-Type: application/json');
      echo json_encode(array(
         "success" => false,
         "message" => "You are not logged in!",
      ));
      exit;
   } 

   $newArticleHandler = new NewArticleHandler($mysqli, $title, $content, $username, $image, $tags);

   $response = $newArticleHandler->save();

   http_response_code($response['code']);
   header('Content-Type: application/json');
   echo json_encode($response);
   exit;
}


