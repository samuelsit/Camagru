<?php
require_once('../../config/database.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="shortcut icon" href="/ressources/camagru.png" type="image/png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <?php
        if (isset($_GET['pic'])) {
            $req_com = $db->query("SELECT * FROM comments WHERE com_pic = ".$_GET['pic']."");
            $id = 0;
            while ($com = $req_com->fetch()) {
                $id++;
                $d1 = new DateTime($com['com_date'], new DateTimeZone('Europe/Paris'));
                $d2 = new DateTime(date("Y-m-d")." ".date("H:i:s"), new DateTimeZone('Europe/Paris'));
                $diff = $d1->diff($d2);
                $nb_heures = $diff->h;
                $nb_heures = $nb_heures + ($diff->d*24);
                if ((intval(date("d")) > intval(date("d", strtotime($com['com_date'])))) || $nb_heures/24 >= 1)
                    $duree = 'Il y à '.ceil($nb_heures/24).' jour&middot;s';
                else
                    $duree = 'Aujourd\'hui à '.date("H:i", strtotime($com['com_date']));

                $com_user = $db->query("SELECT acc_user FROM access WHERE acc_id = ".$com['com_user']."")->fetch();
                echo '<p class="text-left"><span class="font-weight-bold text-white">'.$com_user['acc_user'].':</span> <span class="text-light">'.$com['com_data'].'</span> <span class="text-secondary">'.$duree.'</span></p><hr>';
            }
        }
        else {
            echo '<p class="text-center text-danger font-weight-bold">Un problème est survenu...</p>';
        }
        ?>
    </body>
    <script>window.scrollTo(0,document.body.scrollHeight);</script>
</html>