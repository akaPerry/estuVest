<?php
session_start();

if (!isset($_SESSION['nick'], $_SESSION['id'])) {
    echo "<div class='alert alert-danger'>No has iniciado sesión.</div>";
    exit;
}

$user = [
    'nick' => $_SESSION['nick'],
    'id' => $_SESSION['id']
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Solicitar Elementos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="../JQuery/jquery-3.7.1.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- scripts para select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .hidden-section {
      display: none;
    }
  </style>
</head>
<body class="bg-light">

<!-- Barra superior -->
<nav class="navbar navbar-light bg-light px-3 mb-4">
  <a class="btn btn-outline-secondary me-2" onclick="window.history.back()">
    <i class="bi bi-arrow-left"></i>
  </a>
  <span class="navbar-text me-auto">Bienvenido, <?= htmlspecialchars($user['nick']) ?></span>
  <a href="../controlador/logout.php" class="btn btn-outline-danger">Cerrar Sesión</a>
</nav>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-4">Crear una solicitud</h4>
          <p class="card-text">Selecciona el tipo de elemento que deseas solicitar.</p>

          <div class="d-grid gap-3 mb-4">
            <button class="btn btn-primary btn-lg" onclick="mostrarFormularioSolicitud('centro')" id="btnCentro">
              <i class="bi bi-building me-2"></i> Solicitar nuevo centro
            </button>
            <button class="btn btn-success btn-lg" onclick="mostrarFormularioSolicitud('estudio')" id="btnEstudio">
              <i class="bi bi-journal-text me-2"></i> Solicitar nuevo estudio
            </button>
            <button class="btn btn-warning btn-lg text-dark" onclick="mostrarFormularioSolicitud('asignatura')" id="btnAsig">
              <i class="bi bi-book me-2"></i> Solicitar nueva asignatura
            </button>
          </div>

          <div id="formularioSolicitud" class="hidden-section">
            <form id="formSolicitud" method="post">
              <input type="hidden" name="id_usuario" value="<?= $user['id'] ?>">
              <input type="hidden" name="elemento" id="elementoTipo">
              <div id="contenidoFormulario"></div>
              <button type="submit" class="btn btn-primary mt-3">Enviar solicitud</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
function mostrarFormularioSolicitud(tipo) {
  $('#elementoTipo').val(tipo);
  let html = '';

  if (tipo === 'centro') {
    html = `
      <div class="mb-3">
        <label class="form-label">Nombre del centro</label>
        <input type="text" class="form-control" name="centro" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Ciudad</label>
        <input type="text" class="form-control" name="ciudad" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Tipo</label>
        <select class="form-select" name="tipo" required>
          <option value="instituto">Instituto</option>
          <option value="universidad">Universidad</option>
          <option value="otros">Otros</option>
        </select>
      </div>
    `;
  } else if (tipo === 'estudio') {
    html = `
      <div class="mb-3">
        <label class="form-label">Nombre del estudio</label>
        <input type="text" class="form-control" name="estudio" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Nivel</label>
        <select class="form-select" name="nivel" required>
          <option value="grado medio">Grado Medio</option>
          <option value="grado superior">Grado Superior</option>
          <option value="grado universitario">Grado Universitario</option>
          <option value="master">Máster</option>
          <option value="bachillerato">Bachillerato</option>
          <option value="ESO">ESO</option>
          <option value="otro">Otro</option>
        </select>
        </div>
          <div class="mb-3">
        <label class="form-label">Centro</label>
        <select class="form-select" name="centro" id="centro" required></select>
      </div>
         </div>   
      </div>
    `;
  } else if (tipo === 'asignatura') {
    html = `
      <div class="mb-3">
        <label class="form-label">centro-estudio</label>
        <select class="form-select" name="grado" id="grado" required></select>
      </div>
      <div class="mb-3">
        <label class="form-label">Nombre de la asignatura</label>
        <input type="text" class="form-control" name="asignatura" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Curso</label>
        <input type="number" class="form-control" name="curso" required>
      </div>
    `;
  }

  $('#contenidoFormulario').html(html);
  $('#formularioSolicitud').removeClass('hidden-section');
  // Activar select2 en los selects recién generados
  $('#contenidoFormulario select').select2({
    width: '100%'
  });
}
</script>

<script src="../controlador/solicitudController.js"></script>
<script src="../controlador/crearElementos2.js"></script>
  <script src="../controlador/iniciarSelect2.js"></script>

