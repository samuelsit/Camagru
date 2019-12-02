<?php
require_once('../../includes/session.php');
if (isset($_GET['pic']) || isset($_POST['pic']))
    $pic = isset($_GET['pic']) ? $_GET['pic'] : $_POST['pic'];
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="shortcut icon" href="/ressources/camagru.png" type="image/png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            top.frames['chat'].location = 'chat.php?pic=<?= $pic ?>';
        </script>
    </head>
    <body>
    <?php
    $error = 0;
    if (isset($_SESSION['user'])) {
        date_default_timezone_set('Europe/Paris');
        require_once('../../config/database.php');
        if (isset($_GET['pic']) || isset($_POST['pic'])) {
            $user_id = $db->query("SELECT acc_id, acc_user FROM access WHERE acc_user = \"".$_SESSION['user']."\"")->fetch();
            $pic_uid = $db->query("SELECT pic_user FROM picture WHERE pic_id = ".$pic."")->fetch();
            $pic_user = $db->query("SELECT acc_firstname, acc_email, acc_send, acc_user FROM access WHERE acc_id = ".$pic_uid['pic_user']."")->fetch();
        }
        else {
            $error = 1;
        }
        
        if ($error == 0 && (isset($_POST['msg']) && isset($pic))) {
            $req = $db->prepare("INSERT INTO comments (com_user, com_pic, com_data, com_date) VALUES (:pseudo, :pic, :com, :jour)");
            $req->execute(array(
                'pseudo' => $user_id['acc_id'],
                'pic' => $pic,
                'com' => $_POST['msg'],
                'jour' => date("Y-m-d")." ".date("H:i:s")
            ));
            $destinataire = $pic_user['acc_email'];
            $sujet = "Nouveau commentaire sur votre photo" ;
            $entete = array();
            $entete[] = 'MIME-Version: 1.0';
            $entete[] = 'Content-Type: text/html; charset=utf-8';
            $entete[] = 'To: <' . $destinataire . '>';
            $entete[] = "From: Camagru <noreply@camagru.com>" ;

            $message = '<html>
                <head>
                </head>
                <body>
                    <h1>Bonjour '.$pic_user['acc_firstname'].',</h1>
                    <p>Un nouveau commentaire de la part de '.$user_id['acc_user'].' à été posté sur<br>votre photo, si vous souhaitez lui répondre, cliquez sur ce lien:<br><br>http://localhost:8888/src/front/picture.php?pic='.$pic.'<br>Message: "'.$_POST['msg'].'"<br><br>---------------<br>Ceci est un mail automatique, Merci de ne pas y répondre.</p>
                </body>
            </html>';
            
            if ($pic_user['acc_send'] == 1 && $pic_user['acc_user'] != $_SESSION['user']) {
                if (mail($destinataire, $sujet, $message, implode("\r\n", $entete)) == TRUE)
                    $error = 0;
                else
                    $error = 1;
            }
        }

        if ($error == 0) {
            echo '<form action="speak.php" method="POST">
                <input type="text" name="msg" placeholder="Commenter la publication de '.$pic_user['acc_firstname'].' ..." style="border:0;" class="bg-dark text-white rounded text-center font-weight-bold form-control" required autofocus>
                <input type="hidden" name="pic" value="'.$pic.'">
                <input type="submit" class="btn btn-lg btn_block btn-primary font-weight-bold w-100" value="OK"/>
            </form>';
        }
        else {
            echo '<p class="text-center text-danger font-weight-bold">Un problème est survenu...</p>';
        }
    }
    else {
        echo '<p class="text-center text-danger font-weight-bold">Identifiez-vous pour pouvoir commenter cette publication.</p>';
    }
    ?>
    </body>
</html>