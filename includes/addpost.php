<?php
   session_start();
   include("connectDB.php");

   $Imagem = file_get_contents($_POST["imageData"]);

   try {
      $queryAddPost = $connection->prepare("INSERT INTO publicacao(Publicacao, Key_Utilizador) VALUES (:Publicacao, :Utilizador)");
      $queryAddPost->bindParam(":Publicacao", $Imagem, PDO::PARAM_STR);
      $queryAddPost->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
      $queryAddPost->execute();

      $queryAddPost->closeCursor();

      echo "Add";
   } catch (\Exception $e) {
      echo "Error";
   }


?>
