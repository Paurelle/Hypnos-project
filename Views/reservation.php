
<main>
    <div class="wrapper">
        <h1>Réserver une suite</h1>
        <form action="" method="POST">
            <input type="hidden" name="type" value="reservation">

            <label for="establishment">Choisissez l’établissement</label>
            <select name="establishment" id="establishment" class="input-form">
                <option></option>
                <option value="nom">établissement 1</option>
                <option value="nom">établissement 2</option>
            </select>
            

            <label for="suite">Choisissez la suite</label>
            <select name="suite" id="suite" class="input-form">
                <option></option>
                <option value="nom">suite 1</option>
                <option value="nom">suite 2</option>
            </select>
            
            <label for="startDate">Date de debut</label>
            <input type="date" id="startDate" class="input-form" name="startDate">

            <label for="endDate">Date de fin</label>
            <input type="date" id="endDate" class="input-form" name="endDate">
            
            <button type="submit" class="input-form button-submit">Réserver</button>
        </form>
    </div>
</main>





    

