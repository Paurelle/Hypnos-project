<?php

require_once 'Database.php';

class Establishment {
    
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function selectAllFromEstablishment(){
        $this->db->query('SELECT * FROM establishments');

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function selectNameFromEstablishment(){
        $this->db->query('SELECT name FROM establishments');

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

}
