
<main>
    <div class="wrapper">
        <div class="info">
            <h1>Mon profil</h1>
            <p><?=ucfirst($_SESSION['userHypnosName'])?> <?=ucfirst($_SESSION['userHypnosLastname'])?></p>
            <p><?=$_SESSION['userHypnosEmail']?></p>
            <hr>
        </div>
        <div class="reservation">
            <h2>Réservation</h2>

            <table>
                <thead>
                    <tr>
                        <th class="col1">Hôtel</th>
                        <th class="col2">Suite</th>
                        <th class="col3">Date de réservation</th>
                        <th class="col4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col1">TNom hôtel</td>
                        <td class="col2">Nom suite</td>
                        <td class="col3">Date</td>
                        <td class="col4"><button>Annuler</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</main>













    

