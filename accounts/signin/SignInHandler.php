<?php
include "../auth/MainAuth.php";
class SignInHandler extends MainAuth
{

   public function __construct($db, $username, $password)
   {
      $this->db = $db;
      $this->username = $username;
      $this->password = $password;
   }

   public function signIn()
   {
      switch (true) {
         case empty($this->username):
         case empty($this->password):
            $this->response = array(
               "success" => false,
               "message" => "Please fill all the fields",
               "case" => "empty",
               "code" => 404,
            );
            break;
         case !$this->usernameExists():
            break;
         case !$this->passwordError():
            break;
         case $this->getUserData();
            break;
      }

      return $this->response;
   }

   public function passwordError()
   {
      $stmt = $this->db->prepare("SELECT password FROM User WHERE username = ?");
      $stmt->bind_param("s", $this->username);
      $stmt->execute();
      $result = $stmt->get_result();
      $password = $result->fetch_assoc();

      if (!password_verify($this->password, $password['password'])) {
         $this->response = array(
            "success" => false,
            "code" => 401,
            "case" => "Unauthorized",
         );
         $stmt->close();
         return false;
      } else {
         $this->response = array(
            "success" => true,
            "code" => 200,
            "case" => "Authorized"
         );
         $stmt->close();
         return true;
      }
   }

   public function getUserData()
   {
      $stmt = $this->db->prepare("SELECT `user_id`, `username`, `email`, 
      `created_at`, `full_name`, `bio`, `profile_image`, `website`, `location`, 
      `twitter`, `facebook`, `instagram`, `linkedin`, `github` 
      FROM `User` WHERE username = ? ");

      $stmt->bind_param("s", $this->username);
      $stmt->execute();
      $result = $stmt->get_result();
      $user = $result->fetch_assoc();
      $stmt->close();
      if ($user == null) {
         $this->response = array(
            "success" => true,
            "code" => 500,
            "case" => "Error"
         );
         return false;
      }else{
         $this->response = array( 
            "success" => true,
            "code" => 200,
            "case" => "SignedIn",
         );
         foreach($user as $key=>$value) {
            $this->response[$key] = $value;
         }

         return true;
      }

   }
}
