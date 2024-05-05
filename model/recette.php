<?php

namespace Model;
class recette
{
    private $response=array();
    private $stm_result;

    public function getResponse() {
        return $this->response;
    }

    public function recetteExists($conn, $nomrecette)
    {
        $qry_recetteExist = $conn->prepare("SELECT * FROM recette WHERE titrerecette = ?");
        $qry_recetteExist->bind_param("s", $nomrecette);
        $qry_recetteExist->execute();

        $result = $qry_recetteExist->get_result();
        $this->stm_result= $result;
        if ($result->num_rows > 0) {
            return true;
        } else {

            return false;
        }
    }

    public function setrecette($conn,$userid,$idpays,$nomrecette,$difficulter,$temp_prepa,$cook_temp,$date_publication)
    {
        if ($this->recetteExists($conn,$nomrecette)){
            $this->response['error']=true;
            $this->response['message']= "cette recette exist deja";
            return $this->response;
        }else{

          $qry_setrecette=$conn->prepare("INSERT INTO recette(iduser,idpays,titrerecette,difficulter,temp_prepa,
                                        cook_temp,date_publication) 
                                        VALUES (?, ?, ?, ?, ?, ?,?)");

            $qry_setrecette->bind_param("iissiis", $userid,$idpays,$nomrecette,$temp_prepa,$cook_temp,$date_publication);

            if($qry_setrecette->execute()){
                $this->response['error']=false;
                $this->response['message']= "La recette a bien été ajoutée.";

            }
            else{
                $this->response['error']=true;
                $this->response['message']="une erreur c'est produite, veillez reessayer.";
            }
        }
        return $this->response;
    }

