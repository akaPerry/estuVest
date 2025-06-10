document.addEventListener("DOMContentLoaded", iniciar);
function iniciar() {
  document.getElementById("subirBtn").addEventListener("click", function (e) {
    if (!validarFormularioPublicacion()) {
      e.preventDefault(); // Bloquea el envío
    }
  });

  $("#centro").on("change", function () {
    const idCentro = $(this).val();
    llenarSelectEstudio(idCentro);
    llenarSelectAsignatura("0");
  });
  $("#estudio").on("change", function () {
    const idGrado = $(this).val();
    llenarSelectAsignatura(idGrado);
  });

  llenarSelectCentro();
  cargarPublicacionesTablon();
  cargarMisPublicaciones();
}

function llenarSelectCentro() {
  var select = $("#centro");
  $.ajax({
    type: "POST",
    url: "../controlador/getCentros.php",
    data: { nocache: Math.random() },
    dataType: "json",
    success: function (data) {
      $.each(data, function (index, centro) {
        var option =
          "<option value='" + centro.id + "'>" + centro.centro + "</option>";
        select.append(option);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener centros:", error);
    },
  });
}

function llenarSelectEstudio(idCentro) {
  const select = $("#estudio");
  select.empty();
  if (idCentro == 0) {
    select.append(
      '<option value="0">Seleccione un centro de estudios</option>'
    );
    return;
  } else {
    $.ajax({
      url: "../controlador/getEstudios.php",
      type: "POST",
      data: {
        idCentro: idCentro,
        nocache: Math.random(),
      },
      dataType: "json",
      success: function (data) {
        select.empty();
        select.append(
          "<option value='0'>Selecciona un grado/asignatura</option>"
        );
        $.each(data, function (index, modulo) {
          const option = `<option value='${modulo.id_relacion}'>${modulo.estudio}</option>`;
          select.append(option);
        });
      },
    });
  }
}
function llenarSelectAsignatura(idGrado) {
  const select = $("#asignatura");
  select.empty();
  if (idGrado == 0) {
    select.append('<option value="0">Seleccione un grado/curso</option>');
  } else {
    $.ajax({
      url: "../controlador/getAsignaturas.php",
      type: "POST",
      data: {
        idGrado: idGrado,
        nocache: Math.random(),
      },
      dataType: "json",
      success: function (data) {
        select.empty();
        select.append("<option value='0'>Selecciona una asignatura</option>");
        $.each(data, function (index, asignatura) {
          const option = `<option value='${asignatura.id}'>${asignatura.asignatura}</option>`;
          select.append(option);
        });
      },
      error: function () {
        console.log("Error al obtener los datos");
      },
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
  [
    tituloInput,
    cursoInput,
    centroSelect,
    estudioSelect,
    asignaturaSelect,
  ].forEach((el) => el.classList.remove("campo-error"));
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
    const htmlErrores = errores.map((err) => `<li>${err}</li>`).join("");
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

function cargarPublicacionesTablon() {
  // Vaciar el contenido antes de introducir el nuevo HTML
  $("#publicaciones").empty();
  $.ajax({
    url: "../controlador/getPublicacionesTablon.php",
    type: "POST",
    success: function (html) { 
      $("#publicaciones").html(html);

      cargaIsotope();

      document.querySelectorAll(".ver-publicacion").forEach((btn) => {
        btn.addEventListener("click", function () {
          const id = this.getAttribute("data-id");
          if (id) {
            window.location.href = `publicacion_comentarios.php?id=${id}`;
          }
        });
      });
    },
    error: function () {
      $("#section-tablon").html(
        '<div class="alert alert-danger">No se pudieron cargar las publicaciones.</div>'
      );
    },
  });
}


function cargaIsotope () {
  let $grid = new Isotope("#publicaciones", {
    itemSelector: ".card",
    layoutMode: "fitRows",
    getSortData: {
      asignatura: "[data-asignatura]",
      autor: "[data-autor]",
      estudio: "[data-estudio]",
      curso: "[data-curso]",
      fecha: "[data-fecha]",
      descargas: function (itemElem) {
        return parseInt(itemElem.getAttribute('data-descargas')) || 0;
      }
    }
  });

  // Buscador en vivo
  $('#search').on('input', function () {
    let filtro = $(this).val().toLowerCase();
    $('.close-btn').toggleClass('d-none', filtro === '');

    $grid.arrange({
      filter: function () {
        let texto = $(this).text().toLowerCase();
        return texto.includes(filtro);
      }
    });
  });

  // Botón limpiar buscador
  $('.close-btn').on('click', function () {
    $('#search').val('');
    $grid.arrange({ filter: '*' });
    $(this).addClass('d-none');
  });

  // Ordenar por atributo
  $('#sort-by').on('change', function () {
    let sortByValue = $(this).val();

    $grid.arrange({
      sortBy: sortByValue,
      sortAscending: sortByValue === 'descargas' ? false : true
    });
  });
}

$(document).on("mouseenter", ".vote-star", function () {
  const value = $(this).data("value");
  $(this)
    .parent()
    .children()
    .each(function () {
      $(this).toggleClass("text-warning", $(this).data("value") <= value);
    });
});

$(document).on("mouseleave", ".votacion", function () {
  $(this).children().removeClass("text-warning");
});

$(document).on("click", ".vote-star", function () {
  const valor = $(this).data("value");
  const container = $(this).closest(".votacion");
  const idPublicacion = container.data("id");

  $.ajax({
    url: "../controlador/addVoto.php",
    method: "POST",
    data: {
      id_publicacion: idPublicacion,
      puntuacion: valor,
    },
    success: function (response) {
      if (response.success) {
        alert("Gracias por votar");
        container.html('<span class="text-success">¡Ya votaste!</span>');
        cargarPublicacionesTablon();
      } else {
        alert(response.message || "Error al votar");
      }
    },
    error: function () {
      alert("Error al enviar el voto.");
    },
  });
});


function cargarMisPublicaciones() {
  console.log("cargando cosas");
    $.ajax({
        url: '../controlador/getMisPublicaciones.php', // Ajusta la ruta si es necesario
        type: 'GET',
        dataType: 'html',
        success: function (data) {
          console.log(data);
            $('#tusPublicaciones').html(data);
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar las publicaciones:", status, error);
            $('#tusPublicaciones').html("<p>Error al cargar las publicaciones. Por favor, inténtalo de nuevo más tarde.</p>");
        }
    });
}

// Llama a la función cuando la página esté lista
$(document).ready(function() {
    cargarMisPublicaciones();
});
