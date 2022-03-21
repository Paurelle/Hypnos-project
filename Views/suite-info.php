<?php
    require_once 'Models/User.php';

    $test = new User;
    $row = $test->hotel();
    
?>

<main>
    <div class="wrapper">

        <h1>Nom de l’hotel</h1>

        <div class="info">
            <p>ville, adresse</p>
        </div>
        <div class="carousel owl-carousel">
            <?php
                foreach ($row as $rows) {
                    echo '<div class="card"><img src="data:image/jpeg;base64,' . base64_encode( $rows->establishment_picture ) . '" /></div>';
                }
            ?>
            <div class="card"><img src="Img/test.jpg" alt=""></div>
            <div class="card"><img src="Img/e.jpg" alt=""></div>
            <div class="card"><img src="Img/z.jpg" alt=""></div>
            <div class="card"><img src="Img/logo.png" alt=""></div>
        </div>
        <div class="info">
            <hr>
            <p>
                Lorem ipsum dolor sit amet. Ut perspiciatis quisquam ut voluptatem Quis in autem saepe exercitationem praesentium et saepe consequuntur? 
                Lorem ipsum dolor sit amet. Ut perspiciatis quisquam ut voluptatem Quis in autem saepe exercitationem praesentium et saepe consequuntur? 
            </p>
            <p class="link">Réserver sur <a href="">Hypnos</a> ou sur <a href="">Booking</a></p>
        </div>
    </div>

    
    
</main>

<?php
    foreach ($row as $rows) {
        echo '<img src="data:image/jpeg;base64,' . base64_encode( $rows->establishment_picture ) . '" />';
    }
        












    

