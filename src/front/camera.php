<?php
require_once('../../includes/session.php');
if (empty($_SESSION['user']))
    header('Location: login.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../includes/header.php');
?>

<script src="../js/photo.js"></script>

<div class="container-fluid">
    <div class="row bg-primary p-2">
        <div class="col-lg-7 text-center">
            <div class="bg-dark p-2 rounded">
                <video id="sourcevid" class="rounded" width="100%" height="70%" autoplay="true"></video>
                <div class="text-center">
                    <button onclick="picture()" id="startbutton" class="btn btn-rounded btn-primary w-100 font-weight-bold">TAKE PHOTO</button>
                </div>
                <canvas id="cvs" class="mt-3 w-100 d-none"></canvas>
            </div>
        </div>
        <div class="col-lg-5 text-center">
            <div class="bg-dark p-2 rounded">
                <a href="#" class="btn btn-rounded btn-primary w-100 font-weight-bold">Effet 1</a>
                <a href="#" class="btn btn-rounded btn-primary w-100 font-weight-bold">Effet 2</a>
                <a href="#" class="btn btn-rounded btn-primary w-100 font-weight-bold">Effet 3</a>
                <a href="#" class="btn btn-rounded btn-primary w-100 font-weight-bold">Effet 4</a>
                <a href="#" class="btn btn-rounded btn-primary w-100 font-weight-bold">Effet 5</a>
            </div>
            <div class="p-2 mt-2">
                <img class="img-fluid rounded bg-dark p-2 mx-auto" src="https://fakeimg.pl/400/">
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>