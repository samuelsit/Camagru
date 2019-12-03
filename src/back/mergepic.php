<?php
header ("Content-type: image/png");
require_once('../../config/database.php');

if (isset($_GET['pic']) && isset($_GET['filter'])) {
    if (!file_exists('../../ressources/filtres/'.$_GET['filter'].'.png'))
        die();
    $pic = $db->query("SELECT pic_data FROM picture WHERE pic_id = ".$_GET['pic']."")->fetch();
    $source = imagecreatefrompng('../../ressources/filtres/'.$_GET['filter'].'.png');
    $destination = imagecreatefrompng('../../uploads/'.$pic['pic_data']);

    $largeur_source = imagesx($source);
    $hauteur_source = imagesy($source);
    $largeur_destination = imagesx($destination);
    $hauteur_destination = imagesy($destination);

    $destination_x = $largeur_destination - $largeur_source;
    $destination_y =  $hauteur_destination - $hauteur_source;

    imagecopymerge($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source, 100);

    imagepng($destination);
}
else
    die();
?>