<?php
require_once __DIR__ . "/../includes/header.inc.php";
echo '<script src="./js/login.js"></script>';
require_once __DIR__ . "/../includes/nav.inc.php";
?>


<main class="connect">
    <section class="signin_f">
        <h1>Se Connecter</h1>
        <p>Nous sommes heureux de vous revoir !</p>
        <form id="loginForm" class="signin">
            <div id="generalError" class="error"></div>
            <div class="inputcontrol">
                <input type="text" name="login" id="login" placeholder="E-mail" >
                <div id="loginerror" class="error" ></div>
            </div>

            <div class="inputcontrol">
                <input type="password" name="l_pwd" id="l_pwd" placeholder="votre mot de passe" >
                <div id="l_pwderror" class="error" ></div>
            </div>

            <input type="hidden" name="csrf_token" value="<?= $token; ?>">

            <span>Je n'ai pas de compte,<a href="./signin.php" class="bold"> je m'inscris.</a></span>

            <button type="submit" name="connect" id="connect" class="conn">Connexion</button>

        </form>

        <div id="successModal" class="modal">
            <div class="modal-content">
                <p id="successMessage">vous est connecter</p>
                <span class="close">&times;</span>

            </div>
        </div>
    </section>
</main>

