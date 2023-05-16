<?php

include '../../php/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
   $username = $_SESSION['username'];
   $password = $_SESSION['password'];
   if (empty($username) || empty($password)) {
      http_response_code(401);
      header('Content-Type: application/json');
      echo json_encode(array(
         "success" => false,
         "message" => "You are not logged in!",
      ));
      exit;
   }
   http_response_code(200);
   echo json_encode(array(
      "success" => true,
      "message" => "Signup successful!",
      "username" => $username,
   ));
   exit;
}
