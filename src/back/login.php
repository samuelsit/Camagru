<?php
require_once('../../includes/session.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../config/database.php');

$userName = !empty($_POST['login']) ? $_POST['login'] : NULL;
$password = !empty($_POST['passwd']) ? $_POST['passwd'] : NULL;

if (isset($userName) && isset($password)) {
    sleep(1);
    $log = $db->query("SELECT acc_user, acc_pass, acc_salt, acc_actif FROM access WHERE acc_user = \"".$userName."\"")->fetch();
    $pass_hash = hash('whirlpool', $password.$log['acc_salt']);
    if ($log['acc_pass'] == $pass_hash) {
        if ($log['acc_actif'] == 0) {
            header('Location: ../front/login.php?error=3&user='.$userName);
            exit();
        }
        else {
            $_SESSION['user'] = $userName;
            header('Location: ../../index.php');
            exit();
        }
    }
    else {
        header('Location: ../front/login.php?error=1&user='.$userName);
        exit();
    }
}
else {
    header('Location: ../front/login.php?error=2&user='.$userName);
    exit();
}