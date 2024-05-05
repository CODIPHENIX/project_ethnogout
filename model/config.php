<?php

class Connectdb {

    public function connect($servername, $username, $password, $dbname) {
        try {
            $conn = new mysqli($servername, $username, $password, $dbname);
            return $conn;
        } catch(mysqli_sql_exception $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

}
$connection = new Connectdb();
$conn = $connection->connect("localhost", "root", "", "dbethnogout");