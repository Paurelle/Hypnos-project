<?php

    

    require_once 'Controllers/Helpers/session_helper.php';
    require_once 'Functions/troqueChaine.php';

    require_once 'Models/Establishment.php';

    $establishmentModel = new Establishment;
    $allEstablishments = $establishmentModel->selectAllFromEstablishment();
    
?>

<main>
    <div class="wrapper">
        <h1>Catalogue</h1>
        <div class="catalog">

        <?php
            if ( $allEstablishments) {
                foreach ($allEstablishments as $allEstablishment) {
        ?>
            <div class="content-card">
                <div class="img-card">
                    <?='<img src="data:image/jpeg;base64,' . base64_encode($allEstablishment->establishment_picture) . '" />';?>
                </div>
                <div class="title-card">
                    <a  href="index.php?page=establishment-info&establishment=<?=$allEstablishment->id_establishment?>">
                       <h3><?=$allEstablishment->name?></h3>
                    </a>
                </div>
                <div class="info-card">
                    <p><?=$allEstablishment->city?>, <?=$allEstablishment->address?></p>
                </div>
                <div class="description-card">
                    <p><?=tronque_chaine($allEstablishment->description, 135)?></p>
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













    

