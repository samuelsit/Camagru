<?php
require_once('../../includes/session.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
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
    if ($user['acc_user'] == $pseudo) {
        header('Location: ../front/signup.php?error=3');
        die();
    }
}

if (empty($nom) || empty($prenom) || empty($pseudo) || empty($passwd) || empty($repasswd) || empty($phone) || empty($mail)) {
    header('Location: ../front/signup.php?error=1');
    die();
}
else if ($passwd != $repasswd) {
    header('Location: ../front/signup.php?error=2');
    die();
}
else if (!preg_match("@^[a-zA-Z0-9_]{3,16}$@", $pseudo) || !preg_match("@^([a-zA-Z' ]+)$@", $nom) || !preg_match("@^([a-zA-Z' ]+)$@",$prenom) || !preg_match("@^((\+)33|0)[1-9](\d{2}){4}$@", $phone) || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../front/signup.php?error=3');
    die();
}
else if (!preg_match('@[A-Z]@', $passwd) || !preg_match('@[a-z]@', $passwd) || !preg_match('@[0-9]@', $passwd) || strlen($passwd) < 6) {
    header('Location: ../front/signup.php?error=4');
    die();
}

$salt = getSalt(10);
$key = getSalt(32);

$user_password = hash('whirlpool', $passwd.$salt);

$destinataire = $mail;
$sujet = "Activer votre compte" ;
$entete = "From: inscription@camagru.com" ;
 
$message = "Bienvenue sur Camagru,\n\nPour activer votre compte, veuillez cliquer sur le lien ci dessous\nou copier/coller dans votre navigateur internet.\n\nhttp://localhost:8888/src/back/activation.php?user=".$pseudo."&key=".$key."\n\n---------------\nCeci est un mail automatique, Merci de ne pas y répondre.";
 
if (mail($destinataire, $sujet, $message, $entete) == TRUE) {
    $req = $db->prepare("INSERT INTO access (acc_user, acc_pass, acc_salt, acc_firstname, acc_lastname, acc_phone, acc_email, acc_send, acc_key, acc_actif) VALUES (:pseudo, :passwd, :salt, :prenom, :nom, :phone, :mail, :envoi, :keys, :actif)");
    $req->execute(array(
        'pseudo' => $pseudo,
        'passwd' => $user_password,
        'salt' => $salt,
        'prenom' => $prenom,
        'nom' => $nom,
        'phone' => $phone,
        'mail' => $mail,
        'envoi' => 1,
        'keys' => $key,
        'actif' => 0
    ));
    header('Location: ../front/login.php?mail='.$mail.'');
}
else
    header('Location: ../front/login.php?mail=2');