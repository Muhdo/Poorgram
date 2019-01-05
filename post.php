<head>
   <link rel="stylesheet" href="style/post.css">
   <script src="node_modules/jquery/dist/jquery.js"></script>
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
      <form class="form-comment" name="comentar">
         <textarea class="form-comment" name="comentario" id="comentario<?php echo $IdPub; ?>" maxlength="255" rows="5" placeholder="Comentário"></textarea>
         <button class="form-button" id="submit" type="submit" name="<?php echo $IdPub; ?>" onclick="EnviarComment($(this).attr('name'))">Enviar</button>
      </form>
   </div>

   <?php
      include("includes/connectDB.php");

      $queryComentarios = $connection->prepare("SELECT Key_comentario, Comentario, comentario.Key_Utilizador, NomeUnico FROM comentario INNER JOIN utilizador ON comentario.Key_Utilizador = utilizador.Key_Utilizador WHERE Key_Publicacao = :Key ORDER BY Key_Comentario DESC LIMIT 10");
      $queryComentarios->bindParam(":Key", $GLOBALS["Query_PublicacaoId"], PDO::PARAM_STR);
      $queryComentarios->execute();

      foreach ($queryComentarios->fetchAll() as $resultado) {
         if ($resultado["Key_Utilizador"] == $_SESSION["User_Id"]) {
            echo '<div class="div-comment">
               <a class="a-comment-account" href="perfil.php?'.$resultado["NomeUnico"].'">'.$resultado["NomeUnico"].'</a>
               <p class="comment">'.$resultado["Comentario"].'</p>
               <img class="img-delete" src="img/delete.png" onclick="DeleteComment('.$resultado["Key_comentario"].')">
            </div>';
         } else {
            echo '<div class="div-comment">
               <a class="a-comment-account" href="perfil.php?'.$resultado["NomeUnico"].'">'.$resultado["NomeUnico"].'</a>
               <p class="comment">'.$resultado["Comentario"].'</p>
            </div>';
         }
      }
      $queryCountComments->closeCursor();
   ?>
</article>
