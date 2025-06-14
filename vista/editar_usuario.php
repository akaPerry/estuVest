<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="../controlador/preseleccionarEstudios.js"></script>
    <link rel="stylesheet" href="../css/estilo-formulario.css">
</head>
<body>

    <?php
    include_once("../modelo/BaseDatos.php");
    $id=$_GET["id"];
    $bd=new BaseDatos();
    $usuario=$bd->getUsuReg($id);
    ?>

    <div class="container form-container shadow">
        <h2 class="text-center mb-4">Editar Usuario - ID: <?php echo($id); ?></h2>
        <form method="POST" action="../controlador/editarUsuarioController.php">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo($usuario[0]["nombre"])?>">
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo($usuario[0]["apellidos"])?>">
            </div>
            <div class="mb-3">
                <label for="nick" class="form-label">Nick:</label>
                <input type="text" class="form-control" id="nick" name="nick" value="<?php echo($usuario[0]["nick"])?>">
            </div>
            <div class="mb-3">
                <label for="mail" class="form-label">Correo:</label>
                <input type="email" class="form-control" id="mail" name="mail" value="<?php echo($usuario[0]["mail"])?>">
            </div>
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad:</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?php echo($usuario[0]["ciudad"])?>">
            </div>
            <div class="mb-3">
                <label for="estudios" class="form-label">Estudios:</label>
                <select class="form-select" id="estudios" name="estudios">
                    <option value="0">Seleccione una opción</option>
                    <option value="bachiller">Bachillerato</option>
                    <option value="grado medio">Grado Medio</option>
                    <option value="grado superior">Grado Superior</option>
                    <option value="estudio">Estudio Universitaria</option>
                    <option value="master">Máster</option>
                </select>
            </div>

            <input type="hidden" name="id" value="<?php echo($id)?>">
            <input type="hidden" id="rol" name="rol" value="usuario_registrado">

            <div class="d-flex justify-content-between">
                <input type="submit" class="btn btn-primary-custom" value="Guardar Cambios">
                <button type="button" class="btn btn-secondary-custom" onclick="window.close()">Volver</button>
            </div>
        </form>
    </div>

    <script>
        // Pasamos PHP a JS
        var usuario = <?php echo json_encode($usuario); ?>;

        // Al cargar el DOM
        document.addEventListener("DOMContentLoaded", function(){
            var estudios = document.getElementById("estudios");
            estudios.value = usuario[0]["estudios"];
        });
    </script>
</body>
</html>
