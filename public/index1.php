<?php
require_once __DIR__."/../model/config.php";
require_once __DIR__."/../model/user.php";

use Model\User;

$userManager = new User();

if (isset($_GET['id'])) {
    $userid = $_GET['id'];

    // Appeler la méthode getusrbyID avec l'ID récupéré
    $result = $userManager->getusrbyID($conn, $userid);

    $response = $userManager->getResponse();

    // Traiter le résultat de l'opération
    if ($response['error']) {
        echo json_encode($response['message']);
    } else {
        // Afficher le message de succès ou les données de l'utilisateur
        echo $response['message'];
    }
} else {
    // Gérer le cas où l'ID n'est pas fourni dans $_GET
    echo "L'identifiant de l'utilisateur n'est pas spécifié.";
}