<?php
class SignUpHandler
{
   private $db;
   private $response;
   private $username;
   private $email;
   private $password;

   public function __construct($db, $username, $email, $password)
   {
      $this->db = $db;
      $this->username= $username;
      $this->email = $email;
      $this->password = $password;
   }

   public function signUp()
   {
      switch (true) {
         case empty($this->username) :
         case empty($this->email):
         case empty($this->password):
            $this->response = array(
               "success"=>false,
               "case" => "empty",
               "message"=>"Please fill all the fields!",
               "code"=>400
            );
            break;
         case $this->usernameExists():
            break;
         case $this->emailExists():
            break;
         case !$this->saveUser():
            break;
      }

      return $this->response;
   }

   private function usernameExists()
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
      return false;
   }

   private function emailExists()
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
      return false;
   }

   private function saveUser()
   {
      // Hash the password
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
      $stmt = $this->db->prepare("INSERT INTO  User (username, password, email) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $this->username, $this->password, $this->email);
      $result = $stmt->execute();
      $stmt->close();
      if (!$result) {
         $this->response = array(
            "success" => false,
            "case" => "error",
            "message" => "Signup failed!",
            "code"=>400,
         );
         return false;
      }

      $this->response = array(
         "success" => true,
         "message" => "Signup successful!",
         "username" => $this->username,
         "email" => $this->email,
         "code"=>200,
      );
      return true;
   }
}
