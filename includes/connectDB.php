<?php
   $connection = new mysqli("localhost", "root", "", "poorgram");

   if (mysqli_connect_errno()) {
      printf("Impossivel ligar á base de dados");
      exit();
   }
?>
