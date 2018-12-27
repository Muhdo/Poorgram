<head>
   <link rel="stylesheet" type="text/css" href="style/main.css">
   <link rel="stylesheet" type="text/css" href="style/post.css">
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
      <article class="post">
         <?php
            include("includes/connectDB.php");
            /*
            SELECT
            	publicacao.Key_Publicacao, Publicacao, publicacao.Key_Utilizador, Data,
               utilizador.Key_Utilizador, utilizador.NomeUnico, utilizador.FotoPerfil,
            	COUNT(gosto.Key_Utilizador), COUNT(comentario.Key_Comentario)
            FROM publicacao
            INNER JOIN utilizador ON publicacao.Key_Utilizador = utilizador.Key_Utilizador
            INNER JOIN gosto ON publicacao.Key_Publicacao = gosto.Key_Publicacao
            INNER JOIN comentario ON publicacao.Key_Publicacao = comentario.Key_Publicacao
            INNER JOIN seguindo ON publicacao.Key_Utilizador = seguindo.Key_Utilizador
            WHERE
            	publicacao.Key_Utilizador = seguindo.Key_Seguindo AND
               utilizador.Key_Utilizador = 1
            ORDER BY Data
            LIMIT 100
            */
            //$queryLoadFeed = $connection->prepare("SELECT Publicacao, Data, NomeUnico, FotoPerfil, COUNT(gosto.Key_Utilizador), COUNT(comentario.Key_Comentario), Comentario FROM publicacao INNER JOIN utilizador ON publicacao.Key_Utilizador = utilizador.Key_Utilizador INNER JOIN gosto ON publicacao.Key_Publicacao = gosto.Key_Publicacao INNER JOIN comentario ON publicacao.Key_Publicacao = comentario.Key_Publicacao INNER JOIN seguindo ON  ORDER BY data DESC LIMIT 100");
            $queryLoadFeed = $connection->prepare("SELECT
            	publicacao.Key_Publicacao, Publicacao, publicacao.Key_Utilizador, Data,
               utilizador.Key_Utilizador, utilizador.NomeUnico, utilizador.FotoPerfil,
            	COUNT(gosto.Key_Utilizador), COUNT(comentario.Key_Comentario)
            FROM publicacao
            INNER JOIN utilizador ON publicacao.Key_Utilizador = utilizador.Key_Utilizador
            INNER JOIN gosto ON publicacao.Key_Publicacao = gosto.Key_Publicacao
            INNER JOIN comentario ON publicacao.Key_Publicacao = comentario.Key_Publicacao
            INNER JOIN seguir ON publicacao.Key_Utilizador = seguir.Key_Seguir
            WHERE
            	publicacao.Key_Utilizador = seguir.Key_Seguir AND seguir.Key_Utilizador = :Utilizador
            ORDER BY Data
            LIMIT 100");
            $queryLoadFeed->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
            $queryLoadFeed->execute();

            if ($queryLoadFeed->rowCount() == 0) {
               echo "Ainda não segues ninguem!\nProcura pelos teus amigos (se tiveres) na barra de pesquisa em cima!";
            } elseif ($queryLoadFeed->rowCount() >= 1) {
               foreach ($queryLoadFeed->fetchAll() as $resultado) {
                  //var_dump($resultado);
                  $Utilizador = $resultado["NomeUnico"];

                  if (is_null($resultado["FotoPerfil"])) {
                     $FotoPerfil = "img/profile-picture.png";
                  } else {
                     $FotoPerfil = 'data:image/jpeg;base64,'.base64_encode($resultado["FotoPerfil"]);
                  }

                  $Imagem = 'data:image/jpeg;base64,'.base64_encode($resultado["Publicacao"]);
                  setlocale(LC_ALL, 'pt_PT', 'pt_PT.utf-8', 'pt_PT.utf-8', 'portuguese');
                  $Data = ucfirst(utf8_encode(strftime("%d de %B de %Y", strtotime($resultado["Data"]))));

                  $queryCountLikes = $connection->prepare("SELECT COUNT(Key_Utilizador) FROM gosto WHERE Key_Publicacao = :Key");
                  $queryCountLikes->bindParam(":Key", $resultado["Key_Publicacao"], PDO::PARAM_STR);
                  $queryCountLikes->execute();
                  $resultado = $queryCountLikes->fetchAll();

                  $QuantLikes = $resultado[0][0];
                  $queryCountLikes->closeCursor();

                  $queryCountComments = $connection->prepare("SELECT COUNT(Key_Comentario), Comentario FROM comentario WHERE Key_Publicacao = :Key");
                  $queryCountComments->bindParam(":Key", $resultado["Key_Publicacao"], PDO::PARAM_STR);
                  $queryCountComments->execute();
                  $resultado = $queryCountComments->fetchAll();

                  $QuantComments = $resultado[0][0];
                  $queryCountComments->closeCursor();
               }
            }
            $queryLoadFeed->closeCursor();
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
            $queryComentarios = $connection->prepare("SELECT Comentario, NomeUnico FROM comentario INNER JOIN utilizador ON comentario.Key_Utilizador = utilizador.Key_Utilizador WHERE Key_Publicacao = :Key");
            $queryComentarios->bindParam(":Key", $url["query"], PDO::PARAM_STR);
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
   </main>
   <script>
      function comentar() {
         document.getElementById("div-comment").classList.toggle("hidden");
      }
   </script>
</body>

<?php
   }
?>
