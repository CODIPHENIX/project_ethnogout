<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


require_once __DIR__ . "/../../model/config.php";
require_once __DIR__ . "/../../model/ingredient.php";

use model\ingredient;

$modelingredient = new ingredient();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $response = $modelingredient->getallingrients($conn);
    echo json_encode($response['message']);

} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => true, 'message' => 'Méthode non autorisée']);
}