window.eliminarUsuario = function(id){
    console.log("=== INICIO eliminarUsuario ===");
    console.log("ID recibido:", id);
    console.log("Ruta actual:", window.location.href);
    console.log("Ruta destino:", "../controlador/deleteUsuario.php");
    if(confirm("¿Estás seguro que deseas eliminar al usuario?")) {
        $.ajax({
            type: "POST",
            url: "../controlador/deleteUsuario.php",
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
                console.error("Error en AJAX:", {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    readyState: xhr.readyState,
                    statusText: xhr.statusText
                });
                alert("Error en la solicitud. Ver consola para detalles.");
            },
            complete: function(xhr, status) {
                console.log("Solicitud completada. Estado:", status);
            }
        });
    }
}

var ventana = null;

window.editarUsuario = function(id) {
    if (ventana == null || ventana.closed) {
        ventana = window.open('editar_usuario.php?id=' + id, 'Editar Usuario', 'width=600,height=400');
    } else {
        window.alert("Por favor, termine la edición de usuario actual antes de abrir otra ventana.");
    }
}
