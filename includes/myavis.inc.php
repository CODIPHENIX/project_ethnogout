<?php
require_once __DIR__ . "/../php/auth.php";
checkAuth();
checkUser();
require_once __DIR__ . "/../includes/header.inc.php";
echo '<script src="./js/deleteAvis.js"></script>';
require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <section class="carnet">
        <h1> Mon Carnet</h1>
        <div class="mv_carnet">

            <ul class="ms_nav_carnet pt1">
                <li><a href="./myavis.php">Mes avis</a></li>
            </ul>

            <div class="dropdown">
                <ul class="dropdown_l ">
                    <li><a href="./myrecette.php">Mes Recette</a></li>
                    <li><a href="./favoris.php">Mes Favoris </a></li>
                    <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                </ul>
            </div>

        </div>


        <ul class="nav_carnet">
            <li ><a href="./myrecette.php">Mes Recette</a></li>
            <li class="divider"></li>
            <li class="active_c"><a href="./myavis.php">Mes avis</a></li>
            <li class="divider"></li>
            <li><a href="./favoris.php">Mes Favoris </a></li>
            <li class="divider"></li>
            <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a>
            </li>
        </ul>

    </section>
    <section class="myrecette">
        <div class="flex_avis">
<?php if (is_array($avisDonners)): ?>

            <?php foreach ($avisDonners as $avis):?>
            <div id="avis-<?php echo intval($avis['idrecette']). '-' . $iduser; ?>">
            <ul class="user_avis">

                <li class="img_avis"><a href="./recette.php?id=<?php echo htmlspecialchars($avis['idrecette'])?>"><img src="<?php echo htmlspecialchars($avis['image_recette'])?>" alt="image recette"></a></li>

                <li class="content_avis">
                    <ul>
                        <li class="title"><?php echo htmlspecialchars($avis['titrerecette'])?></li>
                        <li><div class="stars noteDonner">
                            <?php if ($avis['note']): ?>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class=" fa <?= $i <= round($avis['note']) ? 'star checked fa-star ' : 'fa-star' ?>"></i>
                                <?php endfor; ?>
                            <?php endif; ?>
                            </div>
                        </li>
                        <li class="text"><?php echo htmlspecialchars($avis['contenu'])?></li>
                    </ul>
                </li>
                <li class="crud_avis">
                    <ul class="grid_icon">
              <!--          <li class="iconUsra modifyicon" id="navmodifavis" data-target-url="./recette.php?id=<?php /*echo htmlspecialchars($avis['idrecette'])*/?>"
                            data-button-id="actionModifybtn"
                        ><i class="fa-solid fa-pen-nib"></i></li>-->
                        <li class="iconUsra deleteicon"
                            onclick="deleteAvis(<?php echo htmlspecialchars($avis['idrecette']). ',' . $_SESSION['loginid']; ?>)"><i class="fa-solid fa-trash"></i></li>
                    </ul>
                </li>

            </ul>
            </div>>
             <?php endforeach;?>
<?php else: ?>
    <p><?php echo htmlspecialchars($avisDonners); ?></p>
<?php endif; ?>

        </div>

    </section>


</main>
<?php require_once __DIR__ . "/../includes/footer.inc.php"?>