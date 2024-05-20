<?php

require_once __DIR__ . "/../php/auth.php";
checkAuth();
checkUser();
require_once __DIR__ . "/../includes/header.inc.php";
require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <section class="carnet">
        <h1> Mon Carnet</h1>
        <div class="mv_carnet">

            <ul class="ms_nav_carnet pt1">
                <li><a href="./myrecette.php">Mes Recette <span>0</span></a></li>
            </ul>

            <div class="dropdown">
                <ul class="dropdown_l ">
                    <li><a href="./myavis.php">Mes avis <span>0</span></a></li>
                    <li><a href="./favoris.php">Mes Favoris <span>0</span></a></li>
                    <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
                </ul>
            </div>
        </div>


        <ul class="nav_carnet">
            <li class="active_c"><a href="./myrecette.php">Mes Recette <span>0</span></a></li>
            <li class="divider"></li>
            <li><a href="./myavis.php">Mes avis <span>0</span></a></li>
            <li class="divider"></li>
            <li ><a href="./favoris.php">Mes Favoris <span>0</span></a></li>
            <li class="divider"></li>
            <li><a href="./newRecette.php">Creer une recette <span><i class="fa-solid fa-square-plus"></i></span></a></li>
        </ul>

    </section>
    <section class="myrecette">
        <div class="grid_myr">

            <ul class="user_rct">
                <li class="img_myrct"><a href="" ><img src="" alt="image recette"></a></li>
                <li class="title">Titre</li>
                <li>note</li>
                <li>
                    <ul class="crud_a">
                        <li class="iconUsra modifyicon"><i class="fa-solid fa-pen-nib"></i></li>
                        <li class="iconUsra deleteicon"><i class="fa-solid fa-trash"></i></li>
                    </ul>
                </li>

            </ul>
            <ul class="user_rct">
                <li class="img_myrct"><a href="" ><img src="" alt="image recette"></a></li>
                <li class="title">Titre</li>
                <li>note</li>
                <li>
                    <ul class="crud_a">
                        <li class="iconUsra modifyicon"><i class="fa-solid fa-pen-nib"></i></li>
                        <li class="iconUsra deleteicon"><i class="fa-solid fa-trash"></i></li>
                    </ul>
                </li>

            </ul>
            <ul class="user_rct">
                <li class="img_myrct"><a href="" ><img src="" alt="image recette"></a></li>
                <li class="title">Titre</li>
                <li>note</li>
                <li>
                    <ul class="crud_a">
                        <li class="iconUsra modifyicon"><i class="fa-solid fa-pen-nib"></i></li>
                        <li class="iconUsra deleteicon"><i class="fa-solid fa-trash"></i></li>
                    </ul>
                </li>

            </ul>
            <ul class="user_rct">
                <li class="img_myrct"><a href="" ><img src="" alt="image recette"></a></li>
                <li class="title">Titre</li>
                <li>note</li>
                <li>
                    <ul class="crud_a">
                        <li class="iconUsra modifyicon"><i class="fa-solid fa-pen-nib"></i></li>
                        <li class="iconUsra deleteicon"><i class="fa-solid fa-trash"></i></li>
                    </ul>
                </li>

            </ul>

        </div>

    </section>



</main>
