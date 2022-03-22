<?php

    require_once 'Models/Establishment.php';
    require_once 'Models/Subject.php';

    $establishmentModel = new Establishment;
    $allEstablishments = $establishmentModel->selectAllFromEstablishment();

    $subjectModel = new Subject;
    $allSubjects = $subjectModel->selectAllFromSubject();
    
?>

<main>
    <div class="wrapper">
        <h1>Nous contactez</h1>
        <?php flash('contact'); ?>
        <form action="Controllers/Contacts.php" method="POST">
            <input type="hidden" name="type" value="contact">

            <label for="name">Nom</label>
            <input type="text" id="name" class="input-form" name="name">

            <label for="lastname">Prénom</label>
            <input type="text" id="lastname" class="input-form" name="lastname">
            
            <label for="email">Adresse mail</label>
            <input type="text" id="email" class="input-form" name="email">

            <label for="establishment">Choisissez l’établissement</label>
            <select name="establishment" id="establishment" class="input-form">
                <option></option>
                <?php 
                    foreach ($allEstablishments as $allEstablishment) {
                ?>
                <option value=<?=$allEstablishment->id_establishment?>><?=$allEstablishment->name?></option>
                <?php
                    }
                ?>
            </select>
            
            <label for="subject">Sujets de votre demande</label>
            <select name="subject" id="subject" class="input-form">
                <option></option>
                <?php 
                    foreach ($allSubjects as $allSubject) {
                ?>
                <option value=<?=$allSubject->id_subject?>><?=$allSubject->subject?></option>
                <?php
                    }
                ?>
            </select>
            
            <label for="description">Description de votre demande</label>
            <textarea name="description" id="description"></textarea>
            
            <button type="submit" class="input-form button-submit">Envoyer</button>
        </form>
    </div>
</main>





    

