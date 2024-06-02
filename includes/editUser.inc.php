<?php
require_once __DIR__ . "/../php/auth.php";
checkAuth();
require_once __DIR__ . "/../includes/header.inc.php";
echo '<script src="./js/user/updateUser.js"></script>';
require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main class="update">
    <section class="signin_f  modifinfo">
        <form id="updateUser" class="signin" enctype="multipart/form-data" method="post" action="../api/user/updateuser.php">
            <div id="generalError" class="error"></div>
            <div class="flex_userinfo">
                <div class="col-1 edit_col">
                    <label for="avatar-user" class="avatar-user" id="avatar-user-preview" >
                        <img src="<?php echo htmlspecialchars($userinfo['avatar']!==null?$userinfo['avatar']: './asset/appimg/defautavatar.png'); ?>" alt="icon image">
                        <span id="change">Changer l'image</span>
                    </label>
                    <input type="file" id="avatar-user" class="display-hidden" accept=".png, .jpg, .jpeg" name="avatar-user">
                </div>
                <div class="col-3">
                    <h2><?php echo htmlspecialchars($userinfo['nomuser'].' '.$userinfo['prenomuser']);?></h2>
                    <div class="role"><p><?php echo $_SESSION['logintype']==='user'?'Membre':'Admin'?></p></div>
                    <div id="imgError" class="error"></div>
                </div>
            </div>

            <div class="inputcontrol">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" placeholder="Nom"
                       value="<?php echo htmlspecialchars($userinfo['nomuser']);?>" >
                <div id="nomerror" class="error"></div>
            </div>

            <div class="inputcontrol">
                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" id="prenom" placeholder="Prénom"
                       value="<?php echo htmlspecialchars($userinfo['prenomuser']);?>" >
                <div id="prenomerror" class="error"></div>
            </div>

            <div class="inputcontrol">
                <label  for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="E-mail"
                       value="<?php echo htmlspecialchars($userinfo['emailuser']);?>" >
                <div id="emailerror" class="error"></div>
            </div>


            <div class="inputcontrol">
                <label  for="pwd">Nouveau Mot de Passe</label>
                <input type="password" name="pwd" id="pwd" placeholder="Nouveau mot de passe" >
                <div id="pwderror" class="error" ></div>
            </div>
            <div class="inputcontrol">
                <label  for="c_Npwd">Confimation du Nouveau Mot de Passe</label>
                <input type="password" name="c_Npwd" id="c_Npwd" placeholder="Confirmer le nouveau mot de passe" >
                <div id="c_Npwderror" class="error" ></div>
            </div>

            <button type="submit" name="signin" id="signin" class="conn">SAUVEGARDER</button>

        </form>

        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p id="successMessage"></p>
            </div>
        </div>
    </section>
</main>
<?php require_once __DIR__ . "/../includes/footer.inc.php"?>
