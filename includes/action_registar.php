<?php
if (isset($_POST["submit"])) { //Apenas executa caso seja pelo form
   include("connectDB.php"); //Conexão com base de dados
   //Variaveis vindas do formulário
   session_start();
   $_SESSION['regForm'] = $_POST;
   $nome = $_POST["nome"];
   $nickname = $_POST["nickname"];
   $email = $_POST["email"];
   $password = $_POST["password"];
   $repPassword = $_POST["repPassword"];
   if (strlen($nome) < 4 || strlen($nome) > 30 || !preg_match("/^[a-záàâãäåæçèéêëìíîïðñòóôõøùúûüýþÿı ]*$/i", $nome)) { //Nome: Maior ou igual a 4, menor ou igual a 30, nao permite numeros e caracteres especiais
      header("Location: ../registar.php?erroNome");  //Voltar para a página anterior
      exit();
   } else {
      if (strlen($nickname) < 5 || strlen($nickname) > 20) { //Nickname: Maior ou igual a 5, menor ou igual a 20
         header("Location: ../registar.php?erroNickname");  //Voltar para a página anterior
         exit();
      } else {
         //Preparar query para verificar se já existe algum nome de utilizador igual
         $queryProcurarNickname = $connection->prepare("SELECT * FROM utilizador WHERE NomeUnico = :Nickname");
         $queryProcurarNickname->bindParam(":Nickname", $nickname, PDO::PARAM_STR); //Associar a variavel com o campo na query
         $queryProcurarNickname->execute();
         if ($queryProcurarNickname->rowCount() > 0 || strlen($nickname) < 5) { //Verificar se existe algum resultado
            $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
            header("Location: ../registar.php?usadoNickname");  //Voltar para a página anterior
            exit();
         } else {
            $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) { //Email: formato válido, menor ou igual a 255(por precaução)
               header("Location: ../registar.php?erroEmail");  //Voltar para a página anterior
               exit();
            } else {
               //Preparar query para verificar se já existe algum email igual
               $queryProcurarEmail = $connection->prepare("SELECT * FROM utilizador WHERE Email = :Email");
               $queryProcurarEmail->bindParam(":Email", $email, PDO::PARAM_STR); //Associar a variavel com o campo da query
               $queryProcurarEmail->execute();
               if ($queryProcurarEmail->rowCount() > 0) { //Verificar se existe algum resultado
                  $queryProcurarEmail->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
                  header("Location: ../registar.php?usadoEmail");  //Voltar para a página anterior
                  exit();
               } else {
                  $queryProcurarEmail->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas
                  if (!preg_match("/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/", $password) || strlen($password) > 255) { //Password: Tem maiusculas, tem minusculas, tem numeros, tem caracteres especiais, tem 8 caracteres, é menor ou igual a 255
                     header("Location: ../registar.php?erroPassword");  //Voltar para a página anterior
                     exit();
                  } else {
                     if ($password != $repPassword) { //repPassword: São iguais
                        header("Location: ../registar.php?erroIguais");  //Voltar para a página anterior
                        exit();
                     } else {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); //Encriptar a palavra-passe para poder passar para a base de dados
                        //Preparar query para inserir os dados
                        $queryInserir = $connection->prepare("INSERT INTO utilizador(NomeUnico, Nome, Email, Password) VALUES (:Nickname, :Nome, :Email, :Password)");
                        //Associar as variaveis com os campos da query
                        $queryInserir->bindParam(":Nickname", $nickname, PDO::PARAM_STR);
                        $queryInserir->bindParam(":Nome", $nome, PDO::PARAM_STR);
                        $queryInserir->bindParam(":Email", $email, PDO::PARAM_STR);
                        $queryInserir->bindParam(":Password", $hashedPassword, PDO::PARAM_STR);
                        $queryInserir->execute();
                        //Ficheiro que procura e inicia a sessão
                        include("search_login.php");
                        $resultado = ExecutarLogin($email, $hashedPassword); //Função que faz isso, envia email e palavra passe encriptada
                        //Fechar conexões
                        $queryInserir->closeCursor();
                        $connection = null;
                        if ($resultado == FALSE) {
                           header("Location: ../registar.php?erroLogin");  //Voltar para a página anterior
                           exit();
                        } elseif ($resultado == TRUE) {
                           header("Location: ../main.php");  //Vai para a página principal
                           exit();
                        }
                     }
                  }
               }
            }
         }
      }
   }
} else {
   echo "Erro a carregar!";
}
$connection = null;
exit();



   /*
   Cada função valida um dos campos.

   Return Values:
      return 0; = Não retorna nenhum erro.
      return 1; = Retorna erro de formatação, não relacionado com base de dados.
      return 2; = Retorna erro de base de dados, já existe esse registo.
   */
