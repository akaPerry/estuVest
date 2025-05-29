document.addEventListener("DOMContentLoaded", iniciar);
function iniciar() {
  generarAvisosPublicacion();
  console.log("Función iniciar ejecutada correctamente");

  // Asignar eventos a botones
  document.getElementById('btnCentro').addEventListener('click', function () {
    mostrarFormulario('centro');
  });

  document.getElementById('btnAsig').addEventListener('click', function () {
    mostrarFormulario('asignatura');
    pintarCentros();
  });

  document.getElementById('btnEstudio').addEventListener('click', function () {
    mostrarFormulario('estudio');
  });

  document.getElementById('btnModCentro').addEventListener('click', function () {
    mostrarLista('centro');
  });

  document.getElementById('btnModAsig').addEventListener('click', function () {
    mostrarLista('asignatura');
  });

  document.getElementById('btnModEstudio').addEventListener('click', function () {
    mostrarLista('estudio');
  });
}

// Función para pintar estudios en el select correspondiente
function pintarEstudios(valorSeleccionado = null) {
  var select = $("#grado");
  select.empty();
  $.ajax({
    type: "POST",
    url: "../controlador/getEstudios.php",
    data: { "nocache": Math.random() },
    dataType: "json",
    success: function (data) {
      console.log("Datos de estudios recibidos:", data);
      $.each(data, function (index, estudio) {
        var option = '<option value="' + estudio.id_relacion + '">' +
          estudio.centro + ' - ' + estudio.estudio + '</option>';
        select.append(option);
      });
      if (valorSeleccionado) {
        select.val(valorSeleccionado);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener estudios:", error);
    }
  });
}

// Función para pintar centros en el select correspondiente
function pintarCentros(valorSeleccionado = null) {
  var select = $("#centro");
  select.empty();
  $.ajax({
    type: "POST",
    url: "../controlador/getCentros.php",
    data: { "nocache": Math.random() },
    dataType: "json",
    success: function (data) {
      console.log("Datos de centros recibidos:", data);
      $.each(data, function (index, centro) {
        var option = '<option value="' + centro.id + '">' + centro.centro + '</option>';
        select.append(option);
      });
      if (valorSeleccionado) {
        select.val(valorSeleccionado);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener centros:", error);
    }
  });
}

// Función para mostrar formulario según tipo y modo (crear o editar)
function mostrarFormulario(tipo, modo = 'crear', datos = null, id = null) {
  console.log("Datos a editar con id "+id+":" , datos);
  const contenedor = document.getElementById('formularioConfiguracion');
  let html = '';
  let encabezado = (modo === 'editar' ? 'Editar ' : 'Nuevo ') + tipo.charAt(0).toUpperCase() + tipo.slice(1);

  if (tipo === 'centro') {
    html = `
      <h3>${encabezado}</h3>
      <form id="formElemento">
        <label>Nombre del Centro:</label>
        <input type="text" name="centro" id="centro" class="form-control"><br>
        <label>Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" class="form-control"><br>
        <label>Tipo:</label>
        <select name="tipo" id="tipo" class="form-control">
          <option value="universidad">Universidad</option>
          <option value="instituto">Instituto</option>
          <option value="otros">Otros</option>
        </select>
        <button type="submit" class="btn btn-primary mt-2">Guardar</button>
      </form>
    `;
  } else if (tipo === 'asignatura') {
    html = `
      <h3>${encabezado}</h3>
      <form id="formElemento">
        <label>Nombre de la Asignatura:</label>
        <input type="text" name="asignatura" id="asignatura" class="form-control"><br>
        <label>Estudio al que pertenece:</label>
        <select name="grado" id="grado" name="grado" class="form-control"></select><br>
        <label>Año del comienzo del Curso:</label>
        <input type="number" name="curso" id="curso" class="form-control">
        <button type="submit" class="btn btn-primary mt-2">Guardar</button>
      </form>
    `;

  } else if (tipo === 'estudio') { 
    
    html = `
      <h3>${encabezado}</h3>
      <form id="formElemento">
        <label>Nombre de la Carrera/Grado:</label>
        <input type="text" name="estudio" id="estudio" class="form-control"><br>
        <label>Centro Educativo:</label>
        <select name="centro" id="centro" class="form-control"></select><br>
        <label>Nivel:</label>
        <select name="nivel" id="nivel" class="form-control">
          <option value="ESO">ESO</option>
          <option value="bachillerato">Bachillerato</option>
          <option value="grado medio">Grado Medio</option>
          <option value="grado superior">Grado Superior</option>
          <option value="grado universitario">Grado Universitario</option>
          <option value="master">Máster</option>
          <option value="otro">Otro</option>
        </select><br>
        <button type="submit" class="btn btn-primary mt-2">Guardar</button>
      </form>
    `;
  }

  contenedor.innerHTML = html;

if (tipo === 'asignatura') {
 const idEstudio = modo === 'editar' && datos ? datos.id_grado : null;
  pintarEstudios(idEstudio);
}
if (tipo === 'estudio') {
  pintarCentros();
}

  // Si es modo editar, rellenar campos con datos haciendo mapeo de claves
  if (modo === 'editar' && datos) {
    const form = document.getElementById('formElemento');
    // Mapeo de claves backend a nombres inputs
    let mapCampos = {};
    if (tipo === 'centro') {
      mapCampos = {
        'centro': 'centro',
        'ciudad': 'ciudad',
        'tipo': 'tipo'
      };
    } else if (tipo === 'asignatura') {
      mapCampos = {
        'asignatura': 'asignatura',
        'id_grado': 'grado',
        'curso': 'curso'
      };
    } else if (tipo === 'estudio') {
      mapCampos = {
        'estudio': 'estudio',
        'id_relacion': 'centro',
        'nivel': 'nivel'
      };
    }
    for (const key in mapCampos) {
      if (datos.hasOwnProperty(key) && form.elements[mapCampos[key]]) {
        form.elements[mapCampos[key]].value = datos[key];
        console.log(form.elements[mapCampos[key]]+": "+datos[key]);
      }
    }
    if (modo === 'editar' && datos) {
  if (tipo === 'asignatura') {
    pintarEstudios(datos.id_grado);
  } else if (tipo === 'estudio') {
    pintarCentros(datos.id_relacion);
  }
  }
}

  // Añadir listener para submit del formulario
  form = document.getElementById('formElemento');
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    if (!validarFormulario(form)) {
      alert("Por favor, completa todos los campos correctamente.");
      return;
    }

    const formData = {};
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
      formData[input.name] = input.value.trim();
    });

    let url = '';
    if (modo === 'crear') {
      url = '../controlador/add' + tipo.charAt(0).toUpperCase() + tipo.slice(1) + '.php';
    } else {
      url = '../controlador/editar' + tipo.charAt(0).toUpperCase() + tipo.slice(1) + '.php';
      formData['id_' + tipo] = id;
    }

    $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      success: function (respuesta) {
        alert(modo === 'crear' ? 'Guardado con éxito' : 'Modificado con éxito');
        console.log(url," ",formData);
        mostrarLista(tipo);
      },
      error: function (xhr) {
        alert('Error al guardar: ' + xhr.responseText);
      }
    });
  });
}

