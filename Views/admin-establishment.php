
<main>
    <div class="wrapper">
        
        <h1>Admin interface</h1>

        
        <h2>Établissement</h2>

        <div class="establishment">

            <button id="add" class="addBtn">Ajouter un établissement</button>
            
            <div class="content-card">
                <div class="img-card">
                    <img src="" alt=""> 
                </div>
                <div class="title-card">
                    <a href="index.php?page=suite-info&suite=nomSuite">
                       <h3>Nom de l’hôtel</h3>
                    </a>
                </div>
                <div class="btn-card">
                    <button id="modify"><img src="Img/pencil.svg" alt=""></button>
                    <button id="delete"><img src="Img/trash.svg" alt=""></button>
                </div>
                <div class="info-card">
                    <p>ville, adresse</p>
                </div>
                <div class="description-card">
                    <p>Lorem ipsum dolor sit amet. Ut perspiciatis quisquam ut voluptatem Quis in autem saepe exercitationem praesentium et saepe consequuntur...</p>
                </div>
            </div>
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
                <form method="POST" action="Controllers/Admins.php" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="">

                    <label for="name">Nom de l’établissement</label>
                    <input type="text" id="name" class="input-form" name="name">

                    <label for="city">Ville</label>
                    <input type="text" id="city" class="input-form" name="city">
                    
                    <label for="address">Adresse</label>
                    <input type="text" id="address" class="input-form" name="address">
                    
                    <label for="description">Description de l’établissement</label>
                    <textarea name="description" id="description"></textarea>

                    <label for="img">Image de l’établissement</label>
                    <input type="file" id="img" name="img">

                    <button type="submit" class="submit-btn"><span>Ajouter</span></button>
                </form>
            </div>
        </div>
    </div>
    
</main>













    

