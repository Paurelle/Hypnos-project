<?php

    // Check if the establishment in the url is valid and not empty
    if(isset($_GET['establishment']) && !empty($_GET['establishment'])){

        require_once 'Controllers/Helpers/session_helper.php';
        require_once 'Functions/troqueChaine.php';

        require_once 'Models/Establishment.php';
        require_once 'Models/Suite.php';

        $establishmentModel = new Establishment;
        $establishmentInfo = $establishmentModel->selectEstablishmentById($_GET['establishment']);
        $suiteModel = new Suite;
        $suites = $suiteModel->selectAllFromSuiteByIdEstablishment($_GET['establishment']);
        //Check if the establishment was found
        if ($establishmentInfo) {

        

?>

<main>
    <div class="wrapper">
        
        <h1><?=$establishmentInfo->name?></h1>

        <div class="info">
            <p><?=$establishmentInfo->city?>, <?=$establishmentInfo->address?></p>
            <p><?=$establishmentInfo->description?></p>
            <hr>
        </div>
        
        <h2>Les Suites</h2>
        
        <div class="suite">
            <?php
            if ($suites) {
            
                foreach ($suites as $suite) {

            ?>
            <div class="content-card">
                <div class="img-card">
                    <?='<img src="data:image/jpeg;base64,' . base64_encode($suite->featured_img) . '" />';?>
                </div>
                <div class="title-card">
                    <a href="index.php?page=suite-info&establishment=<?=$establishmentInfo->id_establishment?>&suite=<?=$suite->id_suite?>">
                       <h3><?=$suite->title?></h3>
                    </a>
                </div>
                <div class="btn-card">
                    <?php if (!isset($_SESSION['userHypnosRole']) || $_SESSION['userHypnosRole'] == 'customer') : ?>
                    <a href="index.php?page=reservation&establishment=<?=$establishmentInfo->id_establishment?>&suite=<?=$suite->id_suite?>">Réserver</a>
                    <?php endif; ?>
                </div>
                <div class="info-card">
                    <p><?=$suite->price.' €'?></p>
                </div>
                <div class="description-card">
                    <p><?=tronque_chaine($suite->description, 135)?></p>
                </div>
            </div>
            <?php
                }
            }
            ?>
            
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











    

