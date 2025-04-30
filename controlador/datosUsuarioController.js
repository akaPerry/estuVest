$(document).ready(function pintarFormu() {
  var originalData = {}; // Objeto para almacenar los datos originales

  // Llamada AJAX para traer los datos del usuario logueado
  $.ajax({
    url: '../controlador/getDatosAdmin.php',
    type: 'GET',
    data: { "nocache": Math.random() },
    dataType: 'json',
    success: function (data) {
      console.log(data); // Para ver qué llega bien

      // Verificar si data contiene los datos correctamente
      if (data && data.length > 0) {
        // Guardar los datos originales en el objeto
        originalData = {
          nombre: data[0].nombre,
          apellidos: data[0].apellidos,
          nick: data[0].nick,
          mail: data[0].mail
        };

        // Pintar los datos en el formulario
        $('#nombre').val(originalData.nombre);
        $('#apellidos').val(originalData.apellidos);
        $('#nick').val(originalData.nick);
        $('#mail').val(originalData.mail);
      } else {
        console.log('No se encontraron datos del usuario');
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log('Error al obtener datos del usuario: ', textStatus, errorThrown);
    }
  });

  // Función para cancelar los cambios y restaurar los datos originales
  $('#cancelar').click(function actualizar() {
    console.log("botón cancelar pulsado");
    $('#nombre').val(originalData.nombre);
    $('#apellidos').val(originalData.apellidos);
    $('#nick').val(originalData.nick);
    $('#mail').val(originalData.mail);
  });
//Función para actualizar los datos de usuario
$('#guardar').click(function() {
 //obtener los datos del formulario
 const datosNuevos={
  nombre:$('#nombre').val(),
  apellidos:$('#apellidos').val(),
  nick:$('#nick').val(),
  mail:$('#mail').val(),
  id:$('#idUsuarioSesion').val(),
  rol:$('#rol').val,
  };

  //enviar los datos al servidor
  $.ajax({
    url:'../controlador/editarUsuarioController.php',
    type:'POST',
    data:{ "nombre":$('#nombre').val(),
    "apellidos":$('#apellidos').val(),
    "nick":$('#nick').val(),
    "mail":$('#mail').val(),
    "id":$('#idUsuarioSesion').val(),
    "rol":$('#rol').val()},
    success: function(data) {
      console.log('Respuesta del servidor:', data);
      // Mostrar mensaje de éxito al usuario
      alert('Datos actualizados correctamente');
      // Opcional: actualizar los datos originales
      originalData = datosNuevos;
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error al actualizar datos:', textStatus, errorThrown);
      alert('Error al actualizar los datos');
    }

  });
});

});

