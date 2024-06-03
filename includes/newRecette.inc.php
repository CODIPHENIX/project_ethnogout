<?php
session_start();
require_once __DIR__."/../php/auth.php";
checkAuth();
require_once __DIR__ ."/../includes/header.inc.php";
echo '<script src="./js/autocomplitenewrecette.js"></script>';
echo '<script src="./js/onclickstep.js"></script>';
echo '<script src="./js/newRecette.js"></script>';
require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <?php if($_SESSION['logintype']==='user'){?>
    <section class="carnet">
        <h1> Mon Carnet</h1>
        <div class="mv_carnet">

            <ul class="ms_nav_carnet pt1">
                <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
            </ul>

            <div class="dropdown">
                <ul class="dropdown_l ">
                    <li><a href="./myrecette.php">Mes Recette </a></li>
                    <li><a href="./myavis.php">Mes avis </a></li>
                    <li><a href="./favoris.php">Mes Favoris </a></li>
                </ul>
            </div>

        </div>


        <ul class="nav_carnet">
            <li ><a href="./myrecette.php">Mes Recette </a></li>
            <li class="divider"></li>
            <li><a href="./myavis.php">Mes avis </a></li>
            <li class="divider"></li>
            <li ><a href="./favoris.php">Mes Favoris </a></li>
            <li class="divider"></li>
            <li class="active_c"><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
        </ul>

    </section>
    <?php }else{ ?>
        <section class="carnet">
            <h1> Dashboard</h1>
            <div class="mv_carnet">

                <ul class="ms_nav_carnet pt1">
                    <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                </ul>

                <div class="dropdown">
                    <ul class="dropdown_l ">
                        <li><a href="./dashboard.php">Essentail</a></li>
                        <li><a href="./appRecette.php">App Recette</a></li>
                        <li><a href="./favoris.php">Nouveau Admin <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                    </ul>
                </div>

            </div>


            <ul class="nav_carnet">
                <li ><a href="./dashboard.php">Essentail</a></li>
                <li class="divider"></li>
                <li><a href="./myavis.php">App Recette</a></li>
                <li class="divider"></li>
                <li ><a href="./appRecette.php">Nouveau Admin <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                <li class="divider"></li>
                <li class="active_c"><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
            </ul>

        </section>
    <?php } ?>
    <section class="newRecette">
        <form class="formRecette" id="formRecette" enctype="multipart/form-data" method="post" action="../api/recette/postRecette.php">
            <div id="generalError" class="error"></div>
            <label for="name_recette" >Nom de la recette
            </label>
            <input type="text" name="name_recette" id="name_recette">
            <div id="titreRecetteError" class="error"></div>



            <div class="grid_container">
                <div class="col-1">
                    <label for="img_recette" class="img_recette" id="img_recette-preview" >
                        <img src="./asset/appimg/defautimage.png" alt="icon image">
                        <span>Inserer une image<span>
                    </label>
                    <div id="imgError" class="error"></div>
                    <input type="file" id="img_recette" class="display-hidden" accept=".png, .jpg, .jpeg" name="img_recette">
                </div>
                <div class="col-2">
                    <div class="div_tmp">

                        <label for="tmp_prepa">Temps de préparation</label>
                        <div class="div_time">
                            <input type="number" id="tmp_prepa" name="tmp_prepa_hour" class="time tmp_prepa" max="24" placeholder="00">
                            <span>h</span>
                            <input type="number" class="time" name="tmp_prepa_Mins" max="59" placeholder="00">
                        </div>

                    </div>
                    <div id="prepaError" class="error"></div>

                    <div class="div_tmp">
                        <label for="tmp_cuisson">Temps de cuisson</label>
                        <div class="div_time">
                            <input type="number" id="tmp_cuisson" name="tmp_cuisson_hour" class="time tmp_prepa" max="24" placeholder="00">
                            <span>h</span>
                            <input type="number" class="time" name="tmp_cuisson_Mins" max="59" placeholder="00">
                        </div>
                    </div>
                    <div id="cookError" class="error"></div>
                    <div class="div_difficulty">
                        <label for="difficulty">Difficulter</label>
                        <div class="selectContainer">
                            <select id="difficulty" name="difficulty" class="selectbox">
                                <option value="">Non renseigné</option>
                                <?php foreach ($difficulties as $difficulty): ?>
                                    <option value="<?php echo htmlspecialchars($difficulty); ?>"><?php echo htmlspecialchars($difficulty); ?></option>
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
                                    <option value="<?php echo htmlspecialchars($pay); ?>"><?php echo htmlspecialchars($pay); ?></option>
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
                        <div class="ingredientGroup">
                            <div class="f1-elem">
                                <div class="elem">
                                    <label for="quantity-1">Quantité</label>
                                    <input type="number" id="quantity-1"  name="quantity[]" step="0.01" min="0">
                                </div>
                                <div class="elem">
                                    <label for="unit-1">Mesure</label>
                                    <input type="text" id="unit-1" name="unit[]" >
                                </div>
                            </div>
                            <div class="f2-elem">

                                <div class="elem">
                                    <label for="ingredient-1">Ingredient</label>
                                    <input type="text" id="ingredient-1" class="ingredient" name="ingredient[]">
                                </div>
                                <button type="button" class="remove"><i class="fa-solid fa-xmark"></i></button>
                            </div>

                        </div>
                    </div>
                    <div id="ingredientError" class="error"></div>


                    <button type="button" id="addIngredient" class="buttonplusadd"><span class="iconplus"><i class="fa-solid fa-plus"></i></span> Ajouter un ingredient</button>
                </div>

            </div>

            <div class="div_etapeprepa">
                <p> Etapa preparation</p>
                <div id="stepContainer">
                    <div class="stepGroup">
                        <div class="selfstep">
                            <div><label for="stet-1">1</label></div>
                            <input type="number" name="stepnumber[]" id="stepnumber-1" class="display-hidden" value="1">
                            <textarea id="stet-1" name="etapeprepa[]" class="steptext" rows="4"></textarea>
                        </div>

                        <button type="button" class="remove"><i class="fa-solid fa-xmark"></i></button>

                    </div>

                </div>
                <div id="stepError" class="error"></div>
                <button type="button" id="addStep" class="buttonplusadd"><span class="iconplus"><i class="fa-solid fa-plus"></i></span> Ajouter une étape</button>

            </div>
            <button type="submit" Class="publish">PUBLIER LA RECETTE</button>


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
