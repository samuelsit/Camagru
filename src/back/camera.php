<?php

    require_once('../../includes/session.php');
    if (empty($_SESSION['user']))
        die();
    date_default_timezone_set('Europe/Paris');
    require_once('../../config/database.php');
    define('UPLOAD_DIR', '../../uploads/');
    $img = isset($_POST['imgBase64']) ? $_POST['imgBase64'] : NULL;
    $filter = isset($_POST['filter']) ? $_POST['filter'] : NULL;
    if (empty($img) || !isset($filter))
        die();
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = uniqid() . '.png';
    $id_user = $db->query("SELECT acc_id FROM access WHERE acc_user = \"".$_SESSION['user']."\"")->fetch();

    $req = $db->prepare("INSERT INTO picture (pic_user, pic_data, pic_date, pic_filter) VALUES (:puser, :pdata, :pdate, :filt)");
    $req->execute(array(
        'puser' => $id_user['acc_id'],
        'pdata' => $file,
        'pdate' => date("Y-m-d")." ".date("H:i:s"),
        'filt' => $filter
    ));
    $success = file_put_contents(UPLOAD_DIR . $file, $data);

?>