<?php
include '../../php/session.php';
include './ProfileHandler.php';
include '../../php/db.php';

if($_SERVER["REQUEST_METHOD"] == "GET") {
   $username = $_SESSION["username"];
   if(!empty($username)) {
      $profileHandler = new ProfileHandler($mysqli, $username);
      $response = $profileHandler->getProfile();
      http_response_code($response['code']);
      header('Content-Type: application/json');
      echo json_encode($response);
      exit;
   } else {
      header('Content-Type: application/json');
      echo json_encode(array(
         "success" => false,
         "case" => "error",
         "message" => "User not found!",
         "code" => 404,
      ));
      exit;
   }
}else if($_SERVER["REQUEST_METHOD"] == "POST") {
   $username = $_SESSION["username"];
   if(empty($username)) {
      header('Content-Type: application/json');
      echo json_encode(array(
         "success" => false,
         "case" => "error",
         "message" => "User not found!",
         "code" => 404,
      ));
      exit;
   }
   $profileHandler = new ProfileHandler($mysqli, $username);
   $response = $profileHandler->updateProfile(
      $_POST["fullName"],
      $_POST['profile_pic'],
      $_POST['bio'],
      $_POST['website'],
      $_POST['instagram'],
      $_POST['facebook'],
      $_POST['twitter'],
      $_POST['github'],
      $_POST['linkedin'],
      $_POST['location']);

   http_response_code($response['code']);
   header('Content-Type: application/json');
   echo json_encode($response);
   exit;
}