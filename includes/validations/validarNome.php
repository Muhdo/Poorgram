<?php
   $nome = $_POST["nome"];

   if (strlen($nome) < 4 || strlen($nome) > 30 || !preg_match("/^[a-záàâãäåæçèéêëìíîïðñòóôõøùúûüýþÿı ]*$/i", $nome)) { //Nome: Maior ou igual a 4, menor ou igual a 30, nao permite numeros e caracteres especiais
      echo "Error";
      exit();
   } else {
      echo "Valid";
      exit();
   }
?>
