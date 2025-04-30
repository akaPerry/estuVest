document.addEventListener("DOMContentLoaded", iniciar);
function iniciar() {

  function pintarCentros(){
    $.ajax({
      type:"post",
      url:"../controlador/getCentros.php",
      data:{"nocache":Math.random()},
      dataType:"json",
      success:function(data){
        console.log(data); 

        var select=$("#centro");
        select.empty();
        $.each(data, function(index, centro){
          var option='<option value="'+centro.id_centro+'">'+centro.nombre_centro+'</option>';
          select.append(option);
        })
      },
      error: function(xhr, status, error) {
        console.error("AJAX Error:", error);
        console.log("XHR:", xhr.responseText);
      }
      
    });
  }
  document.getElementById('btnCentro').addEventListener('click', function () {
    mostrarFormulario('centro');
  });

  document.getElementById('btnAsig').addEventListener('click', function () {
    mostrarFormulario('asignatura');
    pintarCentros();
  });

  document.getElementById('btnCarrera').addEventListener('click', function () {
    mostrarFormulario('carrera');
  });

  function mostrarFormulario(tipo) {
    const contenedor = document.getElementById('formularioConfiguracion');
    let html = '';

    if (tipo === 'centro') {
      html = `
        <h3>Nuevo Centro Educativo</h3>
        <form id="formCentro">
          <label>Nombre del Centro:</label>
          <input type="text" name="nombreCentro" id="nombreCentro" class="form-control"><br>
          <label>Ciudad:</label>
          <input type="text" name="ciudad" id="ciudad" class="form-control"><br>
          <label>Tipo:</label>
        <select name="tipoCentro" id="tipoCentro" class="form-control">
        <option value="universidad">Universidad</option>
        <option value="instituto">Instituto</option>
        <option value="otros">Otros</option>
        <input type="hidden" name="formTipo" value="centro">

        </select>
          <button type="submit" class="btn btn-primary mt-2">Guardar Centro</button>
        </form>
      `;
    } else if (tipo === 'asignatura') {
      html = `
        <h3>Nueva Asignatura</h3>
        <form id="formAsignatura">
          <label>Nombre de la Asignatura:</label>
          <input type="text" name="nombreAsignatura" id="nombreAsignatura" class="form-control"><br>
          <label>Estudio al que pertenece:</label>
          <input type="text" name="estudioAsignatura" id="estudioAsignatura" class="form-control"><br>
          <input type="hidden" name="formTipo" value="asignatura">

          <button type="submit" class="btn btn-primary mt-2">Guardar Asignatura</button>
        </form>
      `;
    } else if (tipo === 'carrera') {
      pintarCentros();
      html = `
        <h3>Nueva Carrera/Grado</h3>
        <form id="formCarrera">
          <label>Nombre de la Carrera/Grado:</label>
          <input type="text" name="nombreCarrera" id="nombreCarrera" class="form-control"><br>
          <label>Centro Educativo:</label>
          <select id="centro" name="centro" class="form-control">
          </select>
          <br>
          <label>Nivel</label><br>
          <select id="nivel" name="nivel" class="form-control">
          <option value="ESO">ESO</option>
          <option value="bachillerato">Bachillerato</option>
          <option value="grado medio">Grado Medio</option>
          <option value="grado superior">Grado Superior</option>
          <option value="grado universitario">Grado Universitario</option>
          <option value="master">Máster</option>
          <option value="otro">Otro</option>
          </select><br>
          <input type="hidden" name="formTipo" value="carrera">

          <button type="submit" class="btn btn-primary mt-2">Guardar Carrera</button>
        </form>
      `;
    }
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

    contenedor.innerHTML = html;
    const form = contenedor.querySelector('form');
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      if (validarFormulario(form)) { 
        let url = '';
        if (tipo === 'centro') url = '../controlador/addCentro.php';
        else if (tipo === 'asignatura') url = '../controlador/addAsignatura.php';
        else if (tipo === 'carrera') url = '../addCarrera.php';
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
          success: function(respuesta){
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


}
