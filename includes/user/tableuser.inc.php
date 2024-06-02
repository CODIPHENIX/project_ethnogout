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
    <section class="table">
            <table class="content_usertable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>NOM</th>
                    <th>PRENOM</th>
                    <th>EMAIL</th>
                    <th>DATE D'INCRIPTION</th>
                    <th>RECETTE</th>
                    <th>Suprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($users)):?>
                <?php foreach($users as $user):?>
                <tr class="
                <?php echo intval($user['iduser'])===$adminid?'active_row':''?>" id="user-<?php echo intval($user['iduser']); ?>">
                    <td><?php echo intval($user['iduser']);?></td>
                    <td><?php echo htmlspecialchars($user['nomuser']);?></td>
                    <td><?php echo htmlspecialchars($user['prenomuser']);?></td>
                    <td><?php echo htmlspecialchars($user['emailuser']);?></td>
                    <td><?php echo $user['date_inscription'];?></td>
                    <td><?php echo $user['nombre_recettes'];?></td>
                    <td><button class="iconUsra  <?php echo intval($user['iduser'])===$adminid?'disabled':'deleteicon'?>" onclick="deleteuser(<?php echo intval($user['iduser']); ?>)"
                        <?php echo intval($user['iduser'])===$adminid?'disabled':''?>><i class="fa-solid fa-trash"></i></button></td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <p><?php echo $user;?></p>
                <?php endif;?>

                </tbody>

            </table>


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
