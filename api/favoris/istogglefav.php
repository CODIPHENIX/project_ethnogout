<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


require_once __DIR__ . "/../../model/config.php";
require_once __DIR__ . "/../../model/favoris.php";

use model\favoris;

$modelFavoris= new favoris();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $iduser = isset($_POST['iduser']) ? $_POST['iduser'] : null;
    $idrecette = isset($_POST['idrecette']) ? $_POST['idrecette'] : null;

   if($iduser&&$idrecette){
       $isfav=$modelFavoris->isfav($conn,$iduser,$idrecette);
       if($isfav){
           $deletefav=$modelFavoris->deletefav($conn,$iduser,$idrecette);
           if($deletefav){
               $response=['error' => false,
                          'message' => 'Favori supprimé avec succès.',
                          'action' => 'removed'];
           }else{
               $response=['error' => true,
                          'message' => 'Une erreur s\'est produite lors de la suppression du favori.'];
           }

       }else{
           $addfav = $modelFavoris->addfavoris($conn,$iduser,$idrecette);
           if($addfav){
               $response=['error' => false, 'message' => 'Favori ajouté avec succès.',
                          'action' => 'added'];
           }else{
               error_log($addfav);
               $response=['error' => true, 'message' => 'Une erreur s\'est produite lors de l\'ajout du favori.'];
           }
       }
   }else{
       $response=['error' => true, 'message' => 'Une erreur s\'est produite lors de l\'ajout du favori.'];
   }

   echo json_encode($response);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => true, 'message' => 'Méthode non autorisée']);
}
