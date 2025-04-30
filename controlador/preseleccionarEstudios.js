document.addEventListener("DOMContentLoaded",iniciar);
function iniciar(){
    var estudios=document.getElementById("estudios");
    var opciones=estudios.querySelectorAll("option");

   for(let i=0;i<opciones.length;i++){
    if(opciones[i]==usuEst){
        opciones[i].selected=true;
        break;
    }
   }
}