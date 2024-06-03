<?php

namespace Model;

class pays
{
    private $response = array();

    public function getResponse() {
        return $this->response;
    }

    public function getAllPays($conn) {
        $qry_getAllPays = $conn->prepare("SELECT * FROM pays ORDER BY nompays ASC");
        $qry_getAllPays->execute();
        $result = $qry_getAllPays->get_result();

        if ($result->num_rows > 0) {
            $pays = array();

            while ($row = $result->fetch_assoc()) {
                $pays[] = $row['nompays'];
            }

            $this->response['error'] = false;
            $this->response['message'] = $pays;
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Aucun pays trouvé.";
        }

        return $this->response;
    }
    public function getpaysid($conn,$paysname)
    {
        $qry_getpaysId = $conn->prepare("SELECT idpays FROM pays WHERE nompays = ?");
        $qry_getpaysId->bind_param("s", $paysname);
        $qry_getpaysId->execute();
        $result = $qry_getpaysId->get_result();
        $row = $result->fetch_assoc();
        return $row['idpays'];
    }

    public function getpaysinfobyid($conn,$idpays)
    {
        $qry_getpaysId = $conn->prepare("SELECT * FROM pays WHERE idpays = ?");
        $qry_getpaysId->bind_param("s", $idpays);
        $qry_getpaysId->execute();
        $result = $qry_getpaysId->get_result();
        return $result->fetch_assoc();
    }

    public function searchPays($conn, $searchTerm) {
        $qry_searchPays = $conn->prepare("SELECT nompays FROM pays WHERE nompays LIKE ? ORDER BY nompays ASC");
        $searchTerm = "%".$searchTerm."%";
        $qry_searchPays->bind_param("s", $searchTerm);
        $qry_searchPays->execute();
        $result = $qry_searchPays->get_result();

        if ($result->num_rows > 0) {
            $pays = array();

            while ($row = $result->fetch_assoc()) {
                $pays[] = $row['nompays'];
            }

            return $pays;
        } else {
            return array();
        }
    }

    public function getallpayinfo($conn,$limit=NULL)
    {
        $stmt="SELECT * FROM pays 
         ORDER BY date_modification DESC ";
        if(!is_null($limit) && is_numeric($limit) && $limit > 0){
            $stmt.="limit ?";
        }
        $qry_getAllPays=$conn->prepare($stmt);

        if(!is_null($limit) && is_numeric($limit) && $limit > 0){
            $qry_getAllPays->bind_param("i", $limit);
        }



        $qry_getAllPays->execute();
        $result = $qry_getAllPays->get_result();

        if ($result->num_rows > 0) {
            $pays = array();

            while ($row = $result->fetch_assoc()) {
                $pays[] = $row;
            }

            $this->response['error'] = false;
            $this->response['message'] = $pays;
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Aucun pays trouvé.";
        }

        return json_encode($this->response);
    }

    public function updateinfopays($conn,$description,$image,$updatedate,$idpays)
    {
        $qry_stm = $conn->prepare("UPDATE pays
                                        SET description=?,imagepays=?,date_modification=?
                                        WHERE idpays=?");
        $qry_stm->bind_param("sssi", $description, $image, $updatedate, $idpays);

        if ($qry_stm->execute()) {

            if ($qry_stm->affected_rows > 0) {
                $this->response['error'] = false;
                $this->response['message'] = "Cette section a bien été mise à jour.";
            } else {
                $this->response['error'] = true;
                $this->response['message'] = "Aucune donnée mise à jour. Veuillez vérifier les valeurs fournies.";
            }
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Une erreur s'est produite, la mise à jour de vos données n'a pas pu aboutir.";
        }
        return json_encode($this->response);
    }

    public function recettebypays($conn,$idpays)
    {
        $qry_stmt=$conn->prepare("SELECT
                                r.idrecette,r.titrerecette,r.image_recette,
                                COALESCE(AVG(a.note),0) as moyenne_note      
                                FROM recette r
                                LEFT JOIN avis a 
                                ON r.idrecette = a.idrecette
                                WHERE r.idpays=?
                                GROUP BY r.idpays, r.titrerecette, r.image_recette
                                  ");

        $qry_stmt->bind_param("i",$idpays);
        $qry_stmt->execute();

        $result = $qry_stmt->get_result();
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

}