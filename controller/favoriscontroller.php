<?php

namespace controller;

use Model\favoris;

require_once __DIR__ . "/../model/recette.php";
require_once __DIR__ . "/../model/pays.php";
require_once __DIR__ . "/../model/ingredient.php";
require_once __DIR__ . "/../model/user.php";
require_once __DIR__ . "/../model/avis.php";
require_once __DIR__ . "/../model/favoris.php";

class favorisControlleur
{
    public $response;
    public $favorisModel;

    public function __construct($conn)
    {
        $this->response = array();
        $this->favorisModel = new favoris();
        $this->conn = $conn;
    }



    public function showfavorisUser()
    {
        session_start();
        $iduser = $_SESSION['loginid'];
        $userFav = $this->favorisModel->getfavuser($this->conn, $iduser);
        $resultUserfav = json_decode($userFav, true);

        if ($resultUserfav['error'] === false) {
            $fav = $resultUserfav['message'];
        } else {
            $fav = $resultUserfav['message'];
        }
            if(is_array($fav)):
            foreach($fav as $favoris):
                $isFavorite = $this->favorisModel->isfav($this->conn, $iduser, $favoris['idrecette']);
                $favClass = $isFavorite ? 'favorite' : '';
                $favicon = $isFavorite ? 'solid' : 'regular';
            endforeach;
            endif;

        include "../includes/favoris.inc.php";

    }
}
