<?php

include '../php/db.php';


$stmt = $mysqli->prepare("SELECT password from User WHERE username = ?");
$username = "raefi";
//$serialized = serialize($username);
$serialized = filter_var($username, FILTER_SANITIZE_STRING);
echo " the serialized is ".$serialized. " sdf<br>";
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

print_r($user);
