<?php
   include("connectDB.php"); //Conexão com base de dados

   $email = $_POST["email"];
   $password = $_POST["password"];

   //Preparar query para verificar se existe o utilizador
   $queryLogin = $connection->prepare("SELECT * FROM utilizador WHERE Email = :email");

   //Associar as variaveis com os campos da query
   $queryLogin->bindParam(":email", $email, PDO::PARAM_STR);
   $queryLogin->execute();

   //Verificar resultados
   if ($queryLogin->rowCount() == 0) { //Não existe resultados
      //Fechar conexões
      $queryLogin->closeCursor();
      $connection = null;

      echo "Error";
      exit();

   } elseif ($queryLogin->rowCount() == 1) { //Existe um resultado
      $row = $queryLogin->fetchAll(PDO::FETCH_ASSOC); //Ler o resultado
      $hashedPasswordCheck = password_verify($password, $row[0]["Password"]);

      if ($hashedPasswordCheck == FALSE) {
         echo "Error";
         exit();
      } elseif ($hashedPasswordCheck == TRUE) {
         //Iniciar sessão
         session_start();
         $_SESSION["User_Id"] = $row[0]["Key_Utilizador"];
         $_SESSION["User_Nickname"] = $row[0]["NomeUnico"];
         $_SESSION["User_Nome"] = $row[0]["Nome"];
         $_SESSION["User_Email"] = $row[0]["Email"];
         $_SESSION["User_FotoPerfil"] = "data:image/jpeg;base64,".base64_encode($row[0]["FotoPerfil"]);
         $_SESSION["User_Descricao"] = $row[0]["Descricao"];

         //Fechar conexões
         $queryLogin->closeCursor();
         $connection = null;

         echo "Login";
         exit();
      }
   } else { //Qualquer outro tipo de resultado não esperado
      //Fechar conexões
      $queryLogin->closeCursor();
      $connection = null;

      echo "Error";
      exit();
   }
?>
