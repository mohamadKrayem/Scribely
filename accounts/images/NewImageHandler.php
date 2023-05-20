<?php
class NewImageHandler
{
   private $db;
   private $author_id;
   private $image_url;
   private $response;
   private $image_id;

   public function __construct($db, $author_id, $image_url)
   {
      $this->db = $db;
      $this->author_id = $author_id;
      $this->image_url = $image_url;
   }

   

   public function saveImageAndSaveID()
   {
      $stmt = $this->db->prepare("INSERT INTO Image (owner_id, url) VALUES (?, ?)");
      $stmt->bind_param("is", $this->author_id, $this->image_url);
      $result = $stmt->execute();
      if(!$result) {
         $this->response = array(
            "success" => false,
            "case" => "error",
            "message" => "Image upload failed!",
            "code" => 404,
         );
         return false;
      }
      $this->image_id = $stmt->insert_id;
      $stmt->close();
      return true;
   }

   public function getResponse()
   {
      return $this->response;
   }

   public function save() {
      switch (true){
         case empty($this->author_id):
         case empty($this->image_url):
            $this->response = array(
               "success" => false,
               "case" => "empty",
               "message" => "Please fill all the fields",
               "code" => 404,
            );
         break;
         case !$this->saveImageAndSaveID():
            break;
      }

      $this->response = array(
         "success" => true,
         "case" => "success",
         "message" => "Image upload successful!",
         "image_id" => $this->image_id,
         "code" => 200,
      );
      return $this->response;
   }
}
