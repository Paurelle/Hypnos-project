<?php

    if (isset($_SESSION['userHypnosId'])) {
        if ($_SESSION['userHypnosRole'] == 'manager') {

            require_once 'Functions/troqueChaine.php';

            require_once 'Models/Establishment.php';
            require_once 'Models/Suite.php';

            $establishmentModel = new Establishment;
            $establishment = $establishmentModel->selectEstablishmentFromUserId($_SESSION['userHypnosId']);
            
            $suiteModel = new Suite;
            $allSuites = $suiteModel->selectAllFromSuite();
            $allSuitesGallery = $suiteModel->selectAllFromSuiteGallery();
            
?>

<main>
    <div class="wrapper">
        <div class="info">
            <h1>Manager interface</h1>
            <?php if ($establishment) : ?>
            <p>Hôtel, <?=ucfirst($establishment->name)?></p>
            <?php else : ?>
            <p>Hôtel, non attribué</p>
            <?php endif; ?>
            <hr>
        </div>
        
        <h2>Suite</h2>
        <?php flash('registerSuite'); ?>
        
        <div class="suite">
            
            <?php if ($establishment) : ?>
            <button class="addBtn">Ajouter une suite</button>
        
            <?php
                if ($allSuites) {
                    foreach ($allSuites as $allSuite) {
                        if ($establishment->id_establishment == $allSuite->id_establishment) {
                        
            ?>
            <div id="<?=$allSuite->id_suite?>" class="content-card">
                <div class="img-card">
                    <?='<img src="data:image/jpeg;base64,' . base64_encode($allSuite->featured_img) . '" />';?>
                </div>
                <div class="title-card">
                    <a href="index.php?page=suite-info&establishment=<?=$establishment->id_establishment?>&suite=<?=$allSuite->id_suite?>">
                    <h3><?=ucfirst($allSuite->title)?></h3>
                    </a>
                </div>
                <div class="btn-card">
                    <button class="modifyBtn"><img src="Img/pencil.svg" alt=""></button>
                    <button class="deleteBtn"><img src="Img/trash.svg" alt=""></button>
                </div>
                <div class="info-card">
                    <p><?=$allSuite->price?> €</p>
                </div>
                <div class="description-card">
                    <p><?=ucfirst(tronque_chaine($allSuite->description, 135))?></p>
                </div>
            </div>
            <?php
                        }
                    }
                }
            ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- The Modal -->
    <div id="modalForm" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3></h3>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form method="POST" action="Controllers/Suites.php" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="">
                    <input type="hidden" id="id_suite" name="id_suite" value="">
                    <input type="hidden" id="id_establishment" name="id_establishment" value="<?=$establishment->id_establishment?>">

                    <label for="name">Nom de la suite</label>
                    <input type="text" id="name" class="input-form" name="name">

                    <label for="price">Prix</label>
                    <input type="number" id="price" class="input-form" name="price">
                    
                    <label for="link">Lien du booking</label>
                    <input type="text" id="link" class="input-form" name="link">
                    
                    <label for="description">Description de la suite</label>
                    <textarea name="description" id="description"></textarea>

                    <label for="featuredImg">Image à mettre en avant</label>
                    <div class="picture">
                        <label for="featuredImg">Choisir un fichier</label>
                        <input type="file" name="featuredImg" id="featuredImg">
                        <span>Aucun fichier choisi</span>
                    </div>

                    <label for="gallery">Image pour la galerie</label>
                    <div class="gallery">
                        <label for="gallery">Sélect. fichiers</label>
                        <input type="file" name="gallery[]" id="gallery" multiple>
                        <span>Aucun fichier choisi</span>
                    </div>
                    
                    <button type="submit" class="submit-btn"><span>Ajouter</span></button>
                </form>
            </div>
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










    

