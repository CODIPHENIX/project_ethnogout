<?php

require_once __DIR__ . "/../php/auth.php";
checkAuth();
checkAdmin();
require_once __DIR__ . "/../includes/header.inc.php";
echo '<script src="./js/deleteRecette.js"></script>';

require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <section class="carnet">
        <h1> Dashboard</h1>
        <div class="mv_carnet">

            <ul class="ms_nav_carnet pt1">
                <li><a href="./appRecette.php">App Recette</a></li>
            </ul>


            <div class="dropdown">
                <ul class="dropdown_l ">
                    <li><a href="./dashboard.php">Essentail</a></li>
                    <li><a href="./newAdmin.php">Nouveau Admin <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                    <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                </ul>
            </div>
        </div>


        <ul class="nav_carnet">
            <li ><a href="./dashboard.php">Essentail</a></li>
            <li class="divider"></li>
            <li class="active_c"><a href="./appRecette.php">App Recette</a></li>
            <li class="divider"></li>
            <li ><a href="./newAdmin.php">Nouveau Admin <span><i class="fa-solid fa-square-plus"></i></span></a></li>
            <li class="divider"></li>
            <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
        </ul>

    </section>
    <section class="myrecette">
        <div class="grid_myr">
            <?php if(is_array($myrecette)):?>
                <?php foreach ($myrecette as $recette): ?>
                    <ul class="user_rct">
                        <li class="img_myrct">
                            <a href="./recette.php?id=<?php echo htmlspecialchars($recette['idrecette']); ?>" >
                                <img src="<?php echo htmlspecialchars($recette['image_recette']); ?>" alt="image recette">
                            </a>
                        </li>
                        <li class="title"><?php echo htmlspecialchars($recette['titrerecette']); ?></li>
                        <li>
                            <div class="stars noteDonner">
                                <?php if (intval($recette['moyenne_note'])): ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class=" fa <?= $i <= round(intval($recette['moyenne_note'])) ? 'star checked fa-star ' : 'fa-star' ?>"></i>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </div>
                        </li>
                        <li>
                            <ul class="crud_a">
                                <li class="iconUsra ">
                                    <a href="editRecette.php?id=<?php echo htmlspecialchars($recette['idrecette']); ?>" class="modifyicon">
                                        <i class="fa-solid fa-pen-nib"></i></a>
                                </li>
                                <li class="iconUsra deleteicon" onclick="deleteRecette(<?php echo htmlspecialchars($recette['idrecette']); ?>)"><i class="fa-solid fa-trash"></i></li>
                            </ul>
                        </li>
                    </ul>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune recette ajouté de recettes.</p>
            <?php endif; ?>
        </div>

    </section>
    <div id="deleteModal" class="modal">
        <div class="delete_model">
            <div class="flex_dlt">
            <span class="close">&times;</span>
                <div class="grid_dlt">
            <div class="delete_text"><p id="successMessage">Êtes-vous sûr de vouloir supprimer cette recette ?</p></div>

            <button id="delete_btn"> Oui</button>

                </div>

            </div>
        </div>



    </div>


</main>
<?php
require_once __DIR__ . "/../includes/footer.inc.php";
?>
