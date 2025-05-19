document.addEventListener("DOMContentLoaded", iniciar);
function iniciar() {
  //funcionalidad de los botones del apartado de configuración 
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
//funcion para eliminar tuplas de las tablas: asignatura, centro y estudio
function eliminarElemento(id, tipo) {
  console.log("Eliminar elemento con id:", id, "y tipo:", tipo);
  if (confirm("¿Seguro que deseas eliminar este elemento?")) {
    $.ajax({
      url: '../controlador/eliminarElemento.php',
      type: 'POST',
      dataType: 'json',
      data: {
        'id': id,
        'tabla': tipo,
        'nocache': Math.random()
      },
      success: function (data) {
        console.log("Elemento eliminado correctamente: " + data);
        //actualiza la tabla
        $('#tablaElementos').empty();
        document.getElementById('formularioConfiguracion').innerHTML = '';
        mostrarLista(tipo);
      },
      error: function (xhr) {
        console.error("Error al eliminar elemento:", xhr.responseText);
        alert("Error al eliminar: " + xhr.responseText);
      }
    });

  }
}
function mostrarFormulario(tipo, modo = 'crear', datos = null, id = null) {
  console.log(datos);
  const contenedor = document.getElementById('formularioConfiguracion');
  let html = '';
  let encabezado = (modo === 'editar' ? 'Editar ' : 'Nuevo ') + tipo.charAt(0).toUpperCase() + tipo.slice(1);

  if (tipo === 'centro') {
    html = `
      <h3 id='encabezado'>${encabezado}</h3>
      <form id="formElemento">
        <label>Nombre del Centro:</label>
        <input type="text" name="centro" id="centro" class="form-control"><br>
        <label>Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" class="form-control"><br>
        <label>Tipo:</label>
        <select name="tipo" class="form-control">
          <option value="universidad">Universidad</option>
          <option value="instituto">Instituto</option>
          <option value="otros">Otros</option>
        </select>
        <button type="submit" class="btn btn-primary mt-2" id="guardar">Guardar</button>
      </form>
    `;
  } else if (tipo === 'asignatura') {
    pintarEstudios();
    html = `
      <h3 id='encabezado'>${encabezado}</h3>
      <form id="formElemento">
        <label>Nombre de la Asignatura:</label>
        <input type="text" name="asignatura" id="asignatura" class="form-control"><br>
        <label>Estudio al que pertenece:</label>
        <select name="grado" id="grado" class="form-control"></select><br>
        <label>Año del comienzo del Curso</label>
        <input type="number" name="curso" id="curso" class="form-control">
        <button type="submit" class="btn btn-primary mt-2" id="guardar">Guardar</button>
      </form>
    `;
  } else if (tipo === 'estudio') {
    pintarCentros();
    html = `
      <h3 id='encabezado'>${encabezado}</h3>
      <form id="formElemento">
        <label>Nombre de la Carrera/Grado:</label>
        <input type="text" name="estudio" id="estudio" class="form-control"><br>
        <label>Centro Educativo:</label>
        <select name="centro" id="centro" class="form-control"></select><br>
        <label>Nivel:</label><br>
        <select name="nivel" id="nivel" class="form-control">
          <option value="ESO">ESO</option>
          <option value="bachillerato">Bachillerato</option>
          <option value="grado medio">Grado Medio</option>
          <option value="grado superior">Grado Superior</option>
          <option value="grado universitario">Grado Universitario</option>
          <option value="master">Máster</option>
          <option value="otro">Otro</option>
        </select><br>
        <button type="submit" class="btn btn-primary mt-2" id="guardar">Guardar</button>
      </form>
    `;
  }

  contenedor.innerHTML = html;

  // Rellenar si es edición
  if (modo === 'editar' && datos) {
    const form = contenedor.querySelector('form');
    for (const key in datos) {
      if (form.elements[key]) {
        form.elements[key].value = datos[key];
      }
    }
  }

  // Listener al enviar formulario
  const form = document.getElementById("formElemento");
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    if (!validarFormulario(form)) {
      alert("Por favor, completa todos los campos correctamente.");
      return;
    }

    const formData = {};
    const inputs = form.querySelectorAll("input, select");
    inputs.forEach(input => {
      formData[input.name] = input.value.trim();
    });

    let url = "";
    if (modo === "crear") {
      url = "../controlador/add" + tipo.charAt(0).toUpperCase() + tipo.slice(1) + ".php";
    } else {
      url = "../controlador/editar" + tipo.charAt(0).toUpperCase() + tipo.slice(1) + ".php";
      formData["id_" + tipo] = id;
    }

    $.ajax({
      url: url,
      type: "POST",
      data: formData,
      success: function (respuesta) {
        alert(modo === "crear" ? "Guardado con éxito" : "Modificado con éxito");
        mostrarLista(tipo);
      },
      error: function (xhr) {
        alert("Error al guardar: " + xhr.responseText);
      }
    });
  });
}


