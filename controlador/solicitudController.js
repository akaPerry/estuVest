document.addEventListener("DOMContentLoaded", function () {
  const tipoInput = document.getElementById("elementoTipo");
  const form=document.getElementById("formSolicitud");
  
  //comprobamos que el formulario se ha rellenado correctamente y pasamos los datos a json
  form.addEventListener('submit',(event)=>{
    event.preventDefault();
if(!validarFormulario(form)){
  
   alert("Por favor, completa todos los campos correctamente.");
   return;
}

// Convertir campos del formulario a objeto
const formData = {};
const inputs = form.querySelectorAll("input, select, textarea");

inputs.forEach(input => {
  const name = input.name;
  const value = input.value.trim();

  if (name !== "id_usuario" && name !== "elemento") {
    formData[name] = value;
    input.value = ""; // Vacía el campo después de recoger el valor
  }
});

const datosSolicitud = {
  id_usuario: form.querySelector('[name="id_usuario"]').value,
  elemento: form.querySelector('[name="elemento"]').value,
  valor: JSON.stringify(formData) // el JSON con los datos del formulario
};
console.log(datosSolicitud);
//enviamos los datos por AJAX
$.ajax({
  type: "POST",
  url: "../controlador/addSolicitud.php",
  data: datosSolicitud,
  success:function(){
    //$(form).reset();
    window.alert("Solicitud enviada correctamente. Será revisada por un administrador");
  },
});
  });
  
  // Función auxiliar que decide qué select pintar
  function actualizarSelectsPorTipo() {
    if (!tipoInput) return;

    const tipo = tipoInput.value;

    if (tipo === 'estudio') {
      if (typeof pintarCentros === 'function') {
        setTimeout(() => pintarCentros(), 100);
      } else {
        console.warn("Función pintarCentros no disponible.");
      }
    } else if (tipo === 'asignatura') {
      if (typeof pintarEstudios === 'function') {
        setTimeout(() => pintarEstudios(), 100);
      } else {
        console.warn("Función pintarEstudios no disponible.");
      }
    }
  }

  // Detecta clicks en los botones de solicitud (usando IDs de la vista)
  ['btnCentro', 'btnEstudio', 'btnAsig'].forEach(id => {
    const btn = document.getElementById(id);
    if (btn) {
      btn.addEventListener('click', () => {
        setTimeout(actualizarSelectsPorTipo, 150); // Espera a que se renderice el formulario
      });
    }
  });

  // Por si se cambia manualmente el campo oculto de tipo
  if (tipoInput) {
    tipoInput.addEventListener("change", actualizarSelectsPorTipo);
  }
});

