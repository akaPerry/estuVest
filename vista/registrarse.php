<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script type="text/javascript" href="../bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <!-- <script type="text/javascript" src="../controlador/validarFormulario.js"></script> -->
         <!-- <script type="text/javascript" src="../modelos/rellenarCiudades.js"></script> -->

</head>
<body>
    <h1>EstuVest</h1>
    <p>Rellena los campos del formulario:</p>
    <form action="../controlador/registrarUserController.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>
        <label for="mail">E-mail</label>
        <input type="email" id="email" name="email" required>
        <label for="nick">Nick de Usuario:</label>
        <input type="text" id="nick" name="nick" required>
        <label for="contrasenia">Contraseña:</label>
        <input type="password" id="contrasenia" name="contrasenia" required>
        <label for="ciudad">Ciudad</label>
        <select name="ciudad" id="ciudad">
            <option value="0">Selecciona la ciudad de tus estudios actuales:</option>
            <option value="Segovia">Segovia</option>
        </select>
        <label for="estudios">Estudios:</label>
        <select name="estudios" id="estudios">
            <option value="0">Selecciona tu nivel de estudios actuales:</option>
            <option value="bachiller">Bachillerato</option>
            <option value="grado medio">Grado Medio</option>
            <option value="grado superior">Grado Superior</option>
            <option value="carrera">Carrera Universitaria</option>
            <option value="master">Máster</option>
        </select>
        <input type="reset" value="Borrar Todo">
        <input type="submit" value="Registrarse">
    </form>
</body>
</html>