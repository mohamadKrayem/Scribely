<?php

class GetUserHandler {
   public $username;
   public $response;
   private $db;
   private $LIMIT = 10;
   private $OFFSET = 0;

   public function __construct($db, $username = null, $LIMIT = 15, $OFFSET = 0) {
      $this->db = $db;
      $this->username = $username;
      $this->LIMIT = $LIMIT ?? 10;
      $this->OFFSET = $OFFSET ?? 0;
   }

   public function getSingleUser() {
      //get single user with its articles
      $stmt = $this->db->prepare("
         SELECT Article.title, Article.views, Article.likes, Article.article_id, Image.url 
         FROM ((Article INNER JOIN User ON Article.author_id = User.user_id)
         INNER JOIN Image ON Article.image = Image.image_id)
         WHERE User.username = ? LIMIT 15 OFFSET 0
      ");
      $stmt->bind_param("s", $this->username);
      $stmt->execute();
      $result = $stmt->get_result();
      $articles = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      $stmt = $this->db->prepare("
         SELECT User.username, User.user_id, User.email, User.bio, Image.url AS profile_pic, User.website, User.instagram, User.facebook, User.twitter, User.github, User.linkedin, User.location, User.full_name
         FROM User
         LEFT JOIN Image ON User.profile_pic = Image.image_id
         WHERE User.username = ?
      ");
      $stmt->bind_param("s", $this->username);
      $stmt->execute();
      $result = $stmt->get_result();
      $user = $result->fetch_assoc();
      $user["articles"] = $articles;
      $stmt->close();

      if (!$user) {
         $this->response = array(
            "success" => false,
            "case" => "error",
            "message" => "User not found!",
            "code" => 404,
         );
         return false;
      }
      $this->response = array(
         "success" => true,
         "case" => "success",
         "message" => "User found!",
         "code" => 200,
         "user" => $user,
      );

   }

   public function getAllUsers() {
      //get all users with basics information
      $stmt = $this->db->prepare("
         SELECT User.username, User.full_name, User.bio, Image.url AS Profile_pic, User.instagram, User.facebook, User.twitter, User.github, User.linkedin, User.location
         From User
         LEFT JOIN Image ON User.profile_pic = Image.image_id
      ");
      $stmt->execute();
      $result = $stmt->get_result();
      $users = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      if (!$users) {
         $this->response = array(
            "success" => false,
            "case" => "error",
            "message" => "Users not found!",
            "code" => 404,
         );
         return false;
      }
      $this->response = array(
         "success" => true,
         "case" => "success",
         "message" => "Users found!",
         "code" => 200,
         "users" => $users,
      );
      return true;
   }

   public function getUsers() {
      if (!empty($this->username)) {
         $this->getSingleUser();
      } else {
         $this->getAllUsers();
      }
      return $this->response;
   }
}
