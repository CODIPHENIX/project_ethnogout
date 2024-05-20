<?php
namespace controller;
class token
{
    static function session()
    {


        # Générer un jeton CSRF
        $token = bin2hex(random_bytes(32));
        # Stocker le jeton dans la session
        # Cross-Site Request Forgery (CSRF)
        $_SESSION['csrf_token'] = $token;


    }
}