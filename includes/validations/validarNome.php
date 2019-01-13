<?php
   $nome = $_POST["nome"];

   if (strlen($nome) < 4 || strlen($nome) > 30 || !preg_match("/^[a-záàâãäåæçèéêëìíîïðñòóôõøùúûüýþÿı ]*$/i", $nome)) {
      echo "Error";
      exit();
   } else {
      echo "Valid";
      exit();
   }
?>
