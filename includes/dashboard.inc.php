<?php

require_once __DIR__ . "/../php/auth.php";
checkAuth();
checkAdmin();
require_once __DIR__ . "/../includes/header.inc.php";

require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <section class="carnet">
        <h1> Dashboard</h1>
        <div class="mv_carnet">

            <ul class="ms_nav_carnet pt1">
                <li><a href="./dashboard.php">Essentail</a></li>
            </ul>

            <div class="dropdown">
                <ul class="dropdown_l ">
                    <li><a href="./appRecette.php">App Recette</a></li>
                    <li><a href="./newAdmin.php">Nouveau Admin <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                    <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                </ul>
            </div>
        </div>


        <ul class="nav_carnet">
            <li class="active_c"><a href="./dashboard.php">Essentail</a></li>
            <li class="divider"></li>
            <li><a href="./appRecette.php">App Recette</a></li>
            <li class="divider"></li>
            <li ><a href="./newAdmin.php">Nouveau Admin <span><i class="fa-solid fa-square-plus"></i></span></a></li>
            <li class="divider"></li>
            <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
        </ul>

    </section>
    <section class="dashboard">
        <div class="grid_dash">
            <div class="utilisateur">
                <div class="heading">
                    <h3>UTILISATEUR</h3>
                </div>
                <div class="grid_content">
                    <div class="numdash">
                        <a href="./tableUser.php"><h3><?php echo $numUser?></h3></a>
                    </div>
                    <div class="subdash">
                        <div><a href="./tableadmin.php"><p><b><?php echo $numAdmin?></b>Admin</p></a></div>
                        <div><a href="./tablemembre.php"><p><b><?php echo $numUserM?></b>membre</p></a></div>
                    </div>

                </div>

            </div>

            <div class="utilisateur">
                <div class="heading">
                    <h3>RECETTES</h3>
                </div>
                <div class="grid_content">
                    <div class="numdash">
                        <a href="./allrecette.php"><h3><?php echo $numRecette?></h3></a>
                    </div>
                    <div class="subdash">
                        <div><a href="./recettewithavis.php"><p><b><?php echo $numRWA?></b>Avis</p></a></div>
                        <div><a href="./recetteinfav.php"><p><b><?php echo $numRWF?></b>Favoris</p></a></div>
                    </div>

                </div>

            </div>
            <div class="utilisateur">
                <div class="heading dv">
                    <h3>RUBRIQUE DÉCOUVERTE</h3>
                </div>
                <div class="grid_content">
                    <div class="numdash">
                        <a href="./pays.php"><h3>AFRIQUE</h3></a>
                    </div>

                </div>

            </div>

        </div>


    </section>




    </div>


</main>
<?php
require_once __DIR__ . "/../includes/footer.inc.php";
?>
