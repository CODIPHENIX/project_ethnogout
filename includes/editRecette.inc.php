<?php
require_once __DIR__."/../php/auth.php";
checkAuth();
require_once __DIR__ ."/../includes/header.inc.php";
echo '<script src="./js/autocomplitenewrecette.js"></script>';
echo '<script src="./js/onclickstep.js"></script>';
echo '<script src="./js/updateRecette.js"></script>';
require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <section class="carnet">
        <h1> Mon Carnet</h1>
        <div class="mv_carnet">

            <ul class="ms_nav_carnet pt1">
                <li class="titlesp">Modifier la Recette</li>
            </ul>
        </div>
        <ul class="nav_carnet">
            <li class="active_c moremodif"><span>Modifier la Recette</span></li>
        </ul>


    </section>
    <section class="newRecette">
        <form class="formRecette" id="formRecette" enctype="multipart/form-data">
            <input type="hidden" name="idrecette" value="<?php echo htmlspecialchars($responseRecettes['idrecette']); ?>">
            <div id="generalError" class="error"></div>
            <label for="name_recette" >Nom de la recette
            </label>
            <input type="text" name="name_recette" id="name_recette" value="<?php echo htmlspecialchars($responseRecettes['titrerecette'])?>">
            <div id="titreRecetteError" class="error"></div>

            <div class="grid_container">
                <div class="col-1">
                    <label for="img_recette" class="img_recette" id="img_recette-preview" >
                        <img src="<?php echo htmlspecialchars($responseRecettes['image_recette'] ?: './asset/appimg/defautimage.png'); ?>" alt="icon image">
                        <span>Changer l'image<span>
                    </label>
                    <div id="imgError" class="error"></div>
                    <input type="file" id="img_recette" class="display-hidden" accept=".png, .jpg, .jpeg" name="img_recette">
                </div>
                <div class="col-2">
                    <div class="div_tmp">

                        <label for="tmp_prepa">Temps de préparation</label>
                        <div class="div_time">
                            <input type="number" id="tmp_prepa" name="tmp_prepa_hour" class="time tmp_prepa" max="24"
                                   value="<?php echo sprintf('%02d',floor($responseRecettes['temp_prepa'] / 60)); ?>" placeholder="00" ">
                            <span>h</span>
                            <input type="number" class="time" name="tmp_prepa_Mins" max="59"
                                   value="<?php echo sprintf('%02d',floor($responseRecettes['temp_prepa'] % 60)); ?>" placeholder="00" >
                        </div>

                    </div>
                    <div id="prepaError" class="error"></div>

                    <div class="div_tmp">
                        <label for="tmp_cuisson">Temps de cuisson</label>
                        <div class="div_time">
                            <input type="number" id="tmp_cuisson" name="tmp_cuisson_hour" class="time tmp_prepa" max="24"
                                   value="<?php echo sprintf('%02d',floor($responseRecettes['cook_temp'] / 60)); ?>" placeholder="00" ">

                            <span>h</span>
                            <input type="number" class="time" name="tmp_cuisson_Mins" max="59"
                                   value="<?php echo sprintf('%02d',floor($responseRecettes['cook_temp'] % 60)); ?>" placeholder="00" >

                        </div>
                    </div>
                    <div id="cookError" class="error"></div>
                    <div class="div_difficulty">
                        <label for="difficulty">Difficulter</label>
                        <div class="selectContainer">
                            <select id="difficulty" name="difficulty" class="selectbox">
                                <option value="">Non renseigné</option>
                                <?php foreach ($difficulties as $difficulty): ?>
                                    <option value="<?php echo htmlspecialchars($difficulty); ?>"
                                        <?php echo $responseRecettes['difficulter'] == $difficulty ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($difficulty); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="iconselect">
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>

                    </div>
                    <div id="difError" class="error"></div>
                    <div class="div_pays">
                        <label for="pays">Origin du plat:</label>
                        <div class="selectContainer">

                            <select class="select" id="pays" name="pays" class="selectbox selectPay">
                                <option value="">Non renseigné</option>
                                <?php foreach ($pays as $pay): ?>
                                    <option value="<?php echo htmlspecialchars($pay); ?>"
                                        <?php echo $paysRecette['nompays'] == $pay ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($pay); ?></option>
                                <?php endforeach; ?>
                            </select>

                            <div class="iconselect iconsp">
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>

                    </div>
                    <div id="paysError" class="error"></div>
                </div>
            </div>

            <div class="div_ingredients">
                <p>Ingredients:</p>

                <div  class="composant">

                    <div id="ingredientContainer">
                        <?php foreach ($compositions as $index => $composition): ?>
                        <div class="ingredientGroup">
                            <div class="f1-elem">
                                <div class="elem">
                                    <label for="quantity-<?php echo $index; ?>">Quantité</label>
                                    <input type="number" id="quantity-<?php echo $index; ?>" name="quantity[]"
                                           step="0.01" min="0" value="<?php echo htmlspecialchars($composition['quantity'])==0 ?'':htmlspecialchars($composition['quantity']); ?>">
                                </div>
                                <div class="elem">
                                    <label for="unit-<?php echo $index; ?>">Mesure</label>
                                    <input type="text" id="unit-<?php echo $index; ?>" name="unit[]"
                                           value="<?php echo htmlspecialchars($composition['unit']); ?>">
                                </div>
                            </div>
                            <div class="f2-elem">

                                <div class="elem">
                                    <label for="ingredient-<?php echo $index; ?>">Ingredient</label>
                                    <input type="text" id="ingredient-<?php echo $index; ?>" class="ingredient" name="ingredient[]"
                                           value="<?php echo htmlspecialchars($composition['nom_ingredients']); ?>">
                                </div>
                                <button type="button" class="remove"><i class="fa-solid fa-xmark"></i></button>
                            </div>

                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div id="ingredientError" class="error"></div>


                    <button type="button" id="addIngredient" class="buttonplusadd"><span class="iconplus"><i class="fa-solid fa-plus"></i></span> Ajouter un ingredient</button>
                </div>

            </div>

            <div class="div_etapeprepa">
                <p> Etapa preparation</p>
                <div id="stepContainer">
                    <?php foreach ($stepRecette as $index => $step): ?>
                        <div class="stepGroup">
                            <div class="selfstep">
                                <div><label for="step-<?php echo $index + 1; ?>"><?php echo intval($step['num_prepa']); ?></label></div>
                                <input type="number" name="stepnumber[]" id="stepnumber-<?php echo $index + 1; ?>" class="display-hidden" value="<?php echo $index + 1; ?>">
                                <textarea id="step-<?php echo $index + 1; ?>" name="etapeprepa[]" class="steptext" rows="4"><?php echo htmlspecialchars($step['description_etape']); ?></textarea>
                            </div>
                            <button type="button" class="remove"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div id="stepError" class="error"></div>
                <button type="button" id="addStep" class="buttonplusadd"><span class="iconplus"><i class="fa-solid fa-plus"></i></span> Ajouter une étape</button>

            </div>
            <button type="submit" Class="publish">MODIFIE LA RECETTE</button>


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

require_once __DIR__ . "/../includes/footer.inc.php"
?>
