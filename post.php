<head>
   <link rel="stylesheet" href="style/post.css">
   <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
</head>
<article class="post" id="<?php echo $GLOBALS["Query_PublicacaoId"]; ?>">
   <div class="div-account">
      <img class="img-account" src="<?php echo $GLOBALS["Query_FotoPerfil"]; ?>">
      <a class="a-account" href="perfil.php?<?php echo $GLOBALS["Query_Utilizador"]; ?>"><?php echo $GLOBALS["Query_Utilizador"]; ?></a>
   </div>

   <img class="img-post" src="<?php echo $GLOBALS["Query_Imagem"]; ?>">
   <p class="data"><?php echo $GLOBALS["Query_Data"]; ?></p>
   <div class="div-buttons">
      <div class="div-buttons-group">
         <img class="like-button" src="img/like.png" id="like">
         <p class="like-quant" id="QuantLikes"><?php echo $GLOBALS["Query_QuantLikes"]; ?></p>
      </div>
      <div class="div-buttons-group">
         <img class="comment-button"src="img/comment.png" onclick="Comentar()">
         <p class="comment-quant" id="QuantComments"><?php echo $GLOBALS["Query_QuantComments"]; ?></p>
      </div>
   </div>
   <div class="div-place-comment hidden" id="div-comment">
      <form class="form-comment" name="comentar" action="" method="post">
         <textarea class="form-comment" name="comentario" maxlength="255" rows="5" placeholder="Comentário"></textarea>
         <button class="form-button" id="submit" type="submit" name="submit">Enviar</button>
      </form>
   </div>

   <?php
      include("includes/connectDB.php");

      $queryComentarios = $connection->prepare("SELECT Comentario, NomeUnico FROM comentario INNER JOIN utilizador ON comentario.Key_Utilizador = utilizador.Key_Utilizador WHERE Key_Publicacao = :Key ORDER BY Key_Comentario LIMIT 10");
      $queryComentarios->bindParam(":Key", $GLOBALS["Query_PublicacaoId"], PDO::PARAM_STR);
      $queryComentarios->execute();

      foreach ($queryComentarios->fetchAll() as $resultado) {
         echo '<div class="div-comment">
            <a class="a-comment-account" href="perfil.php?'.$resultado["NomeUnico"].'">'.$resultado["NomeUnico"].'</a>
            <p class="comment">'.$resultado["Comentario"].'</p>
         </div>';
      }
      $queryCountComments->closeCursor();
   ?>
</article>
<script>
   function Comentar() {
      document.getElementById("div-comment").classList.toggle("hidden");
   }

   $(document).ready(function(){
      var PubId = $(".post").attr("id");
      var QuantLikes = parseInt($("#QuantLikes").text());

      $("#like").click(function() {
         $.ajax({
            type: 'POST',
            data: { Publicacao: PubId },
            url: 'includes/like.php',
            success: function(result){
               if (result == "Add") {
                  QuantLikes += 1;
                  $('#QuantLikes').text(QuantLikes);
               }
               if (result == "Del") {
                  QuantLikes -= 1;
                  $('#QuantLikes').text(QuantLikes);
               }
            }
         });
      });

      var QuantComments = parseInt($("#QuantComments").text());
      $("#submit").click(function() {
         event.preventDefault();
         $.ajax({
            type: 'POST',
            data: { Publicacao: PubId,
               Comentario: comentar.comentario.value
            },
            url: 'includes/comentar.php',
            success: function(result){
               if (result == "Add") {
                  location.reload();
                  QuantLikes += 1;
                  $('#QuantComments').text(QuantLikes);
               }
            }
         });
      });
   });
</script>
