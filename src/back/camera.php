<?php

    require_once('../../includes/session.php');
    if (empty($_SESSION['user']))
        exit();
    date_default_timezone_set('Europe/Paris');
    require_once('../../config/database.php');
    define('UPLOAD_DIR', '../../uploads/');
    $img = isset($_POST['imgBase64']) ? $_POST['imgBase64'] : NULL;
    $filter = isset($_POST['filter']) ? $_POST['filter'] : NULL;
    if (empty($img) || !isset($filter))
        exit();
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = uniqid() . '.png';
    $id_user = $db->query("SELECT acc_id FROM access WHERE acc_user = \"".$_SESSION['user']."\"")->fetch();

    $req = $db->prepare("INSERT INTO picture (pic_user, pic_data, pic_filter, pic_date) VALUES (:puser, :pdata, :filt, :pdate)");
    $req->execute(array(
        'puser' => $id_user['acc_id'],
        'pdata' => $file,
        'filt' => $filter,
        'pdate' => date("Y-m-d")." ".date("H:i:s")
    ));
    if (!file_exists(UPLOAD_DIR))
        mkdir(UPLOAD_DIR, 0777, true);
    $success = file_put_contents(UPLOAD_DIR . $file, $data);

?>