<?php
   include("../connectDB.php");

   session_start();
   $email = $_POST["email"];

   if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
      echo "Error";
      exit();
   } else {

      $queryProcurarEmail = $connection->prepare("SELECT * FROM utilizador WHERE Email = :Email");
      $queryProcurarEmail->bindParam(":Email", $email, PDO::PARAM_STR);
      $queryProcurarEmail->execute();
      if ($queryProcurarEmail->rowCount() == 1) {
         if (isset($_SESSION["User_Id"])) {
            $resultado = $queryProcurarEmail->fetchAll();

            if ($resultado[0]["Key_Utilizador"] == $_SESSION["User_Id"]) {
               $queryProcurarEmail->closeCursor();
               $connection = null;

               echo "Valid";
               exit();
            } elseif ($resultado[0]["Key_Utilizador"] != $_SESSION["User_Id"]) {
               $queryProcurarEmail->closeCursor();
               $connection = null;

               echo "Duplication";
               exit();
            }
         }
         elseif(!isset($_SESSION["User_Id"])) {
            $queryProcurarEmail->closeCursor();
            $connection = null;

            echo "Duplication";
            exit();
         }
      } elseif ($queryProcurarEmail->rowCount() == 0) {
         $queryProcurarEmail->closeCursor();
         $connection = null;

         echo "Valid";
         exit();
      }
   }
?>
