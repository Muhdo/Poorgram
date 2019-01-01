<?php
   $password = $_POST["password"];

   if (!preg_match("/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/", $password) || strlen($password) > 255) { //Password: Tem maiusculas, tem minusculas, tem numeros, tem caracteres especiais, tem 8 caracteres, é menor ou igual a 255
      echo "Error";
      exit();
   } else {
      echo "Valid";
      exit();
   }
?>
