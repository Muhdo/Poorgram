<?php
   include("connectDB.php");

   $pesquisa = $_GET["pesquisa"];
   if (empty($pesquisa)) {
      header("Location: index.php");
   }

   $srcStr = "%".$pesquisa."%";
   $queryPesquisar = $connection->prepare("SELECT Nome, NomeUnico, FotoPerfil FROM utilizador WHERE NomeUnico LIKE :Pesquisa OR Nome LIKE :Pesquisa");
   $queryPesquisar->bindParam(":Pesquisa", $srcStr, PDO::PARAM_STR);
   $queryPesquisar->execute();

   if ($queryPesquisar->rowCount() == 0) {
      echo "<h2>A pesquisa de \"".$pesquisa."\" não foi dar a nenhum lado 😞</h2>\n<h4>Experimenta mudar a tua pesquisa! 😄</h4>";
   } else {
      foreach ($queryPesquisar->fetchAll() as $resultado) {
         if (is_null($resultado["FotoPerfil"])) {
            $imagem = "img/profile-picture.png";
         } else {
            $imagem = $resultado["FotoPerfil"];
         }

         for ($i=0; $i < 100; $i++) {
            echo '<article class="utilizador">
               <div class="div-account">
                  <img class="img-account" src='.$imagem.'>
                  <p class="p-name" href="#">'.$resultado["Nome"].'</p>
                  <a class="a-account" href="#">'.$resultado["NomeUnico"].'</a>
                  <div>
                     <button class="button-conta" type="button">Visitar Perfil</button>
                  </div>
               </div>
            </article>';
         }
      }
   }
   exit();
?>
