<head>
   <title> Poorgram </title>
   <link rel="stylesheet" type="text/css" href="style/reglog.css">
   <link rel="icon" href="img/favicon.png">
   <script src="node_modules/jquery/dist/jquery.js"></script>
</head>

<body>
   <?php
      session_start();

      if (isset($_SESSION["User_Id"])) {
         header("Location: index.php");
      }
      elseif(!isset($_SESSION["User_Id"])) {
    ?>
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
            <form class="div-form" name="login" method="POST" action="includes/search_login.php">
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
      function StyleErro(input) {
         document.getElementById(input).classList.remove("form-input-correto");
         document.getElementById(input).classList.add("form-input-erro");
      }

      function StyleValid(input) {
         document.getElementById(input).classList.remove("form-input-erro");
         document.getElementById(input).classList.add("form-input-correto");
      }

      function mudarFace() {
         document.getElementById("facebook").innerHTML = "Esquece, não funfa!"
      }

      $(".div-form").submit(function(e) {
         e.preventDefault();

         $.ajax({
            type: "POST",
            url: "includes/search_login.php",
            data: {
               email: login.email.value,
               password: login.password.value,
            },
            success: function(output) {
               console.log(output);
               if (output == "Error") {
                  StyleErro("email");
                  StyleErro("password");
               } else if (output == "Login") {
                  StyleValid("email");
                  StyleValid("password");
                  location.href = "index.php";
               }
            }
         });
      })
   </script>
<?php
   }
?>
</body>
