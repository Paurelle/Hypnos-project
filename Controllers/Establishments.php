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

            // Init data
            $data = [
                'name' => htmlspecialchars(trim($_POST['name'])),
                'manager' => htmlspecialchars(trim($_POST['manager'])),
                'city' => htmlspecialchars(trim($_POST['city'])),
                'address' => htmlspecialchars(trim($_POST['address'])),
                'description' => htmlspecialchars(trim($_POST['description'])),
                'img' => $_FILES['img']
            ];

            // Validate inputs
            if (empty($data['name']) || empty($data['manager']) || empty($data['city']) || 
            empty($data['address']) || empty($data['description']) || empty($data['img'])) {
                flash("registerEstablishment", "Veuillez remplir toutes les entrées");
                redirect("../index.php?page=admin-establishment");
            }

            if(!preg_match("/^[ a-zA-Z,.+!:;()-À-ÖØ-öø-ÿ-]*$/", $data['name'])){
                flash("registerEstablishment", "Nom invalide");
                redirect("../index.php?page=admin-establishment");
            }

            // Find user by id
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

            if(!preg_match("/^[ a-zA-Z,.+!:;()-À-ÖØ-öø-ÿ-]*$/", $data['city'])){
                flash("registerEstablishment", "Ville invalide");
                redirect("../index.php?page=admin-establishment");
            }

            if(!preg_match("/^[ a-zA-Z0-9,.+!:;()-À-ÖØ-öø-ÿ-]*$/", $data['address'])){
                flash("registerEstablishment", "address invalide");
                redirect("../index.php?page=admin-establishment");
            }

            if(!(strlen($data['description']) <= 1024)){
                flash("contact", "Message trop long");
                redirect("../index.php?page=admin-establishment");
            }

            // Check if the image has been sent correctly and if there is no error
            if (isset($data['img']) AND $data['img']['error'] == 0) {
                // Check if the file is not too big
                if ($data['img']['size'] <= 3145728) {
                        // Check if the extension is allowed
                        $infosfichier = pathinfo($data['img']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('png', 'jpg');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            // Init img data
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
            } else {
                flash("registerEstablishment", "Une erreur est survenue");
                redirect("../index.php?page=admin-establishment");
            }
        }

        public function modifyEstablishment() {

            // Init data
            $data = [
                'id' => htmlspecialchars(trim($_POST['id_establishment'])),
                'name' => htmlspecialchars(trim($_POST['name'])),
                'manager' => htmlspecialchars(trim($_POST['manager'])),
                'city' => htmlspecialchars(trim($_POST['city'])),
                'address' => htmlspecialchars(trim($_POST['address'])),
                'description' => htmlspecialchars(trim($_POST['description'])),
                'img' => $_FILES['img']
            ];

            // Validate inputs
            if (empty($data['name']) || empty($data['manager']) || empty($data['city']) || 
            empty($data['address']) || empty($data['description'])) {
                flash("registerEstablishment", "Veuillez remplir toutes les entrées");
                redirect("../index.php?page=admin-establishment");
            }

            if(!preg_match("/^[ a-zA-Z,.+!:;()-À-ÖØ-öø-ÿ-]*$/", $data['name'])){
                flash("registerEstablishment", "Nom invalide");
                redirect("../index.php?page=admin-establishment");
            }

            // Find user by id
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

            if(!preg_match("/^[ a-zA-Z,.+!:;()-À-ÖØ-öø-ÿ-]*$/", $data['city'])){
                flash("registerEstablishment", "Ville invalide");
                redirect("../index.php?page=admin-establishment");
            }

            if(!preg_match("/^[ a-zA-Z0-9,.+!:;()-À-ÖØ-öø-ÿ-]*$/", $data['address'])){
                flash("registerEstablishment", "Ville invalide");
                redirect("../index.php?page=admin-establishment");
            }

            if(!(strlen($data['description']) <= 1024)){
                flash("contact", "Message trop long");
                redirect("../index.php?page=admin-establishment");
            }

            // Check if the image has been sent correctly and if there is no error
            if (isset($data['img']) AND $data['img']['error'] == 0) {
                // Check if the file is not too big
                if ($_FILES['img']['size'] <= 3145728) {
                        // Check if the extension is allowed
                        $infosfichier = pathinfo($_FILES['img']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('png', 'jpg');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            // Init img data
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
                // Select the old img by id
                $img = $this->establishmentModel->selectEstablishmentById($data['id']);
                // Init img data
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

            // Init data
            $data = [
                'id' => htmlspecialchars(trim($_POST['id']))
            ];

            // Delete establishment by id
            if($this->establishmentModel->deleteEstablishment($data['id'])) {
                echo json_encode(true);
            }
        }
        
        public function selectEstablishmentById() {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'id' => htmlspecialchars(trim($_POST['id']))
            ];

            // Select establishment by id
            $rowEstablishment = $this->establishmentModel->selectEstablishmentById($data['id']);
            if ($rowEstablishment) {
                // Select manager by id
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


    