<?php
   include("../connectDB.php");

   session_start();
   $nickname = $_POST["nickname"];

   if (strlen($nickname) < 5 || strlen($nickname) > 20) { //Nickname: Maior ou igual a 5, menor ou igual a 20
      echo "Error";  //Erro tamanho do nome
      exit();
   } else {
      //Preparar query para verificar se já existe algum nome de utilizador igual
      $queryProcurarNickname = $connection->prepare("SELECT * FROM utilizador WHERE NomeUnico = :Nickname");
      $queryProcurarNickname->bindParam(":Nickname", $nickname, PDO::PARAM_STR); //Associar a variavel com o campo na query
      $queryProcurarNickname->execute();
      if ($queryProcurarNickname->rowCount() == 1) { //Verificar se existe algum resultado
         if (isset($_SESSION["User_Id"])) {
            $resultado = $queryProcurarNickname->fetchAll();

            if ($resultado[0]["Key_Utilizador"] == $_SESSION["User_Id"]) {
               $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
               $connection = null;

               echo "Valid";
               exit();
            } elseif ($resultado[0]["Key_Utilizador"] != $_SESSION["User_Id"]) {
               $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
               $connection = null;

               echo "Duplication"; //Erro já existe este nome
               exit();
            }
         }
         elseif(!isset($_SESSION["User_Id"])) {
            $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
            $connection = null;

            echo "Duplication";  //Erro já existe este nome
            exit();
         }
      } elseif ($queryProcurarNickname->rowCount() == 0) {
         $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
         $connection = null;

         echo "Valid";
         exit();
      }
   }
?>
