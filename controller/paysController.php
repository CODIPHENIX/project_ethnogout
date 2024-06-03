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
class paysController
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
    public function updateinfopays()
    {
        session_start();
        $errors = array();
        $idpays = intval($_POST['idpays']);
        $responsepays = $this->paysModel->getpaysinfobyid($this->conn, $idpays);

        $nompays = isset($_POST['nompays']) ? ucwords(trim(htmlspecialchars($_POST['nompays']))) : '';
        $description = isset($_POST['description']) ? ucwords(trim(htmlspecialchars($_POST['description'],ENT_NOQUOTES))) : '';
        $modifdate = date("y-m-d H:i:s");
        $image = isset($_FILES['img_pays']) ? $_FILES['img_pays'] : null;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $uploadDir = '../../public/asset/paysupload/';
        $downloadDir = './asset/paysupload/';
        $uploadFile = $uploadDir . basename(isset($image['name']) ? $image['name'] : '');
        $imageFileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
        $imageName = $downloadDir . $nompays . '.' . $imageFileType;
        $imageNameupload = $uploadDir . $nompays . '.' . $imageFileType;


        if (!empty($description)) {
            if (strlen($description) < 10) {
                $errors['description'] = 'La description du pays dois avoir au moins 10 character';
            }
        }


        if (!empty($errors)) {
            $this->response['error'] = true;
            $this->response['message'] = $errors;
        } else {


            if ($image['error'] === UPLOAD_ERR_NO_FILE) {
                $defaultImage = isset($responsepays['imagepays']) ? $responsepays['imagepays'] : "./asset/appimg/bck_img.jpg";
                $imageName = $defaultImage;
            } else {

                if (in_array($image['type'], $allowedTypes) && $image['size'] <= 2 * 1024 * 1024) {
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    if (move_uploaded_file($image['tmp_name'], $imageNameupload)) {
                        $this->response['error'] = false;
                    } else {
                        $errors['image_recette'] = ['Erreur lors du téléchargement de l\'image.'];
                    }
                } else {
                    $errors['image_recette'] = 'Image invalide. Assurez-vous que l\'image est au format JPG, JPEG, ou PNG et qu\'elle est inférieure à 2MB.';
                }
            }

            if (empty($errors)) {
                $this->paysModel->updateinfopays($this->conn, $description, $imageName, $modifdate, $idpays);
                $result = $this->paysModel->getResponse();
                if ($result['error']) {
                    $this->response['error'] = true;
                } else {
                    $this->response['error'] = false;
                }
                $this->response['message'] = $result['message'];
            } else {
                $this->response['error'] = true;
                $this->response['message'] = $errors;
            }
        }
        echo json_encode($this->response);
    }


    public function showEditform($idpays)
    {
        session_start();
        $infopays=$this->paysModel->recettebypays($this->conn,$idpays);

        include "../includes/pays/editpaysinfo.php";
    }
    public function showRecettebypays($idpays)
    {
        session_start();
        $infopays=$this->paysModel->getpaysinfobyid($this->conn,$idpays);
        $recettespay =$this->paysModel->recettebypays($this->conn,$idpays);
        $result= json_decode($recettespay, true);
        $recettes= $result['message'];

        include "../includes/pays/paysinfo.inc.php";
    }

}