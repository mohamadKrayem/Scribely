
function sessionCheck() {
   $.ajax({
      url: "auth/sessionCheck.php",
      type: "GET",
      success: function (data) {
         //listen for upload done event
         var widget = uploadcare.Widget('[role=uploadcare-uploader]');
         widget.onUploadComplete(function (fileInfo) {
            $('#image').val(fileInfo.cdnUrl);
            $('.image-preview img').attr('src', fileInfo.cdnUrl);
         });

         $('#warning').hide();
         console.log(data)
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
         $("#logout").hide();
         $('#form-container').hide();
         $('#warning').show();
         setTimeout(() => {
            window.location.href = "../index.html";
         }, 2500);
      },
   });
}
function onClickLogout(event) {
   event.preventDefault();
   $.ajax({
      url: "./auth/logout.php",
      type: "GET",
      success: function (data) {
         data = JSON.parse(data);
         console.log(data.success);
         if (data.success == true) {
            $('#warning').show();
            $(".sessionEmpty").show();
            $(".sessionFull").hide();
            $("#logout").hide();
            location.reload();
         }
      },
   });
}
function onSubmit(even) {
   event.preventDefault();
   $.ajax({
      url: "./articles/new-article.php",
      type: "POST",
      data: {
         title: $('#title').val(),
         tags: $('#tags').val(),
         content: $('#content').val(),
         image: $('#image').val()
      },
      success: function (data) {
         data = JSON.parse(data);
         console.log(data.success);
         if (data.success == true) {
            $('#warning').show();
            $(".sessionEmpty").show();
            $(".sessionFull").hide();
            $("#logout").hide();
            location.reload();
         }
      },
      error: function (data) {
         console.log(data);
      },
   })
}
function onReady() {
   sessionCheck();
   $('#form').submit(onSubmit);
}
$(document).ready(onReady);