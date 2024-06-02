<?php
namespace controller;

require_once __DIR__."/../model/recette.php";
require_once __DIR__."/../model/pays.php";
require_once __DIR__."/../model/ingredient.php";
require_once __DIR__."/../model/avis.php";
require_once __DIR__."/../model/favoris.php";


use model\recette;
use model\pays;
use model\ingredient;
use model\avis;
use model\favoris;
class RecetteController
{
    private $recetteModel;
    private $paysModel;
    private $ingredientModel;
    private $favModel;
    private $response;


    private $avisModel;

    public function __construct($conn) {
        $this->recetteModel = new recette();
        $this->paysModel = new pays();
        $this->ingredientModel = new ingredient();
        $this->favModel = new favoris();
        $this->response = array();
        $this->avisModel=new avis();


        $this->conn = $conn;
    }

    public function newRecette($conn)
    {
        session_start();

        $errors = array();

        if (isset($_SESSION['loginid'])) {
            $userid = $_SESSION['loginid'];
        } else {
            $errors['login'] = 'Utilisateur non connecté';
        }

        $namerecette = isset($_POST['name_recette']) ? ucwords(strtolower(trim(strip_tags($_POST['name_recette'])))) : '';
        $tmp_prepa_hr = isset($_POST['tmp_prepa_hour']) ? intval($_POST['tmp_prepa_hour']) : 0;
        $tmp_prepa_min = isset($_POST['tmp_prepa_Mins']) ? intval($_POST['tmp_prepa_Mins']) : 0;
        $tmp_prepa = ($tmp_prepa_hr * 60) + $tmp_prepa_min;

        $tmp_cuisson_hr = isset($_POST['tmp_cuisson_hour']) ? intval($_POST['tmp_cuisson_hour']) : 0;
        $tmp_cuisson_min = isset($_POST['tmp_cuisson_Mins']) ? intval($_POST['tmp_cuisson_Mins']) : 0;
        $tmp_cuisson = ($tmp_cuisson_hr * 60) + $tmp_cuisson_min;


        $difficulty = isset($_POST['difficulty']) ? $_POST['difficulty'] : '';
        $pays = isset($_POST['pays']) ? $_POST['pays'] : '';

        $quantities = isset($_POST['quantity']) ? $_POST['quantity'] : [];
        $units = isset($_POST['unit']) ? $_POST['unit'] : [];
        $ingredients = isset($_POST['ingredient']) ? ($_POST['ingredient']) : [];

        $numberstep = isset($_POST['stepnumber']) ? $_POST['stepnumber'] : [];
        $stepdescription = isset($_POST['etapeprepa']) ? ($_POST['etapeprepa']) : [];
        $datepublication = date("y-m-d H:i:s");

        $image = isset($_FILES['img_recette']) ? $_FILES['img_recette'] : null;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $uploadDir = '../../public/asset/recetteupload/';
        $downloadDir='./asset/recetteupload/';
        $uploadFile = $uploadDir . basename($image['name']);
        $imageFileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
        $imageName = $downloadDir . $namerecette . '.' . $imageFileType;
        $imageNameupload = $uploadDir . $namerecette . '.' . $imageFileType;

    if (empty($namerecette)){
        $errors['namerecette']='*obligatoire';
    }
    elseif(strlen($namerecette)<3){
            $errors['namerecette']='Le nom de la recette dois avoir au moins 3 character';
        }

     if (empty($tmp_prepa)){
        $errors['temp_prepa']='*obligatoire';
    }elseif ($tmp_prepa < 0) {
        $errors['temp_prepa'] = 'Paramètre invalide';
    }

    if (empty($tmp_cuisson)){
        $errors['tmp_cuisson']='*obligatoire';
    }elseif ($tmp_cuisson < 0) {
        $errors['$tmp_cuisson'] = 'Paramètre invalide';
    }

    if (empty($difficulty)){
            $errors['difficulter']='*obligatoire';
        }

    if (empty($pays)){
            $errors['pays']='*obligatoire';
    }


    foreach ($ingredients as $index => $ingredient) {
            $unit = $units[$index];

            if(empty($ingredient)){
                $errors['ingredient']='*Veiller renseigner un ingredient.';
            }


        }

    foreach ($stepdescription as $index => $description) {
            $description = $stepdescription[$index];
            if(empty($description)){
                $errors['stepDescription']='*Veiller renseigner une étape.';
            }

        }



     if(empty($errors)){

         if (!$image || $image['error'] === UPLOAD_ERR_NO_FILE) {
             $defaultImage = './asset/appimg/defautimagerecette.png';
             $imageName = $defaultImage;
         }else{

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
         if($errors){
             $this->response['error']=true;
             $this->response['message']=$errors;
         }
         else{
             $idpays=$this->paysModel->getpaysid($conn,$pays);
             $idRecette= $this->recetteModel->setrecette($conn,$userid,$idpays,$namerecette,$imageName,$difficulty,$tmp_prepa,$tmp_cuisson,$datepublication);
             $resultResponse=$this->recetteModel->getResponse();

             if($resultResponse['error']){
                 $this->response['error'] = true;
                 $this->response['message'] =$resultResponse['message'] ;
             }
             else{

                 foreach ($ingredients as $index => $ingredient) {
                     $ingredient = ucfirst(strtolower(trim($ingredient)));
                     $quantity = $quantities[$index];
                     $unit = $units[$index];

                     $this->ingredientModel->setingredient($conn, $ingredient);
                     $ingredientidid = $this->ingredientModel->getingredientid($conn, $ingredient);

                     $this->ingredientModel->addIngredientToRecette($conn, $idRecette, $ingredientidid, $quantity, $unit);

                 }
                 foreach ($stepdescription as $index => $description) {
                     $stepnum = $numberstep[$index];
                     $description = htmlspecialchars($description,ENT_NOQUOTES);

                     $this->ingredientModel->stepToRecette($conn,$idRecette, $stepnum, $description);

                 }

                 $this->response['error'] = false;
                 $this->response['message'] = 'Recette ajoutée avec succès.';
             }

         }
     }
     else{
             $this->response['error']=true;
             $this->response['message']=$errors;
         }


        echo json_encode($this->response);
     }

    public function updateRecett($conn,$idRecette)
    {
        session_start();
        $responseRecettes = $this->recetteModel->getRecetteById($this->conn, $idRecette);

        $errors = array();

        $namerecette = isset($_POST['name_recette']) ? ucwords(strtolower(trim(strip_tags($_POST['name_recette'])))) : '';
        $tmp_prepa_hr = isset($_POST['tmp_prepa_hour']) ? intval($_POST['tmp_prepa_hour']) : 0;
        $tmp_prepa_min = isset($_POST['tmp_prepa_Mins']) ? intval($_POST['tmp_prepa_Mins']) : 0;
        $tmp_prepa = ($tmp_prepa_hr * 60) + $tmp_prepa_min;

        $tmp_cuisson_hr = isset($_POST['tmp_cuisson_hour']) ? intval($_POST['tmp_cuisson_hour']) : 0;
        $tmp_cuisson_min = isset($_POST['tmp_cuisson_Mins']) ? intval($_POST['tmp_cuisson_Mins']) : 0;
        $tmp_cuisson = ($tmp_cuisson_hr * 60) + $tmp_cuisson_min;


        $difficulty = isset($_POST['difficulty']) ? $_POST['difficulty'] : '';
        $pays = isset($_POST['pays']) ? $_POST['pays'] : '';

        $quantities = isset($_POST['quantity']) ? $_POST['quantity'] : [];
        $units = isset($_POST['unit']) ? $_POST['unit'] : [];
        $ingredients = isset($_POST['ingredient']) ? ($_POST['ingredient']) : [];

        $numberstep = isset($_POST['stepnumber']) ? $_POST['stepnumber'] : [];
        $stepdescription = isset($_POST['etapeprepa']) ? ($_POST['etapeprepa']) : [];


        $image = isset($_FILES['img_recette']) ? $_FILES['img_recette'] : null;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $uploadDir = '../../public/asset/recetteupload/';
        $downloadDir='./asset/recetteupload/';
        $uploadFile = $uploadDir . basename($image['name']);
        $imageFileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
        $imageName = $downloadDir . $namerecette . '.' . $imageFileType;
        $imageNameupload = $uploadDir . $namerecette . '.' . $imageFileType;

        if (empty($namerecette)){
            $errors['namerecette']='*obligatoire';
        }
        elseif(strlen($namerecette)<3){
            $errors['namerecette']='Le nom de la recette dois avoir au moins 3 character';
        }

        if (empty($tmp_prepa)){
            $errors['temp_prepa']='*obligatoire';
        }elseif ($tmp_prepa < 0) {
            $errors['temp_prepa'] = 'Paramètre invalide';
        }

        if (empty($tmp_cuisson)){
            $errors['tmp_cuisson']='*obligatoire';
        }elseif ($tmp_cuisson < 0) {
            $errors['$tmp_cuisson'] = 'Paramètre invalide';
        }

        if (empty($difficulty)){
            $errors['difficulter']='*obligatoire';
        }

        if (empty($pays)){
            $errors['pays']='*obligatoire';
        }


        foreach ($ingredients as $ingredient) {

            if(empty($ingredient)){
                $errors['ingredient']='*Veiller renseigner un ingredient.';
            }
        }

        foreach ($stepdescription as $description) {
            if(empty($description)){
                $errors['stepDescription']='*Veiller renseigner une étape.';
            }

        }

        if(empty($errors)){
            $conn->begin_transaction();

            if ($image['error'] === UPLOAD_ERR_NO_FILE) {
                $defaultImage = $responseRecettes['image_recette'];
                $imageName = $defaultImage;
            }else{

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

            if($errors){
                $this->response['error']=true;
                $this->response['message']=$errors;
            }
            else{
                $idpays=$this->paysModel->getpaysid($conn,$pays);
                $this->recetteModel->updaterecette($conn,$idpays,$namerecette,$imageName,$difficulty,$tmp_prepa,$tmp_cuisson,$idRecette);
                $resultResponse=$this->recetteModel->getResponse();

                if (!$resultResponse['error']) {
                    if($this->recetteModel->deleteRecetteComposition($conn,$idRecette)){

                        foreach ($ingredients as $index => $ingredient) {
                            $ingredient = ucfirst(strtolower(trim($ingredient)));
                            $quantity = $quantities[$index];
                            $unit = $units[$index];

                            $this->ingredientModel->setingredient($conn, $ingredient);
                            $ingredientidid = $this->ingredientModel->getingredientid($conn, $ingredient);

                            $this->ingredientModel->addIngredientToRecette($conn, $idRecette, $ingredientidid, $quantity, $unit);

                        }
                    }
                    if($this->recetteModel->deleteStepRecette($conn,$idRecette)){
                        foreach ($stepdescription as $index => $description) {
                            $stepnum = $numberstep[$index];
                            $description = htmlspecialchars($description,ENT_NOQUOTES);

                            $this->ingredientModel->stepToRecette($conn,$idRecette, $stepnum, $description);

                        }
                    }
                    $conn->commit();


                    $this->response['error'] = false;
                    $this->response['message'] = 'Recette modifier avec succès.';
                }else {

                    $this->response['error'] = true;
                    $this->response['message'] = $resultResponse['message'];

                    $conn->rollback();
                }

            }

        }
        else{
            $this->response['error']=true;
            $this->response['message']=$errors;

        }


        echo json_encode($this->response);
    }

    public function showRecetteForm() {

        $difficulties = $this->recetteModel->getDifficulties($this->conn);
        $resultpays=$this->paysModel->getAllPays($this->conn);

        if ($resultpays['error'] === false) {
            $pays = $resultpays['message'];
        } else {
            $pays = array();
        }
        include '../includes/newRecette.inc.php';
    }

    public function showMyRecette()
    {
        session_start();
        $userid=$_SESSION['loginid'] ;

        $recettes =$this->recetteModel->getrecettebyidusr($this->conn,$userid);
        $result= json_decode($recettes, true);
        if (!$result['error']) {
            $myrecette= $result['message'];
        }
        else{
            $myrecette= $result['message'];
        }

        include '../includes/myrecette.inc.php';
    }
    public function showAdminRecette()
    {
        session_start();
        $userid=$_SESSION['loginid'] ;

        $adminroles='admin';
        $recettes =$this->recetteModel->getrecettebyAdmin($this->conn,$adminroles);
        $result= json_decode($recettes, true);
        if (!$result['error']) {
            $myrecette= $result['message'];
        }
        else{
            $myrecette= $result['message'];
        }

        include '../includes/appRecette.inc.php';
    }
    public function showallRecette()
    {
        session_start();
        $userid=$_SESSION['loginid'] ;

        $recettes =$this->recetteModel->getrallecette($this->conn);
        $result= json_decode($recettes, true);

        $myrecette= $result['message'];


        include '../includes/templeteRecette/recettestemplete.php';
    }
    public function showallRecetteWITHA()
    {
        session_start();
        $userid=$_SESSION['loginid'] ;

        $recettes =$this->recetteModel->getrallecetteWA($this->conn);
        $result= json_decode($recettes, true);

        $myrecette= $result['message'];


        include '../includes/templeteRecette/recettestemplete.php';
    }
    public function showallRecetteWITHFAV()
    {
        session_start();
        $userid=$_SESSION['loginid'] ;

        $recettes =$this->recetteModel->getrallecetteWF($this->conn);
        $result= json_decode($recettes, true);

        $myrecette= $result['message'];


        include '../includes/templeteRecette/recettestemplete.php';
    }

    public function showEditRecetteForm($recetteId)
    {
        session_start();
        $responseRecettes = $this->recetteModel->getRecetteById($this->conn, $recetteId);
        $responsePay=$this->recetteModel->getnompaysbyrecette($this->conn, $recetteId);
        if ($responsePay['error'] === false) {
            $paysRecette = $responsePay['message'];
        } else {
            $paysRecette = array();
        }
        $responseIngrediet=$this->recetteModel->getingredientbyrecette($this->conn, $recetteId);

        if ($responseIngrediet['error'] === false) {
            $compositions = json_decode($responseIngrediet['message'],true);
        } else {
            echo '<p>Erreur:'.htmlspecialchars($responseIngrediet['message']).'</p>';
        }

        $responseStep=$this->recetteModel->getetaperecette($this->conn, $recetteId);
        if ($responseStep['error'] === false) {
            $stepRecette = json_decode($responseStep['message'],true);
        } else {
            echo '<p>Erreur: Une erreur c\'est produit </p>';
        }

        $difficulties = $this->recetteModel->getDifficulties($this->conn);
        $resultpays=$this->paysModel->getAllPays($this->conn);
        if ($resultpays['error'] === false) {
            $pays = $resultpays['message'];
        } else {
            $pays = array();
        }

        include '../includes/editRecette.inc.php';
    }
    public function showhomepage()
    {
        session_start();
        $resultRR=$this->recetteModel->getallrecettenew($this->conn,4);
        $response1=json_decode($resultRR,true);
        $newrecettes=$response1['message'];

        include '../includes/home.php';
    }

    public function showRecettedetail($recetteId)
    {
        session_start();
        if(isset($_SESSION['loginid'])){
            $iduser=$_SESSION['loginid'] ;
        }

        $responseRecettes = $this->recetteModel->getRecetteById($this->conn, $recetteId);
        $responsePay=$this->recetteModel->getnompaysbyrecette($this->conn, $recetteId);
        if ($responsePay['error'] === false) {
            $paysRecette = $responsePay['message'];
        } else {
            $paysRecette = array();
        }
        $responseIngrediet=$this->recetteModel->getingredientbyrecette($this->conn, $recetteId);

        if ($responseIngrediet['error'] === false) {
            $compositions = json_decode($responseIngrediet['message'],true);
        } else {
            echo '<p>Erreur:'.htmlspecialchars($responseIngrediet['message']).'</p>';
        }

        $responseStep=$this->recetteModel->getetaperecette($this->conn, $recetteId);
        if ($responseStep['error'] === false) {
            $stepRecette = json_decode($responseStep['message'],true);
        } else {
            echo '<p>Erreur: Une erreur c\'est produit </p>';
        }

        $numAvis=$this->avisModel->numAvisRecette($this->conn,$recetteId);
        if($numAvis){
            $nombre=$numAvis;
        }else{
            $nombre = 0;
        }

        $moyenneNote = $this->avisModel->getAverageNoteByRecette($this->conn, $recetteId);
        $Temptolal= $responseRecettes['temp_prepa'] + $responseRecettes['cook_temp'];
        if ($moyenneNote !== null) {
            $moyenneNote=$moyenneNote;
        } else {
            $moyenneNote= 0;
        }
        $commentaireRecette = $this->avisModel->getavisRecette($this->conn, $recetteId);
        $response = json_decode($commentaireRecette, true);
        if ($response['error'] === false) {
            $comments = $response['message'];

        } else {
            $comments = $response['message'];

        }
        if(isset($_SESSION['loginid'])){
        $isFavorite = $this->favModel->isfav($this->conn, $iduser, $recetteId);
        $favClass = $isFavorite ? 'favorite' : '';
        $favicon = $isFavorite ? 'solid' : 'regular';
        }else{
            $favicon= 'regular';
        }

        include '../includes/Recette.inc.php';

    }
}
