
<?php
include "../auth/MainAuth.php";
class SignUpHandler extends MainAuth
{

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
