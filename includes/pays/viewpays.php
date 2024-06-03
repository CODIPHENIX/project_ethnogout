<?php

require_once __DIR__ . "/../../php/auth.php";
checkAuth();
checkAdmin();
require_once __DIR__ . "/../../includes/header.inc.php";
echo '<script src="./js/user/deleteUser.js"></script>';
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

     <section class="part dashpays">

         <div class="grid_d grid_rp ">
             <?php if(is_array($pays)):?>
                 <?php foreach ($pays as $pay): ?>


             <ul class="rp">
                 <li class="rp_img">
                     <a href="./paysinfo.php?id=<?php echo intval($pay['idpays'])?>" ><img src="
<?php echo htmlspecialchars($pay['imagepays']!==null?$pay['imagepays']: './asset/appimg/bck_img.jpg'); ?>"
                                                                                            alt="image recette"></a>
                 </li>
                 <li class="rp_part"><h3><?php echo htmlspecialchars($pay['nompays'])?></h3></li>
                 <li>
                     <ul class="crud_a modifc">
                         <li class="iconUsra ">
                             <a href="./editpays.php?id=<?php echo intval($pay['idpays'])?>" class="modifyicon">
                                 <i class="fa-solid fa-pen-nib"></i></a>
                         </li>
                         <li class="iconUsra deleteicon" onclick="deleteRecette()"><i class="fa-solid fa-trash"></i></li>
                     </ul>
                 </li>
             </ul>
                 <?php endforeach; ?>
             <?php else: ?>
                 <p><?php echo intval($pay)?></p>
             <?php endif; ?>
             <ul class="rp">


     </section>


    <div id="deleteModal" class="modal">
        <div class="delete_model">
            <div class="flex_dlt">
                <span class="close">&times;</span>
                <div class="grid_dlt">
                    <div class="delete_text"><p id="successMessage">Êtes-vous sûr de vouloir supprimer cette utilisatuer?</p></div>

                    <button id="delete_btn"> Oui</button>

                </div>

            </div>
        </div>



    </div>


</main>
<?php
require_once __DIR__ . "/../../includes/footer.inc.php";
?>
