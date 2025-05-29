$(document).ready(function () {
  $('form[action="publicar_comentario.php"]').on('submit', function (e) {
    e.preventDefault();

    const comentario = $.trim($('textarea[name="comentario"]').val());
    const id_publicacion = $('input[name="id_publicacion"]').val();
    const submitBtn = $(this).find('button[type="submit"]');

    // Contenedor donde están los comentarios y el h4
    const comentariosContainer = $('.mt-4').next('.mt-4');

    if (comentario === '') {
      alert('El comentario no puede estar vacío.');
      return;
    }

    submitBtn.prop('disabled', true);

    $.ajax({
      url: '../controlador/addComentario.php',
      method: 'POST',
      data: {
        comentario: comentario,
        id_publicacion: id_publicacion
      },
      dataType: 'json',
      success: function (res) {
        if (res.error) {
          alert(res.error);
          return;
        }

        const nuevaCard = `
          <div class="card mb-2 shadow-sm">
            <div class="card-body">
              <h6 class="card-subtitle mb-1 text-muted">Por ${res.autor} el ${res.fecha}</h6>
              <p class="card-text">${res.texto}</p>
            </div>
          </div>
        `;

        // Quitar alerta "Aún no hay comentarios" si existe
        comentariosContainer.find('.alert').remove();

        // Añadir nuevo comentario al final
        comentariosContainer.append(nuevaCard);

        // Actualizar contador de comentarios en el <h4>
        const h4 = comentariosContainer.find('h4').first();
        const textoActual = h4.text(); // Ejemplo: "Comentarios (3)"
        const numActual = parseInt(textoActual.match(/\d+/)[0]) || 0;
        h4.text(`Comentarios (${numActual + 1})`);

        // Limpiar textarea
        $('textarea[name="comentario"]').val('');
      },
      error: function () {
        alert('Error al enviar el comentario.');
      },
      complete: function () {
        submitBtn.prop('disabled', false);
      }
    });
  });
});
