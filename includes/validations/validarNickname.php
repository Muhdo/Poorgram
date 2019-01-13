<?php
   include("../connectDB.php");

   session_start();
   $nickname = $_POST["nickname"];

   if (strlen($nickname) < 5 || strlen($nickname) > 20) {
      echo "Error";
      exit();
   } else {

      $queryProcurarNickname = $connection->prepare("SELECT * FROM utilizador WHERE NomeUnico = :Nickname");
      $queryProcurarNickname->bindParam(":Nickname", $nickname, PDO::PARAM_STR);
      $queryProcurarNickname->execute();
      if ($queryProcurarNickname->rowCount() == 1) {
         if (isset($_SESSION["User_Id"])) {
            $resultado = $queryProcurarNickname->fetchAll();

            if ($resultado[0]["Key_Utilizador"] == $_SESSION["User_Id"]) {
               $queryProcurarNickname->closeCursor();
               $connection = null;

               echo "Valid";
               exit();
            } elseif ($resultado[0]["Key_Utilizador"] != $_SESSION["User_Id"]) {
               $queryProcurarNickname->closeCursor();
               $connection = null;

               echo "Duplication";
               exit();
            }
         }
         elseif(!isset($_SESSION["User_Id"])) {
            $queryProcurarNickname->closeCursor();
            $connection = null;

            echo "Duplication";
            exit();
         }
      } elseif ($queryProcurarNickname->rowCount() == 0) {
         $queryProcurarNickname->closeCursor();
         $connection = null;

         echo "Valid";
         exit();
      }
   }
?>
