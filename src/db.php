<?php
class db
{


    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        // try {
        //     $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
        //     $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // } catch (PDOException $e) {
        //     echo "Connection failed: " . $e->getMessage();
        // }

        // sql lite connection
        try {
            $this->conn = new PDO("sqlite:../db.sqlite");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }




}
