<?php
   if (isset($_POST["submit"])) { //Apenas executa caso seja pelo form
      include("connectDB.php"); //Conexão com Base de dados

      //Variaveis vindas do formulário
      $nome = $_POST["nome"];
      $nickname = $_POST["nickname"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $repPassword = $_POST["repPassword"];

      //Preparar query para verificar se já existe algum nome de utilizador igual
      $queryProcurarNickname = $connection->prepare("SELECT * FROM utilizador WHERE NomeUnico = :Nickname");

      $queryProcurarNickname->bindParam(":Nickname", $nickname, PDO::PARAM_STR); //Associar a variavel com o campo na query
      $queryProcurarNickname->execute();
      var_dump($queryProcurarNickname->fetch());

      if ($queryProcurarNickname->rowCount() > 0) { //Verificar se existe algum resultado
         $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas

         $pagina_salto = "../registar.php?erronickname"; header(sprintf("Location: %s", $pagina_salto));  //Voltar para a página anterior
         exit();
      }
      else {
         $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas

         //Preparar query para verificar se já existe algum email igual
         $queryProcurarEmail = $connection->prepare("SELECT * FROM utilizador WHERE Email = :Email");

         $queryProcurarEmail->bindParam(":Email", $email, PDO::PARAM_STR); //Associar a variavel com o campo da query
         $queryProcurarEmail->execute();

         if ($queryProcurarEmail->rowCount() > 0) { //Verificar se existe algum resultado
            $queryProcurarEmail->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas

            header("location:javascript://history.go(-1)"); //Voltar para a página anterior
            exit();
         }
         else {
            $queryProcurarEmail->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas

            if ($password != $repPassword) { //Verificar se as palavras-passes são iguais
               header("location:javascript://history.go(-1)"); //Voltar para a página anterior
               exit();
            }
            else {
               $hashedPassword = password_hash($password, PASSWORD_DEFAULT); //Encriptar a palavra-passe para poder passar para a base de dados

               //Preparar query para inserir os dados
               $queryInserir = $connection->prepare("INSERT INTO utilizador(NomeUnico, Nome, Email, Password) VALUES (:Nickname, :Nome, :Email, :Password)");

               //Associar as variaveis com os campos da query
               $queryInserir->bindParam(":Nickname", $nickname, PDO::PARAM_STR);
               $queryInserir->bindParam(":Nome", $nome, PDO::PARAM_STR);
               $queryInserir->bindParam(":Email", $email, PDO::PARAM_STR);
               $queryInserir->bindParam(":Password", $hashedPassword, PDO::PARAM_STR);
               $queryInserir->execute();

               //Fechar conexões
               $queryInserir->closeCursor();
               $connection = null;
               exit();
            }
         }
      }
   }
   else {
      echo "Erro a carregar!";
   }

   $connection = null;

   exit();
?>
