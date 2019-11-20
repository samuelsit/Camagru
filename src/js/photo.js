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
    var width = video.width;
    var height = video.height;
    canvas.getContext('2d').drawImage(video, 0, 0, width*3, height*2.2);
    var base64 = canvas.toDataURL("image/png");
    $.ajax({
        type: "POST",
        url: "../back/photo.php",
        data: { 
           imgBase64: base64
        }
    });
}

window.onload = init();