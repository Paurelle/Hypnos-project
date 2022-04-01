<?php

require_once 'Database.php';

class Reservation {
    
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function selectSuiteByIdAndEstablishmentById($id_suite, $id_establishment) {
        $this->db->query('SELECT * FROM suites WHERE id_suite = :id_suite AND id_establishment = :id_establishment');

        $this->db->bind(':id_suite', $id_suite);
        $this->db->bind(':id_establishment', $id_establishment);

        $row = $this->db->single();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function selectReservationBySuiteIdAndEstablishmentId($id_suite, $id_establishment) {
        $this->db->query('SELECT * FROM reservations WHERE id_suite = :id_suite AND id_establishment = :id_establishment');

        $this->db->bind(':id_suite', $id_suite);
        $this->db->bind(':id_establishment', $id_establishment);

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function addReservation($data) {
        $this->db->query('INSERT INTO reservations (id_user, id_establishment, id_suite, price, start_date, end_date) 
        VALUES (:id_user, :id_establishment, :id_suite, :price, :start_date, :end_date)');
        //Bind values
        $this->db->bind(':id_user', $data['id_user']);
        $this->db->bind(':id_establishment', $data['id_establishment']);
        $this->db->bind(':id_suite', $data['id_suite']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':start_date', $data['startDate']);
        $this->db->bind(':end_date', $data['endDate']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function selectReservationByUserId($id_user) {
        $this->db->query(
            'SELECT id_reservation, name, title, reservations.price, start_date, end_date FROM reservations
            JOIN establishments ON reservations.id_establishment = establishments.id_establishment
            JOIN suites ON reservations.id_suite = suites.id_suite
            WHERE reservations.id_user = :id_user'
        );

        $this->db->bind(':id_user', $id_user);

        $row = $this->db->resultSet();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function selectReservationByReservationAndUserId($id_reservation, $id_user) {
        $this->db->query(
            'SELECT * FROM reservations
            WHERE id_reservation=:id_reservation AND id_user=:id_user'
        );
        
        $this->db->bind(':id_reservation', $id_reservation);
        $this->db->bind(':id_user', $id_user);

        $row = $this->db->single();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function deleteReservation($id_reservation, $id_user) {
        $this->db->query('DELETE FROM reservations WHERE id_reservation=:id_reservation AND id_user=:id_user');
        $this->db->bind(':id_reservation', $id_reservation);
        $this->db->bind(':id_user', $id_user);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}
