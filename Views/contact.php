
<main>
    <div class="wrapper">
        <h1>Nous contactez</h1>
        <form action="" method="POST">
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
                <option value="nom">établissement 1</option>
                <option value="nom">établissement 2</option>
            </select>
            
            <label for="suject">Sujets de votre demande</label>
            <select name="suject" id="suject" class="input-form">
                <option></option>
                <option value="1">Je souhaite poser une réclamation</option>
                <option value="2">Je souhaite commander un service supplémentaire</option>
                <option value="3">Je souhaite en savoir plus sur une suite</option>
                <option value="4">J’ai un souci avec cette application</option>
            </select>
            
            <label for="description">Description de votre demande</label>
            <textarea name="description" id="description"></textarea>
            
            <button type="submit" class="input-form button-submit">Envoyer</button>
        </form>
    </div>
</main>





    

