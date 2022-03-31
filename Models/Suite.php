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

    public function selectAllFromSuiteByIdEstablishment($id_establishment) {
        $this->db->query('SELECT * FROM suites WHERE id_establishment = :id_establishment');

        $this->db->bind(':id_establishment', $id_establishment);

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

    public function modifySuite($data) {
        $this->db->query(
            'UPDATE suites SET 
            title=:title, price=:price, description=:description, featured_img_name=:imgName, featured_img=:imgData, link=:link
            WHERE id_suite=:id_suite'
        );

        //Bind values
        $this->db->bind(':id_suite', $data['id_suite']);
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

    public function deleteSuiteGallery($id) {
        $this->db->query('DELETE FROM suite_pictures WHERE id_suite=:id');
        $this->db->bind(':id', $id);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function deleteSuite($id) {
        $this->db->query('DELETE FROM suites WHERE id_suite=:id');
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

    public function selectSuiteGalleryByIdSuite($id_suite) {
        $this->db->query('SELECT * FROM suite_pictures WHERE id_suite = :id_suite');

        $this->db->bind(':id_suite', $id_suite);

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function selectSuiteById($id) {
        $this->db->query('SELECT * FROM suites WHERE id_suite = :id');

        $this->db->bind(':id', $id);

        $row = $this->db->single();

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

    public function selectSuiteByNameAndEstablishmentId($name, $id_establishment) {
        $this->db->query('SELECT * FROM suites WHERE title = :name AND id_establishment = :id_establishment');

        $this->db->bind(':name', $name);
        $this->db->bind(':id_establishment', $id_establishment);

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
