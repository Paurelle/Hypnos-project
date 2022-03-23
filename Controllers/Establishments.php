<?php

    require_once 'Helpers/session_helper.php';
    require_once '../Models/Establishment.php';
    require_once '../Models/User.php';

    class Establishments {

        private $establishmentModel;
        private $userModel;

        public function __construct() {
            $this->establishmentModel = new Establishment;
            $this->userModel = new User;
        }

        public function addEstablishment() {

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'name' => trim($_POST['name']),
                'manager' => trim($_POST['manager']),
                'city' => trim($_POST['city']),
                'address' => trim($_POST['address']),
                'description' => trim($_POST['description']),
                'img' => $_FILES['img']
            ];
            // Validate inputs
            if (empty($data['name']) || empty($data['manager']) || empty($data['city']) || 
            empty($data['address']) || empty($data['description']) || empty($data['img'])) {
                flash("registerEstablishment", "Veuillez remplir toutes les entrées");
                redirect("../index.php?page=admin-establishment");
            }

            if(!preg_match("/^[ a-zA-Z,.+!:;()-]*$/", $data['name'])){
                flash("registerEstablishment", "Nom invalide");
                redirect("../index.php?page=admin-establishment");
            }

            $manager = $this->userModel->findUserById($data['manager']);
            if($manager){
                if ($manager->role != 'manager') {
                    flash("registerEstablishment", "Manager invalide");
                    redirect("../index.php?page=admin-establishment");
                }
            } else {
                flash("registerEstablishment", "Manager invalide");
                redirect("../index.php?page=admin-establishment");
            }

            if(!preg_match("/^[ a-zA-Z,.+!:;()-]*$/", $data['city'])){
                flash("registerEstablishment", "Ville invalide");
                redirect("../index.php?page=admin-establishment");
            }

            if(!preg_match("/^[ a-zA-Z0-9,.+!:;()-]*$/", $data['address'])){
                flash("registerEstablishment", "Ville invalide");
                redirect("../index.php?page=admin-establishment");
            }

            if(!(strlen($data['description']) <= 1024)){
                flash("contact", "Message trop long");
                redirect("../index.php?page=admin-establishment");
            }

            // Testons si le fichier n'est pas trop gros
            if ($data['img']['size'] <= 3145728) {
                    // Testons si l'extension est autorisée
                    $infosfichier = pathinfo($data['img']['name']);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('png');
                    if (in_array($extension_upload, $extensions_autorisees)) {
                        $data['imgName'] = $data['img']['name'];
                        $data['imgData'] = file_get_contents($data['img']['tmp_name']);
                        // register establishment
                        if($this->establishmentModel->registerEstablishment($data)) {
                            flash("registerManager", "L'établissement a bien etait créer", "form-message form-message-green");
                            redirect("../index.php?page=admin-establishment");
                        }else{
                            flash("registerEstablishment", "Une erreur est survenue");
                            redirect("../index.php?page=admin-establishment");
                        }
                    }
                    else {
                        flash("registerEstablishment", "Image aux mauvais formats");
                        redirect("../index.php?page=admin-establishment");
                    }
            }
            else {
                flash("registerEstablishment", "Image trop volumineuse");
                redirect("../index.php?page=admin-establishment");
            }
            
        }

        public function modifyEstablishment() {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'id' => trim($_POST['id_establishment']),
                'name' => trim($_POST['name']),
                'manager' => trim($_POST['manager']),
                'city' => trim($_POST['city']),
                'address' => trim($_POST['address']),
                'description' => trim($_POST['description']),
                'img' => $_FILES['img']
            ];
            // Validate inputs
            if (empty($data['name']) || empty($data['manager']) || empty($data['city']) || 
            empty($data['address']) || empty($data['description'])) {
                flash("registerEstablishment", "Veuillez remplir toutes les entrées");
                redirect("../index.php?page=admin-establishment");
            }

            if(!preg_match("/^[ a-zA-Z,.+!:;()-]*$/", $data['name'])){
                flash("registerEstablishment", "Nom invalide");
                redirect("../index.php?page=admin-establishment");
            }

            $manager = $this->userModel->findUserById($data['manager']);
            if($manager){
                if ($manager->role != 'manager') {
                    flash("registerEstablishment", "Manager invalide");
                    redirect("../index.php?page=admin-establishment");
                }
            } else {
                flash("registerEstablishment", "Manager invalide");
                redirect("../index.php?page=admin-establishment");
            }

            if(!preg_match("/^[ a-zA-Z,.+!:;()-]*$/", $data['city'])){
                flash("registerEstablishment", "Ville invalide");
                redirect("../index.php?page=admin-establishment");
            }

            if(!preg_match("/^[ a-zA-Z0-9,.+!:;()-]*$/", $data['address'])){
                flash("registerEstablishment", "Ville invalide");
                redirect("../index.php?page=admin-establishment");
            }

            if(!(strlen($data['description']) <= 1024)){
                flash("contact", "Message trop long");
                redirect("../index.php?page=admin-establishment");
            }

            // Testons si l'image a bien été envoyé et s'il n'y a pas d'erreur
            if (isset($data['img']) AND $data['img']['error'] == 0) {
                // Testons si le fichier n'est pas trop gros
                if ($_FILES['img']['size'] <= 3145728) {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['img']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('png');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            $data['imgName'] = $data['img']['name'];
                            $data['imgData'] = file_get_contents($data['img']['tmp_name']);
                            // modify establishment
                            if($this->establishmentModel->modifyEstablishment($data)) {
                                flash("registerEstablishment", "L'établissement a bien etait créer", "form-message form-message-green");
                                redirect("../index.php?page=admin-establishment");
                            }else{
                                flash("registerEstablishment", "Une erreur est survenue");
                                redirect("../index.php?page=admin-establishment");
                            }
                        }
                        else {
                            flash("registerEstablishment", "Image aux mauvais formats");
                            redirect("../index.php?page=admin-establishment");
                        }
                } else {
                    flash("registerEstablishment", "Image trop volumineuse");
                    redirect("../index.php?page=admin-establishment");
                }
            } else {
                $img = $this->establishmentModel->selectEstablishmentById($data['id']);
                $data['imgName'] = $img->establishment_picture_name;
                $data['imgData'] = $img->establishment_picture;
                
                // modify establishment
                if($this->establishmentModel->modifyEstablishment($data)) {
                    flash("registerEstablishment", "L'établissement a bien etait modifier", "form-message form-message-green");
                    redirect("../index.php?page=admin-establishment");
                }else{
                    flash("registerEstablishment", "Une erreur est survenue");
                    redirect("../index.php?page=admin-establishment");
                }
            }
        }

        public function deleteEstablishment() {
            $_POST = filter_input_array(INPUT_POST);
            $data = [
                'id' => trim($_POST['id'])
            ];
            if($this->establishmentModel->deleteEstablishment($data['id'])) {
                echo json_encode('');
            }
        }
        
        public function selectEstablishmentById() {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);
            // Init data
            $data = [
                'id' => trim($_POST['id'])
            ];

            $rowEstablishment = $this->establishmentModel->selectEstablishmentById($data['id']);
            if ($rowEstablishment) {
                $manager = $this->userModel->findUserById($rowEstablishment->id_user);
                $establishment = array(
                    'id' => $rowEstablishment->id_establishment, 
                    'name' => $rowEstablishment->name, 
                    'id_user' => $rowEstablishment->id_user, 
                    'user_name' => $manager->name." ".$manager->lastname, 
                    'city' => $rowEstablishment->city, 
                    'address' => $rowEstablishment->address, 
                    'description' => $rowEstablishment->description,
                    'img_name' => $rowEstablishment->establishment_picture_name);
            }
            echo json_encode($establishment);
        }
        
        
    }

    $init = new Establishments;

    // Ensure that user is sending a POST request.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch ($_POST['type']) {
            case 'addEstablishment':
                $init->addEstablishment();
                break;
            case 'modifyEstablishment':
                $init->modifyEstablishment();
                break;
            case 'deleteEstablishment':
                $init->deleteEstablishment();
                break;
            case 'infoEstablishment':
                $init->selectEstablishmentById();
                break;
            default:
                redirect("../index.php");
        }

    }


    