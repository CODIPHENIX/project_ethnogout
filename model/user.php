<?php
namespace Model;

class User{
     private $response=array();
     private $stm_result;

    public function getResponse() {
        return $this->response;
    }

    public function userExists($conn, $email)
    {
        $qry_checkuser = $conn->prepare("SELECT * FROM utilisateur WHERE emailuser = ?");
        $qry_checkuser->bind_param("s", $email);
        $qry_checkuser->execute();
        
        $result = $qry_checkuser->get_result();
        $this->stm_result= $result;
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function setuser($conn, $name,$prenom,$password,$email,$signindate,$role="user")
    {
        if ($this->userExists($conn,$email)){
        $this->response['error']=true;
        $this->response['message']= ['email' => 'Cet utilisateur existe déjà.'];
        }
        else{

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $qry_addusr = $conn->prepare("INSERT INTO utilisateur(nomuser, prenomuser, userpwd,emailuser,roles, 
                                        date_inscription) 
                                        VALUES (?, ?, ?, ?, ?, ?)");

            $qry_addusr->bind_param("ssssss", $name,$prenom, $hashed_password, $email, $role, $signindate);

            if($qry_addusr->execute()){
                $this->response['error']=false;
                $this->response['message']= "Vous avez bien été inscrit(e)";

            }
            else{
                $this->response['error']=true;
                $this->response['message']="une erreur c'est produite, veillez reessayer";
            }
        }
        return json_encode($this->response);
    }

    public function setadmin($conn, $name,$prenom,$password,$email,$signindate,$role="admin")
    {
        if ($this->userExists($conn,$email)){
        $this->response['error']=true;
        $this->response['message']= "cette utilisateur exist deja";

        }
        else{

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $qry_addusr = $conn->prepare("INSERT INTO utilisateur(nomuser, prenomuser, userpwd,emailuser,roles,
                                        date_inscription) 
                                        VALUES (?, ?, ?, ?, ?, ?)");

            $qry_addusr->bind_param("ssssss", $name,$prenom, $hashed_password, $email, $role, $signindate);

            if($qry_addusr->execute()){
                $this->response['error']=false;
                $this->response['message']= "Vous avez bien été inscrit(e)";

            }
            else{
                $this->response['error']=true;
                $this->response['message']="une erreur c'est produite, veillez reessayer";
            }
        }
        return $this->response;
    }

    public function getusrbyID($conn,$userid)
    {
        $qry_getusrbyid=$conn->prepare("SELECT * FROM utilisateur WHERE iduser=?");
        $qry_getusrbyid->bind_param("i",$userid);
        $qry_getusrbyid->execute();
        $result=$qry_getusrbyid->get_result();

        if($result->num_rows >0){
            $user=$result->fetch_assoc();
            $this->response['error']=false;
            $this->response['message']=json_encode($user);
        }else{
            $this->response['error']=true;
            $this->response['message']=" Aucun utilisateur trouvé avec cet ID.";
        }
        return $this->response;
    }
    public function getallusr($conn)
    {
        $qry_getallusr=$conn->prepare("SELECT * FROM utilisateur");
        $qry_getallusr->execute();
        $result=$qry_getallusr->get_result();

        if($result->num_rows >0){
            $users = array();

            while ($user = $result->fetch_assoc()) {
                $users[] = $user;
            }
            $this->response['error']=false;
            $this->response['message']= json_encode($users);

        }else{
            $this->response['error']=true;
            $this->response['message']=" Aucun utilisateur trouvé.";
        }

        return $this->response;
    }


    public function updateuser($conn, $name,$prenom,$email,$password,$userid){

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $qry_updateuser=$conn->prepare("UPDATE utilisateur SET nomuser=?,prenomuser=?,emailuser=?,userpwd=?
                                        WHERE iduser=?");
        $qry_updateuser->bind_param("ssssi",$name,$prenom,$email,$hashed_password,$userid);

        if ($qry_updateuser->execute()) {

            if ($qry_updateuser->affected_rows > 0) {
                $this->response['error'] = false;
                $this->response['message'] = "Vos données ont bien été mises à jour.";
            } else {
                $this->response['error'] = true;
                $this->response['message'] = "Aucune donnée mise à jour. Veuillez vérifier les valeurs fournies.";
            }
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Une erreur s'est produite, la mise à jour de vos données n'a pas pu aboutir.";
        }
        return $this->response;
    }

    public function deleteusr($conn,$userid){

        $qry_deleteusr = $conn->prepare("DELETE FROM utilisateur WHERE iduser=?");
        $qry_deleteusr->bind_param("i",$userid);
        
        if($qry_deleteusr->execute()){
            $this->response['error']=false;
            $this->response['message']="Cet utilisateur a été supprimé avec succès.";
        }else{
            $this->response['error']=true;
            $this->response['message']="Une erreur s'est produite, impossible de supprimer l'utilisateur.";

        }

        return $this->response;
    }


}

