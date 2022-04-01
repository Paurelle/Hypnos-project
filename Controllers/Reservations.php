<?php

    require_once 'Helpers/session_helper.php';
    require_once '../Models/Reservation.php';

    class Reservations {

        private $reservationModel;

        public function __construct() {
            $this->reservationModel = new Reservation;
        }

        public function addReservation() {

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'id_user' => $_SESSION['userHypnosId'],
                'id_establishment' => trim($_POST['establishment']),
                'id_suite' => trim($_POST['suite']),
                'startDate' => $_POST['startDate'],
                'endDate' => $_POST['endDate'],
                'price' => 0
            ];

            // Validate inputs
            if (empty($data['id_establishment']) || empty($data['id_suite']) || 
            empty($data['startDate']) || empty($data['endDate'])) {
                flash("reservation", "Veuillez remplir toutes les entrées");
                redirect("../index.php?page=reservation");
            }

            if ($data['id_user'] == NULL) {
                flash("login", "Veuillez vous connectez pour pouvoir réserver");
                redirect("../index.php?page=login");
            }

            if (!$this->reservationModel->selectSuiteByIdAndEstablishmentById($data['id_suite'], $data['id_establishment'])) {
                flash("reservation", "La suite ou l'établissement est invalide");
                redirect("../index.php?page=reservation");
            }
            
            if (strtotime($data['startDate']) > strtotime($data['endDate'])) {
                flash("reservation", "Les dates sont invalide");
                redirect("../index.php?page=reservation");
            }

            $rows = $this->reservationModel->selectReservationBySuiteIdAndEstablishmentId($data['id_suite'], $data['id_establishment']);
            if ($rows) {
                foreach ($rows as $row) {
                    // Check if interval < interval ddb or interval > interval ddb
                    if (!
                        ((strtotime($row->start_date) > strtotime($data['startDate']) && strtotime($row->start_date) > strtotime($data['endDate'])) ||
                        (strtotime($row->end_date) < strtotime($data['startDate']) && strtotime($row->end_date) < strtotime($data['endDate'])))
                        ) {
                        flash("reservation", "Réservation impossible");
                        redirect("../index.php?page=reservation");
                    }
                }
            }

            // Calculate the total amount
            $suite = $this->reservationModel->selectSuiteByIdAndEstablishmentById($data['id_suite'], $data['id_establishment']);
            $reservationDays = (ceil((strtotime($data['endDate']) - strtotime($data['startDate'])) / 86400)+1);
            $data['price'] = $reservationDays*$suite->price;
                        
            // Add reservation
            if($this->reservationModel->addReservation($data)) {
                flash("reservation", "La réservation a bien etait ajouter, cela vous fera ".$data['price']."€ pour ".$reservationDays." jours", "form-message form-message-green");
                redirect("../index.php?page=reservation");
            }
            
        }

        public function checkReservation() {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'id_establishment' => trim($_POST['id_establishment']),
                'id_suite' => trim($_POST['id_suite']),
                'startDate' => strtotime($_POST['startDate']),
                'endDate' => strtotime($_POST['endDate'])
            ];
            
            $rows = $this->reservationModel->selectReservationBySuiteIdAndEstablishmentId($data['id_suite'], $data['id_establishment']);
            
            
            if ($rows) {
                $interval = true;
                foreach ($rows as $row) {
                    
                    // Check if interval < interval ddb or interval > interval ddb
                    if (!
                        ((strtotime($row->start_date) > $data['startDate'] && strtotime($row->start_date) > $data['endDate']) ||
                        (strtotime($row->end_date) < $data['startDate'] && strtotime($row->end_date) < $data['endDate']))
                    ) {
                        $interval = false;
                    }
                }
                if ($interval) {
                    echo json_encode(true);
                } else {
                    echo json_encode(false);
                }
            } else {
                echo json_encode(true);
            }
            
        }

        public function deleteReservation() {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'id_reservation' => trim($_POST['id_reservation']),
                'id_user' => $_SESSION['userHypnosId']
            ];

            $reservation = $this->reservationModel->selectReservationByReservationAndUserId($data['id_reservation'], $data['id_user']);
            if ($reservation) {
              
                $deleteLimite = strtotime($reservation->start_date."- 3 days");
                $currentDate = time();

                // Check if the user can delete his reservation before 3 days of his reservation
                if ($currentDate < $deleteLimite) {
                    // Delete reservation 
                    if($this->reservationModel->deleteReservation($data['id_reservation'], $data['id_user'])) {
                        echo json_encode(true);
                    }
                } else {
                    echo json_encode("limite");
                }
            } else {
                echo json_encode(false);
            }
        }
        
    }

    $init = new Reservations;

    // Ensure that user is sending a POST request.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch ($_POST['type']) {
            case 'addReservation':
                $init->addReservation();
                break;
            case 'checkReservation':
                $init->checkReservation();
                break;
            case 'delete':
                $init->deleteReservation();
                break;
            default:
                redirect("../index.php");
        }

    }


    