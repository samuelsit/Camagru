<?php
require_once('../../includes/session.php');
if (empty($_GET['user']) && empty($_SESSION['user'])) {
    header('Location: login.php?error=5');
    exit();
}
require_once('../../config/database.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../includes/header.php');

if (!empty($_SESSION['user']) && empty($_GET['user'])) {
    $user = $db->query("SELECT acc_id, acc_user, acc_firstname, acc_lastname, acc_phone, acc_email, acc_send FROM access WHERE acc_user = \"".$_SESSION['user']."\"")->fetch();
    $modify = 1;
}
else {
    $user = $db->query("SELECT acc_id, acc_user, acc_firstname, acc_lastname, acc_phone, acc_email, acc_send FROM access WHERE acc_user = \"".$_GET['user']."\"")->fetch();
    $modify = 0;
}

if (!empty($_SESSION['user']) && !empty($_GET['user']) && $_SESSION['user'] == $_GET['user'])
    $modify = 1;

if ($modify == 0)
    $disabled = "disabled";
else
    $disabled = "";

if (empty($user)) {
    header('Location: ../../index.php');
    exit();
}

if ($user['acc_send'] == 1) {
    $class = "mt-1 btn btn-sm btn-danger btn-rounded font-weight-bold text-white";
    $get = "0";
    $text = "Je ne souhaite plus recevoir de notifications par e-mail";
}
else {
    $class = "mt-1 btn btn-sm btn-success btn-rounded font-weight-bold text-white";
    $get = "1";
    $text = "Je souhaite recevoir des notifications par e-mail";
}

?>

<div class="container-fluid">
    <div class="row bg-primary p-2">
        <div class="col-lg-5 text-center">
            <div class="bg-dark p-4 rounded">
                <form action="../back/profile.php" method="POST">
                    <input type="text" style="border:0;" class="bg-dark text-white w-100 rounded text-center font-weight-bold form-control" value="<?= $user['acc_user'] ?>" required disabled><br>
                    <input type="text" name="nom" placeholder="Nom" style="border:0;" class="bg-dark text-white w-100 rounded text-center font-weight-bold form-control" value="<?= $user['acc_lastname'] ?>" required <?= $disabled ?>><br>
                    <input type="text" name="prenom" placeholder="Prénom" style="border:0;" class="bg-dark text-white mt-1 w-100 rounded text-center font-weight-bold form-control" value="<?= $user['acc_firstname'] ?>" required <?= $disabled ?>><br>
                    <input type="text" name="phone" placeholder="Téléphone" style="border:0;" class="bg-dark text-white mt-1 w-100 rounded text-center font-weight-bold form-control" value="<?= $user['acc_phone'] ?>" required <?= $disabled ?>><br>
                    <input type="text" name="mail" placeholder="E-mail" style="border:0;" class="bg-dark text-white mt-1 w-100 rounded text-center font-weight-bold form-control" value="<?= $user['acc_email'] ?>" required <?= $disabled ?>><br>
                    <?php if ($modify == 1) { ?>
                    <a href="../back/notif.php?send=<?= $get ?>" class="<?= $class ?>"><?= $text ?></a>
                    <br><button type="submit" class="mt-1 btn w-100 btn-rounded btn-primary font-weight-bold">Modifier</button><br>
                    <a href="reinit.php" class="mt-1 mb-3 btn btn-sm btn-rounded btn-primary font-weight-bold">Changer son mot de passe</a>
                    <?php } ?>
                </form>
            </div>
        </div>
        <div class="col-lg-7 text-center">
            <div class="row rounded">
            <?php
                $req = $db->query("SELECT * FROM picture WHERE pic_user = ".$user['acc_id']." ORDER BY pic_date DESC");
                while ($pic = $req->fetch()) {
                    $img = file_exists('../../uploads/'.$pic['pic_data']);
                    if ($img == FALSE)
                        $image = "../../ressources/nonExist.png";
                    else
                        $image = '../back/mergepic.php?pic='.$pic['pic_id'].'&filter='.$pic['pic_filter'];
                    echo '<div class="col-sm-6 col-md-4 col-lg-3 mt-lg-0 mt-2 mb-2">
                        <a href="picture.php?pic='.$pic['pic_id'].'"><img class="img-fluid rounded bg-dark p-2" src="'.$image.'"></a>
                    </div>';
                }
            ?>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>