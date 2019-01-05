<?php
   include("../connectDB.php");

   $email = $_POST["email"];

   if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) { //Email: formato válido, menor ou igual a 255(por precaução)
      echo "Error";  //Erro email
      exit();
   } else {
      //Preparar query para verificar se já existe algum email igual
      $queryProcurarEmail = $connection->prepare("SELECT * FROM utilizador WHERE Email = :Email");
      $queryProcurarEmail->bindParam(":Email", $email, PDO::PARAM_STR); //Associar a variavel com o campo da query
      $queryProcurarEmail->execute();
      if ($queryProcurarEmail->rowCount() > 0) { //Verificar se existe algum resultado
         $queryProcurarEmail->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
         $connection = null;

         echo "Duplication";  //Voltar para a página anterior
         exit();
      } else {
         $queryProcurarEmail->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
         $connection = null;

         echo "Valid";
         exit();
      }
   }
?>