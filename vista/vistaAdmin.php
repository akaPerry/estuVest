<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/estilo-vistaAdmin.css">
  </link>
  <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
 
  <!-- <script type="text/javascript" src="../controlador/crearElementos.js"></script> -->

</head>

<body>
  <?php session_start(); ?>
  <h1>Has iniciado sesión correctamente.</h1>
  <p>Hola, <?php
            echo $_SESSION['nick']. "<br>"; 
            if(isset($_SESSION['id'])){
              echo "ID de sesión: " . $_SESSION['id'];
           }else{
              echo "NO EXISTE ID EN SESIÓN";
           }?></p>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column p-3">
      <h5 class="text-white">Menú</h5>
      <ul class="nav nav-pills flex-column" id="menu">
        <li class="nav-item">
          <a href="#" class="nav-link active" onclick="mostrarSeccion('inicio')">Inicio</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" onclick="mostrarSeccion('usuarios');">Usuarios</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" onclick="mostrarSeccion('perfil')">Perfil</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" onclick="mostrarSeccion('configuracion')">Configuración</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" onclick="mostrarSeccion('avisos')">Avisos <span id="alertNumber" class="badge rounded-pill bg-danger">0</span> </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" onclick="mostrarSeccion('publicaciones')">Publicaciones</a>
        </li>
      </ul>
    </nav>

    <!-- Contenedor principal -->
    <main class="content">
      <div id="inicio" class="seccion">
        <h2>Inicio</h2>
        <p>Bienvenido al panel principal.</p>
      </div>
      <div id="usuarios" class="seccion" style="display: none;">
        <h2>Usuarios</h2>
        <p>Tabla con los usuarios</p>
        <table id="tablaUsuarios" name="tablaUsuarios" class="table">
          <tbody>
            <tr>
              <td>cosa</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div id="perfil" class="seccion" style="display: none;">
        <h2>Perfil</h2>
        <form id="datosUsuario" name="datosUsuario" method="post">
          <label>Nombre:</label>
          <input type="text" name="nombre" id="nombre"><br>
          <label>Apellidos:</label>
          <input type="text" name="apellidos" id="apellidos"><br>
          <label>Nick de Usuario:</label>
          <input type="text" name="nick" id="nick"><br>
          <label>Correo:</label>
          <input type="mail" name="mail" id="mail"><br>
          <input type="hidden" id="idUsuarioSesion" value="<?php echo $_SESSION['id']; ?>">
          <input type="hidden" id="rol" name="rol" value="admin">


          <input type="button" name="guardar" id="guardar" value="Guardar Cambios">
          <input type="button" name="cancelar" id="cancelar" value="Cancelar Cambios" >

        </form>

      </div>
      <div id="configuracion" class="seccion" style="display: none;">
        <h2>Configuración</h2>
        <input type="button" name="btnCentro" id="btnCentro" value="Crear nuevo centro educativo">
        <input type="button" name="btnAsig" id="btnAsig" value="Crear nueva asignatura">
        <input type="button" name="btnEstudio" id="btnEstudio" value="Crear nueva carrera/grado"><br>
        <input type="button" name="btnModCentro" id="btnModCentro" value="Modificar centros educativo">
        <input type="button" name="btnModAsig" id="btnModAsig" value="Modificar asignaturas">
        <input type="button" name="btnModEstudio" id="btnModEstudio" value="Modificar carreras/grados">
        <p>*Antes de añadir a la base de datos unos estudios tiene que estar en la base de dato el centro al que pertenece.</p>
        <p>*Antes de añadir a la base de datos una asignatura hay que crear el estudio al que pertenece</p>
       <!-- Contenedor para los formularios -->
  <div id="formularioConfiguracion"></div>
  <div id="listaConfiguracion"></div>
      </div>
      <div id="avisos" class="seccion" style="display: none">
        <h2>Avisos</h2>
       
        <div id="publicacionesRevisar"></div>
        <div id="avisosSolicitudes"></div>
      </div>
      <div id="publicaciones" class="seccion" style="display: none">
        <h2>Publicaciones</h2>
        <div id="publicacionesContenedor"></div>
      </div>
      
    </main>
  </div>
  
  <script>
    function mostrarSeccion(seccionId) {
      // Oculta todas las secciones
      const secciones = document.querySelectorAll('.seccion');
      secciones.forEach(seccion => seccion.style.display = 'none');

      // Muestra la sección seleccionada
      const seccionActiva = document.getElementById(seccionId);
      if (seccionActiva) {
        seccionActiva.style.display = 'block';
      }

      // Actualiza el menú activo
      const links = document.querySelectorAll('.sidebar .nav-link');
      links.forEach(link => link.classList.remove('active'));
      event.target.classList.add('active');
    }
  </script>
  <script type="text/javascript" src="../controlador/crearElementos2.js"></script>
  <script type="text/javascript" src="../bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../JQuery/jquery-3.7.1.js"></script>
  <script type="text/javascript" src="../controlador/pintarUsuarios.js"></script>
  <script type="text/javascript" src="../controlador/funcionesBotonesTabla_original.js"></script>
  <script type="text/javascript" src="../controlador/datosUsuarioController.js"></script>
</body>

</html>