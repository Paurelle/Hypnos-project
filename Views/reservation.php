<?php

    require_once 'Controllers/Helpers/session_helper.php';
    require_once 'Functions/troqueChaine.php';

    require_once 'Models/Establishment.php';
    require_once 'Models/Suite.php';

    $establishmentModel = new Establishment;
    $allEstablishments = $establishmentModel->selectAllFromEstablishment();
    $suiteModel = new Suite;
    $allsuites = $suiteModel->selectAllFromSuite();


    
?>

<main>
    <div class="wrapper">
        <h1>Réserver une suite</h1>
        <?=flash("reservation")?>
        <form method="POST" action="Controllers/Reservations.php">
            <input type="hidden" name="type" value="addReservation">

            <label for="establishment">Choisissez l’établissement</label>
            <select name="establishment" id="establishment" class="input-form">
                <option></option>
                <?php
                    foreach ($allEstablishments as $Establishment) {
                ?>
                <option value="<?=$Establishment->id_establishment?>"><?=$Establishment->name?></option>
                <?php
                    }
                ?>
            </select>
            

            <label for="suite">Choisissez la suite</label>
            <select name="suite" id="suite" class="input-form">
                <option></option>
            </select>
            
            <label for="startDate">Date de debut</label>
            <input type="date" id="startDate" class="input-form" name="startDate">

            <label for="endDate">Date de fin</label>
            <input type="date" id="endDate" class="input-form" name="endDate">
            
            <button type="submit" class="input-form button-submit">Réserver</button>
        </form>
    </div>
</main>

<?php



    

