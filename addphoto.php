<head>
   <link rel="stylesheet" type="text/css" href="style/main.css">
   <link rel="stylesheet" type="text/css" href="style/addphoto.css">
   <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
   <script src="/path/to/cropper.js"></script>
</head>

<?php
   session_start();

   if (!isset($_SESSION["User_Id"])) {
      header("Location: index.php");
   }
   elseif(isset($_SESSION["User_Id"])) {

   include("includes/header.php");
?>

<body>
   <main>
      <h2>Seleciona a tua foto para publicares!</h2>
      <h3>Todos os teus seguidores vão poder vê-la! (se é que alguem te segue...)</h3>

      <div class="div-form">
         <p class="div-aviso" id="aviso"></p>
         <form class="form-addphoto" action="includes/addpost.php" method="post">
            <label for="imagem" class="form-filebutton">Carregar Imagem</label>
            <input type="file" id="imagem" name="imagem" accept="image/png, image/jpeg, image/JPEG, image/jpeg2000, image/jpg, image/gif">
            <br>
            <input class="form-submit" type="submit" value="Publicar">
         </form>
         <div class="div-preview">
            <img class="img-preview" id="img-preview">
         </div>
      </div>
   </main>
   <script>
      var $image = $('#image');
      $image.cropper({
        aspectRatio: 16 / 9,
        crop: function(event) {
          console.log(event.detail.x);
          console.log(event.detail.y);
          console.log(event.detail.width);
          console.log(event.detail.height);
          console.log(event.detail.rotate);
          console.log(event.detail.scaleX);
          console.log(event.detail.scaleY);
        }
      });



      $("#imagem").bind("change", function() {
         if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
               $('#img-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
         }

         if (this.files[0].size > 1677215) {
            $("#aviso").html("A imagem é maior que 16.8 MB, a qualidade da imagem pode ficar má devido á compressão!");
         } else {
            $("#aviso").html("");
         }
     });
   </script>
</body>

<?php
   }
?>
