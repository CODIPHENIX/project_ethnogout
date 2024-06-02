<?php


namespace Model;
class avis
{
    private $response = array();
    private $stm_result;

    public function getResponse()
    {
        return $this->response;
    }

    public function getavisRecette($conn,$idRecette){
        $qry_getavisandname= $conn->prepare("SELECT u.nomuser, a.contenu, a.note, a.dateCreation,u.avatar, a.iduser
                                                FROM avis a 
                                                INNER JOIN utilisateur u ON a.iduser=u.iduser
                                                INNER JOIN recette r ON  a.idrecette=r.idrecette
                                                WHERE a.idrecette=?");
        $qry_getavisandname->bind_param("i",$idRecette);
        $qry_getavisandname->execute();
        $result=$qry_getavisandname->get_result();
        if($result->num_rows>0){
            $avisRecettes=[];
            while ($avisRecette=$result->fetch_assoc()){
                $avisRecettes[]= $avisRecette;
            }
            $this->response['error']=false;
            $this->response['message']=$avisRecettes;
        }else{
            $this->response['error']=true;
            $this->response['message']="Aucun commentaire trouvé pour cette recette.";
        }
        return json_encode($this->response);

    }
    public function getavisUser($conn,$idUser){
        $qry_getavisUser= $conn->prepare("SELECT r.idrecette,r.titrerecette,a.iduser, a.contenu, a.note, a.dateCreation,r.image_recette
                                                FROM avis a 
                                                INNER JOIN utilisateur u ON a.iduser=u.iduser
                                                INNER JOIN recette r ON  a.idrecette=r.idrecette
                                                WHERE a.iduser=?");
        $qry_getavisUser->bind_param("i",$idUser);
        $qry_getavisUser->execute();
        $result=$qry_getavisUser->get_result();
        if($result->num_rows>0){
            $avisUsers=[];
            while ($avis=$result->fetch_assoc()){
                $avisUsers[]= $avis;
            }
            $this->response['error']=false;
            $this->response['message']=$avisUsers;
        }else{
            $this->response['error']=true;
            $this->response['message']="Aucun commentaire trouvé.";
        }


        return json_encode($this->response);

    }
    public function numAvisUser($conn,$iduser,$idRecette)
    {
        $qry_checkavis = $conn->prepare("SELECT COUNT(*) as count FROM avis WHERE iduser = ? AND idrecette = ?");
        $qry_checkavis->bind_param("ii", $iduser, $idRecette);
        $qry_checkavis->execute();
        $result = $qry_checkavis->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            return  $this->response['message'] = $row['count'];
        } else {
            return false;
        }
    }
    public function AvisUsernum($conn,$iduser)
    {
        $qry_checkavis = $conn->prepare("SELECT COUNT(*) as count FROM avis WHERE iduser");
        $qry_checkavis->bind_param("i", $iduser);
        $qry_checkavis->execute();
        $result = $qry_checkavis->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            return  $this->response['message'] = $row['count'];
        } else {
            return false;
        }
    }

    public function numAvisRecette($conn,$idRecette)
    {
        $qry_checkavisRecette = $conn->prepare("SELECT COUNT(*) as count FROM avis WHERE idrecette = ?");
        $qry_checkavisRecette->bind_param("i", $idRecette);
        $qry_checkavisRecette->execute();
        $result = $qry_checkavisRecette->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            return  $this->response['message'] = $row['count'];
        } else {
           return false;
        }

    }


    public function setavis($conn,$iduser,$idRecette,$commentaire,$note,$date)
    {
        if ($this->numAvisUser($conn,$iduser,$idRecette)!==false) {
            $this->response['error'] = true;
            $this->response['message'] = ['feild'=>"Vous avez déjà laissé un avis pour cette recette."];
        } else {

            $qry_setavis = $conn->prepare("INSERT INTO avis (iduser, idrecette, contenu, note, dateCreation)
                                                        VALUES (?,?,?,?,?)");
            $qry_setavis->bind_param("iisis", $iduser, $idRecette, $commentaire, $note, $date);
            if ($qry_setavis->execute()) {
                $this->response['error'] = false;
            } else {
                $this->response['error'] = true;
                $this->response['message'] = ['feilds'=>"Une erreur s'est produite."];
            }
        }
        return   $this->response;
    }

    public function updateAvis($conn, $commentaire, $note, $date, $iduser, $idRecette) {

        $qry_updateAvis = $conn->prepare("UPDATE avis SET contenu=?, note=?, dateModification=? WHERE iduser=? AND idrecette=?");
        $qry_updateAvis->bind_param("sisii", $commentaire, $note, $date, $iduser, $idRecette);

        if ($qry_updateAvis->execute()) {
            if ($qry_updateAvis->affected_rows > 0) {
                $this->response['error'] = false;
            } else {
                $this->response['error'] = true;
                $this->response['message'] = "Aucun avis mis à jour. Veuillez vérifier les valeurs fournies.";
            }
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Erreur d'exécution de la requête : " . $qry_updateAvis->error;
        }

        return $this->response;
    }
    public function deleteAvis($conn,$idrecette,$iduser)
    {
        $qry_delete_ingredients = $conn->prepare("DELETE FROM avis WHERE idrecette = ? AND iduser=?");
        $qry_delete_ingredients->bind_param("ii", $idrecette, $iduser);
        if($qry_delete_ingredients->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function deleteAvisrecette($conn,$idrecette)
    {
        $qry_delete_ingredients = $conn->prepare("DELETE FROM avis WHERE idrecette = ?");
        $qry_delete_ingredients->bind_param("i", $idrecette);
        if($qry_delete_ingredients->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function deleteAvisuser($conn,$iduser)
    {
        $qry_delete_ingredients = $conn->prepare("DELETE FROM avis WHERE iduser = ?");
        $qry_delete_ingredients->bind_param("i", $iduser);
        if($qry_delete_ingredients->execute()){
            return true;
        }else{
            return false;
        }
    }



    public function getAverageNoteByRecette($conn, $idRecette)
    {
        $qry_avg_note = $conn->prepare("SELECT AVG(note) as moyenne_note FROM avis WHERE idrecette = ?");
        $qry_avg_note->bind_param("i", $idRecette);
        $qry_avg_note->execute();
        $result = $qry_avg_note->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['moyenne_note'];
        } else {
            return null;
        }
    }

}

