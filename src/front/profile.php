<?php
require_once('../../includes/session.php');
if (empty($_GET['user']) && empty($_SESSION['user']))
    header('Location: login.php');
require_once('../../config/database.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../includes/header.php');

if (!empty($_SESSION['user']) && empty($_GET['user'])) {
    $user = $db->query("SELECT acc_id, acc_user, acc_firstname, acc_lastname, acc_phone, acc_email FROM access WHERE acc_user = \"".$_SESSION['user']."\"")->fetch();
    $modify = 1;
}
else {
    $user = $db->query("SELECT acc_id, acc_user, acc_firstname, acc_lastname, acc_phone, acc_email FROM access WHERE acc_user = \"".$_GET['user']."\"")->fetch();
    $modify = 0;
}

if (!empty($_SESSION['user']) && !empty($_GET['user']) && $_SESSION['user'] == $_GET['user'])
    $modify = 1;

if ($modify == 0)
    $disabled = "disabled";
else
    $disabled = "";

if (empty($user))
    header('Location: ../../index.php');

?>

<div class="container-fluid">
    <div class="row bg-primary p-2">
        <div class="col-lg-5 text-center">
            <div class="bg-dark p-4 rounded">
                <form action="../back/profile.php" method="POST">
                    <input type="text" name="nom" placeholder="Nom" style="border:0;" class="bg-dark text-white w-100 rounded text-center font-weight-bold form-control" value="<?= $user['acc_lastname'] ?>" required <?= $disabled ?>><br>
                    <input type="text" name="prenom" placeholder="Prénom" style="border:0;" class="bg-dark text-white mt-1 w-100 rounded text-center font-weight-bold form-control" value="<?= $user['acc_firstname'] ?>" required <?= $disabled ?>><br>
                    <input type="text" name="pseudo" placeholder="Pseudo" style="border:0;" class="bg-dark text-white mt-1 w-100 rounded text-center font-weight-bold form-control" value="<?= $user['acc_user'] ?>" required <?= $disabled ?>><br>
                    <input type="text" name="phone" placeholder="Téléphone" style="border:0;" class="bg-dark text-white mt-1 w-100 rounded text-center font-weight-bold form-control" value="<?= $user['acc_phone'] ?>" required <?= $disabled ?>><br>
                    <input type="text" name="mail" placeholder="E-mail" style="border:0;" class="bg-dark text-white mt-1 w-100 rounded text-center font-weight-bold form-control" value="<?= $user['acc_email'] ?>" required <?= $disabled ?>><br>
                    <?php if ($modify == 1) { ?>
                    <br><button type="submit" class="mt-1 btn w-75 btn-rounded btn-primary font-weight-bold">Modifier</button><br>
                    <?php } ?>
                </form>
            </div>
        </div>
        <div class="col-lg-7 text-center mt-1">
            <div class="row p-2 rounded">
            <?php
                $req = $db->query("SELECT * FROM picture WHERE pic_acc = ".$user['acc_id']."");
                while ($pic = $req->fetch()) {
                    echo '<div class="col-sm-3 p-2">
                        <img class="img-fluid rounded bg-dark p-2" src="../../uploads/'.$pic['pic_data'].'">
                    </div>';
                }
            ?>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>