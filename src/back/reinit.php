<?php
require_once('../../includes/session.php');
if (empty($_SESSION['user']) && empty($_GET['key'])) {
    header('Location: ../../index.php');
    exit();
}

function getSalt($length) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

if (!empty($_SESSION['user']))
    $where = "acc_user = \"".$_SESSION['user']."\"";
else if (!empty($_GET['key']))
    $where = "acc_key = \"".$_GET['key']."\"";
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../config/database.php');

$link = !empty($_GET['key']) ? "&key=".$_GET['key']."" : NULL;

$count = $db->query("SELECT COUNT(*) FROM access WHERE ".$where."")->fetch();
if ($count[0] == 0) {
    header('Location: ../front/reinit.php?error=4'.$link);
    exit();
}

foreach ($_POST as $key => $value)
	$_POST[$key] = htmlspecialchars($value);

$pwdbefore = isset($_POST['pwd-before']) ? $_POST['pwd-before'] : NULL;
$pwd = isset($_POST['pwd-after']) ? $_POST['pwd-after'] : NULL;
$repwd = isset($_POST['repwd']) ? $_POST['repwd'] : NULL;

$user = $db->query("SELECT acc_pass, acc_salt, acc_id FROM access WHERE ".$where."")->fetch();

if (empty($_GET['key']))
    $user_password_before = hash('whirlpool', $pwdbefore.$user['acc_salt']);

if ((empty($pwdbefore) && empty($_GET['key'])) || empty($pwd) || empty($repwd)) {
    header('Location: ../front/reinit.php?error=1'.$link);
    exit();
}
else if ($pwd !== $repwd) {
    header('Location: ../front/reinit.php?error=2'.$link);
    exit();
}
else if (($user_password_before !== $user['acc_pass']) && empty($_GET['key'])) {
    header('Location: ../front/reinit.php?error=3'.$link);
    exit();
}
else if (!preg_match('@[A-Z]@', $pwd) || !preg_match('@[a-z]@', $pwd) || !preg_match('@[0-9]@', $pwd) || strlen($pwd) < 6) {
    header('Location: ../front/reinit.php?error=5'.$link);
    exit();
}

$new_pwd = hash('whirlpool', $pwd.$user['acc_salt']);
$key = getSalt(32);
$req = $db->prepare("UPDATE access SET acc_pass = :pass, acc_key = :cle WHERE acc_id = :user");
$req->execute(array(
    'pass' => $new_pwd,
    'cle' => $key,
    'user' => $user['acc_id']
));

if (empty($_GET['key'])) {
    header('Location: ../front/profile.php');
    exit();
}
else {
    header('Location: ../front/login.php?success=1');
    exit();
}