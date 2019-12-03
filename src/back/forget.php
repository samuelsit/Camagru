<?php
    require_once('../../config/database.php');

    if (empty($_POST['email'])) {
        header('Location: ../front/forget.php?error=1');
        exit();
    }
    
    $mailExist = $db->query("SELECT COUNT(*) FROM access WHERE acc_email = \"".$_POST['email']."\"")->fetch();
    if ($mailExist[0] == 0) {
        header('Location: ../front/reinit.php?error=2');
        exit();
    }

    $mail = $db->query("SELECT acc_firstname, acc_key FROM access WHERE acc_email = \"".$_POST['email']."\"")->fetch();

    $destinataire = $_POST['email'];
    $sujet = "Changement de votre mot de passe" ;
    $entete = array();
    $entete[] = 'MIME-Version: 1.0';
    $entete[] = 'Content-Type: text/html; charset=utf-8';
    $entete[] = 'To: <' . $destinataire . '>';
    $entete[] = "From: Camagru <noreply@camagru.com>" ;

    $message = '<html>
                <head>
                </head>
                <body>
                    <h1>Bonjour '.$mail['acc_firstname'].',</h1>
                    <p>Votre demande de changement de mot de passe à bien été reçue,<br>si vous souhaitez procéder à la modification maintenant, cliquez sur ce lien ci-dessous:<br><br>http://localhost:8888/src/front/reinit.php?key='.$mail['acc_key'].'<br><br>---------------<br>Ceci est un mail automatique, Merci de ne pas y répondre.</p>
                </body>
            </html>';
    
    if (mail($destinataire, $sujet, $message, implode("\r\n", $entete)) == TRUE) {
        header('Location: ../front/login.php?mail='.$_POST['email'].'');
        exit();
    }
    else {
        header('Location: ../front/login.php?mail=2');
        exit();
    }