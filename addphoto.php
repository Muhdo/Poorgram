<head>
   <link rel="stylesheet" type="text/css" href="style/main.css">
   <link rel="stylesheet" type="text/css" href="style/addphoto.css">
   <link rel="icon" href="img/favicon.png">
   <script src="node_modules/jquery/dist/jquery.js"></script>
   <script src="node_modules/cropperjs/dist/cropper.js"></script>
   <link href="node_modules/cropperjs/dist/cropper.css" rel="stylesheet">
   <script src="node_modules/jquery-cropper/dist/jquery-cropper.js"></script>
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
         <form class="form-addphoto" action="includes/addpost.php" method="post">
            <label for="imagem" class="form-filebutton">Carregar Imagem</label>
            <input type="file" id="imagem" name="imagem" accept="image/png, image/jpeg, image/JPEG, image/jpeg2000, image/jpg, image/gif">
         </form>
         <div class="div-preview hidden">
            <img class="img-preview" id="img-preview">
            <div class="div-buttons">
               <div class="div-buttons-group">
                  <button class="btn-selected" type="button" id="btn-move"><img class="img-button" src="img/arrows.png"></button>
                  <button type="button" id="btn-crop"><img class="img-button" src="img/crop.png"></button>
               </div>
               <div class="div-buttons-group">
                  <button type="button" id="btn-rotLft"><img class="img-button" src="img/rotate-left.png"></button>
                  <button type="button" id="btn-rotRht"><img class="img-button" src="img/rotate-right.png"></button>
               </div>
               <div class="div-buttons-group">
                  <button type="button" id="btn-zoomIn"><img class="img-button" src="img/zoom-in.png"></button>
                  <button type="button" id="btn-zoomOut"><img class="img-button" src="img/zoom-out.png"></button>
               </div>
               <div class="div-buttons-group">
                  <button type="button" id="btn-reset"><img class="img-button" src="img/reset.png"></button>
               </div>
            </div>
            <div class="div-buttons">
               <button class="btn-send" type="button" id="btn-submit">Enviar</button>
            </div>
         </div>
      </div>
   </main>
   <script>
   $(function() {
      var image = $("#img-preview");
      $("input:file").change(function() {
         $(".div-preview").removeClass("hidden");

         var oFReader = new FileReader();

         oFReader.readAsDataURL(this.files[0]);
         oFReader.onload = function (oFREvent) {
            image.cropper("destroy");
            image.attr("src", this.result);
            image.cropper({
               aspectRatio: 1 / 1,
               viewMode: 1,
               toggleDragModeOnDblclick: false,
               dragMode: "move",
               crop: function(e) {}
            });
         };
      });

      $("#btn-move").click(function() {
         $("#btn-crop").removeClass("btn-selected");
         $("#btn-move").addClass("btn-selected");
         $("#img-preview").cropper("setDragMode", "move");
      })

      $("#btn-crop").click(function() {
         $("#btn-move").removeClass("btn-selected");
         $("#btn-crop").addClass("btn-selected");
         $("#img-preview").cropper("setDragMode", "crop");
      })

      $("#btn-rotLft").click(function() {
         $("#img-preview").cropper("rotate", -5);
      })

      $("#btn-rotRht").click(function() {
         $("#img-preview").cropper("rotate", 5);
      })

      $("#btn-zoomIn").click(function() {
         $("#img-preview").cropper("zoom", 0.1);
      })

      $("#btn-zoomOut").click(function() {
         $("#img-preview").cropper("zoom", -0.1);
      })

      $("#btn-reset").click(function() {
         $("#img-preview").cropper("reset");
      })
   });

   $("#btn-submit").click(function() {
      var imagem = $("#img-preview").cropper("getCroppedCanvas", {width: 900}).toDataURL("image/jpeg", 0.9);
      var timestamp = Date.now();
      $.ajax({
         type: "POST",
         url: "includes/addpost.php",
         data: {
            imageData: imagem
         },
         success: function(output) {
            if (output == "Add") {
               location.href = "perfil.php";
            } else if (output == "Error") {
               location.href = "index.php";
            }
         }
      });
   })
   </script>
</body>

<?php
   }
?>
