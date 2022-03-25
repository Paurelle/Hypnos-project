<?php

    if (isset($_SESSION['userHypnosId'])) {
        if ($_SESSION['userHypnosRole'] == 'admin') {

            require_once 'Models/Contact.php';

            $contactModel = new Contact;
            $allContacts = $contactModel->selectAllFromContact();
?>

<main>
    <div class="wrapper">
        
        <h1>Admin interface</h1>

        
        <h2>Message utilisateur</h2>

        <div class="contact">

            <?php
                if ($allContacts) {
                    foreach ($allContacts as $allContact) {
            ?>
            <article class="content-card">
                <ul>
                    <li>Nom : <span><?=$allContact->user_name?></span></li>
                    <li>Prénom : <span><?=$allContact->lastname?></span></li>
                    <li>Email : <span><?=$allContact->email?></span></li>
                </ul>
                <hr>
                <ul>
                    <li>Hôtel : <span><?=$allContact->establishment_name?></span></li>
                    <li>Sujet : <span><?=$allContact->subject?></span></li>
                    <li>Message : </li>
                    <li><span><?=$allContact->message?></span></li>
                </ul>
            </article>
            <?php
                    }
                }
            ?>

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










    

