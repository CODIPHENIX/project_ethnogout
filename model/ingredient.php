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
            $this->response['error']=true;
            return $this->response;
        }else{

            $qry_setrecette=$conn->prepare("INSERT INTO ingredients(nom_ingredients) 
                                        VALUES ?");

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


        if (!$this->ingredientExists($conn, $idIngredient)) {
            $result = $this->setingredient($conn, $idIngredient);
            if ($result['error']) {
                $this->response['error'] = true;
                return $this->response;
            }
        }

        $qry_addIngredient = $conn->prepare("INSERT INTO contenir (idrecette, idingredients, quantity, unit) VALUES (?, ?, ?, ?)");
        $qry_addIngredient->bind_param("iids", $idRecette, $idIngredient, $quantity, $unit);

        if ($qry_addIngredient->execute()) {
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