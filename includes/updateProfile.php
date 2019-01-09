<?php
   session_start();

   $nome = $_POST["nome"];
   $nickname = $_POST["nickname"];
   $email = $_POST["email"];
   $oldPassword = $_POST["oldPassword"];
   $newPassword = $_POST["newPassword"];
   $repPassword = $_POST["repPassword"];
   $imagem = $_POST["imagem"];
   $descricao = $_POST["descricao"];

   $valido;

   $result = UpNome($nome);

   if ($result == "Error" || $result == "ErrorUpdate") {
      echo "ErrorNome";
      exit();
   } elseif ($result == "Valid") {
      $result = UpNickname($nickname);

      if ($result == "Error" || $result == "ErrorUpdate") {
         echo "ErrorNickname";
         exit();
      } elseif ($result == "Duplication") {
         echo "DuplicationNickname";
         exit();
      } elseif ($result == "Valid") {
         $result = UpEmail($email);

         if ($result == "Error" || $result == "ErrorUpdate") {
            echo "ErrorEmail";
            exit();
         } elseif ($result == "Duplication") {
            echo "DuplicationEmail";
            exit();
         } elseif ($result == "Valid") {
            $result = UpOldPassword($oldPassword);
            $valido = $result;

            if ($result == "Error") {
               echo "ErrorOldPassword";
               exit();
            } elseif ($result == "Valid" || $result == "Empty") {
               $result = UpNewPassword($valido, $newPassword);

               if ($result == "Error") {
                  echo "ErrorNewPassword";
                  exit();
               } elseif ($result == "Valid" || $result == "Empty") {
                  $result = UpRepPassword($valido, $newPassword, $repPassword);

                  if ($result == "Error") {
                     echo "ErrorRepPassword";
                     exit();
                  } elseif ($result == "Valid" || $result == "Empty") {

                     $result = UpImagem($imagem);

                     if ($result == "Empty" || $result == "Valid" || $result == "ErrorUpdate") {
                        $result = UpDescricao($descricao);

                        if ($result = "Valid" || $result == "ErrorUpdate") {
                           include("connectDB.php");
                           $queryLogin = $connection->prepare("SELECT * FROM utilizador WHERE Key_Utilizador = :Key");
                           $queryLogin->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);
                           $queryLogin->execute();
                           $resultado = $queryLogin->fetchAll();

                           session_unset();
                           session_destroy();
                           session_start();
                           $_SESSION["User_Id"] = $resultado[0]["Key_Utilizador"];
                           $_SESSION["User_Nickname"] = $resultado[0]["NomeUnico"];
                           $_SESSION["User_Nome"] = $resultado[0]["Nome"];
                           $_SESSION["User_Email"] = $resultado[0]["Email"];
                           $_SESSION["User_FotoPerfil"] = "data:image/jpeg;base64,".base64_encode($resultado[0]["FotoPerfil"]);
                           $_SESSION["User_Descricao"] = $resultado[0]["Descricao"];

                           echo "Success";
                           exit();
                        }
                     }
                  }
               }
            }
         }
      }
   }
   function UpNome($nome) {
      if (strlen($nome) < 4 || strlen($nome) > 30 || !preg_match("/^[a-záàâãäåæçèéêëìíîïðñòóôõøùúûüýþÿı ]*$/i", $nome)) {
         return "Error";
         exit();
      } else {
         include("connectDB.php");

         $queryUpdateNome = $connection->prepare("UPDATE utilizador SET Nome = :Nome WHERE Key_Utilizador = :Key");
         $queryUpdateNome->bindParam(":Nome", $nome, PDO::PARAM_STR);
         $queryUpdateNome->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);

         if ($queryUpdateNome->execute()) {
            $queryUpdateNome->closeCursor();
            $connection = null;

            return "Valid";
            exit();
         } else {
            $queryUpdateNome->closeCursor();
            $connection = null;

            return "ErrorUpdate";
            exit();
         }
      }
   }

   function UpNickname($nickname) {
      if (strlen($nickname) < 5 || strlen($nickname) > 20) {
         return "Error";
         exit();
      } else {
         include("connectDB.php");

         $queryProcurarNickname = $connection->prepare("SELECT * FROM utilizador WHERE NomeUnico = :Nickname");
         $queryProcurarNickname->bindParam(":Nickname", $nickname, PDO::PARAM_STR);
         $queryProcurarNickname->execute();
         if ($queryProcurarNickname->rowCount() == 1) {
            if (isset($_SESSION["User_Id"])) {
               $resultado = $queryProcurarNickname->fetchAll();

               if ($resultado[0]["Key_Utilizador"] == $_SESSION["User_Id"]) {
                  $queryProcurarNickname->closeCursor();

                  $queryUpdateNickname = $connection->prepare("UPDATE utilizador SET NomeUnico = :Nickname WHERE Key_Utilizador = :Key");
                  $queryUpdateNickname->bindParam(":Nickname", $nickname, PDO::PARAM_STR);
                  $queryUpdateNickname->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);

                  if ($queryUpdateNickname->execute()) {
                     $queryUpdateNickname->closeCursor();
                     $connection = null;

                     return "Valid";
                     exit();
                  } else {
                     $queryUpdateNickname->closeCursor();
                     $connection = null;

                     return "ErrorUpdate";
                     exit();
                  }
               } elseif ($resultado[0]["Key_Utilizador"] != $_SESSION["User_Id"]) {
                  $queryProcurarNickname->closeCursor();
                  $connection = null;

                  return "Duplication";
                  exit();
               }
            }
            elseif(!isset($_SESSION["User_Id"])) {
               $queryProcurarNickname->closeCursor();
               $connection = null;

               return "Duplication";
               exit();
            }
         } elseif ($queryProcurarNickname->rowCount() == 0) {
            $queryProcurarNickname->closeCursor();

            $queryUpdateNickname = $connection->prepare("UPDATE utilizador SET NomeUnico = :Nickname WHERE Key_Utilizador = :Key");
            $queryUpdateNickname->bindParam(":Nickname", $nickname, PDO::PARAM_STR);
            $queryUpdateNickname->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);

            if ($queryUpdateNickname->execute()) {
               $queryUpdateNickname->closeCursor();
               $connection = null;

               return "Valid";
               exit();
            } else {
               $queryUpdateNickname->closeCursor();
               $connection = null;

               return "ErrorUpdate";
               exit();
            }
         }
      }
   }

   function UpEmail($email) {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
         return "Error";
         exit();
      } else {
         include("connectDB.php");

         $queryProcurarEmail = $connection->prepare("SELECT * FROM utilizador WHERE Email = :Email");
         $queryProcurarEmail->bindParam(":Email", $email, PDO::PARAM_STR);
         $queryProcurarEmail->execute();
         if ($queryProcurarEmail->rowCount() == 1) {
            if (isset($_SESSION["User_Id"])) {
               $resultado = $queryProcurarEmail->fetchAll();

               if ($resultado[0]["Key_Utilizador"] == $_SESSION["User_Id"]) {
                  $queryProcurarEmail->closeCursor();

                  $queryUpdateEmail = $connection->prepare("UPDATE utilizador SET Email = :Email WHERE Key_Utilizador = :Key");
                  $queryUpdateEmail->bindParam(":Email", $email, PDO::PARAM_STR);
                  $queryUpdateEmail->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);

                  if ($queryUpdateEmail->execute()) {
                     $queryUpdateEmail->closeCursor();
                     $connection = null;

                     return "Valid";
                     exit();
                  } else {
                     $queryUpdateEmail->closeCursor();
                     $connection = null;

                     return "ErrorUpdate";
                     exit();
                  }
               } elseif ($resultado[0]["Key_Utilizador"] != $_SESSION["User_Id"]) {
                  $queryProcurarEmail->closeCursor();
                  $connection = null;

                  return "Duplication";
                  exit();
               }
            }
            elseif(!isset($_SESSION["User_Id"])) {
               $queryProcurarEmail->closeCursor();
               $connection = null;

               return "Duplication";
               exit();
            }
         } elseif ($queryProcurarEmail->rowCount() == 0) {
            $queryProcurarEmail->closeCursor();

            $queryUpdateEmail = $connection->prepare("UPDATE utilizador SET Email = :Email WHERE Key_Utilizador = :Key");
            $queryUpdateEmail->bindParam(":Email", $email, PDO::PARAM_STR);
            $queryUpdateEmail->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);

            if ($queryUpdateEmail->execute()) {
               $queryUpdateEmail->closeCursor();
               $connection = null;

               return "Valid";
               exit();
            } else {
               $queryUpdateEmail->closeCursor();
               $connection = null;

               return "ErrorUpdate";
               exit();
            }
         }
      }
   }

   function UpOldPassword($oldPassword) {
      include("connectDB.php");

      if (strlen($oldPassword) == 0) {
         return "Empty";
         exit();
      } else {
         $queryVerificarPassword = $connection->prepare("SELECT * FROM utilizador WHERE Key_Utilizador = :Key");
         $queryVerificarPassword->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);
         $queryVerificarPassword->execute();
         if ($queryVerificarPassword->rowCount() == 1) {
            $resultado = $queryVerificarPassword->fetchAll();
            $hashedPasswordCheck = password_verify($oldPassword, $resultado[0]["Password"]);

            if ($hashedPasswordCheck == FALSE) {
               $queryVerificarPassword->closeCursor();
               $connection = null;

               return "Error";
               exit();
            } elseif ($hashedPasswordCheck == TRUE) {
               $queryVerificarPassword->closeCursor();
               $connection = null;

               return "Valid";
               exit();
            }
         } elseif ($queryVerificarPassword->rowCount() == 0) {
            $queryVerificarPassword->closeCursor();
            $connection = null;

            return "Error";
            exit();
         }
         $queryVerificarPassword->closeCursor();
         $connection = null;

         return "Error";
         exit();
      }
   }

   function UpNewPassword($valido, $newPassword) {
      if ($valido == "Valid") {
         if (!preg_match("/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/", $newPassword)) {
            return "Error";
            exit();
         } else {
            return "Valid";
            exit();
         }
      } elseif ($valido == "Empty") {
         return "Empty";
         exit();
      } else {
         return "Error";
         exit();
      }
   }

   function UpRepPassword($valido, $newPassword, $repPassword) {
      if ($valido == "Valid") {
         if ($newPassword != $repPassword) {
            return "Error";
            exit();
         } else {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            include("connectDB.php");

            $queryUpdatePassword = $connection->prepare("UPDATE utilizador SET Password = :Password WHERE Key_Utilizador = :Key");
            $queryUpdatePassword->bindParam(":Password", $hashedPassword, PDO::PARAM_STR);
            $queryUpdatePassword->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);

            if ($queryUpdatePassword->execute()) {
               $queryUpdatePassword->closeCursor();
               $connection = null;

               return "Valid";
               exit();
            } else {
               $queryUpdatePassword->closeCursor();
               $connection = null;

               return "ErrorUpdate";
               exit();
            }
         }
      } elseif ($valido == "Empty") {
         return "Empty";
         exit();
      } else {
         return "Error";
         exit();
      }
   }

   function UpImagem($imagem) {
      if ($imagem == "NoImage") {
         return "Valid";
         exit();
      } else {
         $imagem = file_get_contents($imagem);

         include("connectDB.php");

         $queryUpdateImagem = $connection->prepare("UPDATE utilizador SET FotoPerfil = :Imagem WHERE Key_Utilizador = :Key");
         $queryUpdateImagem->bindParam(":Imagem", $imagem, PDO::PARAM_STR);
         $queryUpdateImagem->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);

         if ($queryUpdateImagem->execute()) {
            $queryUpdateImagem->closeCursor();
            $connection = null;

            return "Valid";
            exit();
         } else {
            $queryUpdateImagem->closeCursor();
            $connection = null;

            return "ErrorUpdate";
            exit();
         }
      }
   }

   function UpDescricao($descricao) {
      include("connectDB.php");

      $queryUpdateDescricao = $connection->prepare("UPDATE utilizador SET Descricao = :Descricao WHERE Key_Utilizador = :Key");
      $queryUpdateDescricao->bindParam(":Descricao", $descricao, PDO::PARAM_STR);
      $queryUpdateDescricao->bindParam(":Key", $_SESSION["User_Id"], PDO::PARAM_STR);

      if ($queryUpdateDescricao->execute()) {
         $queryUpdateDescricao->closeCursor();
         $connection = null;

         return "Valid";
         exit();
      } else {
         $queryUpdateDescricao->closeCursor();
         $connection = null;

         return "ErrorUpdate";
         exit();
      }
   }
?>
