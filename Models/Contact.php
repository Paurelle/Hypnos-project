<?php

require_once 'Database.php';

class Contact {
    
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function selectAllFromContact() {
        $this->db->query('SELECT contacts.name as user_name, lastname, email, message, subject, establishments.name as establishment_name FROM contacts
        INNER JOIN establishments ON contacts.id_establishment = establishments.id_establishment
        INNER JOIN contact_subjects ON contacts.id_subject = contact_subjects.id_subject');

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function addNewMessage($data) {
        $this->db->query('INSERT INTO contacts (id_subject, id_establishment, name, lastname, email, message) 
        VALUES (:id_subject, :establishment, :name, :lastname, :email, :message)');
        //Bind values
        $this->db->bind(':id_subject', $data['subject']);
        $this->db->bind(':establishment', $data['establishment']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':message', $data['description']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }


}
