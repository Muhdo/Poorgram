<head>
   <link rel="stylesheet" type="text/css" href="style/reglog.css">
   <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
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

      <?php
         $nome = "";
         $nickname = "";
         $email = "";
         $password = "";
         $repPassword = "";

         if (isset($_SESSION["regForm"])) {
            $form = $_SESSION["regForm"];

            $nome = $form["nome"];
            $nickname = $form["nickname"];
            $email = $form["email"];
            $password = $form["password"];
            $repPassword = $form["repPassword"];
         }

         session_unset();
         session_destroy();
      ?>

      <div class="div-direita">
         <div class="div-conteudo">
            <form class="div-form" name="registar" method="POST" action="includes/action_registar.php">
               <button class="button-facebook" id="facebook" type="button" onClick="MudarFace()">Login com Facebook</button>
               <div class="tooltip">
                  <input class="form-input" id="nome" type="text" name="nome" value="<?php echo $nome; ?>" size="30" placeholder="Nome Ex: Jossefino Andrade" required>
                  <span class="tooltiptext">Nome Próprio<br>Até 30 caracteres.</span>
               </div>
               <div class="tooltip">
                  <input class="form-input" id="identificador" type="text" name="nickname" value="<?php echo $nickname; ?>" size="20" placeholder="Nickname Ex: __xXJosefino420Xx__" required>
                  <span class="tooltiptext">Nome de Utilizador que te identifiques.<br>Tem de ser unico.<br>Mais de 4 caracteres.<br>Até 20 caracteres.</span>
               </div>
               <div class="tooltip">
                  <input class="form-input" id="email" type="email" name="email" value="<?php echo $email; ?>" size="255" placeholder="Email Ex: JossefinoAndrade420@gamaile.come" required>
                  <span class="tooltiptext">Email válido para login.<br>Tem de ser unico.</span>
               </div>
               <div class="tooltip">
                  <input class="form-input" id="password" type="password" name="password" value="<?php echo $password; ?>" size="255" placeholder="Palavra-Passe Ex: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                  <span class="tooltiptext">Mais de 8 caracteres.<br>Conter letras maiusculas.<br>Conter letras minusculas.<br>Conter numeros.<br>Conter caracteres especiais.</span>
               </div>
               <div class="tooltip">
                  <input class="form-input" id="repPassword" type="password" name="repPassword" value="<?php echo $repPassword; ?>" size="255" placeholder="Repetir Palavra-Passe Ex: &#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                  <span class="tooltiptext">Tem de ser igual á palavra-passe.</span>
               </div>
               <button class="form-button" id="submit" type="submit" name="submit">Registar</button>
               <a href="login.php">Login</a>
            </form>
            <div class="div-erros">
               <p class="hidden" id="erro-nickname">O nickname já está registado.</p>
               <p class="hidden" id="erro-email">O email já está registado.</p>
            </div>
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

      function MudarFace() {
         document.getElementById("facebook").innerHTML = "Esquece, não funfa!";
      }

      var Timer;
      var Intervalo = 500;

      $("#nome").on("blur", function() {
         $.ajax({
            type: "POST",
            url: "includes/validations/validarNome.php",
            data: {
               nome: registar.nome.value
            },
            success: function(output) {
               if (output == "Error") {
                  StyleErro("nome");
               } else if (output == "Valid") {
                  StyleValid("nome");
               }
            }
         });
      });
      $("#nome").on("keyup", function() {
         clearTimeout(Timer);
         Timer = setTimeout(function() {
            $.ajax({
               type: "POST",
               url: "includes/validations/validarNome.php",
               data: {
                  nome: registar.nome.value
               },
               success: function(output) {
                  if (output == "Error") {
                     StyleErro("nome");
                  } else if (output == "Valid") {
                     StyleValid("nome");
                  }
               }
            });
         }, Intervalo);
      });
      $("#nome").on("keydown", function() {
         clearTimeout(Timer);
      });

      $("#identificador").on("blur", function() {
         $.ajax({
            type: "POST",
            url: "includes/validations/validarNickname.php",
            data: {
               nickname: registar.nickname.value
            },
            success: function(output) {
               if (output == "Error") {
                  StyleErro("identificador");
                  $("#erro-nickname").addClass("hidden");
               } else if (output == "Duplication") {
                  StyleErro("identificador");
                  $("#erro-nickname").removeClass("hidden");
               } else if (output == "Valid") {
                  StyleValid("identificador");
                  $("#erro-nickname").addClass("hidden");
               }
            }
         });
      });
      $("#identificador").on("keyup", function() {
         clearTimeout(Timer);
         Timer = setTimeout(function() {
            $.ajax({
               type: "POST",
               url: "includes/validations/validarNickname.php",
               data: {
                  nickname: registar.nickname.value
               },
               success: function(output) {
                  if (output == "Error") {
                     StyleErro("identificador");
                     $("#erro-nickname").addClass("hidden");
                  } else if (output == "Duplication") {
                     StyleErro("identificador");
                     $("#erro-nickname").removeClass("hidden");
                  } else if (output == "Valid") {
                     StyleValid("identificador");
                     $("#erro-nickname").addClass("hidden");
                  }
               }
            });
         }, Intervalo);
      });
      $("#identificador").on("keydown", function() {
         clearTimeout(Timer);
      });

      $("#email").on("blur", function() {
         $.ajax({
            type: "POST",
            url: "includes/validations/validarEmail.php",
            data: {
               email: registar.email.value
            },
            success: function(output) {
               if (output == "Error") {
                  StyleErro("email");
                  $("#erro-email").addClass("hidden");
               } else if (output == "Duplication") {
                  StyleErro("email");
                  $("#erro-email").removeClass("hidden");
               } else if (output == "Valid") {
                  StyleValid("email");
                  $("#erro-email").addClass("hidden");
               }
            }
         });
      });
      $("#email").on("keyup", function() {
         clearTimeout(Timer);
         Timer = setTimeout(function() {
            $.ajax({
               type: "POST",
               url: "includes/validations/validarEmail.php",
               data: {
                  email: registar.email.value
               },
               success: function(output) {
                  if (output == "Error") {
                     StyleErro("email");
                     $("#erro-email").addClass("hidden");
                  } else if (output == "Duplication") {
                     StyleErro("email");
                     $("#erro-email").removeClass("hidden");
                  } else if (output == "Valid") {
                     StyleValid("email");
                     $("#erro-email").addClass("hidden");
                  }
               }
            });
         }, Intervalo);
      });
      $("#email").on("keydown", function() {
         clearTimeout(Timer);
      });

      $("#password").on("blur", function() {
         $.ajax({
            type: "POST",
            url: "includes/validations/validarPassword.php",
            data: {
               password: registar.password.value
            },
            success: function(output) {
               if (output == "Error") {
                  StyleErro("password");
               } else if (output == "Valid") {
                  StyleValid("password");
               }
            }
         });

         $.ajax({
            type: "POST",
            url: "includes/validations/validarRepPassword.php",
            data: {
               password: registar.password.value,
               repPassword: registar.repPassword.value
            },
            success: function(output) {
               if (output == "Error") {
                  StyleErro("repPassword");
               } else if (output == "Valid") {
                  StyleValid("repPassword");
               }
            }
         });
      });
      $("#password").on("keyup", function() {
         clearTimeout(Timer);
         Timer = setTimeout(function() {
            $.ajax({
               type: "POST",
               url: "includes/validations/validarPassword.php",
               data: {
                  password: registar.password.value
               },
               success: function(output) {
                  if (output == "Error") {
                     StyleErro("password");
                  } else if (output == "Valid") {
                     StyleValid("password");
                  }
               }
            });

            $.ajax({
               type: "POST",
               url: "includes/validations/validarRepPassword.php",
               data: {
                  password: registar.password.value,
                  repPassword: registar.repPassword.value
               },
               success: function(output) {
                  if (output == "Error") {
                     StyleErro("repPassword");
                  } else if (output == "Valid") {
                     StyleValid("repPassword");
                  }
               }
            });
         }, Intervalo);
      });
      $("#password").on("keydown", function() {
         clearTimeout(Timer);
      });

      $("#repPassword").on("blur", function() {
         $.ajax({
            type: "POST",
            url: "includes/validations/validarPassword.php",
            data: {
               password: registar.password.value
            },
            success: function(output) {
               if (output == "Error") {
                  StyleErro("password");
               } else if (output == "Valid") {
                  StyleValid("password");
               }
            }
         });

         $.ajax({
            type: "POST",
            url: "includes/validations/validarRepPassword.php",
            data: {
               password: registar.password.value,
               repPassword: registar.repPassword.value
            },
            success: function(output) {
               if (output == "Error") {
                  StyleErro("repPassword");
               } else if (output == "Valid") {
                  StyleValid("repPassword");
               }
            }
         });
      });
      $("#repPassword").on("keyup", function() {
         clearTimeout(Timer);
         Timer = setTimeout(function() {
            $.ajax({
               type: "POST",
               url: "includes/validations/validarPassword.php",
               data: {
                  password: registar.password.value
               },
               success: function(output) {
                  if (output == "Error") {
                     StyleErro("password");
                  } else if (output == "Valid") {
                     StyleValid("password");
                  }
               }
            });

            $.ajax({
               type: "POST",
               url: "includes/validations/validarRepPassword.php",
               data: {
                  password: registar.password.value,
                  repPassword: registar.repPassword.value
               },
               success: function(output) {
                  if (output == "Error") {
                     StyleErro("repPassword");
                  } else if (output == "Valid") {
                     StyleValid("repPassword");
                  }
               }
            });
         }, Intervalo);
      });
      $("#repPassword").on("keydown", function() {
         clearTimeout(Timer);
      });


      $(".div-form").submit(function(e) {
         e.preventDefault();
         $.ajax({
            type: "POST",
            url: "includes/validations/validarNome.php",
            data: {
               nome: registar.nome.value
            },
            success: function(output) {
               if (output == "Error") {
                  StyleErro("nome");
               } else if (output == "Valid") {
                  StyleValid("nome");

                  $.ajax({
                     type: "POST",
                     url: "includes/validations/validarNickname.php",
                     data: {
                        nickname: registar.nickname.value
                     },
                     success: function(output) {
                        if (output == "Error") {
                           StyleErro("identificador");
                           $("#erro-nickname").addClass("hidden");
                        } else if (output == "Duplication") {
                           StyleErro("identificador");
                           $("#erro-nickname").removeClass("hidden");
                        } else if (output == "Valid") {
                           StyleValid("identificador");
                           $("#erro-nickname").addClass("hidden");

                           $.ajax({
                              type: "POST",
                              url: "includes/validations/validarEmail.php",
                              data: {
                                 email: registar.email.value
                              },
                              success: function(output) {
                                 if (output == "Error") {
                                    StyleErro("email");
                                    $("#erro-email").addClass("hidden");
                                 } else if (output == "Duplication") {
                                    StyleErro("email");
                                    $("#erro-email").removeClass("hidden");
                                 } else if (output == "Valid") {
                                    StyleValid("email");
                                    $("#erro-email").addClass("hidden");

                                    $.ajax({
                                       type: "POST",
                                       url: "includes/validations/validarPassword.php",
                                       data: {
                                          password: registar.password.value
                                       },
                                       success: function(output) {
                                          if (output == "Error") {
                                             StyleErro("password");
                                          } else if (output == "Valid") {
                                             StyleValid("password");

                                             $.ajax({
                                                type: "POST",
                                                url: "includes/validations/validarRepPassword.php",
                                                data: {
                                                   password: registar.password.value,
                                                   repPassword: registar.repPassword.value
                                                },
                                                success: function(output) {
                                                   if (output == "Error") {
                                                      StyleErro("repPassword");
                                                   } else if (output == "Valid") {
                                                      StyleValid("repPassword");

                                                      $.ajax({
                                                         type: "POST",
                                                         url: "includes/action_registar.php",
                                                         data: {
                                                            nome: registar.nome.value,
                                                            nickname: registar.nickname.value,
                                                            email: registar.email.value,
                                                            password: registar.password.value,
                                                            repPassword: registar.repPassword.value
                                                         },
                                                         success: function(output) {
                                                            if (output == "ErrorName") {
                                                               StyleErro("nome");
                                                            } else if (output == "ErrorNickname") {
                                                               StyleErro("identificador");
                                                            } else if (output == "DuplicationNickname") {
                                                               StyleErro("identificador");
                                                               $("#erro-nickname").removeClass("hidden");
                                                            } else if (output == "ErrorEmail") {
                                                               StyleErro("email");
                                                            } else if (output == "DuplicationEmail") {
                                                               StyleErro("email");
                                                               $("#erro-email").removeClass("hidden");
                                                            } else if (output == "ErrorPassword") {
                                                               StyleErro("password");
                                                            } else if (output == "ErrorRepPassword") {
                                                               StyleErro("repPassword");
                                                            } else if (output == "ErrorRegistar") {
                                                               location.href = "index.php";
                                                            } else if (output == "Login") {
                                                               location.href = "index.php";
                                                            }
                                                         }
                                                      });
                                                   }
                                                }
                                             });
                                          }
                                       }
                                    });
                                 }
                              }
                           });
                        }
                     }
                  });
               }
            }
         });
      })
   </script>
<?php
   }
?>
</body>
