<?php
   include("../connectDB.php");

   $nickname = $_POST["nickname"];

   if (strlen($nickname) < 5 || strlen($nickname) > 20) { //Nickname: Maior ou igual a 5, menor ou igual a 20
      echo "Error";  //Erro tamanho do nome
      exit();
   } else {
      //Preparar query para verificar se já existe algum nome de utilizador igual
      $queryProcurarNickname = $connection->prepare("SELECT * FROM utilizador WHERE NomeUnico = :Nickname");
      $queryProcurarNickname->bindParam(":Nickname", $nickname, PDO::PARAM_STR); //Associar a variavel com o campo na query
      $queryProcurarNickname->execute();
      if ($queryProcurarNickname->rowCount() > 0) { //Verificar se existe algum resultado
         $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
         $connection = null;

         echo "Duplication";  //Erro já existe este nome
         exit();
      } else {
         $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
         $connection = null;

         echo "Valid";
         exit();
      }
   }
?>
