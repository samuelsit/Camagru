function changeImage()
{
    var x = document.getElementById("previewfilter");
    var v = x.getAttribute("src");
    var xp = document.getElementById("video_prev");
    var vp = xp.getAttribute("src");
    if (document.getElementById("none").checked == true) {
        v = "../../ressources/filtres/0.png";
        vp = "../../ressources/filtres/0.png";
    }
    else if (document.getElementById("sepia").checked == true) {
        v = "../../ressources/filtres/1.png";
        vp = "../../ressources/filtres/1.png";
    }
    else if (document.getElementById("flamme").checked == true) {
        v = "../../ressources/filtres/2.png";
        vp = "../../ressources/filtres/2.png";
    }
    else if (document.getElementById("marvel").checked == true) {
        v = "../../ressources/filtres/3.png";
        vp = "../../ressources/filtres/3.png";
    }
    else if (document.getElementById("coeur").checked == true) {
        v = "../../ressources/filtres/4.png";
        vp = "../../ressources/filtres/4.png";
    }
    x.setAttribute("src", v);
    xp.setAttribute("src", vp);
}

function init() {

    navigator.mediaDevices.getUserMedia({ audio: false, video: true }).then(function(mediaStream) {
        
        var video = document.getElementById('sourcevid');
        video.srcObject = mediaStream;
        
        video.onloadedmetadata = function(e) {
            video.play();
        };
      
    }).catch(function(err) { console.log(err.name + ": " + err.message); });

}

function picture() {
    var video = document.getElementById('sourcevid');
    var canvas = document.getElementById('cvs');
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
}

window.onload = init();