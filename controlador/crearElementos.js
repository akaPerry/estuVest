document.addEventListener("DOMContentLoaded", iniciar);
function iniciar() {
  console.log("Botones encontrados:",
    document.getElementById('btnModCentro'),
    document.getElementById('btnModAsig'),
    document.getElementById('btnModEstudio'));


  
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

function eliminarElemento(id, tipo) {
  console.log("Eliminar elemento con id:", id, "y tipo:", tipo);
  if(confirm("¿Seguro que deseas eliminar este elemento?")){
    $.ajax({
      url: '../controlador/eliminarElemento.php',
      type: 'POST',
      dataType:'json',
      data: {
        'id': id,
        'tabla': tipo,
        'nocache': Math.random()
      },
      success:function(data){
        console.log("Elemento eliminado correctamente: "+data);
        $('#tablaElementos').empty();
        mostrarLista(tipo);
      },
      error:function(xhr){
        console.error("Error al eliminar elemento:", xhr.responseText);
        alert("Error al eliminar: " + xhr.responseText);
      }
    });
  
}
}
function mostrarFormulario(tipo) {
  //Según el boton que pulses muestra un formulario distinto
  const contenedor = document.getElementById('formularioConfiguracion');
  let html = '';

  if (tipo === 'centro') {
    html = `
      <h3 name='encabezado' id='encabezado'>Nuevo Centro Educativo</h3>
      <form id="formCentro">
        <label>Nombre del Centro:</label>
        <input type="text" name="centro" id="centro" class="form-control"><br>
        <label>Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" class="form-control"><br>
        <label>Tipo:</label>
      <select name="tipo" id="tipo" class="form-control">
      <option value="universidad">Universidad</option>
      <option value="instituto">Instituto</option>
      <option value="otros">Otros</option>
      <input type="hidden" name="formTipo" value="centro">

      </select>
        <button type="submit" class="btn btn-primary mt-2" name="guardar" id="guardar">Guardar Centro</button>
      </form>
    `;
  } else if (tipo === 'asignatura') {
    pintarEstudios();
    html = `
      <h3 name='encabezado' id='encabezado'>Nueva Asignatura</h3>
      <form id="formAsignatura">
        <label>Nombre de la Asignatura:</label>
        <input type="text" name="nombreAsignatura" id="nombreAsignatura" class="form-control"><br>
        <label>Estudio al que pertenece:</label>
        <select name="estudioAsignatura" id="estudioAsignatura" class="form-control"></select><br>
        <label>Año del comienzo del Curso</label>
        <input type="number" name="anio" id="anio" class="form-control">
        <input type="hidden" name="formTipo" value="asignatura">

        <button type="submit" class="btn btn-primary mt-2" name="guardar" id="guardar">Guardar Asignatura</button>
      </form>
    `;
  } else if (tipo === 'estudio') {
    pintarCentros();
    html = `
      <h3 name='encabezado' id='encabezado'>Nueva Carrera/Grado</h3>
      <form id="formEstudio">
        <label>Nombre de la Carrera/Grado:</label>
        <input type="text" name="nombreEstudio" id="nombreEstudio" class="form-control"><br>
        <label>Centro Educativo:</label>
        <select id="centro" name="centro" class="form-control">
        </select>
        <br>
        <label>Nivel:</label><br>
        <select id="nivel" name="nivel" class="form-control">
        <option value="ESO">ESO</option>
        <option value="bachillerato">Bachillerato</option>
        <option value="grado medio">Grado Medio</option>
        <option value="grado superior">Grado Superior</option>
        <option value="grado universitario">Grado Universitario</option>
        <option value="master">Máster</option>
        <option value="otro">Otro</option>
        </select><br>
        <input type="hidden" name="formTipo" value="estudio">

        <button type="submit" class="btn btn-primary mt-2" name="guardar" id="guardar">Guardar Estudio</button>
      </form>
    `;
  }
 

  contenedor.innerHTML = html;
  const form = contenedor.querySelector('form');
  // si se envía algún formulario se valida primero y se define la ruta del controlador
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    if (validarFormulario(form)) {
      let url = '';
      if (tipo === 'centro') url = '../controlador/addCentro.php';
      else if (tipo === 'asignatura') url = '../controlador/addAsignatura.php';
      else if (tipo === 'estudio') url = '../controlador/addEstudio.php';
      alert('Formulario válido.');
      // Convertir datos del formulario a objeto
      const formData = {};
      const inputs = form.querySelectorAll('input, select');

      inputs.forEach(input => {
        formData[input.name] = input.value.trim();
      });
      // enviar datos al servidor

      $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (respuesta) {
          alert('Datos guardados correctamente: ' + respuesta);
          form.reset();
        },
        error: function (xhr, status, error) {
          alert('Error al guardar: ' + error);
        }
      });

    } else {
      alert('Por favor, completa todos los campos correctamente (sin símbolos ni caracteres especiales).');
    }
  });
}
function mostrarLista(tipo) {
  console.log("Entrando en mostrarLista con tipo: ", tipo);

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
function editarElemento(id, tabla){
  // Código para editar un elemento de la tabla
  console.log("Entrando en editarElemento con id: ", id, "y tabla: ", tabla);
  mostrarFormulario(tabla);
  $("#encabezado").text("Editar "+tabla);
  
  let url='../controlador/get'+tabla.charAt(0).toUpperCase() + tabla.slice(1) + 's.php';
  $.ajax({
    url: url,
    type: 'POST',
    data: {
      'id': id,
      'nocache': Math.random()
    },
    dataType: 'json',
    success: function(data){
      console.log("Datos para editar: ", data);
      const form = document.querySelector('#formularioConfiguracion form');
      for (const key in data[0]) {
        console.log("Key: ",key);
        if (data[0].hasOwnProperty(key)) {
          const input = form.querySelector(`[name="${key}"]`);
          if (input) {
            input.value = data[0][key];
          }
        }
      }
      $('#guardar').click(function(){
        $('#guardar').preventDefault();
        let datos = new FormData(form);
        console.log(datos);
        $.ajax({
          url: '../controlador/edit'+tabla.charAt(0).toUpperCase() + tabla.slice(1)+'.php',
          type: 'POST',
          data: {datos,
            "nocache" : Math.random()
          },
          

        });
      });
    },
    error: function(xhr, status, error){
      console.error("Error al obtener datos para editar:", error);
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
      console.log("estudios: " + data);
      var select = $("#estudioAsignatura");
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
      console.log("centros: " + data);

      var select = $("#centro");
      select.empty();
      $.each(data, function (index, centro) {
        var option = '<option value="' + centro.id + '">' + centro.centro + '</option>';
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