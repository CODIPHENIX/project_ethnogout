<?php

namespace Model;
use Exception;

class recette
{
    private $response=array();

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
    public function idrecetteofuser($conn,$iduser)
    {
        $qry_getRecettes = $conn->prepare("SELECT idrecette FROM recette WHERE iduser = ?");
        $qry_getRecettes->bind_param("i", $iduser);
       if( $qry_getRecettes->execute()){
        $result = $qry_getRecettes->get_result();
        return  $result->fetch_all(MYSQLI_ASSOC);
       }else{
           return false;
       }
    }

    public function setrecette($conn,$userid,$idpays,$nomrecette,$image,$difficulter,$temp_prepa,$cook_temp,$date_publication)
    {
        if ($this->recetteExists($conn,$nomrecette)){
            $this->response['error']=true;
            $this->response['message']= ['namerecette'=>"cette recette exist deja"];
        }else{

            $qry_setrecette = $conn->prepare("INSERT INTO recette (iduser, idpays, titrerecette, image_recette, difficulter, temp_prepa, cook_temp, date_publication) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $qry_setrecette->bind_param("iisssiis", $userid, $idpays, $nomrecette, $image, $difficulter, $temp_prepa, $cook_temp, $date_publication);

            if ($qry_setrecette->execute()) {
                $this->response['error'] = false;
                $idrecette = $conn->insert_id;
                return $idrecette;
            } else {
                $this->response['error'] = true;
                $this->response['message'] = "Une erreur s'est produite, veuillez réessayer.";
            }
        }
        return json_encode($this->response);
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
            $this->response['message']="aucune recette";
        }

        return $this->response;
    }
    
