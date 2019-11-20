<?php
require_once('../../includes/session.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../config/database.php');

function getSalt($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

foreach ($_POST as $key => $value)
	$_POST[$key] = htmlspecialchars($value);

$nom = isset($_POST['nom']) ? $_POST['nom'] : NULL;
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : NULL;
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : NULL;
$passwd = isset($_POST['passwd']) ? $_POST['passwd'] : NULL;
$repasswd = isset($_POST['repasswd']) ? $_POST['repasswd'] : NULL;
$phone = isset($_POST['phone']) ? $_POST['phone'] : NULL;
$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;

$reqPseudo = $db->query("SELECT acc_user FROM access");
while ($user = $reqPseudo->fetch()) {
    if ($user['acc_user'] == $pseudo)
        header('Location: ../front/signup.php?error=3');
}

if (empty($nom) || empty($prenom) || empty($pseudo) || empty($passwd) || empty($repasswd) || empty($phone) || empty($mail))
    header('Location: ../front/signup.php?error=1');
else if ($passwd != $repasswd)
    header('Location: ../front/signup.php?error=2');
else if (strlen($pseudo) >= 20 || strlen($nom) >= 30 || strlen($prenom) >= 30 || strlen($phone) >= 20 || strlen($mail) >= 40)
    header('Location: ../front/signup.php?error=3');

$salt = getSalt();

$user_password = hash('whirlpool', $passwd.$salt);

$req = $db->prepare("INSERT INTO access (acc_user, acc_pass, acc_salt, acc_firstname, acc_lastname, acc_phone, acc_email) VALUES (:pseudo, :passwd, :salt, :prenom, :nom, :phone, :mail)");
$req->execute(array(
    'pseudo' => $pseudo,
    'passwd' => $user_password,
    'salt' => $salt,
    'prenom' => $prenom,
    'nom' => $nom,
    'phone' => $phone,
    'mail' => $mail
));

header('Location: ../front/login.php');