$(document).ready(function(){
    $.ajax({
        type:"post",
        url:"../controlador/getUsuarios.php",
        data:{"nocache":Math.random()},
        dataType:"json",
        success: function(data){
             // Cuando la petición es exitosa
             // Selecciona el cuerpo de la tabla
             var tabla = $('#tablaUsuarios'); 
            // Limpia el contenido por si ya tenía algo
             tabla.empty();
             // Recorre el array de usuarios y crea las filas
             if (Array.isArray(data)) {

                tabla.append('<th>id</th><th>nombre</th><th>apellidos</th><th>correo</th><th>ciudad</th><th>estudios</th>');

                $.each(data, function(index, usuario) {
                    var fila = '<tr>' +
                        '<td>' + usuario.id + '</td>' +
                        '<td>' + usuario.nombre + '</td>' +
                        '<td>' + usuario.apellidos + '</td>' +
                        '<td>' + usuario.mail + '</td>' +
                        '<td>' + usuario.ciudad + '</td>' +
                        '<td>' + usuario.estudios + '</td>' +
                        '<td><input type="button" value="Eliminar" onclick="eliminarUsuario(' + usuario.id + ')"></td>' +
                        '<td><input type="button" value="Editar" onclick="editarUsuario(' + usuario.id + ')"></td>'+
                    '</tr>';
                   // Agrega la fila a la tabla
                    tabla.append(fila); 
                  
                });
            } else {
                console.error("Los datos no son un array:", data);
            }
        },
         error:
         function() {
            console.log("Algo ha ido mal");
         }
        
    })
})