    public function getallrecette($conn,$limit=NULL)
    {
        $stmt="SELECT * FROM recette";

        if(!is_null($limit) && is_numeric($limit) && $limit > 0){
            $stmt.="limit ?";
        }
        $qry_getallrecettes=$conn->prepare("stmt");

        if(!is_null($limit) && is_numeric($limit) && $limit > 0){
            $qry_getallrecettes->bind_param("i", $limit);
        }


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

    public function getallrecettenew($conn,$limit=NULL)
    {
        $stmt="SELECT r.idrecette,r.titrerecette,r.image_recette,r.date_publication,a.note
                FROM recette r 
                LEFT JOIN avis a
                ON r.idrecette = a.idrecette
                ORDER BY 
                r.date_publication DESC ";

        if(!is_null($limit) && is_numeric($limit) && $limit > 0){
            $stmt.="limit ?";
        }
        $qry_getallrecettes=$conn->prepare($stmt);

        if(!is_null($limit) && is_numeric($limit) && $limit > 0){
            $qry_getallrecettes->bind_param("i", $limit);
        }


        $qry_getallrecettes->execute();
        $result = $qry_getallrecettes->get_result();
        if($result->num_rows >0){
            $recettes = array();

            while ($recette = $result->fetch_assoc()) {
                $recettes[] = $recette;
            }
            $this->response['error']=false;
            $this->response['message']= $recettes;

        }else{
            $this->response['error']=true;
            $this->response['message']="Aucune recette trouvé.";
        }

        return json_encode($this->response);

    }
    public function getetaperecette($conn,$idrecette)
    {
        $qry_getetaperecette=$conn->prepare("SELECT *
                                         FROM etape_prepa WHERE id_recette=?
                                         ORDER BY num_prepa ");
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
        $qry_getrecettebyidusr = $conn->prepare("SELECT r.idrecette,r.image_recette,r.titrerecette,u.iduser,COALESCE(AVG(a.note), 0) as moyenne_note
                                                    FROM recette r 
                                                    INNER JOIN utilisateur u
                                                    ON r.iduser=u.iduser
                                                    LEFT JOIN avis a 
                                                    ON r.idrecette = a.idrecette
                                                    WHERE u.iduser = ?
                                                    GROUP BY r.idrecette, r.image_recette, r.titrerecette, u.iduser");
        $qry_getrecettebyidusr->bind_param("i", $userid);
        $qry_getrecettebyidusr->execute();

        $result = $qry_getrecettebyidusr->get_result();
        if($result->num_rows >0){
            $recettes = array();

            while ($recette = $result->fetch_assoc()) {
                $recettes[] = $recette;
            }
            $this->response['error']=false;
            $this->response['message']= $recettes;

        }else{
            $this->response['error']=true;
            $this->response['message']="Vous n'avez pas encore ajouter de recette.";
        }

        return json_encode($this->response);
    }

    public function getrecettebyAdmin($conn,$roles){
        $qry_getrecettebyAdmin = $conn->prepare("SELECT r.idrecette,r.image_recette,r.titrerecette,u.iduser,COALESCE(AVG(a.note), 0) as moyenne_note
                                                    FROM recette r 
                                                    INNER JOIN utilisateur u
                                                    ON r.iduser=u.iduser
                                                    LEFT JOIN avis a 
                                                    ON r.idrecette = a.idrecette
                                                    WHERE roles = ?
                                                    GROUP BY r.idrecette, r.image_recette, r.titrerecette, u.iduser;");
        $qry_getrecettebyAdmin->bind_param("s", $roles);

        $qry_getrecettebyAdmin->execute();

        $result = $qry_getrecettebyAdmin->get_result();
        if($result->num_rows >0){
            $recettes = array();

            while ($recette = $result->fetch_assoc()) {
                $recettes[] = $recette;
            }
            $this->response['error']=false;
            $this->response['message']= $recettes;

        }else{
            $this->response['error']=true;
            $this->response['message']="Vous n'avez pas encore ajouter de recette.";
        }

        return json_encode($this->response);
    }
    public function getrallecette($conn,$limit=null ){
        $stmt="SELECT r.idrecette,r.image_recette,r.titrerecette,u.iduser,COALESCE(AVG(a.note), 0) as moyenne_note
                                                    FROM recette r 
                                                    INNER JOIN utilisateur u
                                                    ON r.iduser=u.iduser
                                                    LEFT JOIN avis a 
                                                    ON r.idrecette = a.idrecette
                                                    GROUP BY r.idrecette, r.image_recette, r.titrerecette, u.iduser;
                                                    ";
        if(is_numeric($limit) && $limit > 0){
            $stmt.="limit ?";
        }
        $qry_getrecetteall = $conn->prepare("$stmt");

        if(is_numeric($limit) && $limit > 0){
            $qry_getrecetteall->bind_param("i", $limit);
        }


        $qry_getrecetteall->execute();

        $result = $qry_getrecetteall->get_result();
        if($result->num_rows >0){
            $recettes = array();

            while ($recette = $result->fetch_assoc()) {
                $recettes[] = $recette;
            }
            $this->response['error']=false;
            $this->response['message']= $recettes;

        }else{
            $this->response['error']=true;
            $this->response['message']="Aucune recette trouver.";
        }

        return json_encode($this->response);
    }

    public function getrallecetteWA($conn,$limit=null ){
        $stmt="SELECT r.idrecette,r.image_recette,r.titrerecette,u.iduser,COALESCE(AVG(a.note), 0) as moyenne_note
                                                    FROM recette r 
                                                    INNER JOIN utilisateur u
                                                    ON r.iduser=u.iduser
                                                    INNER JOIN avis a 
                                                    ON r.idrecette = a.idrecette
                                                    GROUP BY r.idrecette, r.image_recette, r.titrerecette, u.iduser;
                                                    ";
        if(is_numeric($limit) && $limit > 0){
            $stmt.="limit ?";
        }
        $qry_getrecetteall = $conn->prepare("$stmt");

        if(is_numeric($limit) && $limit > 0){
            $qry_getrecetteall->bind_param("i", $limit);
        }


        $qry_getrecetteall->execute();

        $result = $qry_getrecetteall->get_result();
        if($result->num_rows >0){
            $recettes = array();

            while ($recette = $result->fetch_assoc()) {
                $recettes[] = $recette;
            }
            $this->response['error']=false;
            $this->response['message']= $recettes;

        }else{
            $this->response['error']=true;
            $this->response['message']="Aucune recette trouver.";
        }

        return json_encode($this->response);
    }
    public function getrallecetteWF($conn,$limit=null ){
        $stmt="SELECT r.idrecette,r.image_recette,r.titrerecette,u.iduser,COALESCE(AVG(a.note), 0) as moyenne_note
                                                    FROM recette r 
                                                    INNER JOIN utilisateur u
                                                    ON r.iduser=u.iduser
                                                    LEFT JOIN avis a 
                                                    ON r.idrecette = a.idrecette
                                                    INNER JOIN favoris f
                                                    on r.idrecette = f.idrecette
                                                    GROUP BY r.idrecette, r.image_recette, r.titrerecette, u.iduser;
                                                    ";
        if(is_numeric($limit) && $limit > 0){
            $stmt.="limit ?";
        }
        $qry_getrecetteall = $conn->prepare("$stmt");

        if(is_numeric($limit) && $limit > 0){
            $qry_getrecetteall->bind_param("i", $limit);
        }


        $qry_getrecetteall->execute();

        $result = $qry_getrecetteall->get_result();
        if($result->num_rows >0){
            $recettes = array();

            while ($recette = $result->fetch_assoc()) {
                $recettes[] = $recette;
            }
            $this->response['error']=false;
            $this->response['message']= $recettes;

        }else{
            $this->response['error']=true;
            $this->response['message']="Aucune recette trouver.";
        }

        return json_encode($this->response);
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
            $this->response['message']= $pays;
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
    public function getDifficulties($conn) {
        $qry_getDifficulties = $conn->prepare("SHOW COLUMNS FROM recette LIKE 'difficulter'");
        $qry_getDifficulties->execute();
        $result = $qry_getDifficulties->get_result()->fetch_assoc();

        $enum_values = $result['Type'];
        preg_match("/^enum\('(.*)'\)$/", $enum_values, $matches);
        $difficulties = explode("','", $matches[1]);

        return $difficulties;
    }

    public function getRecetteById($conn, $recetteId) {
        $qry = $conn->prepare("SELECT * FROM recette WHERE idrecette = ?");
        $qry->bind_param("i", $recetteId);
        $qry->execute();
        $result = $qry->get_result();
        return $result->fetch_assoc();
    }
    public function checkRecetteNameExists($conn, $name, $excludeId) {
        $query = "SELECT COUNT(*) as count FROM recette WHERE titrerecette = ? AND idrecette != ?";
        $stmt = $conn->prepare($query);

            $stmt->bind_param("si", $name, $excludeId);
            if($stmt->execute()){
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $stmt->close();
                return $row['count'] > 0;
            }else{
                return false;
            }
    }

    public function updaterecette($conn,$idpays, $nomrecette,$image,$difficulter,$temp_prepa,$cook_temp,$idrecette){

        if ($this->checkRecetteNameExists($conn,$nomrecette,$idrecette)){
            $this->response['error']=true;
            $this->response['message']= ['namerecette'=>"Une autre recette avec le même nom existe déjà."];
        }else{
        $qry_updateuser=$conn->prepare("UPDATE recette SET recette.idpays=?,titrerecette=?,image_recette=?,difficulter=?,temp_prepa=?,cook_temp=?
                                        WHERE idrecette=?");

        $qry_updateuser->bind_param("isssiii",$idpays,$nomrecette,$image,$difficulter,$temp_prepa,$cook_temp,$idrecette);

        if ($qry_updateuser->execute()) {

            if ($qry_updateuser->affected_rows > 0) {
                $this->response['error'] = false;
            } else {
                $this->response['error'] = false;
                $this->response['message'] = ['field'=>"Aucune recette mise à jour. Veuillez vérifier les valeurs fournies."];
            }
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Une erreur s'est produite, la mise à jour de la recette n'a pas pu aboutir.";
        }
        }
        return $this->response;
    }

    public function deleteRecetteComposition($conn,$idrecette)
    {
        $qry_delete_ingredients = $conn->prepare("DELETE FROM contenir WHERE idrecette = ?");
        $qry_delete_ingredients->bind_param("i", $idrecette);
        if($qry_delete_ingredients->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function deleteStepRecette($conn,$idrecette)
    {
        $qry_delete_steps = $conn->prepare("DELETE FROM etape_prepa WHERE id_recette = ?");
        $qry_delete_steps->bind_param("i", $idrecette);
        if($qry_delete_steps->execute()){
            return true;
        }else{
            return false;
        }
    }



    public function deleteRecette($conn,$idrecette)
    {
        $conn->begin_transaction();

        if ($this->deleteRecetteComposition($conn, $idrecette) && $this->deleteStepRecette($conn, $idrecette)) {

            $qry_deleterecette = $conn->prepare("DELETE FROM recette WHERE idrecette=?");
            $qry_deleterecette->bind_param("i", $idrecette);

            if ($qry_deleterecette->execute()) {
                $conn->commit();

                $this->response['error'] = false;
                $this->response['message'] = "Cet utilisateur a été supprimé avec succès.";
            } else {
                $conn->rollback();

                $this->response['error'] = true;
                $this->response['message'] = "Une erreur s'est produite lors de la suppression de la recette.";

            }
        } else {
            $conn->rollback();

            $this->response['error'] = true;
            $this->response['message'] = "Une erreur s'est produite lors de la suppression des composants de la recette.";
        }

        return $this->response;
    }

    public function getNumRecette($conn)
    {
        $qry_getNumRecette = $conn->prepare("SELECT COUNT(*) as count FROM recette");
        $qry_getNumRecette->execute();
        $result = $qry_getNumRecette->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            return  $this->response['message'] = $row['count'];
        } else {
            return false;
        }
    }
    public function getNumRWA($conn)
    {
        $response = ['error' => false, 'message' => ''];

        try {

            $qry_getNumRWA = $conn->prepare("SELECT COUNT(DISTINCT idrecette) as count FROM avis");
            $qry_getNumRWA->execute();
            $result = $qry_getNumRWA->get_result();
            $row = $result->fetch_assoc();


            if ($row && isset($row['count'])) {
                $response['message'] = $row['count'];
            } else {
                $response['message'] = '0';
            }
        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }




    public function getNumRWF($conn)
    {
        $response = ['error' => false, 'message' => ''];

        try {

            $qry_getNumRWF = $conn->prepare("SELECT COUNT(DISTINCT idrecette) as count FROM favoris");
            $qry_getNumRWF->execute();
            $result = $qry_getNumRWF->get_result();
            $row = $result->fetch_assoc();


            if ($row && isset($row['count'])) {
                $response['message'] = $row['count'];
            } else {
                $response['message'] = '0';
            }
        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function seachbar($conn,$query)
    {
        $sql = "
        SELECT DISTINCT r.idrecette, r.titrerecette, r.image_recette
        FROM recette r
        LEFT JOIN contenir c ON r.idrecette = c.idrecette
        LEFT JOIN ingredients i ON c.idingredients = i.idingredients
        WHERE r.titrerecette LIKE ? OR i.nom_ingredients LIKE ?
    ";

        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $recettes=array();
            while ($recette = $result->fetch_assoc()) {
                $recettes[]=$recette;
            }
            $this->response['error']=false;
            $this->response['message']=$recettes;
        } else {
            $this->response['error']=true;
            $this->response['message']='Aucun résultat trouvé pour cette recherche.';
        }
        return json_encode($this->response);
    }
}