//función para mostrar todas las tuplas de la tabla seleccionada
function mostrarLista(tipo) {
  console.log("Entrando en mostrarLista con tipo: ", tipo);
  //según la selección se elige un php
  let url = '';
  let elementos;
  if (tipo === 'centro') {
    url = '../controlador/getCentros.php';
    elementos = ['centro', 'ciudad', 'tipo'];

  }
  else if (tipo === 'asignatura') {
    url = '../controlador/getAsignaturas.php';
    elementos = ['asignatura', 'grado', 'curso'];
  }
  else if (tipo === 'estudio') {
    url = '../controlador/getEstudios.php';
    elementos = ['estudio', 'centro', 'nivel'];

  }
  $.ajax({
    url: url,
    type: 'GET',
    data: {
      'nocache': Math.random()
    },
    dataType: 'json',
    success: function (data) {
      console.log("Script iniciado correctamente");
      const contenedor = document.getElementById('formularioConfiguracion');
      let html = `<h3>Listado</h3><table class="table table-striped" id="tablaElementos"><thead><tr>`;

      // Encabezados de la tabla
      elementos.forEach(el => {
        html += `<th>${el.charAt(0).toUpperCase() + el.slice(1)}</th>`;
      });

      html += `<th>Eliminar</th><th>Editar</th></tr></thead><tbody>`;

      // Filas de la tabla
      data.forEach(item => {
        html += `<tr>`;
        elementos.forEach(el => {
          html += `<td>${item[el]}</td>`;
        });
        // Agregar botón para eliminar y editar
        html += `<td><button class="btn btn-danger" onclick="eliminarElemento(${item.id}, '${tipo}')">Eliminar</button></td>`;
        html += `<td><button class="btn btn-success" onclick="editarElemento(${item.id}, '${tipo}')">Editar</button></td>`;
        html += `</tr>`;

      });

      html += `</tbody></table>`;
      contenedor.innerHTML = html;
    }
  })
}

// Código para editar un elemento de la tabla
function editarElemento(id, tipo) {
  let url = '../controlador/get' + tipo.charAt(0).toUpperCase() + tipo.slice(1) + 's.php';

  $.ajax({
    url: url,
    type: 'POST',
    data: { id: id, nocache: Math.random() },
    dataType: 'json',
    success: function (data) {
      if (data && data.length > 0) {
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
function pintarEstudios() {
  $.ajax({
    type: "post",
    url: "../controlador/getEstudios.php",
    data: { "nocache": Math.random() },
    dataType: "json",
    success: function (data) {
      console.log("pintando estudios: " + data);
      var select = $("#grado");
      $.each(data, function (index, estudio) {
        var option = '<option value="' + estudio.id_relacion + '" >' +
          estudio.centro + ' - ' +
          estudio.estudio + '</option>';

        select.append(option);
      })
    }
  });
};
function pintarCentros() {
  $.ajax({
    type: "post",
    url: "../controlador/getCentros.php",
    data: { "nocache": Math.random() },
    dataType: "json",
    success: function (data) {
      console.log("pintando centros: " + data);

      var select = $("#centro");
      select.empty();
      $.each(data, function (index, centro) {
        var option = '<option value="'+centro.id+'">'+ centro.centro +'</option>';
        select.append(option);
      })
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", error);
      console.log("XHR:", xhr.responseText);
    }

  });
}
function validarFormulario(form) {
  //valida que el formulario no esté vacío ni tenga carácteres extraños
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