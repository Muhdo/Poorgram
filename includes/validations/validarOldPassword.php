<?php
   include("../connectDB.php");

   session_start();
   $password = $_POST["oldPassword"];

   if (strlen($password) == 0) {
      echo "Empty";
      exit();
   } else {

      $queryVerificarPassword = $connection->prepare("SELECT * FROM utilizador WHERE Key_Utilizador = :Key");
      $queryVerificarPassword->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);
      $queryVerificarPassword->execute();
      if ($queryVerificarPassword->rowCount() == 1) {
         $resultado = $queryVerificarPassword->fetchAll();
         $hashedPasswordCheck = password_verify($password, $resultado[0]["Password"]);

         if ($hashedPasswordCheck == FALSE) {
            $queryVerificarPassword->closeCursor();
            $connection = null;

            echo "Error";
            exit();
         } elseif ($hashedPasswordCheck == TRUE) {
            $queryVerificarPassword->closeCursor();
            $connection = null;

            echo "Valid";
            exit();
         }
      } elseif ($queryVerificarPassword->rowCount() == 0) {
         $queryVerificarPassword->closeCursor();
         $connection = null;

         echo "Error";
         exit();
      }
      $queryVerificarPassword->closeCursor();
      $connection = null;

      echo "Error";
      exit();
   }
?>
