<?php

namespace controller;

require_once __DIR__."/../model/user.php";

use Model\User;
class usercontroller
{

    public function PostUser()
    {
        $usermanager = new User();

        $response=array();

        $nom = htmlspecialchars(strip_tags($_POST['nom']));
        $prenom = htmlspecialchars(strip_tags($_POST['prenom']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $password = $_POST['pwd'];
        $confirm_pwd = $_POST['c_pwd'];
        $signindate= date("y-m-d H:i:s");

        if(empty($nom)||empty($prenom)||empty($password)||empty($confirm_pwd)||empty($email)){
            $response['errors'][] = "Veuillez remplir tous les champs.";
        }
        else {
            $pwdregex='/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
            $emailregex = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

            if(!preg_match($emailregex,$email)){
                $responsemsg['errors'][] = "Veuillez entrer un email valide.";

            }

            if(!preg_match($pwdregex,$password)){
                $responsemsg['errors'][] = "Le mot de passe doit contenir au moins une lettre (minuscule ou majuscule), un chiffre, un caractère spécial parmi @$!%*?& et avoir une longueur totale d'au moins 8 caractères.";

            }

            if($password !== $confirm_pwd){
                $responsemsg['errors'][] = "Les mots de passe ne correspondent pas.";
            }

            if (isset($responsemsg['errors'])) {
                $response['error'] = true;
                $response['message'] = $responsemsg['errors'];
            }
            else{
                $postuser = $usermanager->setuser($conn,$nom,$prenom,$password,$email,$signindate);
                $result = $usermanager->getResponse();

                if($result['error']){
                    $response['error']=true;
                    $response['message']= $result['message'];
                }else{
                    $response['error']=false;
                    $response['message']= $result['message'];
                }
            }
        }
        echo json_encode($response);
    }
}