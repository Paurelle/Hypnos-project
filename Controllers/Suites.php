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

            // Init data
            $data = [
                'id_establishment' => trim($_POST['id_establishment']),
                'name' => htmlspecialchars(trim($_POST['name'])),
                'price' => htmlspecialchars(trim($_POST['price'])),
                'link' => htmlspecialchars(trim($_POST['link'])),
                'description' => htmlspecialchars(trim($_POST['description'])),
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

            if(!preg_match("/^[ a-zA-Z,.+!?\"'`:;()-À-ÖØ-öø-ÿ-]*$/", $data['name'])){
                flash("registerSuite", "Nom invalide");
                redirect("../index.php?page=manager-suite");
            }
            
            $establishment = $this->establishmentModel->selectEstablishmentFromUserId($_SESSION['userHypnosId']);
            if ($this->suiteModel->selectSuiteByNameAndEstablishmentId($data['name'], $establishment->id_establishment)) {
                flash("registerSuite", "Nom de la suite déjà pris");
                redirect("../index.php?page=manager-suite");
            }
            
            if(!preg_match("/^[0-9]*$/", $data['price'])){
                flash("registerSuite", "Prix invalide");
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
                        $extensions_autorisees = array('png', 'jpg');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            // Init img data
                            $data['imgName'] = $data['featuredImg']['name'];
                            $data['imgData'] = file_get_contents($data['featuredImg']['tmp_name']);
                            // register establishment
                            if($this->suiteModel->registerSuite($data)) {
                                if ($this->addSuiteGallery($data, $this->suiteModel->selectIdSuiteFromLastSuite()->id_suite)) {
                                    flash("registerSuite", "La suite a bien etait créer", "form-message form-message-green");
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
                
                // Check if there is no error
                if ($data['gallery']['error'][$i] == 0) {
                    // Check if the file is not too big
                    if ($data['gallery']['size'][$i] <= 3145728) {
                            // Check if the extension is allowed
                            $infosfichier = pathinfo($data['gallery']['name'][$i]);
                            $extension_upload = $infosfichier['extension'];
                            $extensions_autorisees = array('png', 'jpg');
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

            // Init data
            $data = [
                'id_suite' => htmlspecialchars(trim($_POST['id_suite'])),
                'name' => htmlspecialchars(trim($_POST['name'])),
                'price' => htmlspecialchars(trim($_POST['price'])),
                'link' => htmlspecialchars(trim($_POST['link'])),
                'description' => htmlspecialchars(trim($_POST['description'])),
                'featuredImg' => $_FILES['featuredImg'],
                'gallery' => $_FILES['gallery']
            ];

            // Validate inputs
            if (empty($data['id_suite']) || empty($data['name']) || empty($data['price']) || 
            empty($data['link']) || empty($data['description']) || empty($data['featuredImg'])) {
                flash("registerSuite", "Veuillez remplir toutes les entrées");
                redirect("../index.php?page=manager-suite");
            }
            // Find suite by id
            if (!$this->suiteModel->selectSuiteById($data['id_suite'])) {
                flash("registerSuite", "Établissement invalide");
                redirect("../index.php?page=manager-suite");
            }

            if(!preg_match("/^[ a-zA-Z,.+!?\"'`:;()-À-ÖØ-öø-ÿ-]*$/", $data['name'])){
                flash("registerSuite", "Nom invalide");
                redirect("../index.php?page=manager-suite");
            }
            
            if(!preg_match("/^[0-9]*$/", $data['price'])){
                flash("registerSuite", "Prix invalide");
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
                        $extensions_autorisees = array('png', 'jpg');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            // Init img data
                            $data['imgName'] = $data['featuredImg']['name'];
                            $data['imgData'] = file_get_contents($data['featuredImg']['tmp_name']);
                            // register establishment
                            if($this->suiteModel->modifySuite($data)) {
                                if ($this->modifySuiteGallery($data)) {
                                    flash("registerSuite", "La suite a bien etait modifier", "form-message form-message-green");
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
                // Select the old img by id
                $img = $this->suiteModel->selectSuiteById($data['id_suite']);
                // Init img data
                $data['imgName'] = $img->featured_img_name;
                $data['imgData'] = $img->featured_img;
                
                // modify establishment
                if($this->suiteModel->modifySuite($data)) {
                    flash("registerSuite", "La suite a bien etait modifier", "form-message form-message-green");
                    redirect("../index.php?page=manager-suite");
                }else{
                    flash("registerSuite", "Une erreur est survenue");
                    redirect("../index.php?page=manager-suite");
                }
            }
        }

        public function modifySuiteGallery($data) {
            $img = [];
            array_push($img, [
                'imgName' => $data['imgName'],
                'imgData' => $data['imgData']
            ]);
            for ($i=0; $i < count($data['gallery']['name']); $i++) { 
                
                // Check if there is no error
                if ($data['gallery']['error'][$i] == 0) {
                    // Check if the file is not too big
                    if ($data['gallery']['size'][$i] <= 3145728) {
                            // Check if the extension is allowed
                            $infosfichier = pathinfo($data['gallery']['name'][$i]);
                            $extension_upload = $infosfichier['extension'];
                            $extensions_autorisees = array('png', 'jpg');
                            if (in_array($extension_upload, $extensions_autorisees)) {
                                // Init img data
                                array_push($img, [
                                    'imgName' => $data['gallery']['name'][$i],
                                    'imgData' => file_get_contents($data['gallery']['tmp_name'][$i])
                                ]);
                                $this->suiteModel->deleteSuiteGallery($data['id_suite']);
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
                if (!$this->suiteModel->registerSuiteGallery($img[$i], $data['id_suite'])) {
                    flash("registerSuite", "Une erreur est survenue");
                    redirect("../index.php?page=manager-suite");
                }
            }
            return true;
        }

        public function deleteSuite() {

            // Init data
            $data = [
                'id' => trim($_POST['id'])
            ];

            // Delete suite by id
            if($this->suiteModel->deleteSuite($data['id'])) {
                echo json_encode(true);
            }
        }
        
        public function selectSuiteById() {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'id' => htmlspecialchars(trim($_POST['id']))
            ];
            // Select suite by id
            $rowSuite = $this->suiteModel->selectSuiteById($data['id']);
            $rowSuiteGallery = $this->suiteModel->selectSuiteGalleryByIdSuite($data['id']);
            if ($rowSuite) {
                $suite = array(
                    'id_suite' => $rowSuite->id_suite, 
                    'id_establishment' => $rowSuite->id_establishment, 
                    'title' => $rowSuite->title, 
                    'price' => $rowSuite->price, 
                    'description' => $rowSuite->description,
                    'img_name' => $rowSuite->featured_img_name,
                    'img_gallery_name' => count($rowSuiteGallery),
                    'link' => $rowSuite->link);
            }
            echo json_encode($suite);
        }

        public function selectSuite() {

            // Init data
            $data = [
                'id_establishment' => htmlspecialchars(trim($_POST['id_establishment']))
            ];

            $rows = $this->suiteModel->selectAllFromSuiteByIdEstablishment($data['id_establishment']);
            if ($rows) {
                $suites = [];
                foreach ($rows as $row) {
                    array_push($suites, [$row->id_suite, $row->title, $row->price]);
                }
                echo json_encode($suites);
            }
            

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
            case 'selectSuite':
                $init->selectSuite();
                break;
            default:
                redirect("../index.php");
        }

    }


    