<head>
   <link rel="stylesheet" type="text/css" href="style/reglog.css">
</head>

<body>
   <main>
      <div class="div-esquerda">
         <div class="div-conteudo">
            <h1>A rede social do momento!🔥</h1>
            <img src="img/logo.png">
            <h3>Não podes perder ⏰ para esta forma fantástica de entenderes que nao tens amigos!</h3>
            <h3>Acredita, eles apenas querem os teus 👍🏻</h3>
            <h3>Cria já a tua conta para ficares 😭 ao entender que ninguem dá 👍🏻 nas tuas 📷</h3>
         </div>
      </div>
      <div class="div-direita">
         <div class="div-conteudo">
            <form class="div-form" name="form-login" method="POST" action="includes/action_login.php">
               <button class="button-facebook" id="facebook" type="button" onClick="mudarFace()">Login com Facebook</button>
               <input class="form-input" id="email" type="text" name="email" placeholder="Email Ex: JossefinoAndrade420@gamaile.come">
               <input class="form-input" id="password" type="password" name="password" placeholder="Palavra-Passe Ex: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
               <button class="form-button" id="submit" type="submit" name="submit">Login</button>
               <a href="registar.php">Registar</a>
            </form>
         </div>
      </div>
   </main>

   <script>
      function mudarFace() {
         document.getElementById("facebook").innerHTML = "Esquece, não funfa!"
      }
   </script>
</body>
