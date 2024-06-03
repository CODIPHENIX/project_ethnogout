<?php

require __DIR__ . "/../model/config.php";
require_once __DIR__ . "/../controller/payscontroller.php";

use controller\paysController;

$controller = new paysController($conn);

if (isset($_GET['id'])) {
    $idpays = intval($_GET['id']);
    $controller->showEditform($idpays);
} else {
    echo "ID du pays non spécifié.";
}
