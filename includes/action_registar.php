<?php
   include("connectDB.php");

   session_start();
   $_SESSION['regForm'] = $_POST;
   $nome = $_POST["nome"];
   $nickname = $_POST["nickname"];
   $email = $_POST["email"];
   $password = $_POST["password"];
   $repPassword = $_POST["repPassword"];
   if (strlen($nome) < 4 || strlen($nome) > 30 || !preg_match("/^[a-záàâãäåæçèéêëìíîïðñòóôõøùúûüýþÿı ]*$/i", $nome)) {
      echo "ErrorName";
      exit();
   } else {
      if (strlen($nickname) < 5 || strlen($nickname) > 20) {
         echo "ErrorNickname";
         exit();
      } else {

         $queryProcurarNickname = $connection->prepare("SELECT * FROM utilizador WHERE NomeUnico = :Nickname");
         $queryProcurarNickname->bindParam(":Nickname", $nickname, PDO::PARAM_STR);
         $queryProcurarNickname->execute();
         if ($queryProcurarNickname->rowCount() > 0) {
            $queryProcurarNickname->closeCursor();
            echo "DuplicationNickname";
            exit();
         } else {
            $queryProcurarNickname->closeCursor();
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
               echo "ErrorEmail";
               exit();
            } else {

               $queryProcurarEmail = $connection->prepare("SELECT * FROM utilizador WHERE Email = :Email");
               $queryProcurarEmail->bindParam(":Email", $email, PDO::PARAM_STR);
               $queryProcurarEmail->execute();
               if ($queryProcurarEmail->rowCount() > 0) {
                  $queryProcurarEmail->closeCursor();
                  echo "DuplicationEmail";
                  exit();
               } else {
                  $queryProcurarEmail->closeCursor();
                  if (!preg_match("/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/", $password)) {
                     echo "ErrorPassword";
                     exit();
                  } else {
                     if ($password != $repPassword) {
                        echo "ErrorRepPassword";
                        exit();
                     } else {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        $queryInserir = $connection->prepare("INSERT INTO utilizador(NomeUnico, Nome, Email, Password) VALUES (:Nickname, :Nome, :Email, :Password)");

                        $queryInserir->bindParam(":Nickname", $nickname, PDO::PARAM_STR);
                        $queryInserir->bindParam(":Nome", $nome, PDO::PARAM_STR);
                        $queryInserir->bindParam(":Email", $email, PDO::PARAM_STR);
                        $queryInserir->bindParam(":Password", $hashedPassword, PDO::PARAM_STR);
                        $queryInserir->execute();

                        $queryInserir->closeCursor();
                        $connection = null;

                        echo "Registar";
                        exit();
                     }
                  }
               }
            }
         }
      }
   }
$connection = null;
exit();
?>
