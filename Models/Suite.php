<?php

require_once 'Database.php';

class Suite {
    
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function selectAllFromSuite() {
        $this->db->query('SELECT * FROM suites');

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function selectAllFromSuiteGallery() {
        $this->db->query('SELECT * FROM suite_pictures');

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function registerSuite($data) {
        $this->db->query('INSERT INTO suites (id_establishment, title, price, description, featured_img_name, featured_img, link) 
        VALUES (:establishment, :title, :price, :description, :imgName, :imgData, :link)');
        //Bind values
        $this->db->bind(':establishment', $data['id_establishment']);
        $this->db->bind(':title', $data['name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':imgName', $data['imgName']);
        $this->db->bind(':imgData', $data['imgData']);
        $this->db->bind(':link', $data['link']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function registerSuiteGallery($data, $id_suite) {
        $this->db->query('INSERT INTO suite_pictures (id_suite, suite_picture_name, suite_picture) 
        VALUES (:suite, :imgName, :imgData)');
        //Bind values
        $this->db->bind(':suite', $id_suite);
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

    public function selectIdSuiteFromLastSuite() {
        $this->db->query('SELECT id_suite FROM suites ORDER BY id_suite DESC LIMIT 1');

        $row = $this->db->single();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }

    }

    public function selectSuiteGalleryByIdSuite($id) {
        $this->db->query('SELECT * FROM suite_pictures WHERE id_suite = :id');

        $this->db->bind(':id', $id);

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function selectSuiteByName($name) {
        $this->db->query('SELECT * FROM suites WHERE title = :name');

        $this->db->bind(':name', $name);

        $row = $this->db->single();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function selectEstablishmentFromUserId($id) {
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
