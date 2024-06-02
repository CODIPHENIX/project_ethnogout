<?php
require __DIR__."/../model/config.php";
require __DIR__."/../model/recette.php";
require __DIR__."/../model/avis.php";
require __DIR__."/../controller/avisControlleur.php";

use controller\avisControlleur;


$Controller = new avisControlleur($conn);
$Controller->showUserAvis();

?>
