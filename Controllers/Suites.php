<?php

    require_once 'Helpers/session_helper.php';
    require_once '../Models/Suite.php';
    require_once '../Models/Establishment.php';

    class Suites {

        private $suiteModel;
        private $establishmentModel;

        public function __construct() {
            $this->suiteModel = new Suite;
            $this->establishmentModel = new Establishment;
        }

        public function addSuite() {

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'id_establishment' => trim($_POST['id_establishment']),
                'name' => trim($_POST['name']),
                'price' => trim($_POST['price']),
                'link' => trim($_POST['link']),
                'description' => trim($_POST['description']),
                'featuredImg' => $_FILES['featuredImg'],
                'gallery' => $_FILES['gallery']
            ];

            // Validate inputs
            if (empty($data['id_establishment']) || empty($data['name']) || empty($data['price']) || empty($data['link']) || 
            empty($data['description']) || empty($data['featuredImg']) || !isset($data['gallery'])) {
                flash("registerSuite", "Veuillez remplir toutes les entrées");
                redirect("../index.php?page=manager-suite");
            }
            // Find establishment by id
            if (!$this->establishmentModel->selectEstablishmentById($data['id_establishment'])) {
                flash("registerSuite", "Établissement invalide");
                redirect("../index.php?page=manager-suite");
            }

            if(!preg_match("/^[ a-zA-Z,.+!:;()-]*$/", $data['name'])){
                flash("registerSuite", "Nom invalide");
                redirect("../index.php?page=manager-suite");
            }
            
            if(!preg_match("/^[0-9]*$/", $data['price'])){
                flash("registerSuite", "Nom invalide");
                redirect("../index.php?page=manager-suite");
            }

            if(!(strlen($data['description']) <= 1024)){
                flash("contact", "Message trop long");
                redirect("../index.php?page=manager-suite");
            }

            // Check if the image has been sent correctly and if there is no error
            if (isset($data['featuredImg']) AND $data['featuredImg']['error'] == 0) {
                // Check if the file is not too big
                if ($data['featuredImg']['size'] <= 3145728) {
                        // Check if the extension is allowed
                        $infosfichier = pathinfo($data['featuredImg']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('png');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            // Init img data
                            $data['imgName'] = $data['featuredImg']['name'];
                            $data['imgData'] = file_get_contents($data['featuredImg']['tmp_name']);
                            // register establishment
                            if($this->suiteModel->registerSuite($data)) {
                                if ($this->addSuiteGallery($data, $this->suiteModel->selectIdSuiteFromLastSuite()->id_suite)) {
                                    flash("registerSuite", "L'établissement a bien etait créer", "form-message form-message-green");
                                    redirect("../index.php?page=manager-suite");
                                }
                            }else{
                                flash("registerSuite", "Une erreur est survenue");
                                redirect("../index.php?page=manager-suite");
                            }
                        }
                        else {
                            flash("registerSuite", "Image aux mauvais formats");
                            redirect("../index.php?page=manager-suite");
                        }
                }
                else {
                    flash("registerSuite", "Image trop volumineuse");
                    redirect("../index.php?page=manager-suite");
                }
            } else {
                flash("registerSuite", "Une erreur est survenue");
                redirect("../index.php?page=manager-suite");
            }
        }

        public function addSuiteGallery($data, $id_suite) {
            $img = [];
            array_push($img, [
                'imgName' => $data['imgName'],
                'imgData' => $data['imgData']
            ]);
            for ($i=0; $i < count($data['gallery']['name']); $i++) { 
                
                var_dump($data['gallery']['name'][$i]);
                // Check if there is no error
                if ($data['gallery']['error'][$i] == 0) {
                    // Check if the file is not too big
                    if ($data['gallery']['size'][$i] <= 3145728) {
                            // Check if the extension is allowed
                            $infosfichier = pathinfo($data['gallery']['name'][$i]);
                            $extension_upload = $infosfichier['extension'];
                            $extensions_autorisees = array('png');
                            if (in_array($extension_upload, $extensions_autorisees)) {
                                // Init img data
                                array_push($img, [
                                    'imgName' => $data['gallery']['name'][$i],
                                    'imgData' => file_get_contents($data['gallery']['tmp_name'][$i])
                                ]);
                            }
                            else {
                                flash("registerSuite", "Une image aux mauvais formats");
                                redirect("../index.php?page=manager-suite");
                            }
                    }
                    else {
                        flash("registerSuite", "Une image trop volumineuse");
                        redirect("../index.php?page=manager-suite");
                    }
                } else {
                    flash("registerSuite", "Une erreur est survenue");
                    redirect("../index.php?page=manager-suite");
                }
            }
            for ($i=0; $i < count($img); $i++) { 
                if (!$this->suiteModel->registerSuiteGallery($img[$i], $id_suite)) {
                    flash("registerSuite", "Une erreur est survenue");
                    redirect("../index.php?page=manager-suite");
                }
            }
            return true;
        }

        public function modifySuite() {
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

            // Check if the image has been sent correctly and if there is no error
            if (isset($data['img']) AND $data['img']['error'] == 0) {
                // Check if the file is not too big
                if ($_FILES['img']['size'] <= 3145728) {
                        // Check if the extension is allowed
                        $infosfichier = pathinfo($_FILES['img']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('png');
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

        public function deleteSuite() {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'id' => trim($_POST['id'])
            ];

            // Delete establishment by id
            if($this->establishmentModel->deleteEstablishment($data['id'])) {
                echo json_encode(true);
            }
        }
        
        public function selectSuiteById() {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'id' => trim($_POST['id'])
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

    $init = new Suites;

    // Ensure that user is sending a POST request.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch ($_POST['type']) {
            case 'addSuite':
                $init->addSuite();
                break;
            case 'modifySuite':
                $init->modifySuite();
                break;
            case 'deleteSuite':
                $init->deleteSuite();
                break;
            case 'infoSuite':
                $init->selectSuiteById();
                break;
            default:
                redirect("../index.php");
        }

    }


    