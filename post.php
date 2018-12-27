<head>
   <link rel="stylesheet" href="style/post.css">
</head>
<article class="post">
   <?php
      include("includes/connectDB.php");

      $url=parse_url($_SERVER["REQUEST_URI"]);

      $queryLoadPost = $connection->prepare("SELECT Publicacao, Data, NomeUnico, FotoPerfil FROM publicacao INNER JOIN utilizador ON publicacao.Key_Utilizador = utilizador.Key_Utilizador WHERE Key_Publicacao = :Key");
      $queryLoadPost->bindParam(":Key", $url["query"], PDO::PARAM_STR);
      $queryLoadPost->execute();

      if ($queryLoadPost->rowCount() == 0) {
         header('Location: '.$_SERVER['HTTP_REFERER']);
      } elseif ($queryLoadPost->rowCount() > 1) {
         header('Location: '.$_SERVER['HTTP_REFERER']);
      } else {
         $resultado = $queryLoadPost->fetchAll();


         $Utilizador = $resultado[0]["NomeUnico"];

         if (is_null($resultado[0]["FotoPerfil"])) {
            $FotoPerfil = "img/profile-picture.png";
         } else {
            $FotoPerfil = 'data:image/jpeg;base64,'.base64_encode($resultado[0]["FotoPerfil"]);
         }

         $Imagem = 'data:image/jpeg;base64,'.base64_encode($resultado[0]["Publicacao"]);
         setlocale(LC_ALL, 'pt_PT', 'pt_PT.utf-8', 'pt_PT.utf-8', 'portuguese');
         $Data = ucfirst(utf8_encode(strftime("%d de %B de %Y", strtotime($resultado[0]["Data"]))));
      }
      $queryLoadPost->closeCursor();

      $queryCountLikes = $connection->prepare("SELECT COUNT(Key_Utilizador) FROM gosto WHERE Key_Publicacao = :Key");
      $queryCountLikes->bindParam(":Key", $url["query"], PDO::PARAM_STR);
      $queryCountLikes->execute();
      $resultado = $queryCountLikes->fetchAll();

      $QuantLikes = $resultado[0][0];
      $queryCountLikes->closeCursor();

      $queryCountComments = $connection->prepare("SELECT COUNT(Key_Comentario), Comentario FROM comentario WHERE Key_Publicacao = :Key");
      $queryCountComments->bindParam(":Key", $url["query"], PDO::PARAM_STR);
      $queryCountComments->execute();
      $resultado = $queryCountComments->fetchAll();

      $QuantComments = $resultado[0][0];
      $queryCountComments->closeCursor();
   ?>
   <div class="div-account">
      <img class="img-account" src="<?php echo $FotoPerfil; ?>">
      <a class="a-account" href="perfil.php?<?php echo $Utilizador; ?>"><?php echo $Utilizador; ?></a>
   </div>

   <img class="img-post" src="<?php echo $Imagem; ?>">
   <p class="data"><?php echo $Data; ?></p>
   <div class="div-buttons">
      <div class="div-buttons-group">
         <img class="like-button" src="img/like.png">
         <p class="like-quant"><?php echo $QuantLikes; ?></p>
      </div>
      <div class="div-buttons-group">
         <img class="comment-button"src="img/comment.png" onclick="comentar()">
         <p class="comment-quant"><?php echo $QuantComments; ?></p>
      </div>
   </div>
   <div class="div-place-comment hidden" id="div-comment">
      <form class="form-comment" action="" method="post">
         <textarea class="form-comment" name="commentario" maxlength="255" rows="5" placeholder="Comentário"></textarea>
         <button class="form-button" id="submit" type="submit" name="submit">Enviar</button>
      </form>
   </div>

   <?php

   ?>
   <div class="div-comment">
      <a class="a-comment-account" href="#">Muhdex</a>
      <p class="comment">Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! </p>
   </div>
</article>

<script>
   function comentar() {
      document.getElementById("div-comment").classList.toggle("hidden");
   }
</script>
