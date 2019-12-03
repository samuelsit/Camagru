<?php

    require_once('../../includes/session.php');
    if (empty($_SESSION['user'])) {
        header('Location: ../../index.php');
        exit();
    }
    require_once('../../config/database.php');

    if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['phone']) && isset($_POST['mail'])) {
        foreach ($_POST as $key => $value)
	        $_POST[$key] = htmlspecialchars($value);
        $req = $db->prepare("UPDATE access SET acc_firstname = :firstn, acc_lastname= :lastn, acc_phone = :phone, acc_email = :mail WHERE acc_user = :user");
        $req->execute(array(
            'firstn' => $_POST['prenom'],
            'lastn' => $_POST['nom'],
            'phone' => $_POST['phone'],
            'mail' => $_POST['mail'],
            'user' => $_SESSION['user']
        ));
    }

    header('Location: ../front/profile.php');

?>