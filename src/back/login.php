<?php
require_once('../../includes/session.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../config/database.php');

$userName = !empty($_POST['login']) ? $_POST['login'] : NULL;
$password = !empty($_POST['passwd']) ? $_POST['passwd'] : NULL;

if (isset($userName) && isset($password)) {
    sleep(1);
    $log = $db->query("SELECT acc_user, acc_pass, acc_salt FROM access WHERE acc_user = \"".$userName."\"")->fetch();
    $pass_hash = hash('whirlpool', $password.$log['acc_salt']);
    if ($log['acc_pass'] == $pass_hash) {
        $_SESSION['user'] = $userName;
        header('Location: ../../index.php');
    }
    else {
        header('Location: ../front/login.php?error=1');
    }
}
else {
    header('Location: ../front/login.php?error=2');
}