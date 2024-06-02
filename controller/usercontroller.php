<?php

namespace controller;

require_once __DIR__."/../model/user.php";

use Model\User;
class usercontroller
{

    private $usermanager;
    private $response;

    public function __construct($conn) {
        $this->usermanager = new User();
        $this->response = array();
        $this->conn = $conn;
    }

    public function PostUser()
    {


        $errors = array();

        $nom = ucwords(trim(htmlspecialchars($_POST['nom'])));
        $prenom = ucwords(trim(htmlspecialchars($_POST['prenom'])));
        $email = mb_strtolower(trim(htmlspecialchars($_POST['email'])));
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
                $this->response['error'] = true;
                $this->response['message'] = $errors;
            }
            else{
                $this->usermanager->setuser($this->conn,$nom,$prenom,$password,$email,$signindate);
                $result = $this->usermanager->getResponse();

                if($result['error']){
                    $this->response['error']=true;
                    $this->response['message']= $result['message'];
                }else{
                    $this->response['error']=false;
                    $this->response['message']= $result['message'];
                }
            
            }
       

        echo json_encode($this->response);
    }

    public function Postadmin()
    {



        $errors = array();

        $nom = ucwords(trim(htmlspecialchars($_POST['nom'])));
        $prenom = ucwords(trim(htmlspecialchars($_POST['prenom'])));
        $email = mb_strtolower(trim(htmlspecialchars($_POST['email'])));
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
            $this->response['error'] = true;
            $this->response['message'] = $errors;

        }
        else{
            $this->usermanager->setadmin($this->conn,$nom,$prenom,$password,$email,$signindate);
            $result = $this->usermanager->getResponse();

            if($result['error']){
                $this->response['error']=true;
                $this->response['message']= $result['message'];

            }else{
                $this->response['error']=false;
                $this->response['message']= $result['message'];

            }

        }


        echo json_encode($this->response);
    }

    public function loginuser()
    {

        session_start();
        $response=array();

        $email = mb_strtolower(trim(htmlspecialchars($_POST['login'])));
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



                $checkuser = $this->usermanager->userExists($this->conn,$email);

                if ($checkuser){
                    $user = $checkuser->fetch_assoc();

                    if(password_verify($password, $user['userpwd'])){
                        $response['error']=false;
                        $response['message']="vous étes connecter.";

                        $_SESSION['loginid']=$user['iduser'];
                        $_SESSION['logintype']=$user['roles'];
                        $_SESSION['username']=$user['prenomuser'];
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
   public function updatepostUser()
    {
        session_start();
        $errors = array();
        if (isset($_SESSION['loginid'])) {
            $userid = $_SESSION['loginid'];
        } else {
            $errors['login'] = 'Utilisateur non connecté';
        }
        $responseUser = $this->usermanager->getusrbyID($this->conn, $userid);
        $resultUR=json_decode($responseUser, true);
        if($resultUR['error']===false){
            $userinfo=$resultUR['message'];
        }else{
            $errors['fields'] = "Une erreur c'est produit";
        }
        $oldpassword=$userinfo['userpwd'];

        $nom = isset($_POST['nom'])?ucwords(trim(htmlspecialchars($_POST['nom']))):'';
        $prenom = isset($_POST['nom'])?ucwords(trim(htmlspecialchars($_POST['prenom']))):'';
        $email = isset($_POST['nom'])?mb_strtolower(trim(htmlspecialchars($_POST['email']))):'';
        $newpassword = isset($_POST['pwd'])?$_POST['pwd']:'';
        $confirm_Npwd = isset($_POST['c_Npwd'])?$_POST['c_Npwd']:'';
        $modifdate= date("y-m-d H:i:s");
        $image=isset($_FILES['avatar-user']) ? $_FILES['avatar-user'] : null;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $uploadDir = '../../public/asset/avatareupload/';
        $downloadDir='./asset/avatareupload/';
        $uploadFile = $uploadDir . basename(isset($image['name']) ? $image['name'] : '');
        $imageFileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
        $imageName = $downloadDir .  $email . '.' . $imageFileType;
        $imageNameupload = $uploadDir . $email . '.' . $imageFileType;

        if(empty($nom)){
            $errors['nom'] = "*Obligatoire.";
        }
        if(empty($prenom)){
            $errors['prenom'] = "*Obligatoire.";
        }
        if(empty($email)){
            $errors['email'] = "*Obligatoire.";
        }


        $pwdregex='/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        $emailregex = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

        if(!preg_match($emailregex,$email)){
            $errors['email'] = "Veuillez entrer un email valide.";
        }
        if(empty($newpassword)){
            $hashed_password=$oldpassword;

        }else{
            if(password_verify($newpassword, $userinfo['userpwd'])){
                $errors['pwd'] = "Il n'est pas possible d'avoir un mot de passe identique à l'ancien.";
            }

            if(empty($confirm_Npwd)){
                $errors['c_Npwd'] = "Veuillez remplir ce champs.";
            }
            if(!preg_match($pwdregex,$newpassword)){
                $errors['pwd'] = "Le mot de passe doit contenir au moins une lettre (minuscule ou majuscule), un chiffre, un caractère spécial parmi @$!%*?& et avoir une longueur totale d'au moins 8 caractères.";
            }
            else{

                if($newpassword !== $confirm_Npwd){
                    $errors['c_Npwd'] = "Les mots de passe ne correspondent pas.";
                }

            }
            $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
        }


        if (!empty($errors)) {
            $this->response['error'] = true;
            $this->response['message'] = $errors;
        }
        else{


            if ($image['error'] === UPLOAD_ERR_NO_FILE) {
                $defaultImage = isset($userinfo['avatar']) ? $userinfo['avatar'] : "./asset/appimg/defautavatar.png";
                $imageName = $defaultImage;
            } else{

                if (in_array($image['type'], $allowedTypes) && $image['size'] <= 2 * 1024 * 1024) {
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    if (move_uploaded_file($image['tmp_name'], $imageNameupload)) {
                        $this->response['error']=false;
                    } else {
                        $errors['image_recette']=['Erreur lors du téléchargement de l\'image.'];
                    }
                } else {
                    $errors['image_recette']='Image invalide. Assurez-vous que l\'image est au format JPG, JPEG, ou PNG et qu\'elle est inférieure à 2MB.';
                }
            }

            if(empty($errors)){
                $this->usermanager->updateuser($this->conn,$nom,$prenom,$email,$hashed_password,$imageName,$modifdate,$userid);
                $result = $this->usermanager->getResponse();

                if($result['error']){
                    $this->response['error']=true;
                    $this->response['message']= $result['message'];
                }else{
                    $this->response['error']=false;
                    $this->response['message']= $result['message'];
                }
            }else{
                $this->response['error'] = true;
                $this->response['message'] = $errors;
            }

        }


        echo json_encode($this->response);
    }

    public function updateUser()
    {
        session_start();
        $iduser=$_SESSION['loginid'];
        $userResponse=$this->usermanager->getusrbyID($this->conn,$iduser);
        $resultUR=json_decode($userResponse, true);
        if($resultUR['error']===false){
        $userinfo=$resultUR['message'];
        include '../includes/editUser.inc.php';
        }else{
            echo $resultUR['message'];
        }
    }



}