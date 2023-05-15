<?php

include '../php/session.php';
include '../php/db.php';
include 'SignUpHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $password = $_POST['password'];
   $username = $_POST['username'];
   $email = $_POST['email'];

   $signupHandler = new SignUpHandler($mysqli, $username, $email, $password);
   $message = $signupHandler->signUp($username, $email, $password);

   header("Content-Type: application/json");
   if ($message['success']) {
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
   }
   http_response_code($message['code']);
   echo json_encode($message);

   $mysqli->close();
   exit;
}

echo json_encode(array(
   "success" => false,
   "message" => "Signup failed!",
   "isSubmitted" => isset($_POST['submit']),
));
