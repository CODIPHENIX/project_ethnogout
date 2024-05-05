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
                $pays[] = $row;
            }

            $this->response['error'] = false;
            $this->response['message'] = json_encode($pays);
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Aucun pays trouvé.";
        }

        return $this->response;
    }
}