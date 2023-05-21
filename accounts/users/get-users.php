<?php

include '../../php/session.php';
include './GetUserHandler.php';
include '../../php/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
   $username = $_GET["username"];
   $OFFSET = $_GET["OFFSET"];
   $LIMIT = $_GET["LIMIT"];
   // get all users if !username
   if (!empty($username)) {
      $getUserHandler = new GetUserHandler($mysqli, $username);
      $response = $getUserHandler->getUsers();
      http_response_code($response['code']);
      header('Content-Type: application/json');
      echo json_encode($response);
      exit;
   } else {
      $getUserHandler = new GetUserHandler($mysqli);
      $response = $getUserHandler->getUsers();
      http_response_code($response['code']);
      header('Content-Type: application/json');
      echo json_encode($response);
      exit;
   }
}
