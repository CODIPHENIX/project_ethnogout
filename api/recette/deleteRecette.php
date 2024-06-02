<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");

require_once __DIR__ . "/../../model/config.php";
require_once __DIR__ . "/../../model/recette.php";

use model\recette;

$recetteModel = new Recette();

$method = $_SERVER['REQUEST_METHOD'];
$idrecette = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($method === 'DELETE' && $idrecette > 0) {
    $response = $recetteModel->deleteRecette($conn,$idrecette);
    echo json_encode($response);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => true, 'message' => 'Méthode non autorisée']);
}

$conn->close();
