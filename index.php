<?php
require_once('includes/session.php');
require_once('config/database.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('includes/header.php');
?>

<div class="container-fluid">
    <div class="row bg-primary text-center">
      <?php
        $req = $db->query("SELECT * FROM picture");
        while ($pic = $req->fetch()) {
          $user = $db->query("SELECT acc_user FROM access WHERE acc_id = ".$pic['pic_acc']."")->fetch();
          echo '<div class="col-lg-2 p-2"><a href="src/front/profile.php?user='.$user['acc_user'].'">
                  <img class="img-fluid rounded bg-dark p-2" src="uploads/'.$pic['pic_data'].'">
                  <p class="font-weight-bold text-light">'.$user['acc_user'].'</p>
              </a></div>';
        }
      ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>