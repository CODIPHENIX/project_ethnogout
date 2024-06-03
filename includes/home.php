<?php
require_once __DIR__ . "/../includes/header.inc.php";
require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <section class="part">
        <h2>Découverte</h2>
        <div class="grid_d">
            <?php if(is_array($pays)):?>
                <?php foreach($pays as $pay):?>

            <ul class="decouvert">
                <li>
                    <ul class="image_grid" >
                        <li class="d_part"> <a href="./paysinfo.php?id=<?php echo intval($pay['idpays'])?>">
                                <img src="
                        <?php echo htmlspecialchars($pay['imagepays']!==null?$pay['imagepays']:
                                    './asset/appimg/bck_img.jpg'); ?>"
                                     alt="image recette"></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul class="content_grid">
                        <li class="d_part"><h3><?php echo htmlspecialchars($pay['nompays'])?></h3></li>
                        <li class="d_part">
                            <?php
                            echo strlen(htmlspecialchars($pay['description'])) > 100
                                ? substr(htmlspecialchars($pay['description']), 0, 100) . '...<a href="./paysinfo.php?id='.
                                intval($pay['idpays']).'">voir plus</a>'
                                : htmlspecialchars($pay['description']);
                            ?>
                        </li>
                    </ul>
                </li>
            </ul>
                <?php endforeach;?>
            <?php else:?>
                <p><?php echo $pays ?></p>
            <?php endif;?>


        </div>

    </section>
    <section class="part">
        <h2>Recette populaire</h2>
        <div class="grid_d grid_rp">
            <ul class="rp">
                <li class="rp_img">
                    <a href="#" ><img src="./asset/appimg/bck_img.jpg" alt="image recette"></a>
                </li>
                <li class="rp_part"><h3>Titre</h3></li>
                <li class="rp_part">note</li>
            </ul>
            <ul class="rp">

                <li class="rp_img">
                    <a href="#" alt="image recette"></a>
                </li>
                <li class="rp_part"><h3>Titre</h3></li>
                <li class="rp_part">note</li>
            </ul>
            <ul class="rp">

                <li class="rp_img">
                    <a href="#" alt="image recette"></a>
                </li>
                <li class="rp_part"><h3>Titre</h3></li>
                <li class="rp_part">note</li>
            </ul>
            <ul class="rp">

                <li class="rp_img">
                    <a href="#" alt="image recette"></a>
                </li>
                <li class="rp_part"><h3>Titre</h3></li>
                <li class="rp_part">note</li>
            </ul>
            <ul class="rp">

                <li class="rp_img">
                    <a href="#" alt="image recette"></a>
                </li>
                <li class="rp_part"><h3>Titre</h3></li>
                <li class="rp_part">note</li>
            </ul>
            <ul class="rp">

                <li class="rp_img">
                    <a href="#" alt="image recette"></a>
                </li>
                <li class="rp_part"><h3>Titre</h3></li>
                <li class="rp_part">note</li>
            </ul>


        </div>

    </section>
    <section class="part">
        <h2>Recette rapide</h2>
        <div class="grid_d grid_rr">
            <ul class="rr">

                <li class="rr_img">
                    <a href="#" ><img src="#" alt="image recette"></a>
                </li>
                <li class="rr_part"><h3>Titre</h3></li>
            </ul>
            <ul class="rr">

                <li class="rr_img">
                    <a href="#" ><img src="#" alt="image recette"></a>
                </li>
                <li class="rr_part"><h3>Titre</h3></li>
            </ul>
            <ul class="rr">

                <li class="rr_img">
                    <a href="#" ><img src="#" alt="image recette"></a>
                </li>
                <li class="rr_part"><h3>Titre</h3></li>
            </ul>
            <ul class="rr">

                <li class="rr_img">
                    <a href="#" ><img src="#" alt="image recette"></a>
                </li>
                <li class="rr_part"><h3>Titre</h3></li>
            </ul>

        </div>
    </section>
    <section class="part p_iv">
        <h2>Ingrédient vedette</h2>
        <div class="flex_iv">
            <ul class="iv">

                <li class="iv_img">
                    <a href="#" ><img src="#" alt="image recette"></a>
                </li>
                <li class="rr_part iv_part"><h3>Titre</h3></li>
            </ul>
            <ul class="iv">

                <li class="iv_img">
                    <a href="#" ><img src="#" alt="image recette"></a>
                </li>
                <li class="rr_part iv_part"><h3>Titre</h3></li>
            </ul>
            <ul class="iv">

                <li class="iv_img">
                    <a href="#" ><img src="#" alt="image recette"></a>
                </li>
                <li class="rr_part iv_part"><h3>Titre</h3></li>
            </ul>
            <ul class="iv">

                <li class="iv_img">
                    <a href="#" ><img src="#" alt="image recette"></a>
                </li>
                <li class="rr_part iv_part"><h3>Titre</h3></li>
            </ul>
            <ul class="iv">

                <li class="iv_img">
                    <a href="#" ><img src="#" alt="image recette"></a>
                </li>
                <li class="rr_part iv_part"><h3>Titre</h3></li>
            </ul>
            <ul class="iv">

                <li class="iv_img">
                    <a href="#" ><img src="#" alt="image recette"></a>
                </li>
                <li class="rr_part iv_part"><h3>Titre</h3></li>
            </ul>


        </div>
    </section>

    <section class="part">
        <h2>Nouveauté</h2>
        <div class="grid_d grid_rr">
            <?php if(is_array($newrecettes)):?>
            <?php foreach($newrecettes as $new):?>
            <ul class="rr">

                <li class="rr_img N_img">
                    <a href="./recette.php?id=<?php echo intval($new['idrecette'])?>" ><img src="<?php echo htmlspecialchars($new['image_recette'])?>" alt="image recette"></a>
                </li>
                <li class="N_part"><h3><?php echo htmlspecialchars($new['titrerecette'])?></h3></li>
            </ul>
            <?php endforeach;?>
            <?php else:?>
            <p><?php echo $newrecettes ?></p>
            <?php endif;?>

        </div>
    </section>


</main>

<?php

require_once __DIR__ . "/../includes/footer.inc.php"
?>


