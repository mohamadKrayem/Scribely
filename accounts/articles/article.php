<?php
include '../../php/session.php';
include './GetArticleHandler.php';
include '../../php/db.php';

   if($_SERVER["REQUEST_METHOD"] == "GET")  {
      $article_id = $_GET['article_id'];
      $username = $_GET['username'];
      $order = $_GET['order'];
      $OFFSET = $_GET['OFFSET'];
      $LIMIT = $_GET['LIMIT'];

      $getArticleHandler = new GetArticleHandler($mysqli, $article_id, $username, $order, $OFFSET, $LIMIT);
      $message = $getArticleHandler->getArticles();
      print_r($message);
   }

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet" />
   <link href="../../assets/m-style/style.css" rel="stylesheet" />
   <link href="../../assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
   <link rel="stylesheet" href="../../assets/m-style/cards.css">
   <title>Scribely</title>
   <script src="../../assets/jquery/jquery-3.3.1.min.js"></script>
   <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="../../assets/popper/popper.min.js"></script>
   <script>
      function sessionCheck() {
         $.ajax({
            url: "../auth/sessionCheck.php",
            type: "GET",
            success: function (data) {
               data = JSON.parse(data);
               $(".sessionEmpty").hide();
               $(".sessionFull").show();
               $(".sessionFull").append(`<span>${data.username}</span>`);
               $("#logout").show();
               $("#logout").click(onClickLogout);
            },
            error: function (data) {
               $(".sessionEmpty").show();
               $(".sessionFull").hide();
               console.log("should be deleted");
               $("#logout").hide();
            },
         });
      }
      function onClickLogout(event) {
         event.preventDefault();
         $.ajax({
            url: "../auth/logout.php",
            type: "GET",
            success: function (data) {
               data = JSON.parse(data);
               console.log(data.success);
               if (data.success == true) {
                  location.reload();
               }
            },
         });
      }
      $(document).ready(sessionCheck);
   </script>
</head>

<body class="">
   <header id="header" class=" header fixed-top header-scrolled">
      <nav class="navbar mr-lg-4 ml-lg-4 navbar-expand-xl navbar-light py-2 px-lg-5">
         <div class="container-fluid">
            <a class="navbar-brand title" href="#">Scribely</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
               aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav ms-auto d-flex justify-content-between">
                  <li class="nav-item px-3">
                     <a class="nav-link" href="../../index.html">Home</a>
                  </li>
                  <li class="nav-item px-3">
                     <a class="nav-link" href="#">Articles</a>
                  </li>
                  <li class="nav-item px-3">
                     <a class="nav-link" href="../new-article.html">Write Article</a>
                  </li>
                  <li class="nav-item px-3">
                     <a class="nav-link" href="#">Authors</a>
                  </li>
                  <li class="nav-item pr-3 pl-1">
                     <a class="nav-link sessionEmpty" href="../signup.html">Login/Register</a>
                     <a class="nav-link sessionFull" href="#"><i class="bi bi-person-fill"></i></a>
                  </li>
                  <li class="nav-item pr-3 pl-1" id="logout">
                     <a class="nav-link" href="#"><i class="bi bi-box-arrow-right"></i></a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
   </header>

   <main style="margin-top: 100px;">

   </main>
</body>
</html>
