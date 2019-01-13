<?php
   $newValido = $_POST["newValido"];
   $password = $_POST["password"];
   $repPassword = $_POST["repPassword"];

   if ($newValido == "Valid") {
      if ($password != $repPassword) {
         echo "Error";
         exit();
      } else {
         echo "Valid";
         exit();
      }
   } elseif ($newValido == "Empty") {
      echo "Empty";
      exit();
   } else {
      echo "Error";
      exit();
   }
?>
