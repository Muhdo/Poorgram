<?php
   session_start();
   include("connectDB.php");

   $publicacao = $_POST["Publicacao"];
   $comentario = $_POST["Comentario"];

   try {
      $queryComentar = $connection->prepare("INSERT INTO comentario(Key_Publicacao, Key_Utilizador, Comentario) VALUES (:Publicacao, :Utilizador, :Comentario)");
      $queryComentar->bindParam(":Publicacao", $publicacao, PDO::PARAM_STR);
      $queryComentar->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
      $queryComentar->bindParam(":Comentario", $comentario, PDO::PARAM_STR);
      $queryComentar->execute();

      $queryComentar->closeCursor();

      echo "Add";
   } catch (\Exception $e) {
      echo "Error";
   }
?>
