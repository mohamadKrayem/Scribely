
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

   var article_id = localStorage.getItem("article_id");
   var username = localStorage.getItem("username");
   //get article data from database
   $.ajax({
      url: "./get-articles.php",
      type: "GET",
      data: {
         article_id: article_id,
         username: username,
         order: "one"
      },
      success: function (data) {
         let article = data.article
         console.log(article);
         $("#article-title").text(article.title);
         $("#article-author").text(article.username);
         $("#article-content").text(article.content);
         $("#article-img").attr("src", article.article_image);
         $("#author-pic").attr("src", article.profile_image);
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