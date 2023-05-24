<?php
include "../../php/db.php";
include "../../php/session.php";
include "./GetArticleHandler.php";

if ($_SERVER['REQUEST_METHOD'] == "GET") {

   //get articles for a specific user
   // $stmt = $mysqli->prepare("
   //    SELECT User.username, Article.title, Article.content, Article.article_id, Image.url 
   //    FROM ((User INNER JOIN Article ON Article.author_id = User.user_id)
   //    INNER JOIN Image ON Article.image = Image.image_id)
   //    WHERE User.username = ? LIMIT 10 OFFSET 0
   //    ");

   //get articles for all users
   // $stmt = $mysqli->prepare("
   //    SELECT User.username, Article.title, Article.content, Article.article_id, Image.url 
   //    FROM ((User INNER JOIN Article ON Article.author_id = User.user_id)
   //    INNER JOIN Image ON Article.image = Image.image_id)
   //    LIMIT 10 OFFSET 0
   //    ");

   //get one article for a specific user with his profile picture
   // $stmt = $mysqli->prepare("
   //     SELECT User.username, Article.title, Article.content, Article.article_id, Image.url AS article_image, ProfileImage.url AS profile_image
   //     FROM ((User
   //     INNER JOIN Article ON Article.author_id = User.user_id)
   //     INNER JOIN Image ON Article.image = Image.image_id)
   //     LEFT JOIN Image AS ProfileImage ON User.profile_pic = ProfileImage.image_id
   //     WHERE User.username = ? AND Article.article_id = ?");

   //get all articles for all users with their profile pictures
   // $stmt = $mysqli->prepare("
   //    SELECT User.username, Article.title, Article.content, Article.article_id, Image.url AS article_image, ProfileImage.url AS profile_image
   //    FROM ((User
   //    INNER JOIN Article ON Article.author_id = User.user_id)
   //    INNER JOIN Image ON Article.image = Image.image_id)
   //    LEFT JOIN Image AS ProfileImage ON User.profile_pic = ProfileImage.image_id
   //    ORDER BY Article.views DESC LIMIT 3 OFFSET 0
   //    ");

   // $stmt = $mysqli->prepare("SELECT User.username, Article.title, Article.content, Article.article_id, Image.url
   //    FROM ((User INNER JOIN Article ON Article.author_id = User.user_id)
   //    INNER JOIN Image ON Article.image = Image.image_id)
   //    WHERE User.username = ? AND Article.article_id = ?
   //    ");

   //get articles the top 6 articles sorted by views
   // $stmt = $mysqli->prepare("
   //    SELECT User.username, Article.title, Article.content, Article.article_id, Image.url 
   //    FROM ((User INNER JOIN Article ON Article.author_id = User.user_id)
   //    INNER JOIN Image ON Article.image = Image.image_id)
   //    ORDER BY Article.views DESC LIMIT 6 OFFSET 0
   //    ");

   //get articles the top 6 articles sorted by likes
   // $stmt = $mysqli->prepare("
   //    SELECT User.username, Article.title, Article.content, Article.article_id, Image.url
   //    FROM ((User INNER JOIN Article ON Article.author_id = User.user_id)
   //    INNER JOIN Image ON Article.image = Image.image_id)
   //    ORDER BY Article.likes DESC LIMIT 6 OFFSET 0
   //    ");

   //get articles the top 6 articles sorted by date
   // $stmt = $mysqli->prepare("
   //    SELECT User.username, Article.title, Article.content, Article.article_id, Image.url
   //    FROM ((User INNER JOIN Article ON Article.author_id = User.user_id)
   //    INNER JOIN Image ON Article.image = Image.image_id)
   //    ORDER BY Article.created_at DESC LIMIT 6 OFFSET 0
   //    ");
   $getArticleHandler = new GetArticleHandler($mysqli, $_GET['article_id'], $_GET['username'], $_GET['order'], $_GET['OFFSET'], $_GET['LIMIT']);
   $response = $getArticleHandler->getArticles();

   http_response_code(200);
   header('Content-Type: application/json');
   echo json_encode($response);
   exit;
   if (isset($_GET['article_id']) && isset($_GET['username']) && isset($_GET['order']) && isset($_GET['OFFSET']) && isset($_GET['LIMIT'])) {

      $getArticleHandler = new GetArticleHandler($mysqli, $_GET['article_id'], $_GET['username'], $_GET['order'], $_GET['OFFSET'], $_GET['LIMIT']);
      $response = $getArticleHandler->getArticles();

      http_response_code(200);
      header('Content-Type: application/json');
      echo json_encode($response);
   } else if (isset($_GET['article_id']) && isset($_GET['username'])) {
      $getArticleHandler = new GetArticleHandler($mysqli, $_GET['article_id'], $_GET['username']);
      $response = $getArticleHandler->getArticles();

      http_response_code(200);
      header('Content-Type: application/json');
      echo json_encode($response);
   } else if (isset($_GET['order']) && isset($_GET['OFFSET']) && isset($_GET['LIMIT'])) {
      $getArticleHandler = new GetArticleHandler($mysqli, null, null, $_GET['order'], $_GET['OFFSET'], $_GET['LIMIT']);
      $response = $getArticleHandler->getArticles();

      http_response_code(200);
      header('Content-Type: application/json');
      echo json_encode($response);
   } else if (isset($_GET['article_id'])) {
      $getArticleHandler = new GetArticleHandler($mysqli, $_GET['article_id']);
      $response = $getArticleHandler->getArticles();

      http_response_code(200);
      header('Content-Type: application/json');
      echo json_encode($response);
   } else if (isset($_GET['username'])) {
      $getArticleHandler = new GetArticleHandler($mysqli, null, $_GET['username']);
      $response = $getArticleHandler->getArticles();

      http_response_code(200);
      header('Content-Type: application/json');
      echo json_encode($response);
   } else {

      $getArticleHandler = new GetArticleHandler($mysqli, $_GET['article_id'], $_GET['username'], $_GET['order'], $_GET['OFFSET'], $_GET['LIMIT']);
      $response = $getArticleHandler->getArticles();

      http_response_code(200);
      header('Content-Type: application/json');
      echo json_encode($response);
   }
   exit;
}
