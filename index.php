<?php

require_once 'Controllers/Helpers/session_helper.php';


$pages = scandir('Views/');
if(isset($_GET['page']) && !empty($_GET['page'])){
    if(in_array($_GET['page'].'.php',$pages)){
        $page = $_GET['page'];
    }else{
        $page = "error";
    }
}else{
    $page = "home";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/Layout/header.css">
    <link rel="stylesheet" href="Css/Layout/body.css">
    <link rel="stylesheet" href="Css/Layout/footer.css">
    <link rel="stylesheet" href="Css/<?=$page?>.css">
    <?php if ($page == 'admin-manager') : ?>
        <link rel="stylesheet" href="Css/Layout/modal.css">
    <?php elseif ($page == 'admin-establishment') : ?>
        <link rel="stylesheet" href="Css/Layout/modal.css">
    <?php elseif ($page == 'manager-suite') : ?>
        <link rel="stylesheet" href="Css/Layout/modal.css">
    <?php elseif ($page == 'suite-info') : ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <?php endif ?>
    <link rel="icon" href="Img/favicon.ico">

    <title>Hypnos</title>
</head>
<body>

<!-- Header -->
<?php require_once 'Views/Layout/header.php'; ?>

<!-- Main -->
<?php require_once 'Views/'.$page.'.php'; ?>

<!-- Footer -->
<?php require_once 'Views/Layout/footer.php'; ?>

<!-- Import jQuery -->
<script src="Js/jquery-3.6.0.min.js"></script>

<?php if ($page == 'admin-establishment') : ?>
    <script src="Js/adminFormEstablishment.js"></script>
    <script src="Js/inputFile.js"></script>

<?php elseif ($page == 'admin-manager') : ?>
    <script src="Js/adminFormManager.js"></script>

<?php elseif ($page == 'manager-suite') : ?>
    <script src="Js/managerFormSuite.js"></script>
    <script src="Js/inputFile.js"></script>
    
<?php elseif ($page == 'suite-info') : ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="Js/carousel.js"></script>

<?php endif ?>

</body>
</html>

