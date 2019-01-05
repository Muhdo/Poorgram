<head>
   <link rel="stylesheet" href="style/post.css">
   <link rel="icon" href="img/favicon.png">
   <script src="node_modules\jquery\dist\jquery.js"></script>
</head>
<?php
   $IdPub = $GLOBALS["Query_PublicacaoId"];
?>
<article class="post" id="<?php echo $IdPub; ?>">
   <div class="div-account">
      <img class="img-account" src="<?php echo $GLOBALS["Query_FotoPerfil"]; ?>">
      <a class="a-account" href="perfil.php?<?php echo $GLOBALS["Query_Utilizador"]; ?>"><?php echo $GLOBALS["Query_Utilizador"]; ?></a>
   </div>

   <img class="img-post" src="<?php echo $GLOBALS["Query_Imagem"]; ?>">
   <p class="data"><?php echo $GLOBALS["Query_Data"]; ?></p>
   <div class="div-buttons">
      <div class="div-buttons-group">
         <img class="like-button" src="img/like.png" id="like" name="<?php echo $IdPub; ?>" onclick="Like($(this).attr('name'))">
         <p class="like-quant" id="QuantLikes<?php echo $IdPub; ?>"><?php echo $GLOBALS["Query_QuantLikes"]; ?></p>
      </div>
      <div class="div-buttons-group">
         <img class="comment-button"src="img/comment.png" name="<?php echo $IdPub; ?>" onclick="Comentar($(this).attr('name'))">
         <p class="comment-quant" id="QuantComments<?php echo $IdPub; ?>"><?php echo $GLOBALS["Query_QuantComments"]; ?></p>
      </div>
   </div>
   <div class="div-place-comment hidden" id="div-comment<?php echo $IdPub; ?>">
      <form class="form-comment" name="comentar" action="" method="post">
         <textarea class="form-comment" name="comentario<?php echo $IdPub; ?>" maxlength="255" rows="5" placeholder="Comentário"></textarea>
         <button class="form-button" id="submit" type="submit" name="<?php echo $IdPub; ?>" onclick="EnviarComment($(this).attr('name'))">Enviar</button>
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
   function Comentar(PubId) {
      $("#div-comment" + PubId).toggleClass("hidden");
   }

   function Like(PubId) {
      var QuantLikes = parseInt($("#QuantLikes" + PubId).text());

      $.ajax({
         type: "POST",
         data: { Publicacao: PubId },
         url: "includes/like.php",
         success: function(result){
            if (result == "Add") {
               QuantLikes += 1;
               $("#QuantLikes" + PubId).text(QuantLikes);
            }
            if (result == "Del") {
               QuantLikes -= 1;
               $("#QuantLikes" + PubId).text(QuantLikes);
            }
         }
      });
   }

   function EnviarComment(PubId) {
      var QuantComments = parseInt($("#QuantComments" + PubId).text());
      var message = $("#comentario" + PubId).val();
      $("#submit").click(function() {
         event.preventDefault();
         $.ajax({
            type: "POST",
            data: {
               Publicacao: PubId,
               Comentario: message
            },
            url: "includes/comentar.php",
            success: function(result){
               console.log(result);
               if (result == "Add") {
                  location.reload();
                  QuantLikes += 1;
                  $("#QuantComments" + PubId).text(QuantLikes);
               }
               else {
                  console.log(result);
               }
            }
         });
      });
   }
</script>
