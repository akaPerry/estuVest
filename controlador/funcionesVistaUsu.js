document.addEventListener("DOMContentLoaded",iniciar);
function iniciar(){
    document.getElementById("subirBtn").addEventListener("click", function (e) {
    if (!validarFormularioPublicacion()) {
      e.preventDefault(); // Bloquea el envío
    }
  });

     $('#centro').on('change', function () {
        const idCentro = $(this).val();
        llenarSelectEstudio(idCentro);
        llenarSelectAsignatura('0');
    });
     $('#estudio').on('change', function () {
        const idGrado = $(this).val();
        llenarSelectAsignatura(idGrado);
    });
    llenarSelectCentro();
}

function llenarSelectCentro(){
    var select = $('#centro');
    $.ajax({
        type: "POST",
        url: "../controlador/getCentros.php",
        data: {"nocache": Math.random()},
        dataType: "json",
        success: function(data){
            $.each(data, function(index, centro){
                var option="<option value='"+centro.id+"'>"+centro.centro+"</option>";
                select.append(option);
            });
        },
         error: function (xhr, status, error) {
      console.error("Error al obtener centros:", error);
    }
    });
}

function llenarSelectEstudio(idCentro){
     const select = $('#estudio'); 
    select.empty();
     if (idCentro==0) {
        select.append('<option value="0">Seleccione un centro de estudios</option>');
        return;
    }
    else{
        $.ajax({
        url:"../controlador/getEstudios.php",
        type: "POST",
        data: {
            "idCentro": idCentro,
            "nocache":Math.random()
        },
        dataType: "json",
        success:function(data){
            select.empty();
            select.append("<option value='0'>Selecciona un grado/asignatura</option>");
            $.each(data, function (index, modulo) {
                const option = `<option value='${modulo.id_relacion}'>${modulo.estudio}</option>`;
                select.append(option);
            });
        }
        });
    }
}
function llenarSelectAsignatura(idGrado){
    const select=$("#asignatura");
    select.empty();
    if(idGrado==0){
        select.append('<option value="0">Seleccione un grado/curso</option>');
    }else{
        $.ajax({
            url:"../controlador/getAsignaturas.php",
            type: "POST",
            data:{
                "idGrado":idGrado,
                "nocache":Math.random()
                },
            dataType: "json",
            success:function(data){
                select.empty();
                select.append("<option value='0'>Selecciona una asignatura</option>");
                $.each(data, function (index, asignatura) {
                    const option = `<option value='${asignatura.id}'>${asignatura.asignatura}</option>`;
                    select.append(option);
                });
            },
            error:function(){
                console.log("Error al obtener los datos");
                }
        });
    }
}

 function validarFormularioPublicacion() {
  const tituloInput = document.querySelector("input[name='titulo']");
  const cursoInput = document.querySelector("input[name='curso']");
  const centroSelect = document.getElementById("centro");
  const estudioSelect = document.getElementById("estudio");
  const asignaturaSelect = document.getElementById("asignatura");
  const alertContainer = document.getElementById("alertContainer");

  const titulo = tituloInput.value.trim();
  const curso = parseInt(cursoInput.value);
  const anioActual = new Date().getFullYear();

  let errores = [];

  // Limpiar errores anteriores
  [tituloInput, cursoInput, centroSelect, estudioSelect, asignaturaSelect].forEach(el => el.classList.remove("campo-error"));
  alertContainer.innerHTML = ""; // Limpiar alerta previa

  const regexTitulo = /^(?!\s*$).+/;

  if (!regexTitulo.test(titulo)) {
    errores.push("El título no puede estar vacío.");
    tituloInput.classList.add("campo-error");
  }

  if (isNaN(curso) || curso < 2000 || curso > anioActual) {
    errores.push(`El curso debe estar entre 2000 y ${anioActual}.`);
    cursoInput.classList.add("campo-error");
  }

  if (centroSelect.value === "0") {
    errores.push("Debes seleccionar un centro.");
    centroSelect.classList.add("campo-error");
  }

  if (estudioSelect.value === "0") {
    errores.push("Debes seleccionar un grado.");
    estudioSelect.classList.add("campo-error");
  }

  if (asignaturaSelect.value === "0") {
    errores.push("Debes seleccionar una asignatura.");
    asignaturaSelect.classList.add("campo-error");
  }

  if (errores.length > 0) {
    const htmlErrores = errores.map(err => `<li>${err}</li>`).join("");
    const alertaHTML = `
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Se han encontrado los siguientes errores:</strong>
        <ul class="mb-0">${htmlErrores}</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    `;
    alertContainer.innerHTML = alertaHTML;
    return false;
  }

  return true;
}

  