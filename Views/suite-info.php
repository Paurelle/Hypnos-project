<?php
    
    // Check if the establishment in the url is valid and not empty
    if(isset($_GET['establishment']) && !empty($_GET['establishment']) && isset($_GET['suite']) && !empty($_GET['suite'])){

        require_once 'Controllers/Helpers/session_helper.php';
        require_once 'Functions/troqueChaine.php';

        require_once 'Models/Suite.php';
        require_once 'Models/Establishment.php';

        $establishmentModel = new Establishment;
        $establishmentInfo = $establishmentModel->selectEstablishmentById($_GET['establishment']);

        $suiteModel = new Suite;
        $suiteInfo = $suiteModel->selectSuiteById($_GET['suite']);

        $suiteGallery = $suiteModel->selectSuiteGalleryByIdSuite($_GET['suite']);

        //Check if the suite was found
        if ($establishmentInfo && $suiteInfo) {
    
?>


<main>
    <div class="wrapper">

        <h1><?=ucfirst($suiteInfo->title)?></h1>

        <div class="info">
            <p><?=$suiteInfo->price?> €</p>
        </div>
        <div class="carousel owl-carousel">
            <?php
                foreach ($suiteGallery as $picture) {
                    echo '<div class="card"><img src="data:image/jpeg;base64,' . base64_encode( $picture->suite_picture ) . '" /></div>';
                }
            ?>
            
        </div>
        <div class="info">
            <hr>
            <p><?=ucfirst($suiteInfo->description)?></p>
            <p class="link">
                Réserver sur 
                <a href="index.php?page=reservation&establishment=<?=$establishmentInfo->id_establishment?>&suite=<?=$suiteInfo->id_suite?>">Hypnos</a>
                ou sur 
                <a href="<?=$suiteInfo->link?>">Booking</a>
            </p>
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

    
        












    

