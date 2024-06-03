<?php


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


require_once __DIR__ . "/../../model/config.php";
require_once __DIR__ . "/../../model/recette.php";

use model\Recette;

$modelRecette = new recette($conn);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $query=isset($_GET['search'])?trim($_GET['search']):'';
    $modelRecette->seachbar($conn,$query);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => true, 'message' => 'Méthode non autorisée']);
}