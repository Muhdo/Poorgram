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
      <div class="div-direita">
         <div class="div-conteudo">
            <form class="div-form" name="form-login" method="POST" action="includes/search_login.php">
               <button class="button-facebook" id="facebook" type="button" onClick="mudarFace()">Login com Facebook</button>
               <div class="tooltip">
                  <input class="form-input" id="email" type="text" name="email" placeholder="Email Ex: JossefinoAndrade420@gamaile.come">
                  <span class="tooltiptext">Email da conta</span>
               </div>
               <div class="tooltip">
               <input class="form-input" id="password" type="password" name="password" placeholder="Palavra-Passe Ex: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                  <span class="tooltiptext">Password da conta</span>
               </div>
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

      $(".div-form").submit(function(e) {
         e.preventDefault();

         $.ajax({
            type: "POST",
            url: "includes/search_login.php",
            data: {
               email: e.email.value,
               password: e.password.value,
            },
            success: function(output) {
               console.log(output);
            }
         });
      })
   </script>
</body>
