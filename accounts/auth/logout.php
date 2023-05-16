<?php
include "../../php/session.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
   session_destroy();
   http_response_code(200);
   echo json_encode(array(
      "success" => true,
      "message" => "Logout Seccessfully!",
   ));
   exit;
}
