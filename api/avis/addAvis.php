<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


require_once __DIR__ . "/../../model/config.php";
require_once __DIR__ . "/../../controller/avisControlleur.php";

use controller\avisControlleur;

$controlAvis= new avisControlleur($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlAvis->addAvis($conn);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => true, 'message' => 'Méthode non autorisée']);
}
