<?php
session_start();

require_once __DIR__ . "/../controller/token.php";

use controller\token;

token::session();
$token=$_SESSION['csrf_token'];

?>
