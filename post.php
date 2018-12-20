<head>
   <link rel="stylesheet" href="style/post.css">
</head>
<article class="post">
   <?php

   ?>
   <div class="div-account">
      <img class="img-account" src="img/profile.jpg">
      <a class="a-account" href="#">Muhdo</a>
   </div>

   <img class="img-post" src="img/IMG_9892.jpg">
   <p class="data">19 dezembro 2018</p>
   <div class="div-buttons">
      <div class="div-buttons-group">
         <img class="like-button" src="img/like.png">
         <p class="like-quant">2314</p>
      </div>
      <div class="div-buttons-group">
         <img class="comment-button"src="img/comment.png" onclick="comentar()">
         <p class="comment-quant">12</p>
      </div>
   </div>
   <div class="div-place-comment hidden" id="div-comment">
      <form class="form-comment" action="" method="post">
         <textarea class="form-comment" name="commentario" maxlength="255" rows="5" placeholder="Comentário"></textarea>
         <button class="form-button" id="submit" type="submit" name="submit">Enviar</button>
      </form>
   </div>

   <?php

   ?>
   <div class="div-comment">
      <a class="a-comment-account" href="#">Muhdex</a>
      <p class="comment">Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! Que gajo feio! </p>
   </div>
</article>

<script>
   function comentar() {
      document.getElementById("div-comment").classList.toggle("hidden");
   }
</script>
