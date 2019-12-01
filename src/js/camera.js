function changeImage()
{
    var xp = document.getElementById("video_prev");
    var vp = xp.getAttribute("src");
    var xpf = document.getElementById("previewfilter");
    var vpf = xpf.getAttribute("class");
    if (vpf == "no-camera") {
        if (document.getElementById("none").checked == true)
            vpf = "../../ressources/filtres/0.png";
        else if (document.getElementById("sepia").checked == true)
            vpf = "../../ressources/filtres/1.png";
        else if (document.getElementById("flamme").checked == true)
            vpf = "../../ressources/filtres/2.png";
        else if (document.getElementById("marvel").checked == true)
            vpf = "../../ressources/filtres/3.png";
        else if (document.getElementById("coeur").checked == true)
            vpf = "../../ressources/filtres/4.png";
        xpf.setAttribute("src", vpf);
    }
    if (document.getElementById("none").checked == true)
        vp = "../../ressources/filtres/0.png";
    else if (document.getElementById("sepia").checked == true)
        vp = "../../ressources/filtres/1.png";
    else if (document.getElementById("flamme").checked == true)
        vp = "../../ressources/filtres/2.png";
    else if (document.getElementById("marvel").checked == true)
        vp = "../../ressources/filtres/3.png";
    else if (document.getElementById("coeur").checked == true)
        vp = "../../ressources/filtres/4.png";
    xp.setAttribute("src", vp);
}

function init() {

    navigator.mediaDevices.getUserMedia({ audio: false, video: true }).then(function(mediaStream) {
        
        var video = document.getElementById('sourcevid');
        video.srcObject = mediaStream;
        
        video.onloadedmetadata = function(e) {
            video.play();
        };
      
    }).catch(function(err) {
        console.log(err.name + ": " + err.message);
        var x = document.getElementById("previewfilter");
        x.setAttribute("class", "no-camera");
        var filter = document.getElementById("video_prev");
        var vid = document.getElementById("sourcevid");
        var button = document.getElementById("startbutton");
        filter.classList.add("d-none");
        button.classList.add("d-none");
        vid.classList.add("d-none");
    });

}

function upload(e) {
    var file = e.target.files[0];
    if (file.type.match('image.*')) {
        var preview = document.getElementById('preview');
        var reader = new FileReader();
        reader.onload = function (readerEvent) {
            var image = new Image();
            image.onload = function (imageEvent) {
                var canvas = document.createElement('canvas');
                canvas.width = 480;
                canvas.height = 360;
                canvas.getContext('2d').drawImage(image, 0, 0, 480, 360);
                var dataUrl = canvas.toDataURL("image/png");
                preview.src = dataUrl;
                var base64 = dataUrl;
                var filter_val = 0;
                if (document.getElementById("none").checked == true)
                    filter_val = 0;
                else if (document.getElementById("sepia").checked == true)
                    filter_val = 1;
                else if (document.getElementById("flamme").checked == true)
                    filter_val = 2;
                else if (document.getElementById("marvel").checked == true)
                    filter_val = 3;
                else if (document.getElementById("coeur").checked == true)
                    filter_val = 4;
                $.ajax({
                    type: "POST",
                    url: "../back/camera.php",
                    data: { 
                        imgBase64: base64,
                        filter: filter_val
                    }
                });
                var x = document.getElementById("previewfilter");
                var v = x.getAttribute("src");
                if (document.getElementById("none").checked == true)
                    v = "../../ressources/filtres/0.png";
                else if (document.getElementById("sepia").checked == true)
                    v = "../../ressources/filtres/1.png";
                else if (document.getElementById("flamme").checked == true)
                    v = "../../ressources/filtres/2.png";
                else if (document.getElementById("marvel").checked == true)
                    v = "../../ressources/filtres/3.png";
                else if (document.getElementById("coeur").checked == true)
                    v = "../../ressources/filtres/4.png";
                x.setAttribute("src", v);
            }
            image.src = readerEvent.target.result;
        }
        reader.readAsDataURL(file);
    }
    else {
        alert("Ce n'est pas une image.");
    }
}

function picture() {
    var video = document.getElementById('sourcevid');
    var canvas = document.getElementById('cvs');
    var preview = document.getElementById('preview');
    var filter_val = 0;
    if (document.getElementById("none").checked == true)
        filter_val = 0;
    else if (document.getElementById("sepia").checked == true)
        filter_val = 1;
    else if (document.getElementById("flamme").checked == true)
        filter_val = 2;
    else if (document.getElementById("marvel").checked == true)
        filter_val = 3;
    else if (document.getElementById("coeur").checked == true)
        filter_val = 4;
    canvas.getContext('2d').drawImage(video, 0, 0, 480, 360);
    var base64 = canvas.toDataURL("image/png");
    $.ajax({
        type: "POST",
        url: "../back/camera.php",
        data: { 
           imgBase64: base64,
           filter: filter_val
        }
    });
    preview.setAttribute('src', base64);

    var x = document.getElementById("previewfilter");
    var v = x.getAttribute("src");
    if (document.getElementById("none").checked == true)
        v = "../../ressources/filtres/0.png";
    else if (document.getElementById("sepia").checked == true)
        v = "../../ressources/filtres/1.png";
    else if (document.getElementById("flamme").checked == true)
        v = "../../ressources/filtres/2.png";
    else if (document.getElementById("marvel").checked == true)
        v = "../../ressources/filtres/3.png";
    else if (document.getElementById("coeur").checked == true)
        v = "../../ressources/filtres/4.png";
    x.setAttribute("src", v);
}

window.onload = init();