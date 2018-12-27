<?php
   $funcao = $_POST["funcao"];

   if ($funcao == "Seguir") {
      Seguir();
   } elseif ($funcao == "NaoSeguir") {
      NaoSeguir();
   }

   function Seguir() {
      session_start();
      include("connectDB.php");
      var_dump($connection);
      $Seguir = $_POST["Seguir"];

      $queryAddFollower = $connection->prepare("INSERT INTO seguir(Key_Utilizador, Key_Seguir) VALUES (:Utilizador, :Seguir)");
      $queryAddFollower->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
      $queryAddFollower->bindParam(":Seguir", $Seguir, PDO::PARAM_STR);
      $queryAddFollower->execute();

      $queryAddFollower->closeCursor();
      echo "Add";
   }

   function NaoSeguir() {
      session_start();
      include("connectDB.php");
      var_dump($connection);
      $Seguir = $_POST["Seguir"];

      $queryDelFollower = $connection->prepare("DELETE FROM seguir WHERE Key_Utilizador=:Utilizador AND Key_Seguir=:Seguir");
      $queryDelFollower->bindParam(":Utilizador", $_SESSION["User_Id"], PDO::PARAM_STR);
      $queryDelFollower->bindParam(":Seguir", $Seguir, PDO::PARAM_STR);
      $queryDelFollower->execute();

      $queryDelFollower->closeCursor();
      echo "Del";
   }
?>
