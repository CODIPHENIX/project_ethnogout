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
                $this->response['message']= "Nouvel administrateur ajouté";

            }
            else{
                $this->response['error']=true;
                $this->response['message']="une erreur c'est produite, veillez reessayer";
            }
        }
        return $this->response;
    }
    public function checkUserExists($conn, $email, $excludeId) {
        $query = "SELECT COUNT(*) as count FROM utilisateur WHERE emailuser = ? AND iduser != ?";
        $stmt = $conn->prepare($query);

        $stmt->bind_param("si", $email, $excludeId);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['count'] > 0;
        }else{
            return false;
        }


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
            $this->response['message']=$user;
        }else{
            $this->response['error']=true;
            $this->response['message']=" Aucun utilisateur trouvé avec cet ID.";
        }
        return json_encode($this->response);
    }
    public function getallusr($conn)
    {
        $qry_getallusr=$conn->prepare("SELECT 
                            u.iduser,
                            u.nomuser,
                            u.prenomuser,
                            u.emailuser,
                            u.date_inscription,
                            u.avatar,
                            COUNT(r.idrecette) AS nombre_recettes
                        FROM 
                            utilisateur u
                        LEFT JOIN 
                            recette r ON u.iduser = r.iduser
                        GROUP BY 
                            u.iduser, u.nomuser, u.iduser, u.prenomuser, u.emailuser, u.date_inscription, u.avatar, u.avatar
                            ORDER BY 
                            nombre_recettes DESC;
");
        $qry_getallusr->execute();
        $result=$qry_getallusr->get_result();

        if($result->num_rows >0){
            $users = array();

            while ($user = $result->fetch_assoc()) {
                $users[] = $user;
            }
            $this->response['error']=false;
            $this->response['message']= $users;

        }else{
            $this->response['error']=true;
            $this->response['message']=" Aucun utilisateur trouvé.";
        }

        return json_encode($this->response);
    }
    public function getallrole($conn,$role)
    {
        $qry_getallusrWR=$conn->prepare("SELECT 
                                            u.iduser,
                                            u.nomuser,
                                            u.prenomuser,
                                            u.emailuser,
                                            u.date_inscription,
                                            u.avatar,
                                            COUNT(r.idrecette) AS nombre_recettes
                                        FROM 
                                            utilisateur u
                                        LEFT JOIN 
                                            recette r ON u.iduser = r.iduser 
                                        WHERE roles=?
                                        GROUP BY 
                                        u.iduser, u.nomuser, u.iduser, u.prenomuser, u.emailuser, u.date_inscription, u.avatar, u.avatar
                                        ORDER BY 
                                        nombre_recettes DESC");


        $qry_getallusrWR->bind_param('s',$role);
        $qry_getallusrWR->execute();
        $result=$qry_getallusrWR->get_result();

        if($result->num_rows >0){
            $users = array();

            while ($user = $result->fetch_assoc()) {
                $users[] = $user;
            }
            $this->response['error']=false;
            $this->response['message']= $users;

        }else{
            $this->response['error']=true;
            $this->response['message']=" Aucun utilisateur trouvé.";
        }

        return json_encode($this->response);
    }



    public function updateuser($conn, $name,$prenom,$email,$password,$image,$updateDate,$userid){
        if ($this->checkUserExists($conn,$email,$userid)){
            $this->response['error']=true;
            $this->response['message']= ['email'=>"Cette email exist deja dans la base de donner."];
        }else {


            $qry_updateuser = $conn->prepare("UPDATE utilisateur
                                        SET nomuser=?,prenomuser=?,emailuser=?,userpwd=?,avatar=?,date_modification=?
                                        WHERE iduser=?");
            $qry_updateuser->bind_param("ssssssi", $name, $prenom, $email, $password, $image, $updateDate, $userid);

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
        }
        return $this->response;
    }
    public function getNumUser($conn)
    {
        $qry_getNumUser = $conn->prepare("SELECT COUNT(*) as count FROM utilisateur");
        $qry_getNumUser->execute();
        $result = $qry_getNumUser->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            return  $this->response['message'] = $row['count'];
        } else {
            return false;
        }
    }

    public function getNumRole($conn,$roles)
    {
        $qry_getNumMembre = $conn->prepare("SELECT COUNT(*) as count FROM utilisateur WHERE roles=?");
        $qry_getNumMembre->bind_param("s", $roles);
        $qry_getNumMembre->execute();
        $result = $qry_getNumMembre->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            return  $this->response['message'] = $row['count'];
        } else {
            return false;
        }
    }


    public function deleteusr($conn,$userid){

        $qry_deleteusr = $conn->prepare("DELETE FROM utilisateur WHERE iduser=?");
        $qry_deleteusr->bind_param("i",$userid);
        
        if($qry_deleteusr->execute()){
            $this->response['error']=false;
        }else{
            $this->response['error']=true;
            $this->response['message']="Une erreur s'est produite, impossible de supprimer l'utilisateur.";
        }

        return $this->response;
    }


}

