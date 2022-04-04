<?php

    if (isset($_SESSION['userHypnosId'])) {
        if ($_SESSION['userHypnosRole'] == 'admin') {

            require_once 'Functions/troqueChaine.php';

            require_once 'Models/User.php';
            require_once 'Models/Establishment.php';

            $userModel = new User;
            $allManagers = $userModel->selectAllFromManager();

            $establishmentModel = new Establishment;
            $allEstablishments = $establishmentModel->selectAllFromEstablishment();
?>

<main>
    <div class="wrapper">
        
        <h1>Admin interface</h1>

        
        <h2>Établissement</h2>
        <?php flash('registerEstablishment'); ?>

        <div class="establishment">

            <button class="addBtn">Ajouter un établissement</button>
            
            <?php
                foreach ($allEstablishments as $allEstablishment) {
            ?>
            <div id="<?=$allEstablishment->id_establishment?>" class="content-card">
                <div class="img-card">
                    <?='<img src="data:image/jpeg;base64,' . base64_encode($allEstablishment->establishment_picture) . '" />';?>
                </div>
                <div class="title-card">
                    <a href="index.php?page=establishment-info&establishment=<?=$allEstablishment->id_establishment?>">
                       <h3><?=$allEstablishment->name?></h3>
                    </a>
                </div>
                <div class="btn-card">
                    <button class="modifyBtn"><img src="Img/pencil.svg" alt=""></button>
                    <button class="deleteBtn"><img src="Img/trash.svg" alt=""></button>
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
            ?>
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
                <form method="POST" action="Controllers/Establishments.php" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="">
                    <input type="hidden" id="id" name="id_establishment" value="">

                    <label for="name">Nom de l’établissement</label>
                    <input type="text" id="name" class="input-form" name="name">

                    <label for="manager">Choisissez un manager</label>
                    <select name="manager" id="manager" class="input-form">
                        <option></option>
                        <?php 
                            foreach ($allManagers as $allManager) {
                                if (!$establishmentModel->selectEstablishmentFromUserId($allManager->id_user)) {
                        ?>
                        <option value=<?=$allManager->id_user?>><?=$allManager->name." ".$allManager->lastname?></option>
                        <?php
                                    
                                }
                            }
                        ?>
                    </select>

                    <label for="city">Ville</label>
                    <input type="text" id="city" class="input-form" name="city">
                    
                    <label for="address">Adresse</label>
                    <input type="text" id="address" class="input-form" name="address">
                    
                    <label for="description">Description de l’établissement</label>
                    <textarea name="description" id="description"></textarea>

                    <label for="img">Image de l’établissement</label>
                    <div class="picture">
                        <label for="img">Choisir un fichier</label>
                        <input type="file" name="img" id="img">
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
            header("location: index.php?page=home");
        }
    } else {
        header("location: index.php?page=home");
    }












    

