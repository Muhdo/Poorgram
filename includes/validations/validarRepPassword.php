<?php
   $password = $_POST["password"];
   $repPassword = $_POST["repPassword"];

   if ($password != $repPassword) { //repPassword: São iguais
      echo "Error";  //Voltar para a página anterior
      exit();
   } else {
      echo "Valid";
      exit();
   }
?>
