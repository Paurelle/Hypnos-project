<?php

    // Check if the establishment in the url is valid and not empty
    if(isset($_GET['establishment']) && !empty($_GET['establishment'])){

        require_once 'Controllers/Helpers/session_helper.php';
        require_once 'Functions/troqueChaine.php';

        require_once 'Models/Establishment.php';

        $establishmentModel = new Establishment;
        $establishmentInfo = $establishmentModel->selectEstablishmentByName($_GET['establishment']);

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
                //foreach () {

            ?>
            <div class="content-card">
                <div class="img-card">
                    <img src="Img/test.jpg" alt="">
                </div>
                <div class="title-card">
                    <a href="index.php?page=suite-info&suite=nomSuite">
                       <h3>Nom de la suite</h3>
                    </a>
                </div>
                <div class="btn-card">
                    <?php if (!isset($_SESSION['userHypnosRole']) || $_SESSION['userHypnosRole'] == 'customer') : ?>
                    <button>Réserver</button>
                    <?php endif; ?>
                </div>
                <div class="info-card">
                    <p>prix</p>
                </div>
                <div class="description-card">
                    <p>Lorem ipsum dolor sit amet. Ut perspiciatis quisquam ut voluptatem Quis in autem saepe exercitationem praesentium et saepe consequuntur...</p>
                </div>
            </div>
            <?php
                //}
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











    

