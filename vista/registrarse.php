<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="../bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/estilo-formulario.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">EstuVest</h1>
        <p>Rellena los campos del formulario:</p>
        <div class="container form-container shadow">
        <form action="../controlador/registrarUserController.php" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nick" class="form-label">Nick de Usuario:</label>
                <input type="text" id="nick" name="nick" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contrasenia" class="form-label">Contraseña:</label>
                <input type="password" id="contrasenia" name="contrasenia" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad</label>
                <select name="ciudad" id="ciudad" class="form-select">
                    <option value="0">Selecciona la ciudad de tus estudios actuales:</option>
                    <option value="Segovia">Segovia</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estudios" class="form-label">Estudios:</label>
                <select name="estudios" id="estudios" class="form-select">
                    <option value="0">Selecciona tu nivel de estudios actuales:</option>
                    <option value="bachiller">Bachillerato</option>
                    <option value="grado medio">Grado Medio</option>
                    <option value="grado superior">Grado Superior</option>
                    <option value="estudio">Estudio Universitaria</option>
                    <option value="master">Máster</option>
                </select>
            </div>
            <input type="reset" value="Borrar Todo" class="btn btn-secondary">
            <input type="submit" value="Registrarse" class="btn btn-primary">
        </form>
        </div>
    </div>
</body>
</html>