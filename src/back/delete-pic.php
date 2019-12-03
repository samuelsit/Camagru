<?php

    require_once('../../includes/session.php');
    if (empty($_SESSION['user']) || empty($_GET['pic']) || !ctype_digit($_GET['pic'])) {
        header('Location: ../../index.php');
        exit();
    }
    require_once('../../config/database.php');

    $isMine = $db->query("SELECT acc_id FROM access WHERE acc_user = \"".$_SESSION['user']."\"")->fetch();
    $data = $db->query("SELECT pic_data FROM picture WHERE pic_id = ".$_GET['pic']." AND pic_user = ".$isMine['acc_id']."")->fetch();
    if (empty($data)) {
        header('Location: ../../index.php');
        exit();
    }

    $req_pic = $db->prepare("DELETE FROM picture WHERE pic_id = :id");
    $req_pic->execute(array(
        'id' => $_GET['pic']
    ));

    $req_like = $db->prepare("DELETE FROM likes WHERE like_pic = :id");
    $req_like->execute(array(
        'id' => $_GET['pic']
    ));

    $req_com = $db->prepare("DELETE FROM comments WHERE com_pic = :id");
    $req_com->execute(array(
        'id' => $_GET['pic']
    ));

    unlink("../../uploads/".$data['pic_data']);

    header('Location: ../front/profile.php');

?>