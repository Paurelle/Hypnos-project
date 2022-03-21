<?php

    require_once '../Models/User.php';
    require_once 'Helpers/session_helper.php';

    class Users {

        private $userModel;

        public function __construct(){
            $this->userModel = new User;
        }

        public function login() {
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);
    
            //Init data
            $data=[
                'email' => trim($_POST['email']),
                'pwd' => trim($_POST['pwd'])
            ];
            
            if(empty($data['email']) || empty($data['pwd'])){
                flash("login", "Veuillez remplir toutes les entrées");
                redirect("../index.php?page=login");
                
            }
    
            //Check for user/email
            if($this->userModel->findUserByEmail($data['email'])){
                //User Found
                $loggedInUser = $this->userModel->login($data['email'], $data['pwd']);
                if($loggedInUser){
                    //Create session
                    $this->createUserSession($loggedInUser);
                    redirect("../index.php");
                }else{
                    flash("login", "Email ou Mot de passe incorrect");
                    redirect("../index.php?page=login");
                }
            }else{
                flash("login", "Email ou Mot de passe incorrect");
                redirect("../index.php?page=login");
            }
        }

        public function createUserSession($user){
            $_SESSION['userHypnosId'] = $user->id_user;
            $_SESSION['userHypnosName'] = $user->name;
            $_SESSION['userHypnosLastname'] = $user->lastname;
            $_SESSION['userHypnosRole'] = $user->role;
            $_SESSION['userHypnosEmail'] = $user->email;
        }
    
        public function logout(){
            unset($_SESSION['userHypnosId']);
            unset($_SESSION['userHypnosName']);
            unset($_SESSION['userHypnosRole']);
            unset($_SESSION['userHypnosEmail']);
            session_destroy();
            redirect("../index.php");
        }

        public function register(){
            // Process form

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'name' => trim($_POST['name']),
                'lastname' => trim($_POST['lastname']),
                'email' => trim($_POST['email']),
                'pwd' => trim($_POST['pwd']),
                'cPwd' => trim($_POST['cPwd']),
            ];

            // Validate inputs
            if (empty($data['name']) || empty($data['lastname']) || 
            empty($data['email']) || empty($data['pwd']) || empty($data['cPwd'])) {
                flash("register", "Veuillez remplir toutes les entrées");
                redirect("../index.php?page=register");
            }

            if(!preg_match("/^[a-zA-Z]*$/", $data['name'])){
                flash("register", "Nom invalide");
                redirect("../index.php?page=register");
            }

            if(!preg_match("/^[a-zA-Z]*$/", $data['lastname'])){
                flash("register", "Prénom invalide");
                redirect("../index.php?page=register");
            }

            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                flash("register", "Email invalide");
                redirect("../index.php?page=register");
            }

            //User with the same email or password already exists
            if($this->userModel->findUserByEmail($data['email'])){
                flash("register", "Email déjà pris");
                redirect("../index.php?page=register");
            }

            if(strlen($data['pwd']) < 6){
                flash("register", "Mot de passe invalide (minimum 7 caractères)");
                redirect("../index.php?page=register");
            } else if($data['pwd'] !== $data['cPwd']){
                flash("register", "Les mots de passe ne correspondent pas");
                redirect("../index.php?page=register");
            }

            //Passed all validation checks.
            //Now going to hash password
            $data['pwd'] = password_hash($data['pwd'], PASSWORD_DEFAULT);
            
            //Register User
            if($this->userModel->register($data)){
                redirect("../index.php?page=login");
            }else{
                flash("register", "Une erreur est survenue");
                redirect("../index.php?page=login");
            }
            
        }

        

        public function validate() {
            $_POST = filter_input_array(INPUT_POST);

            $data = [
                'userEmail' => trim($_POST['email'])
            ];

            if ($this->userModel->findUserByEmail($data['userEmail'], null)) {
                if ($this->userModel->validateUser($data['userEmail'])) {
                    echo json_encode('validate');
                }
            }
        }

        public function delete() {
            $_POST = filter_input_array(INPUT_POST);

            $data = [
                'userEmail' => trim($_POST['email'])
            ];

            if ($this->userModel->findUserByEmail($data['userEmail'], null)) {
                if ($this->userModel->deleteUser($data['userEmail'])) {
                    echo json_encode('delete');
                }
            }
        }
        
        
    }

    $init = new Users;

    // Ensure that user is sending a POST request.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch ($_POST['type']) {
            case 'register':
                $init->register();
                break;
            case 'login':
                $init->login();
                break;
            case 'validate':
                $init->validate();
                break;
            case 'delete':
                $init->delete();
                break;
            default:
                redirect("../index.php");
        }

    }else{
        switch($_GET['q']){
            case 'logout':
                $init->logout();
                break;
            default:
            redirect("../index.php");
        }
    }


    