<?php
   include("../connectDB.php");

   $password = $_POST["oldPassword"];

   //Preparar query para verificar se já existe algum nome de utilizador igual
   $queryVerificarPassword = $connection->prepare("SELECT Password FROM utilizador WHERE Key_Utilizador = :Key");
   $queryVerificarPassword->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR); //Associar a variavel com o campo na query
   $queryVerificarPassword->execute();
   if ($queryVerificarPassword->rowCount() == 1) { //Verificar se existe algum resultado
      $resultado = $queryVerificarPassword->fetchAll();
      $hashedPasswordCheck = password_verify($password, $resultado["Password"]);

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
?>
