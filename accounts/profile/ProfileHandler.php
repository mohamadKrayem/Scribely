<?php

class ProfileHandler
{
   private $db;
   private $username;
   private $response;

   public function __construct($db, $username)
   {
      $this->db = $db;
      $this->username = $username;
   }

   public function getProfile()
   {
      // get all user information
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
      $stmt->close();
      if (!$user) {
         return $this->response = array(
            "success" => false,
            "case" => "error",
            "message" => "User not found!",
            "code" => 404,
         );
      }
      return $this->response = array(
         "success" => true,
         "case" => "success",
         "message" => "User found!",
         "code" => 200,
         "user" => $user,
      );
   }

   public function updateProfile($fullName, $profile_pic, $bio, $website, $instagram, $facebook, $twitter, $github, $linkedin, $location)
   {
      // public function updateProfile() {
      //update user information with his profile picture
      $stmt = $this->db->prepare("
      SELECT profile_pic FROM User WHERE username = ?
      ");
      $stmt->bind_param("s", $this->username);
      $stmt->execute();
      $result = $stmt->get_result();
      $image = $result->fetch_assoc();
      $stmt->close();
      if (!isset($image['profile_pic'])) {
         $stmt = $this->db->prepare("
         INSERT INTO Image (url) VALUES (?)
         ");
         $stmt->bind_param("s", $profile_pic);
         $stmt->execute();
         $image['profile_pic'] = $stmt->insert_id;
         $stmt->close();
         $stmt = $this->db->prepare("
         UPDATE User SET profile_pic = ? WHERE username = ?
         ");
         $stmt->bind_param("is", $image['profile_pic'], $this->username);
         $stmt->execute();
         $stmt->close();
      } else {
         $stmt = $this->db->prepare("
            UPDATE Image SET url = ? WHERE image_id = ?
         ");
         $stmt->bind_param("si", $profile_pic, $image['profile_pic']);
         $stmt->execute();
         $stmt->close();
      }
      $stmt = $this->db->prepare("
         UPDATE User
         SET full_name = ?, bio = ?, website = ?, instagram = ?, facebook = ?, twitter = ?, github = ?, linkedin = ?, location = ?
         WHERE username = ?
      ");
      $stmt->bind_param("ssssssssss", $fullName, $bio, $website, $instagram, $facebook, $twitter, $github, $linkedin, $location, $this->username);
      $stmt->execute();
      $stmt->close();

      $this->response = array(
         "success" => true,
         "case" => "success",
         "message" => "Profile updated!",
         "code" => 200,
         "profile_pic" => $profile_pic,
         "image_id" => $image['profile_pic'],
      );
      return $this->response;
   }
}