// Función para validar formulario (campos no vacíos y sin caracteres extraños)
function validarFormulario(form) {
  const inputs = form.querySelectorAll('input, select');
  const regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ0-9\s,.\-]+$/;
  let valido = true;

  inputs.forEach(input => {
    const valor = input.value.trim();
    if (valor === '' || !regex.test(valor)) {
      input.classList.add('is-invalid');
      valido = false;
    } else {
      input.classList.remove('is-invalid');
    }
  });

  return valido;
}

// Función para mostrar lista de elementos según tipo
function mostrarLista(tipo) {
  console.log("Entrando en mostrarLista con tipo: ", tipo);
  let url = '';
  let elementos = [];

  if (tipo === 'centro') {
    url = '../controlador/getCentros.php';
    elementos = ['centro', 'ciudad', 'tipo'];
  } else if (tipo === 'asignatura') {
    url = '../controlador/getAsignaturas.php';
    elementos = ['asignatura', 'grado', 'curso'];
  } else if (tipo === 'estudio') {
    url = '../controlador/getEstudios.php';
    elementos = ['estudio', 'centro', 'nivel'];
  }

  $.ajax({
    url: url,
    type: 'GET',
    data: { 'nocache': Math.random() },
    dataType: 'json',
    success: function (data) {
      const contenedor = document.getElementById('formularioConfiguracion');
      let html = `<h3>Listado</h3><table class="table table-striped" id="tablaElementos"><thead><tr>`;

      // Encabezados
      elementos.forEach(el => {
        html += `<th>${el.charAt(0).toUpperCase() + el.slice(1)}</th>`;
      });

      html += `<th>Eliminar</th><th>Editar</th></tr></thead><tbody>`;

      // Filas
      data.forEach(item => {
        html += `<tr>`;
        elementos.forEach(el => {
          html += `<td>${item[el]}</td>`;
        });
        html += `<td><button class="btn btn-danger" onclick="eliminarElemento(${item.id}, '${tipo}')">Eliminar</button></td>`;
        html += `<td><button class="btn btn-success" onclick="editarElemento(${item.id}, '${tipo}')">Editar</button></td>`;
        html += `</tr>`;
      });

      html += `</tbody></table>`;
      contenedor.innerHTML = html;
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener lista:", error);
    }
  });
}

