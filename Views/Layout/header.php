
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
                <?php if (!isset($_SESSION['user'])) : ?>
                    <li class="<?= ($page=="login")?"active" : ""; ?>"><a href="index.php?page=login">Connexion</a></li>
                    <li class="<?= ($page=="register")?"active" : ""; ?>"><a href="index.php?page=register">S'inscrire</a></li>
                <?php else : ?>
                    <li class="<?= ($page=="profile")?"active" : ""; ?>"><a href="index.php?page=profile">Profile</a></li>
                    <li><a href="Controllers/Users.php?q=logout">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>


