<?php
require_once('../../config/database.php');

function getSalt($length) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

$login = isset($_GET['user']) ? $_GET['user'] : NULL;
$cle = isset($_GET['key']) ? $_GET['key'] : NULL;

if (empty($login) || empty($cle)) {
    header('Location: ../front/login.php?error=3');
    exit();
}

$activ = $db->query("SELECT acc_key, acc_actif FROM access WHERE acc_user = \"".$login."\"")->fetch();

if ($activ['acc_actif'] == '1') {
    header('Location: ../front/login.php?error=4');
    exit();
}
else {
    if ($cle == $activ['acc_key']) {
        $key = getSalt(32);
        $req = $db->prepare("UPDATE access SET acc_actif = :act, acc_key = :cle WHERE acc_user = :user ");
        $req->execute(array(
            'act' => 1,
            'cle' => $key,
            'user' => $login
        ));
        header('Location: ../front/login.php?mail=1');
        exit();
    }
    else {
        header('Location: ../front/login.php?error=3');
        exit();
    }
}