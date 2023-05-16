<?php
class MainAuth {
   public $db;
   public $username;
   public $email;
   public $response;
   public $password;

   public function usernameExists()
   {
      $stmt = $this->db->prepare("SELECT * FROM User WHERE username = ?");
      $stmt->bind_param("s", $this->username);
      $result = $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
         $this->response = array(
            "success" => false,
            "case" => "conflict",
            "message" => "Username already exists!",
            "code"=>409,
         );
         $stmt->close();
         return true;
      }
      $stmt->close();
      return false;
   }

   public function emailExists()
   {
      $stmt = $this->db->prepare("SELECT * FROM User WHERE email = ?");
      $stmt->bind_param("s", $this->email);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
         $this->response = array(
            "success" => false,
            "case" => "conflict",
            "message" => "Email already exists!",
            "code"=>409,
         );
         $stmt->close();
         return true;
      }
      $stmt->close();
      return false;
   }
} 