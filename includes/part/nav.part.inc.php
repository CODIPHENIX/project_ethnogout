</head>
<body>

<header>
    <Nav class="nav_bar">
        <div class="res_nav">
            <div class="icon_menu icon">
                <i class="fa-solid fa-bars"></i>
            </div>
            <ul class="nav_menu">
                <li class="nav_link"><a href="#">Accueil</a></li>
                <li class="nav_link"><a href="#">Cuisine</a></li>
                <li class="nav_link"><a href="#">Ingredient</a></li>
                <li class="nav_link"><a href="#">Restaurent</a></li>
            </ul>
        </div>


        <ul class="nav">
            <li class="nav_link"><a href="./index.php">Accueil</a></li>
            <li class="nav_link"><a href="./cuisine.php">Cuisine</a></li>
            <li class="nav_link"><a href="./ingredient.php">Ingredient</a></li>
            <li class="nav_link"><a href="./restaurent.php">Restaurent</a></li>
        </ul>
        <div class="logo">
            <a href="./index.php"><img src="./asset/appimg/logo-01.png" alt="ethnogout logo"></a>
        </div>
        <div class="icon search-icon p_searchicon">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div class="ssdiv p_ssdiv">
z            <div class="sdiv">
                <form action="#" method="get" class="search_form sfnav">
                    <input type="search" name="search_bar" id="searchbar" placeholder="Je cherche des recettes...">
                    <div class="icon_s">
                        <i class="fa-solid fa-magnifying-glass " ></i>
                    </div>
                </form>
            </div>
        </div>

        <div class="user_menu">
            <div class="icon user_icon p_usericon">
                <i class="fa-regular fa-user"></i>
            </div>
            <ul class="content">
                <?php if(isset($_SESSION['loginid'])){ ?>
                <?php if($_SESSION['logintype']==='admin'){ ?>
                        <li class="cnt_link passive"><a href="./myrecette.php">Dashboard</a></li>
                    <?php } else{?>
                        <li class="cnt_link passive"><a href="./myrecette.php">Mon Carnet</a></li>
                    <?php }?>

                <li class="cnt_link passive"><a href="">Parametre de Compte</a></li>
                <li class="cnt_link activel"><a href="../php/logout.php">Se Déconnecter</a></li>
                <?php } else{?>
                <li class="cnt_link passive"><a href="./signin.php">S'Inscrire</a></li>
                <li class="cnt_link activel"><a href="./login.php">Se Connecter</a></li>
                <?php }?>
            </ul>
        </div>
    </Nav>
</header>
<div class="searchs_section main_search">
    <form action="#" method="get" class="search_form sfdiv">
        <input type="search" name="search_bar" id="search_bar" placeholder="Je cherche des recettes...">
        <div class="icon_s">
            <i class="fa-solid fa-magnifying-glass " ></i>
        </div>

    </form>
</div>

