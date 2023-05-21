<?php

include '../../php/session.php';
include './GetArticleHandler.php';
include '../../php/db.php';

if($_SERVER["REQUEST_METHOD"] == "PUT") {
   parse_str(file_get_contents('php://input'), $_PUT);
   $article_id = $_PUT["article_id"];
   //update and select the likes
   $stmt = $mysqli->prepare("
      UPDATE Article SET `likes`=(`likes`+1) WHERE `article_id`=?;
   ");
   $stmt->bind_param("i", $article_id);
   $stmt->execute();
   $stmt = $mysqli->prepare("
      SELECT `likes` FROM Article WHERE `article_id`=?;
   ");
   $stmt->bind_param("i", $article_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $likes = $result->fetch_assoc()["likes"];
   $stmt->close();


   echo json_encode(array(
      "likes" => $likes,
      "success" => true,
      "article_id" => $article_id,
      "case" => "success",
      "message" => "Article liked!",
      "code" => 200,
   ));


}



