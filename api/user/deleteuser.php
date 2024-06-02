<?php

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");

require_once __DIR__ . "/../../model/config.php";
require_once __DIR__ . "/../../controller/adminController.php";

use controller\adminControlleur;

$adminController = new adminControlleur($conn);


$method = $_SERVER['REQUEST_METHOD'];
$userid = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($method === 'DELETE' && $userid > 0) {
    $response = $adminController->deleteUser($userid);
    echo json_encode($response);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => true, 'message' => 'Méthode non autorisée']);
}

$conn->close();