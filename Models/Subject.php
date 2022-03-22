<?php

require_once 'Database.php';

class Subject {
    
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function selectAllFromSubject(){
        $this->db->query('SELECT * FROM contact_subjects');

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }
}
