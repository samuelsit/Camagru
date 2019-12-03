<?php
   require_once('includes/session.php');
   require_once('config/database.php');
   $title = ucfirst(substr(basename(__FILE__), 0, -4));
   require_once('includes/header.php');
   
   $count = $db->query('SELECT COUNT(*) FROM picture')->fetch();
   $nbPerPage = 12;
   $nbPage = ceil($count[0]/$nbPerPage) + 1;
   $currentPage = 1;
   
   if (isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] < $nbPage) {
       $currentPage = $_GET['p'];
   }
   else {
       $currentPage = 1;
   }
   
   if ($currentPage == 1)
     $left = 1;
   else
     $left = $currentPage-1;
   if ($currentPage == ($nbPage-1))
     $right = $nbPage-1;
   else
     $right = $currentPage+1;
   ?>
<script src="src/js/info.js"></script>
<div class="container-fluid">
   <?php if ($count[0] == 0) {
      echo '<div class="bg-primary rounded p-5 text-center">';
      echo '<p class="h2 text-white font-weight-bold">Bonjour et bienvenue sur Camagru, soyez le premier à publier sur cette plateforme !<br>Pour cela, n\'hesitez pas à vous inscrire et à prendre une photo !<br>Plusieurs filtres sont à votre disposition:<br></p><hr>';
      echo '<div class="p-2 rounded">
              <label for="none" onclick="changeImage();" class="btn btn-rounded btn-dark w-25 font-weight-bold"><input type="radio" id="none" name="filter" value="0" class="d-none" checked>Sans effet</label>
              <label for="sepia" onclick="changeImage();" class="btn btn-rounded btn-dark w-25 font-weight-bold"><input type="radio" id="sepia" name="filter" value="1" class="d-none">Sepia</label>
              <label for="flamme" onclick="changeImage();" class="btn btn-rounded btn-dark w-25 font-weight-bold"><input type="radio" id="flamme" name="filter" value="2" class="d-none">Flamme</label>
              <label for="marvel" onclick="changeImage();" class="btn btn-rounded btn-dark w-25 font-weight-bold"><input type="radio" id="marvel" name="filter" value="3" class="d-none">Marvel</label>
              <label for="coeur" onclick="changeImage();" class="btn btn-rounded btn-dark w-25 font-weight-bold"><input type="radio" id="coeur" name="filter" value="4" class="d-none">Coeurs</label>
              </div>
              <img id="previewfilter" class="img-fluid rounded bg-dark p-2 mx-auto" src="../../ressources/filtres/4.png">
            </div>';
      }
      ?>
   <div class="row bg-primary text-center">
      <?php
         $req = $db->query("SELECT * FROM picture ORDER BY pic_date DESC LIMIT ".(($currentPage-1)*$nbPerPage).",".$nbPerPage);
         while ($pic = $req->fetch()) {
            $like = $db->query('SELECT COUNT(*) FROM likes WHERE like_pic = '.$pic['pic_id'].'')->fetch();
           $user = $db->query("SELECT acc_user FROM access WHERE acc_id = ".$pic['pic_user']."")->fetch();
           $img = file_exists('uploads/'.$pic['pic_data']);
           if ($img == FALSE)
               $image = "ressources/nonExist.png";
            else
               $image = 'src/back/mergepic.php?pic='.$pic['pic_id'].'&filter='.$pic['pic_filter'];
           echo '<div class="col-lg-2 col-md-3 col-sm-6 p-2">
                   <a href="src/front/picture.php?pic='.$pic['pic_id'].'"><img class="img-fluid rounded bg-dark p-2" src="'.$image.'"></a>
                   <a href="src/front/profile.php?user='.$user['acc_user'].'"><p class="font-weight-bold text-light">'.$user['acc_user'].' &middot; '.date("d/m/y", strtotime($pic['pic_date'])).' &middot; '.$like[0].' ❤️</p></a>
               </div>';
         }
         
         if ($count[0] > 12) { ?>
   </div>
   <div class="row text-center text-white p-2 bg-primary">
      <div class="col">
         <span class="mr-3">
         <a href="index.php?p=<?= "1" ?>" class="btn btn-outline-light bg-dark"><img width="30" src="/ressources/angle-double-left-solid.svg"></a>
         </span>
         <span class="mr-3">
         <a href="index.php?p=<?= $left ?>" class="btn btn-outline-light bg-dark"><img width="30" src="/ressources/angle-left-solid.svg"></a>
         </span>
         <span class="ml-3">
         <a href="index.php?p=<?= $right ?>" class="btn btn-outline-light bg-dark"><img style="transform: rotate(180deg);" width="30" src="/ressources/angle-left-solid.svg"></a>
         </span>
         <span class="ml-3">
         <a href="index.php?p=<?= $nbPage-1 ?>" class="btn btn-outline-light bg-dark"><img style="transform: rotate(180deg);" width="30" src="/ressources/angle-double-left-solid.svg"></a>
         </span>
      </div>
   </div>
   <?php } ?>
</div>
<?php include 'includes/footer.php'; ?>