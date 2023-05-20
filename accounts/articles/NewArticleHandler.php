<?php
include "../images/NewImageHandler.php";

class NewArticleHandler
{
   private $title;
   private $content;
   private $author_id ;
   private $tags;
   private $db;
   private $author_name;
   private $image_url;
   private $image_id;
   private $response;

   public function __construct($db, $title, $content, $author_name, $image_url, $tags)
   {
      $this->db = $db;
      $this->title = $title;
      $this->content = $content;
      $this->author_name= $author_name;
      $this->image_url= $image_url;
      $this->tags = [];
   }


   public function setAuthorID() {
      $stmt = $this->db->prepare("SELECT user_id FROM User WHERE username = ?");
      $stmt->bind_param("s", $this->author_name);
      $stmt->execute();
      $result = $stmt->get_result();
      $author = $result->fetch_assoc();
      $stmt->close();
      $this->author_id = $author['user_id'];
   }


   public function saveArticleToDB() {
      $stmt = $this->db->prepare("INSERT INTO Article (title, content, author_id, image) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssii", $this->title, $this->content, $this->author_id, $this->image_id);
      $result = $stmt->execute();
      $stmt->close();
      if (!$result) {
         $this->response = array(
            "success" => false,
            "case" => "error",
            "message" => "Article creation failed!",
            "code" => 400,
         );
         return false;
      }
      $this->response = array(
         "success" => true,
         "message" => "Article creation successful!",
         "code" => 200,
      );
      return true;
   }

   public function save()
   {
      switch(true) {
         case empty($this->title):
         case empty($this->content):
         case empty($this->author_id):
            $this->response = array(
               "success" => false,
               "case" => "empty",
               "message" => "Please fill all the fields",
               "title" => $this->title,
               "content" => $this->content,
               "author_id" => $this->author_id,
               "code" => 404,
            );
            break;
      }
      $this->setAuthorID();

      $imageHandler = new NewImageHandler($this->db, $this->author_id, $this->image_url);

      $this->response = $imageHandler->save();
      if (!$this->response['success']) {
        return $this->response;
      }

      $this->image_id = $this->response['image_id'];
      $this->saveArticleToDB();

      return $this->response;
   }
}


