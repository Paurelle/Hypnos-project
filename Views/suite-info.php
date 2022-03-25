<?php
    
    // Check if the establishment in the url is valid and not empty
    if(isset($_GET['suite']) && !empty($_GET['suite'])){

        require_once 'Controllers/Helpers/session_helper.php';
        require_once 'Functions/troqueChaine.php';

        require_once 'Models/Suite.php';

        $suiteModel = new Suite;
        $suiteInfo = $suiteModel->selectSuiteByName($_GET['suite']);
        $suiteGallery = $suiteModel->selectSuiteGalleryByIdSuite($suiteInfo->id_suite);

        //Check if the establishment was found
        if ($suiteInfo) {
    
?>


<main>
    <div class="wrapper">

        <h1><?=$suiteInfo->title?></h1>

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
            <p><?=$suiteInfo->description?></p>
            <p class="link">Réserver sur <a href="">Hypnos</a> ou sur <a href="">Booking</a></p>
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

    
        












    

