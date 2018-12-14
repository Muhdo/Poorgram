<?php
   try {
   $connection = new PDO("mysql:host=localhost;dbname=poorgram", "root", ""); //Ligação a utilizar PDO
   $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Atribui o modo de erros
   }
   catch(PDOException $e)
   {
   echo "A conexão falhou!: " . $e->getMessage(); //Caso não seja possivel ligar à base de dados
   }
?>
