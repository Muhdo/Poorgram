<?php
   include("connectDB.php");

   $nome = $_POST['nome'];
   $nickname = $_POST['nickname'];
   $email = $_POST['email'];
   $password = $_POST['password'];
   $repPassword = $_POST['repPassword'];

   $queryProcurarNickname = $connection->prepare("SELECT * FROM utilizador WHERE NomeUnico = ?");
   $queryInserir = $connection->prepare("INSERT INTO utilizador(NomeUnico, Nome, Email, Password) VALUES :Nickname, :Nome, :Email, :Password");

   $queryProcurarNickname->bindParam("s", $nickname);
   $queryProcurarNickname->execute();
   $queryProcurarNickname->store_result();

   if ($queryProcurarNickname->num_rows == 0) {

   }

   /*
   $queryInserir->bindParam(":Nickname", $nickname, PDO::PARAM_STR);
   $queryInserir->bindParam(":Nome", $nome, PDO::PARAM_STR);
   $queryInserir->bindParam(":Email", $email, PDO::PARAM_STR);
   $queryInserir->bindParam(":Password", $password, PDO::PARAM_STR);
   */

?>
