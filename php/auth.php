<?php
// auth.php
session_start();

function checkAuth() {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: login.php');
        exit;
    }
}

function checkAdmin() {
    if (!isset($_SESSION['logintype']) || $_SESSION['logintype'] !== 'admin') {
        header('Location: no_access.php');
        exit;
    }
}

function checkUser() {
    if (!isset($_SESSION['logintype']) || $_SESSION['logintype'] !== 'user') {
        header('Location: no_access.php');
        exit;
    }
}

