<?php


require __DIR__ . "/../model/config.php";
require __DIR__ . "/../model/recette.php";
require __DIR__ . "/../controller/recettecontroller.php";

use controller\RecetteController;


$Controller = new RecetteController($conn);
$Controller->showallRecette();
