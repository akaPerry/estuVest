function updateDescargas(id){
  $.ajax({
    url:"../controlador/updateDescargas.php",
    type:'POST',
    data:{
      id:"id"
    },
    dataType: "json",
    success:function(){
      console.log("descagas ++ en id:"+id);
    },
    error:function(){
      console.log("Algo ha ido mal con la publicación con ID:"+id);
    }
  });
}
$(document).ready(function () {
 $(document).on('click', '#descargarBtn', function () {
    const id = $(this).data('id'); // obtiene el id del atributo data-id
    updateDescargas(id);
  });
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


function deleteComentario(eventOrId) {
  // Permite recibir el evento o el id directamente
  let id;
  if (typeof eventOrId === 'object' && eventOrId.target) {
    id = $(eventOrId.target).data('id');
  } else {
    id = eventOrId;
  }

  if (!confirm('¿Seguro que deseas eliminar este comentario?')) return;

  $.ajax({
    url: '../controlador/deleteComentario.php',
    type: 'POST',
    data: { id_comentario: id },
    dataType: 'json',
    success: function (res) {
      if (res.success) {
        // Elimina la card del comentario del DOM
        $(`button.eliminar-comentario[data-id="${id}"]`).closest('.card').remove();

        // Actualiza el contador de comentarios
        const h4 = $('.mt-4').next('.mt-4').find('h4').first();
        const textoActual = h4.text();
        const numActual = parseInt(textoActual.match(/\d+/)[0]) || 1;
        h4.text(`Comentarios (${numActual - 1})`);
        alert('to pinga');
      } else {
        alert(res.error || 'No se pudo eliminar el comentario.');
      }
    },
    error: function () {
      alert('Error al eliminar el comentario.');
    }
  });
}