<head>
   <link rel="stylesheet" type="text/css" href="style/registar.css">
</head>

<body>
   <main>
      <div class="div-esquerda">
         <div class="div-conteudo">
            <h1>A rede social do momento!🔥🔥🔥</h1>
            <img src="img/logo.png">
            <h3>Não podes perder ⏰ esta forma fantástica de entenderes que nao tens amigos!</h3>
            <h3>Acredita, eles apenas querem os teus 👍🏻</h3>
            <h3>Cria já a tua conta para ficares 😭 ao entender que ninguem dá 👍🏻 nas tuas 📷</h3>
         </div>
      </div>
      <div class="div-direita">
         <div class="div-conteudo">
            <form class="div-form-registar" action="" method="post">
               <button class="button-facebook" id="facebook" type="button" onClick="mudarNome()">Login com Facebook</button>
               <input class="form-input" id="nome" type="text" name="nome" placeholder="Nome Ex: Jossefino Andrade">
               <input class="form-input" id="identificador" type="text" name="Identificador" placeholder="Nickname Ex: __xXJosefino420Xx__">
               <input class="form-input" id="email" type="text" name="Email" placeholder="Email Ex: JossefinoAndrade420@gamaile.come">
               <input class="form-input" id="password" type="password" name="Password" placeholder="Palavra-Passe Ex: ************">
               <input class="form-button" id="submit" type="submit" name="Registar" value="Registar">
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
