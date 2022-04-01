
<?php

    if (isset($_SESSION['userHypnosId'])) {
        if ($_SESSION['userHypnosRole'] == 'customer') {

            require_once 'Functions/troqueChaine.php';

            require_once 'Models/Reservation.php';

            $reservationModel = new Reservation;
            $reservations = $reservationModel->selectReservationByUserId($_SESSION['userHypnosId']);
            
?>

<main>
    <div class="wrapper">
        <div class="info">
            <h1>Mon profil</h1>
            <p><?=ucfirst($_SESSION['userHypnosName'])?> <?=ucfirst($_SESSION['userHypnosLastname'])?></p>
            <p><?=$_SESSION['userHypnosEmail']?></p>
            <hr>
        </div>
        <div class="reservation">
            <h2>Réservation</h2>

            <table>
                <thead>
                    <tr>
                        <th class="col1">Hôtel</th>
                        <th class="col2">Suite</th>
                        <th class="col3">Prix</th>
                        <th class="col4">Date de réservation</th>
                        <th class="col5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (!empty($reservations)) {
                            foreach ($reservations as $reservation) {
                    ?>
                    <tr id="<?=$reservation->id_reservation?>">
                        <td class="col1"><?=$reservation->name?></td>
                        <td class="col2"><?=$reservation->title?></td>
                        <td class="col3"><?=$reservation->price."€"?></td>
                        <td class="col4"><?=date('d-m-Y', strtotime($reservation->start_date)).'<br> aux <br>'.date('d-m-Y', strtotime($reservation->end_date))?></td>
                        <td class="col5"><button class="deleteBtn">Annuler</button></td>
                    </tr>
                    <?php
                            }  
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
</main>


<?php
        } else {
            header("location: index.php?page=error");
        }
    } else {
        header("location: index.php?page=error");
    }










    

