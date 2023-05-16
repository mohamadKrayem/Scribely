<?php
include '../../php/db.php';
include '../../php/session.php';
include 'SignInHandler.php';

if($_SERVER["REQUEST_METHOD"] == "POST")  {
   $username = $_POST['username'];   
   $password = $_POST['password'];

   $signInHandler = new SignInHandler($mysqli, $username, $password);
   $message = $signInHandler->signIn();

   header("Content-Type: application/json");
   if ($message['case'] == "SignedIn") {
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;

      foreach($message as $key=>$value) {
         if($key!="case" && $key!="code") {
            $_SESSION[$key] = $value;
         }
      }
   }
   http_response_code($message['code']);
   echo json_encode($message);

   $mysqli->close();
   exit;
}
