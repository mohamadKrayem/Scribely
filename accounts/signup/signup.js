
$(document).ready(function () {
   // Handle form submission
   // $("#signup-form").submit(function (event) {
   //    event.preventDefault(); // Prevent the form from submitting normally

   //    $.post($(this).attr("action"), $(this).serialize(), function (response, status) {
   //       if (response.success == true) {
   //          $("#response-message").html(
   //             '<div class="alert alert-success" role="alert">' + response.message + '</div>'
   //          );
   //          setTimeout(() => {
   //             window.location.href = "../index.html";
   //          }, 1000);
   //       } else {
   //          $("#response-message").html(
   //             '<div class="alert alert-danger" role="alert">' + response.message + '</div>'
   //          );
   //       }
   //    });
   // });
   $("#signup-form").submit(function (event) {
      event.preventDefault();
      $.ajax({
         url: "signup/signup.php",
         type: "POST",
         data: $(this).serialize(),
         success: function (data) {
            if (data.success == true) {
               $("#response-message").html(
                  '<div class="alert alert-success" role="alert">' + data.message + '</div>'
               );
               setTimeout(() => {
                  window.location.href = "../index.html";
               }, 1000);
            } else {
               $("#response-message").html(
                  '<div class="alert alert-danger" role="alert">' + data.message + '</div>'
               );
            }
         },
         error: function (data) {
            $("#response-message").html(
               '<div class="alert alert-danger" role="alert">' + data.message + '</div>'
            );
         }
      })
   });
});