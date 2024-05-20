<?php

namespace controller;

require_once __DIR__."/../model/user.php";

use Model\User;
class usercontroller
{

    public function PostUser($conn)
    {
        $usermanager = new User();

        $response=array();
        $errors = array();

        $nom = htmlspecialchars(strip_tags($_POST['nom']));
        $prenom = htmlspecialchars(strip_tags($_POST['prenom']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $password = $_POST['pwd'];
        $confirm_pwd = $_POST['c_pwd'];
        $signindate= date("y-m-d H:i:s");

        if(empty($nom)||empty($prenom)||empty($password)||empty($confirm_pwd)||empty($email)){
            $errors['fields'] = "Veuillez remplir tous les champs.";
        }  
       
            $pwdregex='/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
            $emailregex = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

            if(!preg_match($emailregex,$email)){
                $errors['email'] = "Veuillez entrer un email valide.";

            }      

            if(!preg_match($pwdregex,$password)){
                $errors['pwd'] = "Le mot de passe doit contenir au moins une lettre (minuscule ou majuscule), un chiffre, un caractère spécial parmi @$!%*?& et avoir une longueur totale d'au moins 8 caractères.";

            }
            else{

                if($password !== $confirm_pwd){
                    $errors['c_pwd'] = "Les mots de passe ne correspondent pas.";
                }

            }

            if (!isset($_POST['termsCheckbox'])) {
                $errors['termsCheckbox'] = "Veuillez accepter les conditions d'utilisation pour continuer.";
            }

            if (!empty($errors)) {
                $response['error'] = true;   
                $response['message'] = $errors;
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
       

        echo json_encode($response);
    }

    public function Postadmin($conn)
    {
        $usermanager = new User();

        $response=array();
        $errors = array();

        $nom = htmlspecialchars(strip_tags($_POST['nom']));
        $prenom = htmlspecialchars(strip_tags($_POST['prenom']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $password = $_POST['pwd'];
        $confirm_pwd = $_POST['c_pwd'];
        $signindate= date("y-m-d H:i:s");

        if(empty($nom)||empty($prenom)||empty($password)||empty($confirm_pwd)||empty($email)){
            $errors['fields'] = "Veuillez remplir tous les champs.";

        }

        $pwdregex='/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        $emailregex = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

        if(!preg_match($emailregex,$email)){
            $errors['email'] = "Veuillez entrer un email valide.";

        }

        if(!preg_match($pwdregex,$password)){
            $errors['pwd'] = "Le mot de passe doit contenir au moins une lettre (minuscule ou majuscule), un chiffre, un caractère spécial parmi @$!%*?& et avoir une longueur totale d'au moins 8 caractères.";

        }
        else{

            if($password !== $confirm_pwd){
                $errors['c_pwd'] = "Les mots de passe ne correspondent pas.";
            }

        }


        if (!empty($errors)) {
            $response['error'] = true;
            $response['message'] = $errors;

        }
        else{
            $postuser = $usermanager->setadmin($conn,$nom,$prenom,$password,$email,$signindate);
            $result = $usermanager->getResponse();

            if($result['error']){
                $response['error']=true;
                $response['message']= $result['message'];

            }else{
                $response['error']=false;
                $response['message']= $result['message'];

            }

        }


        echo json_encode($response);
    }

    public function loginuser($conn)
    {

        session_start();
        $response=array();

        $email = htmlspecialchars(strip_tags($_POST['login']));
        $password = $_POST['l_pwd'];

        if(empty($email)||empty($password))
        {
            $response['error'] = true;
            $response['message'] = ['fields'=>'Veuillez remplir tous les champs.'];
        }
        else
        {
            if(isset($_POST['csrf_token']) && isset($_SESSION['csrf_token'])
                && $_POST['csrf_token'] === $_SESSION['csrf_token'])
            {


                $usermanager = new User();
                $checkuser = $usermanager->userExists($conn,$email);

                if ($checkuser){
                    $user = $checkuser->fetch_assoc();

                    if(password_verify($password, $user['userpwd'])){
                        $response['error']=false;
                        $response['message']="vous étes connecter.";

                        $_SESSION['loginid']=$user['iduser'];
                        $_SESSION['logintype']=$user['roles'];
                        $_SESSION['loggedin']= true;



//                        unset($_SESSION['csrf_token']);

                    }
                    else{
                        $response['error']=true;
                        $response['message']= ['l_pwd'=>'mot de passe erroné.'];

                    }
                }else {
                    $response['error'] = true;
                    $response['message'] = ['login'=>'Utilisateur non trouvé.'];

                }
            } else {
                $response['error'] = true;
                $response['message'] = "Tentative de CSRF détectée.";

            }

        }

        echo json_encode($response);
    }



}