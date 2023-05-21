<?php
include '../../php/session.php';

class GetArticleHandler
{
   private $db;
   private $article_id;
   private $username;
   private $article;
   private $response;
   private $OFFSET = 0;
   private $LIMIT = 15;
   private $order = "date";

   public function __construct($db, $article_id = null, $username = null, $order = "date", $OFFSET = 0, $LIMIT = 15)
   {
      $this->db = $db;
      $this->article_id = $article_id;
      $this->username = $username;
      $this->OFFSET = $OFFSET ?? 0;
      $this->LIMIT = $LIMIT ?? 15;
      $this->order = $order ?? "date";
   }

   private function getOneArticle()
   {
      //get all articles for all users with their profile pictures and increase views
      $stmt = $this->db->prepare("
      UPDATE Article SET `views`=(`views`+1) WHERE `article_id`=?;
      ");
      $stmt->bind_param("i", $this->article_id);
      $stmt->execute();
      $stmt = $this->db->prepare("
       SELECT User.username, Article.title, Article.content, Article.article_id, Image.url AS article_image, ProfileImage.url AS profile_image
       FROM (((User
       INNER JOIN Article ON Article.author_id = User.user_id)
       INNER JOIN Image ON Article.image = Image.image_id)
       LEFT JOIN Image AS ProfileImage ON User.profile_pic = ProfileImage.image_id)
       WHERE Article.article_id = ?
       ");
      $stmt->bind_param("i", $this->article_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $article = $result->fetch_assoc();
      $stmt->close();
      if (!$article) {
         $this->response = array(
            "success" => false,
            "case" => "error",
            "message" => "Article not found!",
            "code" => 404,
         );
         return false;
      }
      $this->response = array(
         "success" => true,
         "case" => "success",
         "message" => "Article found!",
         "code" => 200,
         "article" => $article,
      );
      return true;
   }

   private function getAllArticlesForUser()
   {
      $stmt = $this->db->prepare("
         SELECT User.username, Article.title, Article.views, Article.likes, Article.article_id, Image.url 
         FROM ((User INNER JOIN Article ON Article.author_id = User.user_id)
         INNER JOIN Image ON Article.image = Image.image_id)
         WHERE User.username = ? LIMIT 15 OFFSET 0
         ");
      $stmt->bind_param("s", $this->username);
      $stmt->execute();
      $result = $stmt->get_result();
      $articles = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      if (!$articles) {
         $this->response = array(
            "success" => false,
            "case" => "error",
            "message" => "Articles not found!",
            "code" => 404,
         );
         return false;
      }
      $this->response = array(
         "success" => true,
         "case" => "success",
         "message" => "Articles found!",
         "code" => 200,
         "articles" => $articles,
      );
      return true;
   }

   private function getAllArticlesForAllUsersOrderedByViews()
   {
      //get all articles for all users with their profile pictures
      $stmt = $this->db->prepare("
      SELECT User.username, Article.title, Article.views, Article.likes, Article.article_id, Image.url AS article_image, ProfileImage.url AS profile_image
      FROM ((User
      INNER JOIN Article ON Article.author_id = User.user_id)
      INNER JOIN Image ON Article.image = Image.image_id)
      LEFT JOIN Image AS ProfileImage ON User.profile_pic = ProfileImage.image_id
      ORDER BY Article.views DESC LIMIT ? OFFSET ?
      ");
      $stmt->bind_param("ii", $this->LIMIT, $this->OFFSET);
      $stmt->execute();
      $result = $stmt->get_result();
      $articles = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      if (!$articles) {
         $this->response = array(
            "success" => false,
            "case" => "error",
            "message" => "Articles not found!",
            "code" => 404,
         );
         return false;
      }
      $this->response = array(
         "success" => true,
         "case" => "success",
         "message" => "Articles found!",
         "code" => 200,
         "articles" => $articles,
      );
      return true;
   }

   private function getAllArticlesForAllUsersOrderedByDate()
   {
      $stmt = $this->db->prepare("
      SELECT User.username, Article.title, Article.views, Article.likes, Article.article_id, Image.url AS article_image, ProfileImage.url AS profile_image
      FROM ((User
      INNER JOIN Article ON Article.author_id = User.user_id)
      INNER JOIN Image ON Article.image = Image.image_id)
      LEFT JOIN Image AS ProfileImage ON User.profile_pic = ProfileImage.image_id
      ORDER BY Article.created_at DESC LIMIT ? OFFSET ?
      ");
      $stmt->bind_param("ii", $this->LIMIT, $this->OFFSET);
      $stmt->execute();
      $result = $stmt->get_result();
      $articles = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      if (!$articles) {
         $this->response = array(
            "success" => false,
            "case" => "error",
            "message" => "Articles not found!",
            "limit" => $this->LIMIT,
            "offset" => $this->OFFSET,
            "code" => 404,
         );
         return false;
      }
      $this->response = array(
         "success" => true,
         "case" => "success",
         "message" => "Articles found!",
         "code" => 200,
         "articles" => $articles,
      );
      return true;
   }

   public function getArticles()
   {
      switch ($this->order) {
         case "views":
            $this->getAllArticlesForAllUsersOrderedByViews();
            break;
         case "user":
            $this->getAllArticlesForUser();
            break;
         case "one":
            $this->getOneArticle();
            break;
         case "date":
         default:
            $this->getAllArticlesForAllUsersOrderedByDate();
            break;
      }
      return $this->response;
   }

   public function likeArticle()
   {
      $stmt = $this->db->prepare("
      UPDATE Article SET `likes`=(`likes`+1) WHERE `article_id`=?;
      ");
      $stmt->bind_param("i", $this->article_id);
      $stmt->execute();
      $stmt->close();
      $this->response = array(
         "success" => true,
         "case" => "success",
         "message" => "Article liked!",
         "code" => 200,
      );
      return $this->response;
   }

   public function getResponse()
   {
      return $this->response;
   }

   public function setLimit($limit)
   {
      $this->LIMIT = $limit;
   }

   public function setOffset($offset)
   {
      $this->OFFSET = $offset;
   }

   public function setUsername($username)
   {
      $this->username = $username;
   }

   public function setArticleId($article_id)
   {
      $this->article_id = $article_id;
   }

   public function setOrder($order)
   {
      $this->order = $order;
   }
}
