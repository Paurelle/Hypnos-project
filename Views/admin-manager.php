<?php

    if (isset($_SESSION['userHypnosId'])) {
        if ($_SESSION['userHypnosRole'] == 'admin') {

            require_once 'Models/User.php';

            $userModel = new User;
            $allManagers = $userModel->selectAllFromManager();
?>

<main>
    <div class="wrapper">
        
        <h1>Admin interface</h1>

        <h2>Manager</h2>

        <div class="manager">
            <button class="addBtn">Ajouter un manager</button>
            <?php flash('registerManager'); ?>

            <table>
                <thead>
                    <tr>
                        <th class="col1">Nom</th>
                        <th class="col2">Prénom</th>
                        <th class="col3">Email</th>
                        <th class="col4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($allManagers as $allManager) {
                    ?>
                    <tr">
                        <td class="col1"><?=$allManager->name?></td>
                        <td class="col2"><?=$allManager->lastname?></td>
                        <td class="col3"><?=$allManager->email?></td>
                        <td class="col4"><button class="deleteBtn">Supprimer</button></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- The Modal -->
    <div id="modalForm" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Ajouter un manager</h3>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form method="POST" action="Controllers/Users.php">
                    <input type="hidden" name="type" value="">

                    <label for="name">Nom</label>
                    <input type="text" id="name" class="input-form" name="name">

                    <label for="lastname">Prénom</label>
                    <input type="text" id="lastname" class="input-form" name="lastname">
                    
                    <label for="email">Adresse mail</label>
                    <input type="text" id="email" class="input-form" name="email">

                    <label for="pwd">Mot de passe</label>
                    <input type="password" id="pwd" class="input-form" name="pwd">

                    <label for="cPwd">Comfirmé le mot de passe</label>
                    <input type="password" id="cPwd" class="input-form" name="cPwd">

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











    













    

