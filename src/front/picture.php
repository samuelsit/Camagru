<?php
require_once('../../includes/session.php');
require_once('../../config/database.php');
$picture = isset($_GET['pic']) ? $_GET['pic'] : NULL;
if (empty($picture))
    header('Location: ../../index.php');
$imgExist = $db->query("SELECT COUNT(*) FROM picture WHERE pic_id = ".$picture."")->fetch();
if ($imgExist[0] == 0)
    header('Location: ../../index.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4))." ".$picture;
require_once('../../includes/header.php');
$pic = $db->query("SELECT pic_filter, pic_date FROM picture WHERE pic_id = ".$picture."")->fetch();
$mine = 0;
if (!empty($_SESSION['user'])) {
    $user_id = $db->query("SELECT acc_id FROM access WHERE acc_user = \"".$_SESSION['user']."\"")->fetch();
    $isLiked = $db->query("SELECT COUNT(*) FROM likes WHERE like_pic = ".$picture." AND like_user = ".$user_id['acc_id']."")->fetch();
    $isLike = $isLiked[0] == 0 ? 0 : 1;
}
$pic_uid = $db->query("SELECT pic_user FROM picture WHERE pic_id = ".$picture."")->fetch();
$pic_user = $db->query("SELECT acc_user FROM access WHERE acc_id = ".$pic_uid['pic_user']."")->fetch();

if (!empty($_SESSION['user']) && $user_id['acc_id'] == $pic_uid['pic_user']) {
    $mine = 1;
}

switch ($pic['pic_filter']) {
    case 0:
        $filt = "Aucun";
        break;
    case 1:
        $filt = "Sépia";
        break;
    case 2:
        $filt = "Feu";
        break;
    case 3:
        $filt = "Marvel";
        break;
    case 4:
        $filt = "Coeurs";
        break;
}
$nblike = $db->query("SELECT COUNT(*) FROM likes WHERE like_pic = ".$picture."")->fetch();
$like = !empty($_SESSION['user']) ? $nblike[0] : $nblike[0]." like&middot;s";
?>

<div class="container-fluid">
    <div class="row bg-primary p-2">
        <div class="col-lg-7 text-center">
            <div class="bg-dark p-2 rounded">
                <div class="text-center mb-2 text-light">
                    Photo de <a href="profile.php?user=<?= $pic_user['acc_user'] ?>" class="text-white font-weight-bold"><?= $pic_user['acc_user'] ?></a> publiée le <span class="text-white font-weight-bold"><?= date("d/m/Y", strtotime($pic['pic_date'])) ?></span> à <span class="text-white font-weight-bold"><?= date("H:i", strtotime($pic['pic_date'])) ?></span> avec le filtre <span class="text-white font-weight-bold"><?= $filt ?></span>
                </div>
                <img class="img-fluid rounded" width="90%" src="../back/mergepic.php?pic=<?= $picture ?>&filter=<?= $pic['pic_filter'] ?>">
                <?php
                if (!empty($_SESSION['user'])) { 
                ?>
                    <div class="text-center mt-2">
                        <?php
                        if ($isLike == 0)
                            $img = '../../ressources/heart.png';
                        else
                            $img = '../../ressources/like.png';
                        ?>
                        <a href="../back/like.php?user=<?= $user_id['acc_id'] ?>&pic=<?= $picture ?>&like=<?= $isLike ?>"><img src="<?php echo $img; ?>" id="img" width="6%" class="bg-secondary p-1 rounded"/></a>
                    </div>
                <?php } ?>
                <p class="h2 text-white font-weight-bold text-center mt-2"><?= $like ?></p>
            </div>
        </div>
        <div class="col-lg-5 text-center mt-sm-1 mt-lg-0">
            <div class="bg-dark p-2 rounded">
                <iframe id="chat" height="400" width="100%" name="chat" src="chat.php?pic=<?= $picture ?>" frameborder="0"></iframe>
            </div><hr>
            <div class="bg-dark p-2 mt-2 rounded">
                <iframe height="100" width="100%" src="speak.php?pic=<?= $picture ?>" frameborder="0"></iframe>
            </div>
        </div>
        <?php
        if ($mine == 1)
            echo '<a href="../back/delete-pic.php?pic='.$picture.'" class="mt-2 ml-3 btn btn-sm btn-danger" onclick="if(window.confirm(\'Voulez-vous vraiment supprimer cette photo ?\n! Attention, cette action est irréversible !\')){return true;}else{return false;}">Supprimer cette photo</a>';
        ?>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>