<?php
require_once('../../includes/session.php');
if (empty($_SESSION['user']))
    header('Location: login.php?error=5');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../includes/header.php');
?>

<script src="../js/camera.js"></script>

<div class="container-fluid">
    <div class="row bg-primary p-2">
        <div class="col-lg-7 text-center">
            <div class="bg-dark p-2 rounded" style="position:relative;">
                <video id="sourcevid" class="rounded" width="100%" height="70%" autoplay="true"></video>
                <img id="video_prev" src="../../ressources/filtres/0.png" width="100%" class="p-2" style="position:absolute; top:0px; left:0px;">
                <div class="text-center">
                    <button onclick="picture()" id="startbutton" class="btn btn-rounded btn-primary w-100 font-weight-bold">TAKE PHOTO</button>
                </div>
                <canvas id="cvs" width="480" height="360" class="mt-3 d-none"></canvas>
            </div>
        </div>
        <div class="col-lg-5 text-center mt-sm-1 mt-lg-0">
            <div class="bg-dark p-2 rounded">
                <label for="none" onclick="changeImage();" class="btn btn-rounded btn-primary w-100 font-weight-bold"><input type="radio" id="none" name="filter" value="0" class="d-none" checked>Sans effet</label>
                <label for="sepia" onclick="changeImage();" class="btn btn-rounded btn-primary w-100 font-weight-bold"><input type="radio" id="sepia" name="filter" value="1" class="d-none">Sepia</label>
                <label for="flamme" onclick="changeImage();" class="btn btn-rounded btn-primary w-100 font-weight-bold"><input type="radio" id="flamme" name="filter" value="2" class="d-none">Flamme</label>
                <label for="marvel" onclick="changeImage();" class="btn btn-rounded btn-primary w-100 font-weight-bold"><input type="radio" id="marvel" name="filter" value="3" class="d-none">Marvel</label>
                <label for="coeur" onclick="changeImage();" class="btn btn-rounded btn-primary w-100 font-weight-bold"><input type="radio" id="coeur" name="filter" value="4" class="d-none">Coeurs</label>
            </div>
            <div class="p-2 mt-2">
                <img id="previewfilter" class="img-fluid rounded bg-dark p-2 mx-auto" src="../../ressources/filtres/0.png">
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>