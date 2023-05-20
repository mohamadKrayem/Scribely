
$(document).ready(function () {
   // Handle form submission
   $("#signin-form").submit(function (event) {
      event.preventDefault(); // Prevent the form from submitting normally
      $.ajax({
         url: "./signin/signin.php",
         type: "POST",
         data: $(this).serialize(),
         success: function (data) {
            console.log(data)
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
            console.log(data)
            $("#response-message").html(
               '<div class="alert alert-danger" role="alert">' + data.message + '</div>'
            );
         }
      })
   });
});