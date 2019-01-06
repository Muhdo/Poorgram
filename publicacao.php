<head>
   <link rel="stylesheet" type="text/css" href="style/main.css">
   <link rel="stylesheet" href="style/post.css">
   <link rel="icon" href="img/favicon.png">
   <script src="node_modules/jquery/dist/jquery.js"></script>
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

            $url = parse_url($_SERVER["REQUEST_URI"]);

            $queryLoadPost = $connection->prepare("SELECT publicacao.Key_Utilizador, Publicacao, Data, NomeUnico, FotoPerfil FROM publicacao INNER JOIN utilizador ON publicacao.Key_Utilizador = utilizador.Key_Utilizador WHERE Key_Publicacao = :Key");
            $queryLoadPost->bindParam(":Key", $url["query"], PDO::PARAM_STR);
            $queryLoadPost->execute();

            if ($queryLoadPost->rowCount() == 0) {
               header('Location: '.$_SERVER['HTTP_REFERER']);
            } elseif ($queryLoadPost->rowCount() > 1) {
               header('Location: '.$_SERVER['HTTP_REFERER']);
            } else {
               $resultado = $queryLoadPost->fetchAll();

               $IdUtilizador = $resultado[0]["Key_Utilizador"];
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

            $queryCountComments = $connection->prepare("SELECT COUNT(Key_Comentario) FROM comentario WHERE Key_Publicacao = :Key");
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
               <img class="like-button" id="like" src="img/like.png">
               <p class="like-quant" id="QuantLikes"><?php echo $QuantLikes; ?></p>
            </div>
            <div class="div-buttons-group">
               <img class="comment-button"src="img/comment.png" onclick="Comentar()">
               <p class="comment-quant" id="QuantComments"><?php echo $QuantComments; ?></p>
            </div>
            <?php
               if ($IdUtilizador == $_SESSION["User_Id"]) {
                  echo '<div class="div-buttons-group-right">
                     <img class="delete-button" src="img/delete.png" id="deletePost" onclick="DeletePost('.$url["query"].')">
                     <p class="delete-text hidden">Eliminar publicação?</p>
                  </div>';
               }
            ?>
         </div>
         <div class="div-place-comment hidden" id="div-comment">
            <form class="form-comment" name="comentar" action="" method="post">
               <textarea class="form-comment" name="comentario" maxlength="255" rows="5" placeholder="Comentário"></textarea>
               <button class="form-button" id="submit" type="submit" name="submit">Enviar</button>
            </form>
         </div>

         <?php
            $queryComentarios = $connection->prepare("SELECT Key_comentario, Comentario, comentario.Key_Utilizador, NomeUnico FROM comentario INNER JOIN utilizador ON comentario.Key_Utilizador = utilizador.Key_Utilizador WHERE Key_Publicacao = :Key ORDER BY Key_Comentario DESC");
            $queryComentarios->bindParam(":Key", $url["query"], PDO::PARAM_STR);
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

      <script>
         function Comentar() {
            document.getElementById("div-comment").classList.toggle("hidden");
         }

         function DeleteComment(CommentId) {
            $.ajax({
               type: "POST",
               data: { chave: CommentId },
               url: "includes/deleteComment.php",
               success: function(result){
                  location.reload();
               }
            });
         }

         $(document).ready(function(){
            var QuantLikes = <?php echo $QuantLikes; ?>;

            $("#like").click(function() {
               $.ajax({
                  type: "POST",
                  data: { Publicacao: <?php echo $url["query"];?> },
                  url: "includes/like.php",
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

            var QuantComments = <?php echo $QuantComments; ?>;

            $("#submit").click(function() {
               event.preventDefault();
               $.ajax({
                  type: "POST",
                  data: { Publicacao: <?php echo $url["query"];?>,
                     Comentario: comentar.comentario.value
                  },
                  url: "includes/comentar.php",
                  success: function(result){
                     location.reload();
                  }
               });
            });
         });

         var ultimoClick = 0;
         var ultimoPost;
         var Timer;
         var Intervalo = 3000;

         function DeletePost(PublicacaoId) {
            clearTimeout(Timer);

            var d = new Date();
            var tempo = d.getTime();

            $("#deletePost").attr("src", "img/delete-red.png");
            $(".delete-text").removeClass("hidden");

            if((tempo - ultimoClick <= 3000 && tempo - ultimoClick >= 150) && ultimoPost == PublicacaoId) {
               $.ajax({
                  type: "POST",
                  data: { chave: PublicacaoId },
                  url: "includes/deletePost.php",
                  success: function(result){

                     if (result == "Error") {
                        location.reload();
                     } else if (result == "Del") {
                        location.href = "perfil.php";
                     }
                  }
               });
            }
            ultimoClick = tempo;
            ultimoPost = PublicacaoId;

            Timer = setTimeout(function() {
               $("#deletePost").attr("src", "img/delete.png");
               $(".delete-text").addClass("hidden");
               ultimoClick = 0;
               ultimoPost = undefined;
            }, Intervalo);
         }
      </script>
   </main>
</body>

<?php
   $connection = null;
   }
?>
