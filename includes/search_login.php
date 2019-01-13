<?php
   include("connectDB.php");

   $email = $_POST["email"];
   $password = $_POST["password"];


   $queryLogin = $connection->prepare("SELECT * FROM utilizador WHERE Email = :email");


   $queryLogin->bindParam(":email", $email, PDO::PARAM_STR);
   $queryLogin->execute();


   if ($queryLogin->rowCount() == 0) {

      $queryLogin->closeCursor();
      $connection = null;

      echo "Error";
      exit();

   } elseif ($queryLogin->rowCount() == 1) {
      $row = $queryLogin->fetchAll(PDO::FETCH_ASSOC);
      $hashedPasswordCheck = password_verify($password, $row[0]["Password"]);

      if ($hashedPasswordCheck == FALSE) {
         echo "Error";
         exit();
      } elseif ($hashedPasswordCheck == TRUE) {

         session_start();
         $_SESSION["User_Id"] = $row[0]["Key_Utilizador"];
         $_SESSION["User_Nickname"] = $row[0]["NomeUnico"];
         $_SESSION["User_Nome"] = $row[0]["Nome"];
         $_SESSION["User_Email"] = $row[0]["Email"];
         $_SESSION["User_FotoPerfil"] = "data:image/jpeg;base64,".base64_encode($row[0]["FotoPerfil"]);
         $_SESSION["User_Descricao"] = $row[0]["Descricao"];


         $queryLogin->closeCursor();
         $connection = null;

         echo "Login";
         exit();
      }
   } else {

      $queryLogin->closeCursor();
      $connection = null;

      echo "Error";
      exit();
   }
?>
