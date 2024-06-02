<?php
namespace controller;
use Model\avis;

require_once __DIR__."/../model/recette.php";
require_once __DIR__."/../model/pays.php";
require_once __DIR__."/../model/ingredient.php";
require_once __DIR__."/../model/user.php";
require_once __DIR__."/../model/avis.php";

class avisControlleur
{
    public $response;
    public $avisModel;
    public function __construct($conn) {
        $this->response = array();
        $this->avisModel= new avis();
        $this->conn = $conn;
    }
    public function updateAvis($conn){

        session_start();
        $errors=array();
        if (isset($_SESSION['loginid'])) {
            $userid = $_SESSION['loginid'];
        } else {
            $errors['login'] = 'Utilisateur non connecté';
        }

        $idRecette= isset($_POST['idRecette'])? intval($_POST['idRecette']): 0;
        $comment=isset($_POST['modifcomment'])? htmlspecialchars(trim($_POST['modifcomment']), ENT_NOQUOTES):'';
        $note = isset($_POST['ratingmod'])? intval($_POST['ratingmod']):0;
        $datemodif = date("y-m-d H:i:s");


        if($idRecette<=0 ){
            $errors['field']='aucune idrecette.';
        }
        if (empty($userid)){
            $errors['field']='aucune userid';
        }

        if(empty($comment)){
            $errors['comments']='vieller laisser un commentaire.';
        }
        if($note<1||$note>5){
            $errors['rating']='Vieller noté la recette.';
        }
        if(!empty($errors)){
            $this->response['error']=true;
            $this->response['message']=$errors;
        }else{

            $this->avisModel->updateAvis($conn,$comment,$note,$datemodif,$userid,$idRecette);
            $result=$this->avisModel->getResponse();
            if(!$result['error']){
                $this->response['error']=false;
                $this->response['message']="Votre avis a bien étez modifier.";
            }else{
                $this->response['error']=true;
                $this->response['message']=$result['message'];
            }

        }

        echo json_encode($this->response);
    }


    public function addAvis($conn){

        session_start();
        $errors=array();
        if (isset($_SESSION['loginid'])) {
            $userid = $_SESSION['loginid'];
        } else {
            $errors['login'] = 'Utilisateur non connecté';
        }
        $idRecette= isset($_POST['idRecette'])? intval($_POST['idRecette']): 0;
        $comment=isset($_POST['comment'])? htmlspecialchars($_POST['comment'], ENT_NOQUOTES):'';
        $note = isset($_POST['rating'])? intval($_POST['rating']):0;
        $dateAjout = date("y-m-d H:i:s");

        if($idRecette<=0 || empty($userid)){
            $errors['field']='Erreur: vous ne pouver pas commenter cette recette.';
        }

        if(empty($comment)){
            $errors['comments']='vieller laisser un commentaire.';
        }
       if($note<1||$note>5){
            $errors['rating']='Vieller noté la recette.';
        }
       ;

       if(!empty($errors)){
           $this->response['error']=true;
           $this->response['message']=$errors;
       }else{

           $this->avisModel->setavis($conn,$userid,$idRecette,$comment,$note,$dateAjout);
           $result=$this->avisModel->getResponse();
           if(!$result['error']){
               $this->response['error']=false;
               $this->response['message']="Merci! pour votre avis.";
           }else{
               $this->response['error']=true;
               $this->response['message']=$result['message'];
           }

       }

       echo json_encode($this->response);
    }

    public function showUserAvis(){
        session_start();
        $iduser= $_SESSION['loginid'];
        $userAvis=$this->avisModel->getavisUser($this->conn,$iduser);
        $resultAvisuser=json_decode($userAvis,true);

        if($resultAvisuser['error']===false){
            $avisDonners=$resultAvisuser['message'];
        }else{
            $avisDonners=$resultAvisuser['message'];
        }


        include "../includes/myavis.inc.php";

    }
}

