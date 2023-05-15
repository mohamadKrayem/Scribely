<?php
include '../php/db.php';

$password = '1';
$username = 'mohamadkrayem';
$stmt = $mysqli->prepare("SELECT password FROM `User` WHERE username = ?");
$stmt->bind_param("s", $username); // bind the parameter to the variable
$stmt->execute(); // execute the query
$stmt->bind_result($passwordHash); // bind the password hash to the variable
$stmt->fetch(); // get the password hash from the database
$stmt->close();


if (password_verify($password, $passwordHash)) {
   echo "<br>Password is valid!";
} else {
   echo "Invalid password.";
}
