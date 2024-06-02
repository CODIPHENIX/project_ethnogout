<?php
namespace controller;
use Exception;
use Model\avis;
use Model\favoris;
use Model\user;
use Model\recette;

require_once __DIR__."/../model/recette.php";
require_once __DIR__."/../model/pays.php";
require_once __DIR__."/../model/ingredient.php";
require_once __DIR__."/../model/user.php";
require_once __DIR__."/../model/avis.php";
require_once __DIR__."/../model/favoris.php";

class adminControlleur
{
    public $response;
    public $avisModel;
    public $userModel;
    public $recetteModel;
    public $favorisModel;
    public function __construct($conn) {
        $this->response = array();
        $this->userModel= new user();
        $this->avisModel= new avis();
        $this->recetteModel= new recette();
        $this->favorisModel= new favoris();
        $this->conn = $conn;
    }

    public function deleteUser($iduser)
    {

        try{
            $this->conn->begin_transaction();
            $recettes=$this->recetteModel->idrecetteofuser($this->conn,$iduser);


            foreach ($recettes as $recette){
            $idrecette=$recette['idrecette'];

            $this->favorisModel->deletefavrecette($this->conn,$idrecette);
            $this->avisModel->deleteAvisrecette($this->conn,$idrecette);
            $this->recetteModel->deleteRecette($this->conn,$idrecette);
             }
            $this->avisModel->deleteAvisuser($this->conn,$iduser);
            $this->favorisModel->deletefavuser($this->conn,$iduser);
            $this->userModel->deleteusr($this->conn,$iduser);

            $this->conn->commit();

            $this->response['error']=false;
            $this->response['message']="L'utilisateur a bien étez supprimer";

        } catch (Exception $e) {
            $this->conn->rollback();

            $this->response['error'] = true;
            $this->response['message'] = $e->getMessage();
        }
        return $this->response;
    }

    public function showDashboard($conn){
        session_start();
//user
        $adminid=$_SESSION['loginid'];
        $responsenumUser=$this->userModel->getNumUser($conn);
        if($responsenumUser){
            $numUser=$responsenumUser;
        }
        $roleAdmin='admin';
        $roleUser='user';
        $responsenumAdmin=$this->userModel->getNumRole($conn,$roleAdmin);
        if($responsenumAdmin){
            $numAdmin=$responsenumAdmin;
        }
        $responsenumM=$this->userModel->getNumRole($conn,$roleUser);
        if($responsenumM){
            $numUserM=$responsenumM;
        }
        //recette
        $responsenumRecette=$this->recetteModel->getNumRecette($conn);
        if($responsenumRecette){
            $numRecette=$responsenumRecette;
        }
        $responsenumRWA=$this->recetteModel->getNumRWA($conn);
        if($responsenumRWA){
            $numRWA=$responsenumRWA['message'];
        }
        $responsenumRWF=$this->recetteModel->getNumRWF($conn);
        if($responsenumRWF){
            $numRWF=$responsenumRWF['message'];
        }




        include "../includes/dashboard.inc.php";

    }

    public function newadminForm()
    {
        session_start();

        include "../includes/newadmin.inc.php";

    }
    public function showtableUser()
    {
        session_start();
        $adminid=$_SESSION['loginid'];
        $responseUser=$this->userModel->getallusr($this->conn);
        $resultU=json_decode($responseUser,true);
        $users=$resultU['message'];

        include "../includes/user/tableuser.inc.php";
    }
    public function showtableAdmin()
    {
        session_start();
        $role='admin';
        $adminid=$_SESSION['loginid'];
        $responseUser=$this->userModel->getallrole($this->conn,$role);
        $resultU=json_decode($responseUser,true);
        $users=$resultU['message'];

        include "../includes/user/tableuser.inc.php";
    }
    public function showtablemembre()
    {
        session_start();
        $role='user';
        $adminid=$_SESSION['loginid'];
        $responseUser=$this->userModel->getallrole($this->conn,$role);
        $resultU=json_decode($responseUser,true);
        $users=$resultU['message'];

        include "../includes/user/tableuser.inc.php";
    }


}


