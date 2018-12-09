<?php
   try {
   $connection = new PDO("mysql:host=localhost;dbname=poorgram", "root", "");
   $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
   catch(PDOException $e)
   {
   echo "A conexão falhou!: " . $e->getMessage();
   }
?>
