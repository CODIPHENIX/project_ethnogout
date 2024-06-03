<?php


require __DIR__ . "/../model/config.php";
require __DIR__ . "/../model/user.php";
require __DIR__ . "/../controller/usercontroller.php";
require __DIR__ . "/../controller/adminController.php";

use controller\usercontroller;
use controller\adminControlleur;


$Controller = new adminControlleur($conn);
$Controller->showdiffpaysinfo();