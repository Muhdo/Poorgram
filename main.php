<head>
   <link rel="stylesheet" type="text/css" href="style/main.css">
   <link rel="icon" href="img/favicon.png">
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
         <?php
            include("includes/connectDB.php");

            $queryLoadFeed = $connection->prepare("SELECT
            	publicacao.Key_Publicacao, Publicacao, publicacao.Key_Utilizador, Data,
               utilizador.Key_Utilizador, utilizador.NomeUnico, utilizador.FotoPerfil
            FROM publicacao
            INNER JOIN utilizador ON publicacao.Key_Utilizador = utilizador.Key_Utilizador
            INNER JOIN seguir ON publicacao.Key_Utilizador = seguir.Key_Seguir
            WHERE
            	publicacao.Key_Utilizador = seguir.Key_Seguir AND seguir.Key_Utilizador = :Utilizador
            ORDER BY Data DESC
            LIMIT 100");
            $queryLoadFeed->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
            $queryLoadFeed->execute();

            if ($queryLoadFeed->rowCount() == 0) {
               echo "Ainda não segues ninguem!\nProcura pelos teus amigos (se tiveres) na barra de pesquisa em cima!";
            } elseif ($queryLoadFeed->rowCount() >= 1) {
               foreach ($queryLoadFeed->fetchAll() as $resultado) {

                  $GLOBALS["Query_PublicacaoId"] = $resultado["Key_Publicacao"];
                  $GLOBALS["Query_Utilizador"] = $resultado["NomeUnico"];

                  if (is_null($resultado["FotoPerfil"])) {
                     $GLOBALS["Query_FotoPerfil"] = "img/profile-picture.png";
                  } else {
                     $GLOBALS["Query_FotoPerfil"] = 'data:image/jpeg;base64,'.base64_encode($resultado["FotoPerfil"]);
                  }

                  $GLOBALS["Query_Imagem"] = 'data:image/jpeg;base64,'.base64_encode($resultado["Publicacao"]);
                  setlocale(LC_ALL, 'pt_PT', 'pt_PT.utf-8', 'pt_PT.utf-8', 'portuguese');
                  $GLOBALS["Query_Data"] = ucfirst(utf8_encode(strftime("%d de %B de %Y", strtotime($resultado["Data"]))));

                  $queryCountLikes = $connection->prepare("SELECT COUNT(Key_Utilizador) FROM gosto WHERE Key_Publicacao = :Key");
                  $queryCountLikes->bindParam(":Key", $GLOBALS["Query_PublicacaoId"], PDO::PARAM_STR);
                  $queryCountLikes->execute();
                  $resultado = $queryCountLikes->fetchAll();

                  $GLOBALS["Query_QuantLikes"] = $resultado[0][0];
                  $queryCountLikes->closeCursor();

                  $queryCountComments = $connection->prepare("SELECT COUNT(Key_Comentario) FROM comentario WHERE Key_Publicacao = :Key");
                  $queryCountComments->bindParam(":Key", $GLOBALS["Query_PublicacaoId"], PDO::PARAM_STR);
                  $queryCountComments->execute();
                  $resultado = $queryCountComments->fetchAll();

                  $GLOBALS["Query_QuantComments"] = $resultado[0][0];
                  $queryCountComments->closeCursor();

                  include("post.php");
               }
            }
            $queryLoadFeed->closeCursor();
         ?>
   </main>
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

         $.ajax({
            type: "POST",
            data: {
               Publicacao: PubId,
               Comentario: message
            },
            url: "includes/comentar.php",
            success: function(result){
               if (result == "Add") {
                  location.reload();
                  QuantLikes += 1;
                  $("#QuantComments" + PubId).text(QuantLikes);
               }
            }
         });
      }

      function DeleteComment(CommentId) {
         $.ajax({
            type: 'POST',
            data: { chave: CommentId },
            url: 'includes/deleteComment.php',
            success: function(result){
               location.reload();
            }
         });
      }
   </script>
</body>

<?php
   }
?>
