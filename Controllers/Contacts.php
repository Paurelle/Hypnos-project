<?php

    require_once '../Models/Contact.php';
    require_once 'Helpers/session_helper.php';

    class Contacts {

        private $contactModel;

        public function __construct() {
            $this->contactModel = new Contact;
        }

        public function newMessage() {
    
            //Init data
            $data = [
                'name' => htmlspecialchars(trim($_POST['name'])),
                'lastname' => htmlspecialchars(trim($_POST['lastname'])),
                'email' => htmlspecialchars(trim($_POST['email'])),
                'establishment' => htmlspecialchars(trim($_POST['establishment'])),
                'subject' => htmlspecialchars(trim($_POST['subject'])),
                'description' => htmlspecialchars(trim($_POST['description']))
            ];

            // Validate inputs
            if (empty($data['name']) || empty($data['lastname']) || empty($data['email']) || 
            empty($data['establishment']) || empty($data['subject']) || empty($data['description'])) {
                flash("contact", "Veuillez remplir toutes les entrées");
                redirect("../index.php?page=contact");
            }

            if(!preg_match("/^[a-zA-Z]*$/", $data['name'])){
                flash("contact", "Nom invalide");
                redirect("../index.php?page=contact");
            }

            if(!preg_match("/^[a-zA-Z]*$/", $data['lastname'])){
                flash("contact", "Prénom invalide");
                redirect("../index.php?page=contact");
            }

            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                flash("contact", "Email invalide");
                redirect("../index.php?page=contact");
            }

            if ($data['establishment'] < 0) {
                flash("contact", "Établissement invalide");
                redirect("../index.php?page=contact");
            }
            
            if(!preg_match("/^[1-4]*$/", $data['subject'])){
                flash("contact", "Sujet invalide");
                redirect("../index.php?page=contact");
            }

            if(!(strlen($data['description']) <= 1024)){
                flash("contact", "Message trop long");
                redirect("../index.php?page=contact");
            }

            //Register new message
            if($this->contactModel->addNewMessage($data)){
                flash("contact", "Demmande envoyer", "form-message form-message-green");
                redirect("../index.php?page=contact");
            }else{
                flash("contact", "Une erreur est survenue");
                redirect("../index.php?page=contact");
            }
        }
    }

    $init = new Contacts;

    // Ensure that user is sending a POST request.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch ($_POST['type']) {
            case 'contact':
                $init->newMessage();
                break;
            default:
                redirect("../index.php");
        }

    }


    