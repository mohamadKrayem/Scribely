<?php
include '../php/db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $password = $_POST['password'];
   $username = $_POST['username'];
   $email = $_POST['email'];
   $firstName = $_POST['first_name'];
   $lastName = $_POST['last_name'];
   $location = $_POST['location'];
   $bio = $_POST['bio'];
   $github = $_POST['github'];
   $linkedin = $_POST['linkedin'];
   $twitter = $_POST['twitter'];
   $website = $_POST['website'];
   $facebook = $_POST['facebook'];
   $instagram = $_POST['instagram'];

   $fullName = $firstName . " " . $lastName;

   $passwordHash = password_hash($password, PASSWORD_DEFAULT);
   $stmt = $mysqli->prepare("INSERT INTO  User
   (username, password, email, full_name, location, bio, github, linkedin, twitter, website, facebook, instagram) 
   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

   $stmt->bind_param("ssssssssssss", $username, $passwordHash, $email, $fullName, $location, $bio, $github, $linkedin, $twitter, $website, $facebook, $instagram);
   $stmt->execute();
   $stmt->close();

   $response = array(
      "success" => true,
      "message" => "Signup successful!",
      "username" => $_POST['username'],
      "password" => $_POST['password'],
      "email" => $_POST['email'],
   );

   // Send the response as JSON
   header("Content-Type: application/json");
   http_response_code(200);
   echo json_encode($response);
   $mysqli->close();
   exit;
}

echo json_encode(array(
   "success" => false,
   "message" => "Signup failed!",
   "isSubmitted" => isset($_POST['submit']),
));
exit;
