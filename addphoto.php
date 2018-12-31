<head>
   <link rel="stylesheet" type="text/css" href="style/main.css">
   <link rel="stylesheet" type="text/css" href="style/addphoto.css">
   <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
   <script src="node_modules\cropperjs\dist\cropper.js"></script>
   <link href="node_modules\cropperjs\dist\cropper.css" rel="stylesheet">
   <script src="node_modules\jquery-cropper\dist\jquery-cropper.js"></script>
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
         <p class="div-aviso hidden hidden" id="aviso">A imagem é maior que 16.8 MB, a qualidade da imagem pode ficar má devido á compressão!</p>
         <form class="form-addphoto" action="includes/addpost.php" method="post">
            <label for="imagem" class="form-filebutton">Carregar Imagem</label>
            <input type="file" id="imagem" name="imagem" accept="image/png, image/jpeg, image/JPEG, image/jpeg2000, image/jpg, image/gif">
         </form>
         <div class="div-preview hidden">
            <img class="img-preview" id="img-preview">
            <div class="div-buttons">
               <button class="btn-selected" type="button" id="btn-move"><img class="img-button" src="img/arrows.png"></button>
               <button type="button" id="btn-crop"><img class="img-button" src="img/crop.png"></button>
               <button type="button" id="btn-rotLft"><img class="img-button" src="img/rotate-left.png"></button>
               <button type="button" id="btn-rotRht"><img class="img-button" src="img/rotate-right.png"></button>
               <button type="button" id="btn-zoomIn"><img class="img-button" src="img/zoom-in.png"></button>
               <button type="button" id="btn-zoomOut"><img class="img-button" src="img/zoom-out.png"></button>
               <button type="button" id="btn-reset"><img class="img-button" src="img/reset.png"></button>
            </div>
         </div>
      </div>
   </main>
   <script>
      function initCropper(){
         var image = document.getElementById("img-preview");
         blobURL = URL.createObjectURL(image);
         $image.one('built.cropper', function () {
            URL.revokeObjectURL(blobURL);
         }).cropper('replace', blobURL);

         var cropper = new Cropper(image, {
            ready() {
               this.cropper.setAspectRatio(1 / 1),
               this.cropper.setDragMode("move")
            },
            crop: function(e) {

            }
         });

         $("#btn-move").click(function() {
            $("#btn-crop").removeClass("btn-selected");
            $("#btn-move").addClass("btn-selected");
            cropper.setDragMode("move")
         })

         $("#btn-crop").click(function() {
            $("#btn-move").removeClass("btn-selected");
            $("#btn-crop").addClass("btn-selected");
            cropper.setDragMode("crop")
         })

         $("#btn-rotLft").click(function() {
            cropper.setDragMode("crop")
         })
      }

      $("#imagem").on("change", function() {
         if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
               $('#img-preview').attr("src", e.target.result);
               $(".div-preview").removeClass("hidden");
               image = $("#img-preview");
            }
            reader.readAsDataURL(this.files[0]);
            setTimeout(initCropper, 100);
         }

         if (this.files[0].size > 1677215) {
            $("#aviso").removeClass("hidden");
         } else {
            $("#aviso").addClass("hidden");
         }
     });
   </script>
</body>

<?php
   }
?>
