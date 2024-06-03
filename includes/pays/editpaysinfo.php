<?php

require_once __DIR__ . "/../../php/auth.php";
checkAuth();
checkAdmin();
require_once __DIR__ . "/../../includes/header.inc.php";
echo '<script src="./js/pays/updatepaysinfo.js"></script>';
require_once __DIR__ . "/../../includes/part/nav.part.inc.php";
?>
<main>
    <section class="carnet">
        <h1> Dashboard</h1>
        <div class="mv_carnet">

            <ul class="ms_nav_carnet pt1">
                <li><a href="./dashboard.php"><i class="fa-solid fa-angles-left"></i> Essentail</a></li>
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

    <section class="newRecette">
        <form class="formRecette" id="formeditpays" enctype="multipart/form-data">



            <input type="hidden" id="idpays" class="display-hidden" name="idpays" value="<?php echo intval($infopays['idpays']); ?>">
            <div class="grid_container modifp">
                <div class="col-1 edit_col editpays">
                    <label for="img_pays" class="img_pays" id="img_pays-preview">
                        <img src="<?php echo htmlspecialchars($infopays['imagepays'] ?: './asset/appimg/defautimage.png'); ?>" alt="icon image">
                        <span>Changer l'image<span>
                    </label>
                    <input type="file" id="img_pays" class="display-hidden" accept=".png, .jpg, .jpeg" name="img_pays">
                </div>
                <div class="col-2 payscol">
                    <h2><?php echo htmlspecialchars($infopays['nompays']); ?></h2>
                    <input type="hidden" id="nompays" name="nompays" class="display-hidden" value="<?php echo htmlspecialchars($infopays['nompays']); ?>">

                    <div class="despays">
                        <div><label for="description">Description</label></div>
                        <textarea id="description" name="description" class="steptext" rows="10"><?php echo htmlspecialchars($infopays['description']); ?></textarea>
                    </div>
                    <div id="DescriptioneError" class="error"></div>
                    <div id="imgError" class="error"></div>
                </div>
            </div>
            <div id="generalError" class="error"></div>
            <button type="submit" Class="publish">MODIFIE</button>


        </form>
    </section>

    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="successMessage"></p>
        </div>
    </div>
</main>
<?php
require_once __DIR__ . "/../../includes/footer.inc.php";
?>
