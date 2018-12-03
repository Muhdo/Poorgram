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
               <table>
                  <tr>
                     <td><h3>Nome:</h3></td>
                     <td><input class="form-input" id="nome" type="text" name="nome" placeholder="Ex: Jossefino Andrade"></td>
                  </tr>
                  <tr>
                     <td><h3>Identificador:</h3></td>
                     <td><input class="form-input" id="identificador" type="text" name="Identificador" placeholder="Ex: @__xXJosefino420Xx__"></td>
                  </tr>
                  <tr>
                     <td><h3>Email:</h3></td>
                     <td><input class="form-input" id="email" type="text" name="Email" placeholder="Ex: JossefinoAndrade420@gamaile.come"></td>
                  </tr>
                  <tr>
                     <td><h3>Password:</h3></td>
                     <td><input class="form-input" id="password" type="text" name="Password" placeholder="Ex: ************"></td>
                  </tr>
                  <tr>
                     <button class="button-facebook" id="facebook" type="button" name="fb" onClick="mudarNome()">Login com Facebook</button>
                  </tr>
               </table>
            </form>
         </div>
      </div>
   </main>

   <script>
      function mudarNome() {
         document.getElementById("facebook").innerHTML = "Isto não funciona ok?"
      }
   </script>
</body>
