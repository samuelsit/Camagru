<?php
require_once('../../config/database.php');

$login = isset($_GET['user']) ? $_GET['user'] : NULL;
$cle = isset($_GET['key']) ? $_GET['key'] : NULL;

if (empty($login) || empty($cle))
    header('Location: ../front/login.php?error=3');

$activ = $db->query("SELECT acc_key, acc_actif FROM access WHERE acc_user = ".$login."")->fetch();

if ($activ['acc_actif'] == '1')
    header('Location: ../front/login.php?error=4');
else {
    if ($cle == $activ['acc_key']) {
        $req = $db->prepare("UPDATE access SET acc_actif = 1 WHERE acc_user = :user ")->bindParam(':user', $login)->execute();
        header('Location: ../front/login.php?mail=1');
    }
    else
        header('Location: ../front/login.php?error=3');
}