<?php

    require_once '../Models/Establishment.php';
    require_once 'Helpers/session_helper.php';

    class Establishments {

        private $establishmentModel;

        public function __construct(){
            $this->establishmentModel = new Establishment;
        }

       
        
        
    }

    $init = new Establishments;

    // Ensure that user is sending a POST request.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch ($_POST['type']) {
            
            default:
                redirect("../index.php");
        }

    }


    