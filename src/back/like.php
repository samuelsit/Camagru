<?php
    require_once('../../includes/session.php');
    if (empty($_SESSION['user'])) {
        header('Location: ../../index.php');
        exit();
    }
    require_once('../../config/database.php');
    if (isset($_GET['like']) && isset($_GET['user']) && isset($_GET['pic'])) {
        if ($_GET['like'] == 0) {
            $req_del = $db->prepare("INSERT INTO likes (like_user, like_pic) VALUES (:user, :pic)");
            $req_del->execute(array(
                'user' => $_GET['user'],
                'pic' => $_GET['pic']
            ));
        }
        else {
            $req_del = $db->prepare("DELETE FROM `likes` WHERE like_user = :user AND like_pic = :pic");
            $req_del->execute(array(
                'user' => $_GET['user'],
                'pic' => $_GET['pic']
            ));
        }
        header('Location: ../front/picture.php?pic='.$_GET['pic'].'');
        exit();
    }
    else {
        header('Location: ../../index.php');
        exit();
    }

?>