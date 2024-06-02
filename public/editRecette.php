<?php
require __DIR__ . "/../model/config.php";
require_once __DIR__ . "/../controller/recettecontroller.php";

use controller\RecetteController;

$controlRecette = new RecetteController($conn);

if (isset($_GET['id'])) {
    $recetteId = intval($_GET['id']);
    $controlRecette->showEditRecetteForm($recetteId);
} else {
    echo "ID de recette non spécifié.";
}
