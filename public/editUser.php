<?php

require __DIR__ . "/../model/config.php";
require __DIR__ . "/../model/user.php";
require __DIR__ . "/../controller/usercontroller.php";

use controller\usercontroller;


$Controller = new usercontroller($conn);
$Controller->updateUser();
