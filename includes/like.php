<?php
   session_start();
   include("connectDB.php");
   $Publicacao = $_POST["Publicacao"];

   try {
      $queryAddLike = $connection->prepare("INSERT INTO gosto(Key_Publicacao, Key_Utilizador) VALUES (:Publicacao, :Utilizador)");
      $queryAddLike->bindParam(":Publicacao", $Publicacao, PDO::PARAM_STR);
      $queryAddLike->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
      $queryAddLike->execute();

      $queryAddLike->closeCursor();

      echo "Add";
   } catch (\Exception $e) {
      try {
         $queryDelLike = $connection->prepare("DELETE FROM gosto WHERE Key_Publicacao=:Publicacao AND Key_Utilizador=:Utilizador");
         $queryDelLike->bindParam(":Publicacao", $Publicacao, PDO::PARAM_STR);
         $queryDelLike->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
         $queryDelLike->execute();

         $queryDelLike->closeCursor();
         echo "Del";
      } catch (\Exception $e) {
         echo "Error";
      }
   }
?>
