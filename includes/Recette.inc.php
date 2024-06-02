<?php
require_once __DIR__."/../php/auth.php";
isLoggedIn();


require_once __DIR__ . "/../includes/header.inc.php";
echo "<script src='./js/actionModifcomment.js'></script>";
echo '<script src="./js/deleteAvis.js"></script>';
echo '<script src="./js/favoris/togglefav.js"></script>';

require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <section class="t_rct">
        <h1>
            <?php echo htmlspecialchars($responseRecettes['titrerecette'])?>
        </h1>
        <div class="note">
            <div class="stars noteDonner">
                <?php if ($moyenneNote): ?>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class=" fa <?= $i <= round($moyenneNote) ? 'star checked fa-star ' : 'fa-star' ?>"></i>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
            <div class="avis"> <?php echo intval($nombre)?> avis</div>
        </div>
        <div class="img_rct">
            <img src="<?php echo htmlspecialchars($responseRecettes['image_recette'])?>" alt="image recette">
        </div>
        <ul class="info_rct">
            <li>
                <div class="icon_r"><i class="fi fi-rr-alarm-clock"></i></div>
                <div><?php echo htmlspecialchars($responseRecettes['difficulter'])?></div>
            </li>
            <li>
                <div class="icon_r"><i class="fi fi-rs-hat-chef"></i></div>
                <div><?php echo htmlspecialchars($Temptolal)<60? htmlspecialchars($Temptolal).'min'
                        : floor(htmlspecialchars($Temptolal)%60).'h'. sprintf('%02d',floor(htmlspecialchars($Temptolal)/60));?></div>

            </li>
            <li>
                <div class="icon_r icon_fav <?php echo $favClass; ?>"
                     data-iduser="<?php echo $iduser; ?>"
                     data-idrecette="<?php echo $recetteId; ?>">
                    <i class="fa-<?php echo $favicon; ?> fa-heart"></i>
                </div>
            </li>


        </ul>
        <div class="s_ing">
            <h3>Ingredient</h3>

            <ul class="ingredient">
                <?php foreach ($compositions as $index => $composition): ?>
                <li><?php echo htmlspecialchars($composition['nom_ingredients'])?><?php
                    echo htmlspecialchars($composition['quantity'])==0? '':': '.htmlspecialchars($composition['quantity']); ?> <?php echo htmlspecialchars($composition['unit'])?> </li>
                <?php endforeach;?>
            </ul>

        </div>

        <ul class="time_r">
            <li><h3>Origin du plat:</h3></li>
            <li><?php echo htmlspecialchars($paysRecette['nompays'])?></li>

        </ul>

        <ul class="time_r">
            <li><h3>Preparation:</h3></li>
            <li>Preparation<span><?php echo htmlspecialchars($responseRecettes['temp_prepa'])<60? htmlspecialchars($responseRecettes['temp_prepa']).'min'
                        : floor(htmlspecialchars($responseRecettes['temp_prepa'])%60).'h'. sprintf('%02d',floor(htmlspecialchars($responseRecettes['temp_prepa'])/60));?></span></li>
            <li>Cuisson<span><?php echo htmlspecialchars($responseRecettes['cook_temp'])<60? htmlspecialchars($responseRecettes['cook_temp']).'min'
                        : floor(htmlspecialchars($responseRecettes['cook_temp'])%60).'h'. sprintf('%02d',floor(htmlspecialchars($responseRecettes['cook_temp'])/60));?></span></li>
        </ul>

        <ul class="etape_r">
            <?php foreach ($stepRecette as $index => $step): ?>

            <li><h3><?php echo htmlspecialchars($step['num_prepa'])?></h3></li>
            <li><?php echo htmlspecialchars($step['description_etape'])?></li>
            <?php endforeach;?>
    </ul>
    </section>
    <section class="b_rct">
        <div class="part1">
            <div class="usr_cmt">

                <?php $isLoggedIn = isLoggedIn(); ?>
                <form id="commentForm" >
                    <label for="comment">
                        <h3>Commentaire</h3>
                    </label>

                    <input type="hidden" name="idRecette" value="<?php echo intval($responseRecettes['idrecette'])?>">
                    <textarea id="comment" name="comment" class="comment" rows="3"></textarea>
                    <div id="commentError" class="error"></div>
                    <div id="ratingGeneralError" class="error"></div>
                    <div class="rating-group" id="star-rating">
                        <input type="radio" name="rating" id="rating-1" value="1">
                        <label for="rating-1" class="star fa fa-star" data-value="1"></label>

                        <input type="radio" name="rating" id="rating-2" value="2">
                        <label for="rating-2" class="star fa fa-star" data-value="2"></label>

                        <input type="radio" name="rating" id="rating-3" value="3">
                        <label for="rating-3" class="star fa fa-star" data-value="3"></label>

                        <input type="radio" name="rating" id="rating-4" value="4">
                        <label for="rating-4" class="star fa fa-star" data-value="4"></label>

                        <input type="radio" name="rating" id="rating-5" value="5">
                        <label for="rating-5" class="star fa fa-star" data-value="5"></label>
                    </div>


                    <button type="submit" id="sent_cmt" class="<?php echo $isLoggedIn ? '' : 'disabled'; ?>"
                        <?php echo $isLoggedIn ? '' : 'disabled'; ?>>envoyer</button>
                </form>
            </div>
            <div class="usr_cmt">
                <?php if (is_array($comments)): ?>
                <?php foreach ($comments as $index => $commentaire): ?>

                <div class="avis_usrs">
                    <div id="avis-<?php echo intval($responseRecettes['idrecette']). '-' . htmlspecialchars($commentaire['iduser']); ?>">

                    <div class="avatar_user">
                        <div class="avatar_img">
                            <img src="<?php echo htmlspecialchars($commentaire['avatar']!==null? ($commentaire['avatar']): './asset/appimg/defautavatar.png');?>" alt="avatar" ></div>
                        <div class="commentCrud">

                            <div><?php echo htmlspecialchars($commentaire['nomuser'])?></div>
                            <div class="actionCmt">
                            <button class=" <?php echo htmlspecialchars($iduser===$commentaire['iduser']?'iconcomment':'disabled')?>" id="actionModifybtn"
                                    <?php echo htmlspecialchars($iduser===$commentaire['iduser']?'':'disabled')?>><i class="fa-solid fa-ellipsis"></i>
                            </button>
                                <div class="actionCmtbtn">
                                    <button class="modifCmt">Modifier</button>
                                    <button class="deleteCmt" onclick="deleteAvis(<?php echo intval($responseRecettes['idrecette']). ',' . $_SESSION['loginid']; ?>)">Supprimer</button>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="comment_user">
                        <div class="avisUser" >
                            <div><p><?php echo htmlspecialchars($commentaire['contenu'])?></p></div>
                            <div class="stars noteDonner">
                                <?php if ($commentaire['note']): ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class=" fa <?= $i <= round($commentaire['note']) ? 'star checked fa-star ' : 'fa-star' ?>"></i>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if($iduser===$commentaire['iduser']){?>
                        <form class="modifForm" method="post" id="test" action="../api/avis/updateAvis.php">
                            <label for="modifcomment">
                            </label>

                            <input type="hidden" name="idRecette" value="<?php echo intval($responseRecettes['idrecette'])?>">
                            <textarea class="modifcomment" name="modifcomment" class="comment" rows="3"><?php echo htmlspecialchars($commentaire['contenu'])?></textarea>
                            <div id="comment2Error" class="error"></div>
                            <div id="ratingGeneral2Error" class="error"></div>
                            <div class="rating-group" id="star-rating">
                                <input type="radio" name="ratingmod" id="ratingmod-1" value="1">
                                <label for="ratingmod-1" class="star fa fa-star" data-value="1"></label>

                                <input type="radio" name="ratingmod" id="ratingmod-2" value="2">
                                <label for="ratingmod-2" class="star fa fa-star" data-value="2"></label>

                                <input type="radio" name="ratingmod" id="ratingmod-3" value="3">
                                <label for="ratingmod-3" class="star fa fa-star" data-value="3"></label>

                                <input type="radio" name="ratingmod" id="ratingmod-4" value="4">
                                <label for="ratingmod-4" class="star fa fa-star" data-value="4"></label>

                                <input type="radio" name="ratingmod" id="ratingmod-5" value="5">
                                <label for="ratingmod-5" class="star fa fa-star" data-value="5"></label>
                            </div>

                            <div class="btnmodifcmt">
                            <button type="submit" id="validerMod" class="btnStlye">Valider</button>
                            <button type="button" class="btnStlye annuler">Annuler</button>
                            </div>
                        </form>
                    <?php };?>
                    </div>

