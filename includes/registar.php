<head>
   <link rel="stylesheet" type="text/css" href="style/registar.css">
</head>

<body>
   <main>
      <div class="div-esquerda">
         <div class="div-conteudo">
            <h1>A rede social do momento!🔥🔥🔥</h1>
            <img src="img/logo.png">
            <h3>Não podes perder ⏰ para esta forma fantástica de entenderes que nao tens amigos!</h3>
            <h3>Acredita, eles apenas querem os teus 👍🏻</h3>
            <h3>Cria já a tua conta para ficares 😭 ao entender que ninguem dá 👍🏻 nas tuas 📷</h3>
         </div>
      </div>
      <div class="div-direita">
         <div class="div-conteudo">
            <form class="div-form-registar" name="form-registar" method="POST" action="includes/action_registar.php">
               <button class="button-facebook" id="facebook" type="button" onClick="mudarNome()">Login com Facebook</button>
               <input class="form-input" id="nome" type="text" name="nome" placeholder="Nome Ex: Jossefino Andrade">
               <input class="form-input" id="identificador" type="text" name="nickname" placeholder="Nickname Ex: __xXJosefino420Xx__">
               <input class="form-input" id="email" type="text" name="email" placeholder="Email Ex: JossefinoAndrade420@gamaile.come">
               <input class="form-input" id="password" type="password" name="password" placeholder="Palavra-Passe Ex: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
               <input class="form-input" id="repPassword" type="password" name="repPassword" placeholder="Repetir Palavra-Passe Ex: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
               <button class="form-button" id="submit" type="submit" name="submit">Registar</button>
               <a href="#">Login</a>
            </form>
         </div>
      </div>
   </main>

   <script>
      function mudarNome() {
         document.getElementById("facebook").innerHTML = "Esquece, não funfa!"
      }
   </script>
</body>
