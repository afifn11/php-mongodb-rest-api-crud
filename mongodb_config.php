<?php

class DbManager {
    //Database configuration
    private $dbhost = 'localhost';
    private $dbport = '27017';
    private $conn;

    function __construct () {
        //Connecting to MongoDB
        try {
            //Estabilish database connection
            $this->conn = new MongoDB\Driver\Manager('mongodb://'.$this->dbhost.':'.$this->dbport);
        }catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage ();
            echo n12br("n");
        }
    }

    function getConnection () {
        return $this->conn;
    }
}

?>