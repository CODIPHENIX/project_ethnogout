<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>éthogout</title>
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
<link rel="manifest" href="./favicon/site.webmanifest">
    <!-- favicon end -->

    <!-- css  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">

    
</head>
<body>
    
    <header>
        <Nav class="nav_bar">
            <div class="icon_menu icon">
                <i class="fa-solid fa-bars"></i>
            </div>
            <ul class="nav">
                <li class="nav_link"><a href="#">Accueil</a></li>
                <li class="nav_link"><a href="#">Cuisine</a></li>
                <li class="nav_link"><a href="#">Ingredient</a></li>
                <li class="nav_link"><a href="#">Restaurent</a></li>
            </ul>
            <div class="logo">
                <a href="#"><img src="./asset/appimg/logo-01.png" alt="ethogout logo"></a>
            </div>
            <div class="search-icon icon">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="ssdiv">
                <div class="sdiv">
                    <form action="#" method="get" class="search_form sfnav">
                        <input type="search" name="search_bar" id="searchbar" placeholder="Je cherche des recettes...">
                        <div class="icon_s">
                            <i class="fa-solid fa-magnifying-glass " ></i>
                         </div>
                    </form>
                </div>
            </div>


            <div class="user_icon icon">
                <i class="fa-regular fa-user"></i>
            </div>
        </Nav>
    </header>
    <div class="searchs_section">
        <form action="#" method="get" class="search_form sfdiv">
            <input type="search" name="search_bar" id="search_bar" placeholder="Je cherche des recettes...">
            <div class="icon_s">
                <i class="fa-solid fa-magnifying-glass " ></i>
             </div>
        </form>
    </div>
    <main>
        <section class="signin_f">
            <h1>Inscription</h1>
        <p>Profitez des services réservés aux membres : notez, commentez et sauvegardez vos recettes favorites. </p>
        <form action="../api/user/apiuser.php" method="POST" class="signin">
            <div class="inputcontrol">
                <div class="error"></div>
                <input type="text" name="nom" id="nom" placeholder="Nom" >

            </div>

            <div class="inputcontrol">

                <input type="text" name="prenom" id="prenom" placeholder="Prénom" >
            </div>

            <div class="inputcontrol">
                <input type="text" name="email" id="email" placeholder="E-mail" >
                <div class="error" ></div>
            </div>


            <div class="inputcontrol">
                <input type="password" name="pwd" id="pwd" placeholder="votre mot de passe" >
                <div class="error" ></div>
            </div>

            <div class="inputcontrol">
                <input type="password" name="c_pwd" id="c_pwd" placeholder="Confirmer le mot de passe" >
                <div class="error" ></div>
            </div>
            <div class="inputcontrol cb">
                <input type="checkbox" name="checkbox" id="checkbox" class="checkbox"> <span>J'accepte les Conditions <a href="" >Générales d'Utilisation</a></span>
                <div class="error" ></div>
            </div>
            <span>J'ai déjà un compte,<a href="" class="bold">je me connecte.</a></span>



            <button type="submit" name="signin" id="signin" class="conn">S'INSCRIRE</button>

        </form>
        </section>
    </main>
    <footer>
        <div class="container">
            <div class="arrow">
                <a href="#"><img src="./asset/appimg/logo-02.png" alt="arrow"></a>
            </div>
            <p>Tous droits réservés Bwango Astrid - 2024</p>

        </div>

    </footer>
</body>