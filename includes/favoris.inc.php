<?php

require_once __DIR__ . "/../php/auth.php";
checkAuth();
checkUser();
require_once __DIR__ . "/../includes/header.inc.php";
echo '<script src="./js/favoris/togglefav.js"></script>';
require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <section class="carnet">
        <h1> Mon Carnet</h1>
        <div class="mv_carnet">

            <ul class="ms_nav_carnet pt1">
                <li><a href="./favoris.php">Mes Favoris</a></li>
            </ul>

            <div class="dropdown">
                <ul class="dropdown_l ">
                    <li><a href="./myrecette.php">Mes Recette</a></li>
                    <li><a href="./myavis.php">Mes avis </a></li>
                    <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                </ul>
            </div>
        </div>


        <ul class="nav_carnet">
            <li ><a href="./myrecette.php">Mes Recette</a></li>
            <div class="divider"></div>
            <li><a href="./myavis.php">Mes avis</a></li>
            <div class="divider"></div>
            <li class="active_c"><a href="./favoris.php">Mes Favoris </a></li>
            <div class="divider"></div>
            <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
        </ul>

    </section>
    <section class="myrecette">
        <div class="grid_myr">

            <?php if(is_array($fav)):?>
            <?php foreach($fav as $favoris):?>

            <ul class="user_rct">
                <li class="img_myrct"><a href="./recette.php?id=<?php echo intval($favoris['idrecette'])?>">
                        <img src="<?php echo $favoris['image_recette']?>" alt="image recette"></a>
                    <div class="icon_r icon_fav fav_btn"
                         data-iduser="<?php echo $iduser; ?>"
                         data-idrecette="<?php echo intval($favoris['idrecette']); ?>">
                        <i class="fa-<?php echo $favicon; ?> fa-heart"></i></div>
                </li>
                <li class="title"><?php echo $favoris['titrerecette']?></li>
                <li>
                    <div class="stars noteDonner">
                        <?php if (intval($favoris['moyenne_note'])): ?>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class=" fa <?= $i <= round(intval($favoris['moyenne_note'])) ? 'star checked fa-star ' : 'fa-star' ?>"></i>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
            <?php endforeach;?>

            <?php else: ?>
            <p><?php echo htmlspecialchars($fav); ?></p>
            <?php endif; ?>


        </div>

    </section>



</main>
<?php require_once __DIR__ . "/../includes/footer.inc.php"?>

