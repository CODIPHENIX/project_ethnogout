<?php

namespace Model;

class ingredient
{
    private $response=array();
    private $stm_result;

    public function getResponse() {
        return $this->response;
    }

    public function ingredientExists($conn, $nomingredient)
    {
        $qry_ingredientExists = $conn->prepare("SELECT * FROM ingredients WHERE nom_ingredients = ?");
        $qry_ingredientExists->bind_param("s", $nomingredient);
        $qry_ingredientExists->execute();

        $result = $qry_ingredientExists->get_result();
        $this->stm_result= $result;
        if ($result->num_rows > 0) {
            return true;
        } else {

            return false;
        }
    }

    public function setingredient($conn,$nomingredient)
    {
        if ($this->ingredientExists($conn,$nomingredient)){
            return true;
        }else{

            $qry_setrecette = $conn->prepare("INSERT INTO ingredients (nom_ingredients) VALUES (?)");

            $qry_setrecette->bind_param("s", $nomingredient);

            if($qry_setrecette->execute()){
                $this->response['error']=false;

            }
            else{
                $this->response['error']=true;
            }
        }
        return $this->response;
    }


    public function addIngredientToRecette($conn, $idRecette, $idIngredient, $quantity, $unit)
    {

        $qry_addIngredient = $conn->prepare("INSERT INTO contenir (idrecette, idingredients, quantity, unit) VALUES (?, ?, ?, ?)");
        $qry_addIngredient->bind_param("iids", $idRecette, $idIngredient, $quantity, $unit);

        if ($qry_addIngredient->execute()) {
            $this->response['error'] = false;
        } else {
            $this->response['error'] = true;
            $this->response['message'] = 'Une erreur s\'est produite lors de l\'ajout de l\'ingrédient à la recette.';
        }

        return json_encode($this->response);
    }
    public function stepToRecette($conn, $idRecette,$stepnumber, $stepDescription)
    {

        $qry_addStep = $conn->prepare("INSERT INTO etape_prepa (etape_prepa.id_recette,num_prepa, description_etape) VALUES (?, ?, ?)");
        $qry_addStep->bind_param("iis", $idRecette,$stepnumber, $stepDescription);

        if ($qry_addStep->execute()) {
            $this->response['error'] = false;
        } else {
            $this->response['error'] = true;
        }

        return $this->response;
    }

    public function getallingrients($conn)
    {
        $qry_getallingrients=$conn->prepare("SELECT nom_ingredients FROM ingredients");
        $qry_getallingrients->execute();
        $result=$qry_getallingrients->get_result();
        if($result->num_rows>0){
            $ingredients = array();
            while ($row = $result->fetch_assoc()) {
                $ingredients[] = $row['nom_ingredients'];
            }
            $this->response['error'] = false;
            $this->response['message'] = json_encode($ingredients);
        }else{
            $this->response['error']=true;
            $this->response['message']= "Aucune ingredient trouver";
        }
        return $this->response;
    }

    public function getingredientid($conn, $nomingredient)
    {
        $qry_getIngredientId = $conn->prepare("SELECT idingredients FROM ingredients WHERE nom_ingredients = ?");
        $qry_getIngredientId->bind_param("s", $nomingredient);
        $qry_getIngredientId->execute();
        $result = $qry_getIngredientId->get_result();
        $row = $result->fetch_assoc();

        return $row['idingredients'];
    }
    public function getMostUsedIngredients($conn)
    {

        $qry_mostUsedIngredients = $conn->prepare("SELECT i.idingredients, i.nom_ingredients, COUNT(*) AS occurrences
                                               FROM contenir c
                                               INNER JOIN ingredients i ON c.idingredients = i.idingredients
                                               GROUP BY i.idingredients
                                               ORDER BY occurrences DESC");

        $qry_mostUsedIngredients->execute();
        $result = $qry_mostUsedIngredients->get_result();

        if ($result->num_rows > 0) {
            $mostUsedIngredients = array();

            while ($row = $result->fetch_assoc()) {
                $ingredientInfo = array(
                    "idingredients" => $row['idingredients'],
                    "nom_ingredients" => $row['nom_ingredients'],
                    "occurrences" => $row['occurrences']
                );
                $mostUsedIngredients[] = $ingredientInfo;
            }

            $this->response['error'] = false;
            $this->response['message'] = json_encode($mostUsedIngredients);
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Aucun ingrédient trouvé dans la table contenir.";
        }

        return $this->response;
    }

}