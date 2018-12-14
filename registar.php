<head>
   <link rel="stylesheet" type="text/css" href="style/reglog.css">
</head>

<body>
   <main>
      <div class="div-esquerda">
         <div class="div-conteudo">
            <h1>A rede social do momento!🔥</h1>
            <img src="img/logo.png">
            <h3>Não podes perder ⏰ para esta forma fantástica de entenderes que não tens amigos!</h3>
            <h3>Acredita, eles apenas querem os teus 👍🏻</h3>
            <h3>Cria já a tua conta para ficares 😭 ao entender que ninguem dá 👍🏻 nas tuas 📷</h3>
         </div>
      </div>

      <?php
         session_start();

         $nome = "";
         $nickname = "";
         $email = "";
         $password = "";
         $repPassword = "";

         if (isset($_SESSION['regForm'])) {
            $form = $_SESSION['regForm'];

            $nome = $form['nome'];
            $nickname = $form['nickname'];
            $email = $form['email'];
            $password = $form['password'];
            $repPassword = $form['repPassword'];
         }

         session_unset();
         session_destroy();

         //if (isset($_GET['GrandTheftAuto'])) {
      ?>

      <div class="div-direita">
         <div class="div-conteudo">
            <form class="div-form" name="form-registar" method="POST" action="includes/action_registar.php">
               <button class="button-facebook" id="facebook" type="button" onClick="mudarFace()">Login com Facebook</button>
               <div class="tooltip">
                  <input class="form-input" id="nome" type="text" name="nome" value="<?php echo $nome; ?>" placeholder="Nome Ex: Jossefino Andrade">
                  <span class="tooltiptext">a</span>
               </div>
               <div class="tooltip">
               <input class="form-input" id="identificador" type="text" name="nickname" value="<?php echo $nickname; ?>" placeholder="Nickname Ex: __xXJosefino420Xx__">
                  <span class="tooltiptext">a</span>
               </div>
               <div class="tooltip">
               <input class="form-input" id="email" type="text" name="email" value="<?php echo $email; ?>" placeholder="Email Ex: JossefinoAndrade420@gamaile.come">
                  <span class="tooltiptext">a</span>
               </div>
               <div class="tooltip">
               <input class="form-input" id="password" type="password" name="password" value="<?php echo $password; ?>" placeholder="Palavra-Passe Ex: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                  <span class="tooltiptext">a</span>
               </div>
               <div class="tooltip">
               <input class="form-input" id="repPassword" type="password" name="repPassword" value="<?php echo $repPassword; ?>" placeholder="Repetir Palavra-Passe Ex: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                  <span class="tooltiptext">a</span>
               </div>
               <button class="form-button" id="submit" type="submit" name="submit">Registar</button>
               <a href="login.php">Login</a>
            </form>
         </div>
      </div>
   </main>

   <script>
      if(window.location.href.indexOf("?erroNome") > -1) {
         erroNome();
      }

      function erroNome() {

      }

      function mudarFace() {
         document.getElementById("facebook").innerHTML = "Esquece, não funfa!"
      }
   </script>
</body>
