function getColor(){

    var color = localStorage.getItem('color');
    var body = document.getElementsByTagName("body")[0];

    if(color && color.length > 0)
    {
        body.classList.remove("oscuro");
        body.classList.add(color);
    }
}
function changeClass(valor){
    document.getElementsByTagName("body")[0].className = valor;
    localStorage.setItem('color', valor);
}
function removerClass()
{
    var body = document.getElementsByTagName("body")[0];
    body.classList.remove("oscuro");
    localStorage.removeItem('color');
}

document.addEventListener("DOMContentLoaded", function(event) { 
    getColor();
  });