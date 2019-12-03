<?php
require_once('../../includes/session.php');
if (empty($_SESSION['user'])) {
    header('Location: login.php?error=5');
    exit();
}
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../includes/header.php');
?>

<script src="../js/camera.js"></script>

<div class="container-fluid">
    <div class="row bg-primary p-2">
        <div class="col-lg-7 text-center">
            <div class="bg-dark rounded" style="position:relative;">
                <video id="sourcevid" width="90%" autoplay="true"></video>
                <img id="video_prev" src="../../ressources/filtres/0.png" width="90%" style="position:absolute; top:0px; left:5%">
                <div class="text-center">
                    <button onclick="picture()" id="startbutton" class="btn btn-rounded btn-primary w-100 font-weight-bold">TAKE PHOTO</button>
                    <form>
                        <label for="file_import" class="mt-2 font-weight-bold btn btn-outline-primary"><img width="30" src="../../ressources/upload-solid.svg"></label>
                        <input type="file" accept = "image/*" onchange="upload(event);" class="d-none" id="file_import">
                    </form>
                </div>
                <canvas id="cvs" width="480" height="360" class="d-none"></canvas>
            </div>
        </div>
        <div class="col-lg-5 mt-sm-1 mt-lg-0">
            <div class="bg-dark p-2 rounded">
                <label for="none" onclick="changeImage();" class="btn btn-rounded btn-primary w-100 font-weight-bold"><input type="radio" id="none" name="filter" value="0" class="d-none" checked>Sans effet</label>
                <label for="sepia" onclick="changeImage();" class="btn btn-rounded btn-primary w-100 font-weight-bold"><input type="radio" id="sepia" name="filter" value="1" class="d-none">Sepia</label>
                <label for="flamme" onclick="changeImage();" class="btn btn-rounded btn-primary w-100 font-weight-bold"><input type="radio" id="flamme" name="filter" value="2" class="d-none">Flamme</label>
                <label for="marvel" onclick="changeImage();" class="btn btn-rounded btn-primary w-100 font-weight-bold"><input type="radio" id="marvel" name="filter" value="3" class="d-none">Marvel</label>
                <label for="coeur" onclick="changeImage();" class="btn btn-rounded btn-primary w-100 font-weight-bold"><input type="radio" id="coeur" name="filter" value="4" class="d-none">Coeurs</label>
            </div>
            <div class="mt-2 bg-dark" style="position:relative;text-align:center;">
                <img src="" id="imagec" class="d-none">
                <img id="preview" width="380" height="260">
                <img id="previewfilter" width="380" height="260" src="../../ressources/filtres/0.png" style="position:absolute; top:0px; left:calc(50% - 190px);">
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>