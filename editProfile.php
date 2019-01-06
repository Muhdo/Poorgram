<head>
   <link rel="stylesheet" type="text/css" href="style/main.css">
   <link rel="stylesheet" type="text/css" href="style/editProfile.css">
   <link rel="icon" href="img/favicon.png">
   <script src="node_modules/jquery/dist/jquery.js"></script>
   <script src="node_modules/cropperjs/dist/cropper.js"></script>
   <link href="node_modules/cropperjs/dist/cropper.css" rel="stylesheet">
   <script src="node_modules/jquery-cropper/dist/jquery-cropper.js"></script>
</head>

<?php
   session_start();

   if (!isset($_SESSION["User_Id"])) {
      header("Location: index.php");
   }
   elseif(isset($_SESSION["User_Id"])) {

   include("includes/header.php");
?>

<body>
   <main>
      <div class="div-form">
         <h3 class="h3-aviso hidden"> Não foi possivel alterar a Password!<br>Não foram salvas nenhumas alterações.</h3>
         <table class="table-form">
            <tr>
               <td>
                  <h5>Nome:</h5>
               </td>
               <td colspan="2">
                  <input type="text" id="nome" name="nome" value="<?php echo $_SESSION["User_Nome"]; ?>" maxlength="30">
               </td>
            </tr>
            <tr>
               <td>
                  <h5>Nickname:</h5>
               </td>
               <td>
                  <input type="text" id="identificador" name="identificador" value="<?php echo $_SESSION["User_Nickname"]; ?>" maxlength="20">
               </td>
            </tr>
            <tr>
               <td>
                  <h5>Email:</h5>
               </td>
               <td colspan="3">
                  <input type="text" id="email" name="email" value="<?php echo $_SESSION["User_Email"]; ?>" maxlength="255">
               </td>
            </tr>
            <tr>
               <td>
                  <h5>Password Antiga:</h5>
               </td>
               <td>
                  <input type="password" id="oldPassword" name="oldPassword" value="">
               </td>
               <td>
                  <h5>Password Nova:</h5>
               </td>
               <td>
                  <input type="password" id="newPassword" name="newPassword" value="">
               </td>
               <td>
                  <h5>Repetir Password:</h5>
               </td>
               <td>
                  <input type="password" id="repPassword" name="repPassword" value="">
               </td>
            </tr>
            <tr>
               <td>
                  <h5>Imagem Perfil:</h5>
               </td>
               <td>
                  <form class="form-addphoto" action="includes/addpost.php" method="post">
                     <label for="Imagem" class="form-filebutton">Carregar Imagem</label>
                     <input type="file" id="Imagem" name="Imagem" accept="image/png, image/jpeg, image/JPEG, image/jpeg2000, image/jpg, image/gif">
                  </form>
               </td>
            </tr>
            <tr>
               <td>
                  <h5>Descrição:</h5>
               </td>
               <td colspan="5">
                  <textarea id="Descricao" name="Descricao" maxlength="255" rows="4"></textarea>
               </td>
            </tr>
         </table>
         <div class="div-preview hidden">
            <img class="img-preview" id="img-preview">
            <div class="div-buttons">
               <div class="div-buttons-group">
                  <button class="btn-selected" type="button" id="btn-move"><img class="img-button" src="img/arrows.png"></button>
                  <button type="button" id="btn-crop"><img class="img-button" src="img/crop.png"></button>
               </div>
               <div class="div-buttons-group">
                  <button type="button" id="btn-rotLft"><img class="img-button" src="img/rotate-left.png"></button>
                  <button type="button" id="btn-rotRht"><img class="img-button" src="img/rotate-right.png"></button>
               </div>
               <div class="div-buttons-group">
                  <button type="button" id="btn-zoomIn"><img class="img-button" src="img/zoom-in.png"></button>
                  <button type="button" id="btn-zoomOut"><img class="img-button" src="img/zoom-out.png"></button>
               </div>
               <div class="div-buttons-group">
                  <button type="button" id="btn-reset"><img class="img-button" src="img/reset.png"></button>
               </div>
            </div>
         </div>
         <div class="div-buttons">
            <button class="btn-send" type="button" id="btn-submit">Enviar</button>
         </div>
      </div>
   </main>
   <script>
      function StyleErro(input) {
         document.getElementById(input).classList.remove("correto");
         document.getElementById(input).classList.add("erro");
      }

      function StyleValid(input) {
         document.getElementById(input).classList.remove("erro");
         document.getElementById(input).classList.add("correto");
      }

      var Timer;
      var Intervalo = 500;

      $("#nome").on("blur", function() {
         $.ajax({
            type: "POST",
            url: "includes/validations/validarNome.php",
            data: {
               nome: $("#nome").val()
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
                  nome: $("#nome").val()
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
               nickname: $("#identificador").val()
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
                  nickname: $("#identificador").val()
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
               email: $("#email").val()
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
                  email: $("#email").val()
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

      $("#newPassword").on("blur", function() {
         $.ajax({
            type: "POST",
            url: "includes/validations/validarPassword.php",
            data: {
               password: $("#newPassword").val()
            },
            success: function(output) {
               if (output == "Error") {
                  StyleErro("newPassword");
               } else if (output == "Valid") {
                  StyleValid("newPassword");
               }
            }
         });

         $.ajax({
            type: "POST",
            url: "includes/validations/validarRepPassword.php",
            data: {
               password: $("#newPassword").val(),
               repPassword: $("#repPassword").val()
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
                  password: $("#newPassword").val()
               },
               success: function(output) {
                  if (output == "Error") {
                     StyleErro("newPassword");
                  } else if (output == "Valid") {
                     StyleValid("newPassword");
                  }
               }
            });

            $.ajax({
               type: "POST",
               url: "includes/validations/validarRepPassword.php",
               data: {
                  password: $("#newPassword").val(),
                  repPassword: $("#repPassword").val()
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
               password: $("#newPassword").val()
            },
            success: function(output) {
               if (output == "Error") {
                  StyleErro("newPassword");
               } else if (output == "Valid") {
                  StyleValid("newPassword");
               }
            }
         });

         $.ajax({
            type: "POST",
            url: "includes/validations/validarRepPassword.php",
            data: {
               password: $("#newPassword").val(),
               repPassword: $("#repPassword").val()
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
                  password: $("#newPassword").val()
               },
               success: function(output) {
                  if (output == "Error") {
                     StyleErro("newPassword");
                  } else if (output == "Valid") {
                     StyleValid("newPassword");
                  }
               }
            });

            $.ajax({
               type: "POST",
               url: "includes/validations/validarRepPassword.php",
               data: {
                  password: $("#newPassword").val(),
                  repPassword: $("#repPassword").val()
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

      $("#btn-submit").clicl(function(e) {
         $.ajax({
            type: "POST",
            url: "includes/validations/validarNome.php",
            data: {
               nome: $("#nome").val()
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
                        nickname: $("#identificador").val()
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
                                 email: $("#email").val()
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

                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
                                    //ESTA UMA MERDA FILHA DA PUTA CONA DO CARALHO
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

      $(function() {
         var image = $("#img-preview");
         $("input:file").change(function() {
            $(".div-preview").removeClass("hidden");

            var oFReader = new FileReader();

            oFReader.readAsDataURL(this.files[0]);
            oFReader.onload = function (oFREvent) {
               image.cropper("destroy");
               image.attr("src", this.result);
               image.cropper({
                  aspectRatio: 1 / 1,
                  viewMode: 1,
                  toggleDragModeOnDblclick: false,
                  dragMode: "move",
                  crop: function(e) {}
               });
            };
         });

         $("#btn-move").click(function() {
            $("#btn-crop").removeClass("btn-selected");
            $("#btn-move").addClass("btn-selected");
            $("#img-preview").cropper("setDragMode", "move");
         })

         $("#btn-crop").click(function() {
            $("#btn-move").removeClass("btn-selected");
            $("#btn-crop").addClass("btn-selected");
            $("#img-preview").cropper("setDragMode", "crop");
         })

         $("#btn-rotLft").click(function() {
            $("#img-preview").cropper("rotate", -5);
         })

         $("#btn-rotRht").click(function() {
            $("#img-preview").cropper("rotate", 5);
         })

         $("#btn-zoomIn").click(function() {
            $("#img-preview").cropper("zoom", 0.1);
         })

         $("#btn-zoomOut").click(function() {
            $("#img-preview").cropper("zoom", -0.1);
         })

         $("#btn-reset").click(function() {
            $("#img-preview").cropper("reset");
         })
      });

      $("#btn-submit").click(function() {
         var imagem = $("#img-preview").cropper("getCroppedCanvas", {width: 900}).toDataURL("image/jpeg", 0.9);
         $.ajax({
            type: "POST",
            url: "includes/addpost.php",
            data: {
               imageData: imagem
            },
            success: function(output) {
               if (output == "Add") {
                  location.href = "perfil.php";
               } else if (output == "Error") {
                  location.href = "index.php";
               }
            }
         });
      })
   </script>
</body>

<?php
   }
?>
