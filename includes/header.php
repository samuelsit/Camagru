<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://kit.fontawesome.com/b00756195c.js" crossorigin="anonymous"></script>
    <title>Camagru<?= isset($title) ? " | ".$title : NULL; ?></title>
    <link rel="shortcut icon" href="/ressources/camagru.png" type="image/png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <a class="navbar-brand" href="/index.php">
        <img src="/ressources/camagru.svg" width="50" height="50" alt=""><span class="font-weight-bold"> AMAGRU</span>
    </a>
    <div class="justify-content-center">
        <a class="btn btn-outline-light" href="/src/front/camera.php"><i class="fas fa-camera-retro"></i></a>
        <a class="btn btn-outline-light" href="/src/front/profile.php"><i class="fas fa-user"></i></a>
        <?php
        if (empty($_SESSION['user'])) {
            echo '<a class="btn btn-outline-light" href="/src/front/login.php"><i class="fas fa-sign-in-alt"></i></a>';
        }
        else {
            echo '<a class="btn btn-outline-light" href="/src/back/logout.php"><i class="fas fa-sign-out-alt"></i></a>';
        } ?>
    </div>
    <div class="search-bar-sam">
        <form class="form-inline" action="/src/front/profile.php" method="GET">
            <input style="border:0;" name="user" class="bg-dark text-white rounded text-center font-weight-bold form-control mr-2" type="search" placeholder="Rechercher..." aria-label="Search">
            <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</nav><br><br>