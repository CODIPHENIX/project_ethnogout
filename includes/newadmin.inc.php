<?php

require_once __DIR__ . "/../php/auth.php";
checkAuth();
checkAdmin();
require_once __DIR__ . "/../includes/header.inc.php";
echo '<script src="./js/user/newadmin.js"></script>';

require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <section class="carnet">
        <h1> Dashboard</h1>
        <div class="mv_carnet">

            <ul class="ms_nav_carnet pt1">
                <li><a href="./newAdmin.php">Nouveau Admin <span><i class="fa-solid fa-square-plus"></i></span></a></li>
            </ul>



            <div class="dropdown">
                <ul class="dropdown_l ">
                    <li><a href="./dashboard.php">Essentail</a></li>
                    <li><a href="./appRecette.php">App Recette</a></li>
                    <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                </ul>
            </div>
        </div>


        <ul class="nav_carnet">
            <li ><a href="./dashboard.php">Essentail</a></li>
            <li class="divider"></li>
            <li ><a href="./appRecette.php">App Recette</a></li>
            <li class="divider"></li>
            <li class="active_c"><a href="./newAdmin.php">Nouveau Admin <span><i class="fa-solid fa-square-plus"></i></span></a></li>
            <li class="divider"></li>
            <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
        </ul>

    </section>
    <section class="signin_f admin_f">

        <form id="newAdminForm" class="signin">
            <div id="generalError" class="error"></div>
            <div class="inputcontrol">
                <label for="nom"></label>
                <input type="text" name="nom" id="nom" placeholder="Nom" >
                <div id="nomerror" class="error"></div>
            </div>

            <div class="inputcontrol">
                <label for="prenom"></label>
                <input type="text" name="prenom" id="prenom" placeholder="Prénom" >
                <div id="prenomerror" class="error"></div>
            </div>

            <div class="inputcontrol">
                <label for="email"></label>
                <input type="text" name="email" id="email" placeholder="E-mail" >
                <div id="emailerror" class="error"></div>
            </div>


            <div class="inputcontrol">
                <label for="pwd"></label>
                <input type="password" name="pwd" id="pwd" placeholder="votre mot de passe" >
                <div id="pwderror" class="error" ></div>
            </div>

            <div class="inputcontrol">
                <label for="c_pwd"></label>
                <input type="password" name="c_pwd" id="c_pwd" placeholder="Confirmer le mot de passe" >
                <div id="c_pwderror" class="error" ></div>
            </div>

            <button type="submit" name="signin" id="signin" class="conn"> AJOUTER</button>


        </form>

        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p id="successMessage"></p>
            </div>
        </div>
    </section>


</main>
<?php
require_once __DIR__ . "/../includes/footer.inc.php";
?>

