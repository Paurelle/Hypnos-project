<?php

require_once 'Database.php';

class User {
    
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    //Find user by email
    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    //Login user
    public function login($email, $password){
        $row = $this->findUserByEmail($email);

        if($row == false) return false;

        $hashedPassword = $row->password;
        if(password_verify($password, $hashedPassword)){
            return $row;
        }else{
            return false;
        }
    }

    //Register User
    public function register($data){
        $this->db->query('INSERT INTO users (name, lastname, role, email, password) 
        VALUES (:name, :lastname, :role, :email, :password)');
        //Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':role', "customer");
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['pwd']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Register Manager
    public function registerManager($data){
        $this->db->query('INSERT INTO users (name, lastname, role, email, password) 
        VALUES (:name, :lastname, :role, :email, :password)');
        //Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':role', "manager");
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['pwd']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function deleteUser($email) {
        $this->db->query('DELETE FROM users WHERE email=:email');
        $this->db->bind(':email', $email);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function selectAllFromManager() {
        $this->db->query('SELECT * FROM users WHERE role = "manager"');

        $row = $this->db->resultSet();
        return $row;
    }

    public function hotel()
    {
        $this->db->query(
            'SELECT * FROM establishments'
        );

        $row = $this->db->resultSet();
        return $row;
    }

    public function findUserById($id){
        $this->db->query('SELECT * FROM users WHERE id_user = :id');
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
