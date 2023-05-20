
function sessionCheck() {
   $.ajax({
      url: "./accounts/auth/sessionCheck.php",
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
      url: "./accounts/auth/logout.php",
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
   localStorage.setItem("article_id", article_id);
   localStorage.setItem("username", username);
   window.location.href = "./accounts/articles/article.html";
}

function getFeaturedArticles() {
   $.ajax({
      url: "./accounts/articles/get-articles.php",
      type: "GET",
      data: {
         order: "views",
         OFFSET: 0,
         LIMIT: 6,
      },
      success: function (data) {
         console.log(data.articles);
         (data.articles).forEach(article => {
            console.log(article.profile_image)
            document.getElementById("articles-row").innerHTML += `
            <div class="post-card" onclick="onClickCard(${article.article_id},  '${article.username}')">
               <div class="avatar">
                  <img class="avatar" src="${(function () {
                  if (article.profile_image != null) {
                     return article.profile_image
                  } else {
                     return "https://avatars.githubusercontent.com/u/47269261?v=4"
                  }
               })()
               }" alt="">
               </div>
               <a class="post-title" href="#" title="${article.title}">${(()=>{
                  if(article.title.length > 45){
                  return (article.title).slice(0, 45) + "..."
                  }else{
                     return article.title
                  }
               })()
               }</a>
               <span class="datetime">#Rust</span>
               <div class="image-preview"
                  style="background-image: url(${(function () {
                  if (article.hasOwnProperty("article_image")) {
                     return article.article_image
                  } else {

                     return "background-image: linear-gradient(to top left, blueviolet, rgb(73, 31, 112)); "
                  }
               })()
               });"
               >
               </div>
               <div class="views-like">
                  <div class="like d-flex align-items-center">
                     <i class="bi bi-heart"></i>
                     <span>${article.likes}</span>
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
   sessionCheck();
   getFeaturedArticles();
}

$(document).ready(onReady);