// Función para eliminar elemento
function eliminarElemento(id, tipo) {
  if (confirm("¿Seguro que deseas eliminar este elemento?")) {
    $.ajax({
      url: '../controlador/eliminarElemento.php',
      type: 'POST',
      dataType: 'json',
      data: { 'id': id, 'tabla': tipo, 'nocache': Math.random() },
      success: function (data) {
        alert("Elemento eliminado correctamente");
        mostrarLista(tipo);
      },
      error: function (xhr) {
        alert("Error al eliminar: " + xhr.responseText);
      }
    });
  }
}

// Función para editar elemento
function editarElemento(id, tipo) {
  let url = '../controlador/get' + tipo.charAt(0).toUpperCase() + tipo.slice(1) + 's.php';
  $.ajax({
    url: url,
    type: 'POST',
    data: { id: id,
       nocache: Math.random() },
    dataType: 'json',
    success: function (data) {
      if (data && data.length > 0) {
        console.log("Datos sacados del AJAX: "+data[0]);
        mostrarFormulario(tipo, 'editar', data[0], id);
      } else {
        alert("No se encontraron datos para editar.");
      }
    },
    error: function (xhr) {
      alert("Error al obtener datos: " + xhr.responseText);
    }
  });
}


function generarAvisosPublicacion(){
  let url = '../controlador/getPublicaciones.php';

  $.ajax({
      url: url,
      type: 'POST',
      success: function(response) {
          $("#publicacionesRevisar").html(response);
        
          const total = $("#contenedorPublicaciones").data("count");
          if (total !== undefined) {
              $("#alertNumber").html(total);
          }
      },
      error: function() {
          $("#publicacionesRevisar").html('<div class="alert alert-danger">Error al cargar las publicaciones.</div>');
      }
  });
}


function aceptarPublicacion(btn) {
    const id = $(btn).data("id");
    actualizarPublicacion(id, 'aceptar');
}

function rechazarPublicacion(btn) {
    const id = $(btn).data("id");
    actualizarPublicacion(id, 'rechazar');
}


function actualizarPublicacion(id, accion) {
    $.ajax({
        url: '../controlador/updatePublicacion.php',
        type: 'POST',
        data: {
            id: id,
            accion: accion
        },
        success: function(response) {
            alert(response);
            
            // Elimina la card del DOM
            const card = $('button[data-id="' + id + '"]').closest('.card');
            card.remove();

            // Actualiza el contador
            let total = parseInt($("#alertNumber").text());
            if (!isNaN(total) && total > 0) {
                total -= 1;
                $("#alertNumber").text(total);
            }

            // Opcional: ocultar el aviso si no quedan publicaciones
            if (total === 0) {
                $("#alertNumber").closest('.alert').hide(); // o mostrar otro mensaje
                $("#publicacionesRevisar").html('<div class="alert alert-info">No hay más publicaciones pendientes.</div>');
            }
        },
        error: function() {
            alert("Error al procesar la publicación.");
        }
    });
}
