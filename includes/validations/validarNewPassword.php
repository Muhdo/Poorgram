<?php
   $oldValido = $_POST["oldValido"];
   $password = $_POST["password"];

   if ($oldValido == "Valid") {
      if (!preg_match("/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/", $password)) { //Password: Tem maiusculas, tem minusculas, tem numeros, tem caracteres especiais, tem 8 caracteres
         echo "Error";
         exit();
      } else {
         echo "Valid";
         exit();
      }
   } elseif ($oldValido == "Empty") {
      echo "Empty";
      exit();
   } else {
      echo "Error";
      exit();
   }
?>