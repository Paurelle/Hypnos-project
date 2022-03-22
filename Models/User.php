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

    public function hotel()
    {
        $this->db->query(
            'SELECT * FROM establishments'
        );

        $row = $this->db->resultSet();
        return $row;
    }

    public function countUsersNotChecked()
    {
        $this->db->query(
            'SELECT COUNT(*) as total FROM users WHERE user_checked = 0'
        );

        $row = $this->db->single();
        if($this->db->rowCount() > 0){
            return $row->total;
        }else{
            return false;
        }
    }

    public function checkIfUserHasValidAccount($email)
    {
        $this->db->query(
            'SELECT * FROM users WHERE user_email = :email AND user_checked = 1'
        );

        $this->db->bind(':email', $email);

        $this->db->single();
        if($this->db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function countUsersByRole($role)
    {
        $this->db->query('SELECT count(*) as userNumbers FROM users WHERE user_role = :role');
        $this->db->bind(':role', $role);

        $row = $this->db->single();

        //Check row
        if($this->db->rowCount() > 0){
            return $row->userNumbers;
        }else{
            return false;
        }
    }

    public function validateUser($email) {
        $this->db->query('UPDATE users SET user_checked=:validate WHERE user_email=:email');
        $this->db->bind(':validate', 1);
        $this->db->bind(':email', $email);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function deleteUser($email) {
        $this->db->query('DELETE FROM users WHERE user_email=:email');
        $this->db->bind(':email', $email);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Reset Password
    public function resetPassword($newPwdHash, $tokenEmail){
        $this->db->query('UPDATE users SET user_pwd=:pwd WHERE user_email=:email');
        $this->db->bind(':pwd', $newPwdHash);
        $this->db->bind(':email', $tokenEmail);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}
