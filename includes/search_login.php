<?php
   ExecutarLogin($_POST["email"], $_POST["password"]);

   //Função para ser executada quando for para fazer login
   function ExecutarLogin($email, $password) { //Variaveis vindo do ficheiro pai, email cru, password cru
      include("connectDB.php"); //Conexão com base de dados

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

      } elseif ($queryLogin->rowCount() == 1) { //Existe um resultado
         $row = $queryLogin->fetchAll(PDO::FETCH_ASSOC); //Ler o resultado

         var_dump($row[0]["Password"]);
         $hashedPasswordCheck = password_verify($password, $row[0]["Password"]);

         if ($hashedPasswordCheck == FALSE) {
            exit();
         } elseif ($hashedPasswordCheck == TRUE) {
            //Iniciar sessão
            session_start();
            $_SESSION["User_Id"] = $row[0]["Key_Utilizador"];
            $_SESSION["User_Nickname"] = $row[0]["NomeUnico"];
            $_SESSION["User_Nome"] = $row[0]["Nome"];
            $_SESSION["User_Email"] = $row[0]["Email"];
            $_SESSION["User_Password"] = $row[0]["Password"];
            $_SESSION["User_FotoPerfil"] = $row[0]["FotoPerfil"];
            $_SESSION["User_Descricao"] = $row[0]["Descricao"];

            //Fechar conexões
            $queryLogin->closeCursor();
            $connection = null;

            header("Location: ../index.php");
         }
      } else { //Qualquer outro tipo de resultado não esperado
         //Fechar conexões
         $queryLogin->closeCursor();
         $connection = null;

         echo "Erro meu filho";
      }
   }
?>
