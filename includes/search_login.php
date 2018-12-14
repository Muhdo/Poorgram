<?php
   include("connectDB.php"); //Conexão com base de dados

   //Função para ser executada quando for para fazer login
   function ExecutarLogin($email, $password) { //Variaveis vindo do ficheiro pai, email cru, password encriptada
      //Preparar query para verificar se existe o utilizador
      $queryLogin = $connection->prepare("SELECT * FROM utilizador WHERE Email = :email AND Password = :password");

      //Associar as variaveis com os campos da query
      $queryLogin->bindParam(":email", $email, PDO::PARAM_STR);
      $queryLogin->bindParam(":password", $password, PDO::PARAM_STR);
      $queryLogin->execute();

      //Verificar resultados
      if ($queryLogin->rowCount() == 0) { //Não existe resultados
         //Fechar conexões
         $queryLogin->closeCursor();
         $connection = null;

         return FALSE;
      } elseif ($queryLogin->rowCount() == 1) { //Existe um resultado
         $row = $queryLogin->fetchAll(); //Ler o resultado

         //Iniciar sessão
         session_start();
         $_SESSION["User_Id"] = $row["Key_Utilizador"];
         $_SESSION["User_Nickname"] = $row["NomeUnico"];
         $_SESSION["User_Nome"] = $row["Nome"];
         $_SESSION["User_Email"] = $row["Email"];
         $_SESSION["User_Password"] = $row["Password"];
         $_SESSION["User_FotoPerfil"] = $row["FotoPerfil"];
         $_SESSION["User_Descricao"] = $row["Descricao"];

         //Fechar conexões
         $queryLogin->closeCursor();
         $connection = null;

         return TRUE;
      } else { //Qualquer outro tipo de resultado não esperado
         //Fechar conexões
         $queryLogin->closeCursor();
         $connection = null;

         return FALSE;
      }
   }
?>
