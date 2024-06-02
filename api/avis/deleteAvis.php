<?php

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");

require_once __DIR__ . "/../../model/config.php";
require_once __DIR__ . "/../../model/avis.php";

use model\avis;



if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = file_get_contents("php://input");

    $data = json_decode($input, true);

    $idRecette = isset($data['idRecette']) ? intval($data['idRecette']) : 0;
    $idUser = isset($data['idUser']) ? intval($data['idUser']) : 0;

    if ($idRecette && $idUser) {
        $avisModel = new Avis();
        $response = $avisModel->deleteAvis($conn, $idRecette, $idUser);
        $response = ['error' => false, 'message' => 'L\'avis a bien étez supprimer.'];
    } else {
        $response['error'] = true;
        $response['message'] = 'ID de la recette ou de l\'utilisateur manquant.';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Méthode non autorisée.';
}

echo json_encode($response);
