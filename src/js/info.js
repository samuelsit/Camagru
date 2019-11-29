function changeImage()
{
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