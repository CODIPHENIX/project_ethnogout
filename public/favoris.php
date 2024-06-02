<?php

require __DIR__ . "/../model/config.php";
require __DIR__ . "/../model/favoris.php";
require __DIR__ . "/../controller/favoriscontroller.php";

use controller\favorisControlleur;


$Controller = new favorisControlleur($conn);
$Controller->showfavorisUser();