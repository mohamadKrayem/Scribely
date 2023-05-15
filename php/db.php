<?php
$mysqli = new mysqli("localhost", "root", "", "Scribely");
if ($mysqli->connect_error) {
   die("Connection failed: " . $mysqli->connect_error);
} else {
   echo "Connected successfully";
}
