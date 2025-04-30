
window.eliminarUsuario = function(id){
    if(confirm("¿Estás seguro que deseas eliminar al usuario?")) {
        $.ajax({
            type: "POST",
            url: "deleteUsuario.php",
            dataType: "json",
            data: {
                "id": id,
                "nocache": Math.random()
            },
            success: function(data) {
                if(data.success) {
                    alert(data.message);
                    // Recargar solo la tabla sin refrescar toda la página
                    $.ajax({
                        type: "post",
                        url: "../controlador/getUsuarios.php",
                        data: {"nocache": Math.random()},
                        dataType: "json",
                        success: function(newData) {
                            $('#tablaUsuarios tbody').empty();
                            $.each(newData, function(index, usuario) {
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
                                $('#tablaUsuarios tbody').append(fila);
                            });
                        }
                    });
                } else {
                    alert("Error: " + data.message);
                }
            },
            error: function(xhr, status, error) {
                alert("Error en la solicitud: " + error);
            }
        });
    }
}
