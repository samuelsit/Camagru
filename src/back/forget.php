<?php
    require_once('../../config/database.php');

    if (empty($_GET['email']))
        header('Location: ../front/forget.php?error=1');
    
    $mailExist = $db->query("SELECT COUNT(*) FROM access WHERE acc_email = ".$_GET['email']."")->fetch();
    if ($mailExist[0] == 0)
        header('Location: ../front/reinit.php?error=2');

    $mail = $db->query("SELECT acc_firstname, acc_key FROM access WHERE acc_email = ".$_GET['email']."")->fetch();

    $destinataire = $_GET['email'];
    $sujet = "Changement de votre mot de passe" ;
    $entete = "From: noreply@camagru.com" ;
    
    $message = 'Bonjour '.$mail['acc_firstname'].',
            
            Votre demande de changement de mot de passe à bien été reçue,
            si vous souhaitez procéder à la modification maintenant, cliquez sur ce lien ci-dessous:
            
            http://localhost:8888/src/front/reinit.php?key='.$mail['acc_key'].'
            
            
            ---------------
            Ceci est un mail automatique, Merci de ne pas y répondre.';
    
    
    if (mail($destinataire, $sujet, $message, $entete) == TRUE)
        header('Location: ../front/login.php?mail='.$_GET['email'].'');
    else
        header('Location: ../front/login.php?mail=2');