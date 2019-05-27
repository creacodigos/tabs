function changeClass(valor){
    document.getElementsByTagName("body")[0].className = valor;
}
function removerClass()
{
    var body = document.getElementsByTagName("body")[0];
    body.classList.remove("oscuro");
}