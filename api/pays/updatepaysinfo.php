<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


require_once __DIR__ . "/../../model/config.php";
require_once __DIR__ . "/../../controller/payscontroller.php";

use controller\paysController;

$controlpays= new paysController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlpays->updateinfopays();

} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => true, 'message' => 'Méthode non autorisée']);
}