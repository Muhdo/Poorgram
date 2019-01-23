<?php
   $newValido = $_POST["newValido"];
   $password = $_POST["password"];
   $repPassword = $_POST["repPassword"];

   if ($newValido == "Valid") {
      if ($password != $repPassword || !preg_match("/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/", $repPassword)) {
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