</div>
                </div>
                <?php endforeach;?>

    <?php else: ?>
        <p><?php echo htmlspecialchars($comments); ?></p>
    <?php endif; ?>
            </div>

            <div class="s_rct_smr">
                <h3>
                    Recette similaires
                </h3>
                <div class="grid grid_rs">
                    <ul class="item ctnt_rs">
                        <li class="img_p "><img src="" alt="image recette"></li>
                        <li class="title">Title</li>
                    </ul>
                    <ul class="item ctnt_rs">
                        <li class="img_p "><img src="" alt="image recette"></li>
                        <li class="title">Title</li>
                    </ul>
                    <ul class="item ctnt_rs">
                        <li class="img_p "><img src="" alt="image recette"></li>
                        <li class="title">Title</li>
                    </ul>
                </div>

            </div>

        </div>
        <div class="part2">
            <h3>
                Restaurent a proximiter
            </h3>
            <div class="grid rest_p">
                <ul class="item ctnt_rp">
                    <li class="img_p "><img src="" alt="image recette"></li>
                    <li class="title">Title</li>
                    <li>address</li>
                </ul>
                <ul class="item ctnt_rp">
                    <li class="img_p "><img src="" alt="image recette"></li>
                    <li class="title">Title</li>
                    <li>address</li>
                </ul>
                <ul class="item ctnt_rp">
                    <li class="img_p "><img src="" alt="image recette"></li>
                    <li class="title">Title</li>
                    <li>address</li>
                </ul>
            </div>

        </div>

    </section>
    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="successMessage"></p>
        </div>
    </div>

</main>
<?php

require_once __DIR__ . "/../includes/footer.inc.php";
?>

