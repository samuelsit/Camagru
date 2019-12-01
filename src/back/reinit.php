<?php
require_once('../../includes/session.php');
if (empty($_SESSION['user']) && empty($_GET['key']))
    header('Location: ../../index.php');
if (!empty($_SESSION['user']))
    $where = "acc_user = \"".$_SESSION['user']."\"";
else if (!empty($_GET['key']))
    $where = "acc_key = \"".$_GET['key']."\"";
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../config/database.php');

$count = $db->query("SELECT COUNT(*) FROM access WHERE ".$where."")->fetch();
if ($count[0] == 0) {
    header('Location: ../front/reinit.php?error=4');
    die();
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
    header('Location: ../front/reinit.php?error=1');
    die();
}
else if ($pwd !== $repwd) {
    header('Location: ../front/reinit.php?error=2');
    die();
}
else if (($user_password_before !== $user['acc_pass']) && empty($_GET['key'])) {
    header('Location: ../front/reinit.php?error=3');
    die();
}
else if (!preg_match('@[A-Z]@', $pwd) || !preg_match('@[a-z]@', $pwd) || !preg_match('@[0-9]@', $pwd) || strlen($pwd) < 6) {
    header('Location: ../front/reinit.php?error=5');
    die();
}

$new_pwd = hash('whirlpool', $pwd.$user['acc_salt']);

$req = $db->prepare("UPDATE access SET acc_pass = :pass WHERE acc_id = :user");
$req->execute(array(
    'pass' => $new_pwd,
    'user' => $user['acc_id']
));

if ($error == 0 && empty($_GET['key']))
    header('Location: ../front/profile.php');
else
    header('Location: ../front/login.php?success=1');