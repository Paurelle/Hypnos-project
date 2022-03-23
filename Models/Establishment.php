<?php

require_once 'Database.php';

class Establishment {
    
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function selectAllFromEstablishment() {
        $this->db->query('SELECT * FROM establishments');

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function registerEstablishment($data) {
        $this->db->query('INSERT INTO establishments (id_user, name, city, address, description, establishment_picture_name, establishment_picture) 
        VALUES (:manager, :name, :city, :address, :description, :imgName, :imgData)');
        //Bind values
        $this->db->bind(':manager', $data['manager']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':imgName', $data['imgName']);
        $this->db->bind(':imgData', $data['imgData']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function modifyEstablishment($data) {
        $this->db->query(
            'UPDATE establishments SET 
            id_user=:manager, name=:name, city=:city, address=:address, description=:description, establishment_picture_name=:imgName, establishment_picture=:imgData
            WHERE id_establishment=:id'
        );

        //Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':manager', $data['manager']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':imgName', $data['imgName']);
        $this->db->bind(':imgData', $data['imgData']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function deleteEstablishment($id) {
        $this->db->query('DELETE FROM establishments WHERE id_establishment=:id');
        $this->db->bind(':id', $id);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function selectNameFromEstablishment() {
        $this->db->query('SELECT name FROM establishments');

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function selectEstablishmentById($id) {
        $this->db->query('SELECT * FROM establishments WHERE id_establishment = :id');

        $this->db->bind(':id', $id);

        $row = $this->db->single();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function selectUserFromEstablishmentById($id) {
        $this->db->query('SELECT * FROM establishments WHERE id_user = :id');

        $this->db->bind(':id', $id);

        $row = $this->db->single();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

}