/*
   include("connectDB.php"); //Conexão com base de dados

   function validarNome($nome) {
      if (strlen($nome) < 4 || strlen($nome) > 30 || !preg_match("/^[a-záàâãäåæçèéêëìíîïðñòóôõøùúûüýþÿı ]*$/i", $nome)) { //Nome: Maior ou igual a 4, menor ou igual a 30, nao permite numeros e caracteres especiais
         return 1;
      } else {
         return 0;
      }
   }

   function validarNickname($nickname) {
      if (strlen($nickname) < 5 || strlen($nickname) > 20) { //Nickname: Maior ou igual a 5, menor ou igual a 20
         return 1;
      } else {
         //Preparar query para verificar se já existe algum nome de utilizador igual
         $queryProcurarNickname = $connection->prepare("SELECT * FROM utilizador WHERE NomeUnico = :Nickname");

         $queryProcurarNickname->bindParam(":Nickname", $nickname, PDO::PARAM_STR); //Associar a variavel com o campo na query
         $queryProcurarNickname->execute();

         if ($queryProcurarNickname->rowCount() > 0 || strlen($nickname) < 5) { //Verificar se existe algum resultado
            $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas

            return 2;
         } else {
            $queryProcurarNickname->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas

            return 0;
         }
      }
   }

   function validarEmail($email) {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) { //Email: formato válido, menor ou igual a 255(por precaução)
         return 1;
      } else {
         //Preparar query para verificar se já existe algum email igual
         $queryProcurarEmail = $connection->prepare("SELECT * FROM utilizador WHERE Email = :Email");

         $queryProcurarEmail->bindParam(":Email", $email, PDO::PARAM_STR); //Associar a variavel com o campo da query
         $queryProcurarEmail->execute();

         if ($queryProcurarEmail->rowCount() > 0) { //Verificar se existe algum resultado
            $queryProcurarEmail->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas

            return 2;
         } else {
            $queryProcurarEmail->closeCursor(); //Terminar a ligação para nao existir ligações desnecessárias abertas

            return 0;
         }
   }

   function validarPassword($password) {
      if (!preg_match("/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/", $password) || strlen($password) > 255) { //Password: Tem maiusculas, tem minusculas, tem numeros, tem caracteres especiais, tem 8 caracteres, é menor ou igual a 255
         return 1;
      } else {
         return 0;
      }
   }

   function validarPassIgualdade($password, $repPassword) {
      if ($password != $repPassword) { //repPassword: Não são iguais
         return 1;
      } else {
         return 0;
      }
   }

   function inserirUtilizador($nome, $nickname, $email, $password) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT); //Encriptar a palavra-passe para poder passar para a base de dados

      //Preparar query para inserir os dados
      $queryInserir = $connection->prepare("INSERT INTO utilizador(NomeUnico, Nome, Email, Password) VALUES (:Nickname, :Nome, :Email, :Password)");

      //Associar as variaveis com os campos da query
      $queryInserir->bindParam(":Nickname", $nickname, PDO::PARAM_STR);
      $queryInserir->bindParam(":Nome", $nome, PDO::PARAM_STR);
      $queryInserir->bindParam(":Email", $email, PDO::PARAM_STR);
      $queryInserir->bindParam(":Password", $hashedPassword, PDO::PARAM_STR);
      $queryInserir->execute();

      //Ficheiro que procura e inicia a sessão
      include("search_login.php");
      $resultado = ExecutarLogin($email, $hashedPassword); //Função que faz isso, envia email e palavra passe encriptada

      //Fechar conexões
      $queryInserir->closeCursor();
      $connection = null;

      if ($resultado == FALSE) {
         return 2;
      } elseif ($resultado == TRUE) {
         return 0;
      }
   }
*/
?>
