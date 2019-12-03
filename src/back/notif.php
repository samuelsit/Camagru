<?php

require_once('../../includes/session.php');
if (empty($_SESSION['user']) || !isset($_GET['send'])) {
    header('Location: ../../index.php');
    exit();
}
require_once('../../config/database.php');

if ($_GET['send'] == 1 || $_GET['send'] == 0) {
    $req = $db->prepare("UPDATE access SET acc_send = :envoi WHERE acc_user = :user");
    $req->execute(array(
        'envoi' => $_GET['send'],
        'user' => $_SESSION['user']
    ));
}

header('Location: ../front/profile.php');