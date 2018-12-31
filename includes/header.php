<head>
  <link rel="stylesheet" type="text/css" href="style/header.css">
</head>
<body>
   <header>
      <nav>
         <ul class="nav-list">
               <li class="nav-list-item">
                  <a href="index.php">
                     <img class="nav-logo" src="img/logo.png">
                  </a>
               </li>
               <li class="nav-list-center">
                  <form action="pesquisa.php" method="get">
                     <input class="search-box" type="text" name="pesquisa" placeholder="Pesquisar">
                     <input type="submit" hidden>
                  </form>
               </li>
               <li class="nav-list-item">
                  <a href="perfil.php?<?php echo $_SESSION["User_Nickname"]; ?>">
                     <img class="nav-icon" src="img/profile.png">
                  </a>
                  <a href="includes/logout.php">
                     <img class="nav-icon" src="img/logout.png">
                  </a>
               </li>
         </ul>
      </nav>
   </header>
</body>
