<?php
require_once __DIR__ . "/../includes/header.inc.php";
echo '<script src="./js/signin.js"></script>';
require_once __DIR__ . "/../includes/nav.inc.php";
?>
<main class="connect">
    <section class="signin_f">
        <h1>Inscription</h1>
        <p>Profitez des services réservés aux membres : notez, commentez et sauvegardez vos recettes favorites. </p>
        <form id="signupForm" class="signin">
            <div id="generalError" class="error"></div>
            <div class="inputcontrol">
                <input type="text" name="nom" id="nom" placeholder="Nom" >
                <div id="nomerror" class="error"></div>
            </div>

            <div class="inputcontrol">

                <input type="text" name="prenom" id="prenom" placeholder="Prénom" >
                <div id="prenomerror" class="error"></div>
            </div>

            <div class="inputcontrol">
                <input type="text" name="email" id="email" placeholder="E-mail" >
                <div id="emailerror" class="error"></div>
            </div>


            <div class="inputcontrol">
                <input type="password" name="pwd" id="pwd" placeholder="votre mot de passe" >
                <div id="pwderror" class="error" ></div>
            </div>

            <div class="inputcontrol">
                <input type="password" name="c_pwd" id="c_pwd" placeholder="Confirmer le mot de passe" >
                <div id="c_pwderror" class="error" ></div>
            </div>
            <div class="inputcontrol cb">
                <input type="checkbox" name="termsCheckbox" id="termsCheckbox">
                <div>
                    <span>J'accepte les Conditions <a href="./CGU.php" >Générales d'Utilisation</a></span>
                    <div id="GCUerror" class="error" ></div>
                </div>


            </div>


            <span>J'ai déjà un compte,<a href="./login.php" class="bold">je me connecte.</a></span>



            <button type="submit" name="signin" id="signin" class="conn"> S'INSCRIRE</button>


        </form>

        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p id="successMessage"></p>
            </div>
        </div>
    </section>
</main>