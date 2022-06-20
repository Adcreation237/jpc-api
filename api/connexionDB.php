<?php
class Operations{

    // private $servername = "mysql.db.mdbgo.com";
    // private $username = "addevelop_addevelop";
    // private $password = "Anne2607@@";
    // private $dbname = "addevelop_youth";
    
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "youth";

    function dbConnection(){
        try {
            $dbh = new PDO('mysql:host='.$this->servername.';dbname='.$this->dbname.'', $this->username, $this->password,);
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $dbh;
            
        } catch (PDOException $th) {
            echo 'Impossible de se connecter '.$th->getMessage();
            exit;
        }
    }
}

