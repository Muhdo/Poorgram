<?php
   include("../connectDB.php");

   session_start();
   $password = $_POST["oldPassword"];

   if (strlen($password) == 0) {
      echo "Empty";
      exit();
   } else {
      //Preparar query para verificar password
      $queryVerificarPassword = $connection->prepare("SELECT * FROM utilizador WHERE Key_Utilizador = :Key");
      $queryVerificarPassword->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR); //Associar a variavel com o campo na query
      $queryVerificarPassword->execute();
      if ($queryVerificarPassword->rowCount() == 1) { //Verificar se existe algum resultado
         $resultado = $queryVerificarPassword->fetchAll();
         $hashedPasswordCheck = password_verify($password, $resultado[0]["Password"]);

         if ($hashedPasswordCheck == FALSE) {
            $queryVerificarPassword->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
            $connection = null;

            echo "Error";
            exit();
         } elseif ($hashedPasswordCheck == TRUE) {
            $queryVerificarPassword->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
            $connection = null;

            echo "Valid";
            exit();
         }
      } elseif ($queryVerificarPassword->rowCount() == 0) {
         $queryVerificarPassword->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
         $connection = null;

         echo "Error";
         exit();
      }
      $queryVerificarPassword->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
      $connection = null;

      echo "Error";
      exit();
   }
?>
