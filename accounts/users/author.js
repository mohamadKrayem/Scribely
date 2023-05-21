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

function onClickCard(article_id, username) {
   console.log(article_id, "  ", username)
   localStorage.setItem("article_id", article_id);
   localStorage.setItem("username", username);
   window.location.href = "../articles/article.html";
}

function onLike(article_id, likes) {
   console.log(article_id, "  ", likes)
   $.ajax({
      url: "../articles/like-article.php",
      type: "PUT",
      data: {
         article_id: article_id
      },
      success: function (data) {
         data = JSON.parse(data)
         console.log(data.success);
         if (data.success == true) {
            console.log(data)
            $("#like-score-" + article_id).html(likes + 1);
            //delete the onLike listener form the element
            $("#like-" + article_id).removeAttr("onclick");
         }
      },
      error: function (data) {
         console.log(data);
      }
   });
}

function getFeaturedArticles() {
   $.ajax({
      url: "./get-users.php",
      type: "GET",
      data: {
         order: "views",
         username: localStorage.getItem("author"),
         OFFSET: 0,
         LIMIT: 6,
      },
      success: function (data) {
         console.log(data);
         (data.user.articles).forEach(article => {
            console.log(data.user)
            let username = data.user.username;
            document.getElementById("Name").innerHTML = username;
            document.getElementById("fullName").innerHTML = data.user.full_name;
            $("#instagram").attr("href", data.user.instagram);
            $("#twitter").attr("href", data.user.twitter);
            $("#facebook").attr("href", data.user.facebook);
            $("#github").attr("href", data.user.github);
            $("#linkedin").attr("href", data.user.linkedin);

            document.getElementById("articles-row").innerHTML += `
            <div class="post-card">
               <a class="post-title" onclick="onClickCard(${article.article_id},  '${username}')" href="#" title="${article.title}">${(() => {
                  if (article.title.length > 45) {
                     return (article.title).slice(0, 45) + "..."
                  } else {
                     return article.title
                  }
               })()
               }</a>
               <span class="datetime">#Rust</span>
               <div class="image-preview"
                  onclick="onClickCard(${article.article_id},  '${username}')"
                  style="background-image: url(${(function () {
                  if (article.hasOwnProperty("url")) {
                     return article.url
                  } else {

                     return "background-image: linear-gradient(to top left, blueviolet, rgb(73, 31, 112)); "
                  }
               })()
               });"
               >
               </div>
               <div class="views-like">
                  <div class="like d-flex align-items-center">
                     <i id="like-${article.article_id}" class="heart bi bi-heart" onclick="onLike(${article.article_id},  ${article.likes})"></i>
                     <span id="like-score-${article.article_id}">${article.likes}</span>
                  </div>
                  <div class="views d-flex align-items-center">
                     <i class="bi bi-eye"></i>
                     <span>${article.views}</span>
                  </div>
               </div>
            </div>
               `;
         });
      },
      error: function (data) {
         console.log("there is an error");
      }
   })
}

function onReady() {
   console.log(localStorage.getItem("author"))
   sessionCheck();
   getFeaturedArticles();
}

$(document).ready(onReady);
