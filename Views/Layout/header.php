
<header>
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <img src="Img/logo.png" alt="Logo Hypnos">
            </a>
        </div>
        <div class="navigation">
            <input type="checkbox" class="toggle-menu">
            <div class="hamburger"></div>
            <ul class="menu">
                <li class="<?= ($page=="home")?"active" : ""; ?>"><a href="index.php">Home</a></li>
                <?php if (!isset($_SESSION['userHypnosId'])) : ?>
                    <li class="<?= ($page=="catalog")?"active" : ""; ?>"><a href="index.php?page=catalog">Catalogue</a></li>
                    <li class="<?= ($page=="reservation")?"active" : ""; ?>"><a href="index.php?page=reservation">Réservation</a></li>
                    <li class="<?= ($page=="login")?"active" : ""; ?>"><a href="index.php?page=login">Connexion</a></li>
                    <li class="<?= ($page=="contact")?"active" : ""; ?>"><a href="index.php?page=contact">Nous contactez</a></li>

                <?php elseif ($_SESSION['userHypnosRole'] == 'customer'): ?>
                    <li class="<?= ($page=="catalog")?"active" : ""; ?>"><a href="index.php?page=catalog">Catalogue</a></li>
                    <li class="<?= ($page=="reservation")?"active" : ""; ?>"><a href="index.php?page=reservation">Réservation</a></li>
                    <li class="<?= ($page=="profile")?"active" : ""; ?>"><a href="index.php?page=profil">Profile</a></li>
                    <li class="<?= ($page=="contact")?"active" : ""; ?>"><a href="index.php?page=contact">Nous contactez</a></li>
                    <li><a href="Controllers/Users.php?q=logout">Logout</a></li>

                <?php elseif ($_SESSION['userHypnosRole'] == 'manager'): ?>
                    <li class="<?= ($page=="manager-suite")?"active" : ""; ?>"><a href="index.php?page=manager-suite">Manager</a></li>
                    <li><a href="Controllers/Users.php?q=logout">Logout</a></li>
                
                <?php elseif ($_SESSION['userHypnosRole'] == 'admin'): ?>
                    <li class="<?= ($page=="admin-manager")?"active" : ""; ?>"><a href="index.php?page=admin-manager">Manager</a></li>
                    <li class="<?= ($page=="admin-establishment")?"active" : ""; ?>"><a href="index.php?page=admin-establishment">Établissement</a></li>
                    <li class="<?= ($page=="admin-contact")?"active" : ""; ?>"><a href="index.php?page=admin-contact">Contact</a></li>
                    <li><a href="Controllers/Users.php?q=logout">Logout</a></li>
                <?php endif; ?>
                
            </ul>
        </div>
    </div>
</header>



