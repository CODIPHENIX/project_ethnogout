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

}