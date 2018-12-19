<head>
   <link rel="stylesheet" type="text/css" href="style/reglog.css">
   <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
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
                  <input class="form-input" id="nome" type="text" name="nome" value="<?php echo $nome; ?>" size="30" placeholder="Nome Ex: Jossefino Andrade">
                  <span class="tooltiptext">Nome Próprio<br>Até 30 caracteres.</span>
               </div>
               <div class="tooltip">
               <input class="form-input" id="identificador" type="text" name="nickname" value="<?php echo $nickname; ?>" size="20" placeholder="Nickname Ex: __xXJosefino420Xx__">
                  <span class="tooltiptext">Nome de Utilizador que te identifiques.<br>Mais de 4 caracteres.<br>Até 20 caracteres.</span>
               </div>
               <div class="tooltip">
               <input class="form-input" id="email" type="text" name="email" value="<?php echo $email; ?>" size="255" placeholder="Email Ex: JossefinoAndrade420@gamaile.come">
                  <span class="tooltiptext">Email para login.</span>
               </div>
               <div class="tooltip">
               <input class="form-input" id="password" type="password" name="password" value="<?php echo $password; ?>" size="255" placeholder="Palavra-Passe Ex: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                  <span class="tooltiptext">Mais de 8 caracteres.<br>Conter letras maiusculas.<br>Conter letras minusculas.<br>Conter numeros.<br>Conter caracteres especiais.</span>
               </div>
               <div class="tooltip">
               <input class="form-input" id="repPassword" type="password" name="repPassword" value="<?php echo $repPassword; ?>" size="255" placeholder="Repetir Palavra-Passe Ex: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                  <span class="tooltiptext">Ser igual á palavra-passe.</span>
               </div>
               <button class="form-button" id="submit" type="submit" name="submit">Registar</button>
               <a href="login.php">Login</a>
            </form>
         </div>
      </div>
   </main>

   <script>

      function mudarStyle(input) {
         document.getElementsByTagName("input").classList.remove("form-input-correto");
         document.getElementById(input).classList.add("form-input-erro");
      }

      function mudarFace() {
         document.getElementById("facebook").innerHTML = "Esquece, não funfa!";
      }
   </script>
</body>
