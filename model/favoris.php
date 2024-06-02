<?php


namespace Model;

class favoris
{
    private $response = array();


    public function getResponse()
    {
        return $this->response;
    }

    public function addfavoris($conn,$iduser,$idrecette){
        $qry_addfavoris= $conn->prepare("INSERT INTO favoris (iduser, idrecette) VALUES 
                                            (?,?)");
        $qry_addfavoris->bind_param("ii",$iduser,$idrecette);
        if($qry_addfavoris->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function isfav($conn,$iduser, $idrecette){
        $qry_isfav=$conn->prepare("SELECT 1 FROM favoris
                WHERE iduser = ? AND idrecette = ?");
        $qry_isfav->bind_param("ii",$iduser,$idrecette);
        if($qry_isfav->execute()){
            $result=$qry_isfav->get_result();
            return $result->num_rows>0;
        }else{
            return false;
        }

    }

    public function getfavuser($conn,$iduser){
        $qry_getfavuser = $conn->prepare("SELECT f.iduser, f.idrecette, r.titrerecette,r.image_recette, COALESCE(AVG(a.note), 0) as moyenne_note
                            FROM favoris f 
                            INNER JOIN recette r ON f.idrecette=r.idrecette 
                            LEFT JOIN avis a on r.idrecette = a.idrecette 
                            WHERE f.iduser=?
                            GROUP BY f.iduser, f.idrecette, r.titrerecette,r.image_recette");

        $qry_getfavuser->bind_param("i", $iduser);
        $qry_getfavuser->execute();
        $result = $qry_getfavuser->get_result();

        if ($result->num_rows > 0) {
            $favRecettes = array();
            while ($favRecette = $result->fetch_assoc()) {
                $favRecettes[] = $favRecette;
            }
            $this->response['error'] = false;
            $this->response['message'] = $favRecettes;
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Vous n'avez mis aucune recette en favoris.";
        }
        return json_encode($this->response);
    }

    public function deletefav($conn,$iduser, $idrecette){

        $qry_deletefav=$conn->prepare("DELETE FROM favoris 
                                        WHERE iduser=? AND idrecette=?");
        $qry_deletefav->bind_param("ii",$iduser,$idrecette);
        if($qry_deletefav->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function deletefavrecette($conn,$idrecette){

        $qry_deletefav=$conn->prepare("DELETE FROM favoris 
                                        WHERE idrecette=?");
        $qry_deletefav->bind_param("i",$idrecette);
        if($qry_deletefav->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function deletefavuser($conn,$iduser){

        $qry_deletefav=$conn->prepare("DELETE FROM favoris 
                                        WHERE iduser=?");
        $qry_deletefav->bind_param("i",$iduser);
        if($qry_deletefav->execute()){
            return true;
        }else{
            return false;
        }
    }
}

