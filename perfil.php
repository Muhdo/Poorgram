<head>
   <link rel="stylesheet" type="text/css" href="style/main.css">
   <link rel="stylesheet" type="text/css" href="style/perfil.css">
   <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
</head>

<?php
   session_start();

   if (!isset($_SESSION["User_Id"])) {
      header("Location: index.php");
   }
   elseif(isset($_SESSION["User_Id"])) {

   include("includes/header.php");


   include("includes/connectDB.php");

   $url=parse_url($_SERVER["REQUEST_URI"]);

   $queryLoadUser = $connection->prepare("SELECT * FROM utilizador WHERE NomeUnico = :Nickname");
   $queryLoadUser->bindParam(":Nickname", $url["query"], PDO::PARAM_STR);
   $queryLoadUser->execute();

   if ($queryLoadUser->rowCount() == 0) {
      header("Location: index.php");
   } elseif ($queryLoadUser->rowCount() > 1) {
      header("Location: index.php");
   } else {
      foreach ($queryLoadUser->fetchAll() as $resultado) {
         $UserKey = $resultado["Key_Utilizador"];
         $Nickname = $resultado["NomeUnico"];
         $Nome = $resultado["Nome"];

         if (is_null($resultado["FotoPerfil"])) {
            $FotoPerfil = "img/profile-picture.png";
         } else {
            $FotoPerfil = 'data:image/jpeg;base64,'.base64_encode($resultado["FotoPerfil"]);
         }

         $Descricao = $resultado["Descricao"];
      }
   }

   $queryLoadUser->closeCursor();

   $queryCountFollowers = $connection->prepare("SELECT COUNT(Key_Seguir) FROM seguir WHERE Key_Seguir = :Key");
   $queryCountFollowers->bindParam(":Key", $UserKey, PDO::PARAM_STR);
   $queryCountFollowers->execute();
   $resultado = $queryCountFollowers->fetchAll();

   $NumFollowers = $resultado[0][0];
   $queryCountFollowers->closeCursor();

   $queryCountFollowing = $connection->prepare("SELECT COUNT(Key_Seguir) FROM seguir WHERE Key_Utilizador = :Key");
   $queryCountFollowing->bindParam(":Key", $UserKey, PDO::PARAM_STR);
   $queryCountFollowing->execute();
   $resultado = $queryCountFollowing->fetchAll();

   $NumFollowing = $resultado[0][0];
   $queryCountFollowing->closeCursor();

   $queryCountPosts = $connection->prepare("SELECT COUNT(Key_Publicacao) FROM publicacao WHERE Key_Utilizador = :Key");
   $queryCountPosts->bindParam(":Key", $UserKey, PDO::PARAM_STR);
   $queryCountPosts->execute();
   $resultado = $queryCountPosts->fetchAll();

   $NumPosts = $resultado[0][0];
   $queryCountPosts->closeCursor();
?>

<body>
   <main>
      <div class="utilizador">
         <div class="div-ident">
            <div class="div-profile-pic">
               <img class="img-profile" src="<?php echo $FotoPerfil; ?>">
            </div>
            <div class="div-profile-text">
               <h2 class="h2-nickname"><?php echo $Nickname; ?></h2>
               <h3 class="h3-nome"><?php echo $Nome; ?></h2>
            </div>
            <div class="div-descricao">
               <p><?php echo $Descricao ?></p>
            </div>
         </div>
         <div class="div-stats">
            <div class="div-stats-followers">
               <h4 class="text">Seguidores</h4>
               <h4 class="value"><?php echo $NumFollowers; ?></h4>
            </div>
            <div class="div-stats-following">
               <h4 class="text">Seguindo</h4>
               <h4 class="value"><?php echo $NumFollowing; ?></h4>
            </div>
            <div class="div-stats-posts">
               <h4 class="text">Publicações</h4>
               <h4 class="value"><?php echo $NumPosts; ?></h4>
            </div>
            <div class="div-buttons">
               <?php
                  if ($UserKey == $_SESSION["User_Id"]) {
                     echo '<a class="a-button" href="editar.php">Editar Perfil</a>';
                  } else {
                     $querySaberSegue = $connection->prepare("SELECT * FROM seguir WHERE Key_Utilizador = :Key AND Key_Seguir = :Seguir");
                     $querySaberSegue->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);
                     $querySaberSegue->bindParam(":Seguir", $UserKey, PDO::PARAM_STR);
                     $querySaberSegue->execute();

                     if ($querySaberSegue->rowCount() == 0) {
                        echo "<a class='a-button' id='seguir'>Seguir</a>";
                     }
                     else {
                        echo "<a class='a-button' id='naoseguir'>Deixar de Seguir</a>";
                     }
                  }
               ?>
            </div>
         </div>
      </div>
      <div class="div-posts">
         <div class="gallery">
            <?php
               $queryLoadPosts = $connection->prepare("SELECT Key_Publicacao, Publicacao FROM publicacao WHERE Key_Utilizador = :Key");
               $queryLoadPosts->bindParam(":Key", $UserKey, PDO::PARAM_STR);
               $queryLoadPosts->execute();

               foreach ($queryLoadPosts->fetchAll() as $resultado) {
                  $imagem = 'data:image/jpeg;base64,'.base64_encode($resultado["Publicacao"]);
                  $postkey = $resultado["Key_Publicacao"];
                  echo '<div class="gallery-item">
                     <a href="publicacao.php?'.$postkey.'">
                        <img class="gallery-image" src="'.$imagem.'">
                     </a>
         			</div>';
               }

               if ($NumPosts % 3 != 0) {
                  for ($i=0; $i <= ($NumPosts % 3); $i++) {
                     echo '<div class="gallery-item-hidden"></div>';
                  }
               }
            ?>
         </div>
      </div>
   </main>

   <script>
      $(document).ready(function(){
         $("#seguir").click(function() {
            $.ajax({
               type: 'POST',
               data: { funcao: "Seguir",
                  Seguir: <?php echo $UserKey;?> },
               url: 'includes/seguir.php',
               success: function(result){
                     history.go(0);
               }
            });
         });

         $("#naoseguir").click(function() {
            $.ajax({
               type: 'POST',
               data: { funcao: "NaoSeguir",
                  Seguir: <?php echo $UserKey; ?> },
               url: 'includes/seguir.php',
               success: function(result){
                     history.go(0);
               }
            });
         });
      });
   </script>
</body>

<?php
   $connection = null;
   }
?>