    public function getrecettebypays($conn,$idpay){
        $qry_getrecettebypays = $conn->prepare("SELECT * FROM recette WHERE idpays = ?");
        $qry_getrecettebypays->bind_param("i", $idpay);
        $qry_getrecettebypays->execute();

        $result = $qry_getrecettebypays->get_result();
        if($result->num_rows >0){
            $recettes = array();

            while ($recette = $result->fetch_assoc()) {
                $recettes[] = $recette;
            }
            $this->response['error']=false;
            $this->response['message']= json_encode($recettes);

        }else{
            $this->response['error']=true;
            $this->response['message']="Vous n'avez pas encore ajouter de recette.";
        }

        return $this->response;
    }
    public function getallrecette($conn)
    {
        $qry_getallrecettes=$conn->prepare("SELECT * FROM recette");
        $qry_getallrecettes->execute();
        $result = $qry_getallrecettes->get_result();
        if($result->num_rows >0){
            $recettes = array();

            while ($recette = $result->fetch_assoc()) {
                $recettes[] = $recette;
            }
            $this->response['error']=false;
            $this->response['message']= json_encode($recettes);

        }else{
            $this->response['error']=true;
            $this->response['message']="Vous n'avez pas encore ajouter de recette.";
        }

        return $this->response;

    }
    public function getetaperecette($conn,$idrecette)
    {
        $qry_getetaperecette=$conn->prepare("SELECT num_prepa, description_etape
                                         FROM etape_prepa WHERE id_recette=?");
        $qry_getetaperecette->bind_param("i", $idrecette);
        $qry_getetaperecette->execute();

        $result = $qry_getetaperecette->get_result();
        if($result->num_rows >0){
            $etapes_prepa = array();

            while ($etape_prepa = $result->fetch_assoc()) {
                $etapes_prepa[] = $etape_prepa;
            }
            $this->response['error']=false;
            $this->response['message']= json_encode($etapes_prepa);

        }else{
            $this->response['error']=true;
        }

        return $this->response;
    }
    public function getrecettebyidusr($conn,$userid){
        $qry_getrecettebypays = $conn->prepare("SELECT * FROM recette WHERE iduser = ?");
        $qry_getrecettebypays->bind_param("i", $userid);
        $qry_getrecettebypays->execute();

        $result = $qry_getrecettebypays->get_result();
        if($result->num_rows >0){
            $recettes = array();

            while ($recette = $result->fetch_assoc()) {
                $recettes[] = $recette;
            }
            $this->response['error']=false;
            $this->response['message']= json_encode($recettes);

        }else{
            $this->response['error']=true;
            $this->response['message']="Vous n'avez pas encore ajouter de recette.";
        }

        return $this->response;
    }
    public function addEtapeRecette($conn, $idRecette, $numPrepa, $descriptionEtape)
    {
        $qry_addEtapeRecette = $conn->prepare("INSERT INTO etape_prepa (id_recette, num_prepa, description_etape) VALUES (?, ?, ?)");
        $qry_addEtapeRecette->bind_param("iis", $idRecette, $numPrepa, $descriptionEtape);

        $this->response = array();

        if ($qry_addEtapeRecette->execute()) {
            $this->response['error'] = false;
        } else {
            $this->response['error'] = true;
        }

        return $this->response;
    }
    public function addIngredientToRecette($conn, $idRecette, $idIngredient, $quantity, $unit)
    {
        $qry_addIngredient = $conn->prepare("INSERT INTO contenir (idrecette, idingredients, quantity, unit) VALUES (?, ?, ?, ?)");
        $qry_addIngredient->bind_param("iids", $idRecette, $idIngredient, $quantity, $unit);

        $this->response = array();

        if ($qry_addIngredient->execute()) {
            $this->response['error'] = false;
            $this->response['message'] = "Ingrédient ajouté avec succès à la recette.";
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Erreur lors de l'ajout de l'ingrédient à la recette.";
        }

        return $this->response;
    }


    public function getnompaysbyrecette($conn,$idrecette){
        $qry_paysnom=$conn->prepare("SELECT p.nompays 
                                    FROM recette r 
                                    INNER JOIN pays p ON r.idpays=p.idpays
                                    WHERE idrecette=?");
        $qry_paysnom->bind_param("i",$idrecette);
        $qry_paysnom->execute();
        $result= $qry_paysnom->get_result();
        if($result->num_rows>0){
            $pays=$result->fetch_assoc();
            $this->response['error']=false;
            $this->response['message']= $pays['nompays'];
        }else{
            $this->response['error']=true;
            $this->response['message']= "Aucun pays associé à cette recette.";
        }

        return $this->response;
    }
    public function getingredientbyrecette($conn,$idrecette)
    {
        $qry_ingretient=$conn->prepare("SELECT i.idingredients,i.nom_ingredients, c.quantity, c.unit
                                        FROM contenir c
                                        INNER JOIN ingredients i
                                        ON c.idingredients=i.idingredients
                                        WHERE idrecette=?");
        $qry_ingretient->bind_param("i",$idrecette);
        $qry_ingretient->execute();
        $result=$qry_ingretient->get_result();
        if($result->num_rows>0){
            $ingretientsrecette=array();
            while($ingretientrecette=$result->fetch_assoc()){
                $ingretientsrecette[]=$ingretientrecette;
            }
            $this->response['error']=false;
            $this->response['message']= json_encode($ingretientsrecette);
        }else{
            $this->response['error']=true;
            $this->response['message']="une erreur c'est produit.";
        }
        return $this->response;
    }
    public function getQuickRecipes($conn)
    {
        $qry_quickRecipes = $conn->prepare("SELECT idrecette,difficulter, titrerecette, temp_prepa, cook_temp, (temp_prepa + cook_temp) AS total_time
                                        FROM recette
                                        WHERE (temp_prepa + cook_temp) < 30");

        $qry_quickRecipes->execute();
        $result = $qry_quickRecipes->get_result();

        if ($result->num_rows > 0) {
            $quickRecipes = array();

            while ($row = $result->fetch_assoc()) {
                $recipeInfo = array(
                    "idrecette" => $row['idrecette'],
                    "titrerecette" => $row['titrerecette'],
                    "temp_prepa" => $row['temp_prepa'],
                    "cook_temp" => $row['cook_temp'],
                    "total_time" => $row['total_time']
                );
                $quickRecipes[] = $recipeInfo;
            }

            $this->response['error'] = false;
            $this->response['message'] = json_encode($quickRecipes);
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Aucune recette rapide trouvée.";
        }

        return $this->response;
    }


    public function updaterecette($conn, $nomrecette,$difficulter,$temp_prepa,$cook_temp,$idrecette){

        $qry_updateuser=$conn->prepare("UPDATE recette SET titrerecette=?,difficulter=?,temp_prepa=?,difficulter=?,cook_temp=?
                                        WHERE idrecette=?");
        $qry_updateuser->bind_param("siii",$nomrecette,$difficulter,$temp_prepa,$cook_temp,$idrecette);

        if ($qry_updateuser->execute()) {

            if ($qry_updateuser->affected_rows > 0) {
                $this->response['error'] = false;
                $this->response['message'] = "La recette a bien été mises à jour.";
            } else {
                $this->response['error'] = true;
                $this->response['message'] = "Aucune recette mise à jour. Veuillez vérifier les valeurs fournies.";
            }
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Une erreur s'est produite, la mise à jour de la recette n'a pas pu aboutir.";
        }
        return $this->response;
    }



    public function deleterecette($conn,$idrecette){

        $qry_deleterecette = $conn->prepare("DELETE FROM recette WHERE idrecette=?");
        $qry_deleterecette->bind_param("i",$idrecette);

        if($qry_deleterecette->execute()){
            $this->response['error']=false;
            $this->response['message']="Cet utilisateur a été supprimé avec succès.";
        }else{
            $this->response['error']=true;
            $this->response['message']="Une erreur s'est produite, impossible de supprimer l'utilisateur.";

        }

        return $this->response;
    }


}