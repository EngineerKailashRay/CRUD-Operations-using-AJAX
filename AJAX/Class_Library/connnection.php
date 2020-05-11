<?php

class connection {

    protected $pdo;

    function __construct() {
        try {
            $con = new PDO('mysql:host=localhost;dbname=kailash;', 'root', '');
//            echo "Connected successfully";
        } catch (Exception $ex) {
            echo "connection failed " . $ex->getMessage();
            exit();
        }
        $this->pdo = $con;
    }

    function getconnection() {
        return $this->pdo;
    }

}
