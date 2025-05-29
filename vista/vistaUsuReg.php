<?php
session_start();
// Datos de Usuario
$user = [
  'nick' => $_SESSION['nick'],


];
// Provisional para comprobar como se vería
$posts = [
  ['title' => 'Tema 1', 'description' => 'Tema 1 de PHP', 'file' => 'manual.pdf', 'author' => 'juanito'],
  ['title' => 'Presentación', 'description' => 'Slides del proyecto', 'file' => 'presentacion.pdf', 'author' => 'usuario_demo'],
];
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Panel de Usuario</title>
  <script type="text/javascript" src="../JQuery/jquery-3.7.1.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="../controlador/funcionesBotonesTabla_original.js"></script>
  <script type="text/javascript" src="../controlador/publicar.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

  <script src="../controlador/funcionesVistaUsu.js"></script>
  <link rel="stylesheet" href="../css/estilo-tablonPubli.css">


  <style>
    body {
      background-color: #f8f9fa;
    }

    .offcanvas-body a {
      display: block;
      padding: 10px 0;
      color: #212529;
      text-decoration: none;
    }

    .offcanvas-body a:hover {
      text-decoration: underline;
    }

    .hidden-section {
      display: none;
    }
  </style>
</head>

<body>

  <!-- Barra superior -->
  <nav class="navbar navbar-light bg-light px-3 mb-4">
    <button class="btn btn-outline-secondary me-2" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
      ☰
    </button>
    <span class="navbar-text me-auto">Bienvenido, <?= htmlspecialchars($user['nick']) ?></span>
    <a href="../controlador/logout.php" class="btn btn-outline-danger">Cerrar Sesión</a>
  </nav>

  <!-- Barra lateral desplegable -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menú</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <a href="#" onclick="showSection('tablon');" data-bs-dismiss="offcanvas">📋 Tablón</a>
      <a href="#" onclick="showSection('publicar');" data-bs-dismiss="offcanvas">📤 Publicar</a>
      <a href="#" onclick="showSection('ver');" data-bs-dismiss="offcanvas">📄 Ver Publicaciones</a>
      <a href="#" onclick="editarUsuario(<?php echo ($_SESSION['id']) ?>)" data-bs-dismiss="offcanvas">👤 Editar Perfil</a>
    </div>
  </div>

  <!-- Contenido principal -->
  <div class="container">
    <!-- Sección: Tablón -->
    <div class="section">
      <h3>Tablón de Publicaciones</h3>

      <div class="row align-items-center mb-3">
        <!-- Buscador -->
        <div class="col-md-6 mb-2">
          <form class="form m-0" onsubmit="return false;">
            <label for="search" class="w-100 position-relative">
              <input autocomplete="off" placeholder="Buscar..." id="search" type="text" class="form-control pe-5" />
              <div class="position-absolute end-0 top-0 mt-2 me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                  class="bi bi-x-circle close-btn d-none" viewBox="0 0 16 16" style="cursor:pointer;">
                  <path
                    d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
              </div>
            </label>
          </form>
        </div>

        <!-- Ordenación -->
        <div class="col-md-6 mb-2">
          <select id="sort-by" class="form-select">
            <option value="original-order">Orden por defecto</option>
            <option value="asignatura">Asignatura</option>
            <option value="autor">Autor</option>
            <option value="estudio">Estudio</option>
            <option value="curso">Curso</option>
            <option value="fecha">Fecha</option>
          </select>
        </div>
      </div>

      <!-- Aquí se insertarán los cards -->
      <div id="section-tablon" class="section">
          <!-- Aquí se insertarán los cards -->
      </div>
    </div>


    <!-- Sección: Publicar -->
    <div id="section-publicar" class="section hidden-section">
      <div id="alertContainer"></div>
      <h3>Subir nueva publicación</h3>
      <form method="post" action="" enctype="multipart/form-data" id="formPublicar">
        <div class="mb-3">
          <label class="form-label">Título</label>
          <input type="text" class="form-control" name="titulo" id="titulo" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Centro</label><br>
          <select class="form-control" name="centro" id="centro" required>
            <option value="0">Selecciona un centro...</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Grado</label><br>
          <select class="form-control" name="estudio" id="estudio" required>
            <option value="0">Selecciona un grado...</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Asignatura/Módulo</label><br>
          <select class="form-control" name="asignatura" id="asignatura" required>
            <option value="0">Selecciona una asignatura/módulo...</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Curso</label>
          <input type="number" class="form-control" name="curso" id="curso" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Archivo PDF</label>
          <input type="file" class="form-control" name="pdf" id="pdf" accept="application/pdf" required>
        </div>
        <button type="submit" class="btn btn-success" id="subirBtn" name="subirBtn">Subir</button>
        <button type="reset" class="btn btn-warning">Borrar Datos</button>

      </form>
    </div>

    <!-- Sección: Ver Publicaciones -->
    <div id="section-ver" class="section hidden-section">
      <h3>Tus Publicaciones</h3>
      <?php foreach ($posts as $post): ?>
        <?php if ($post['author'] === $user['nick']): ?>
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($post['description']) ?></p>
              <a href="uploads/<?= htmlspecialchars($post['file']) ?>" target="_blank" class="btn btn-outline-primary">Ver PDF</a>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <!-- Sección: Editar Perfil -->
    <div id="section-perfil" class="section hidden-section">
      <h3>Editar Perfil</h3>
      <form method="post" action="editarUsuarioController.php">
        <div class="mb-3">
          <label class="form-label">Usuario</label>
          <input type="text" class="form-control" name="nick">
        </div>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" id="nombre">
        </div>
        <div class="mb-3">
          <label class="form-label">Apellidos</label>
          <input type="text" name="apellidos" id="apellidos" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </form>
    </div>
  </div>

  <script>
    function showSection(section) {
      const sections = ['tablon', 'publicar', 'ver', 'perfil'];
      sections.forEach(id => {
        document.getElementById(`section-${id}`).classList.add('hidden-section');
      });
      document.getElementById(`section-${section}`).classList.remove('hidden-section');
    }

    // Mostrar sección de tablón por defecto
    showSection('tablon');
  </script>
  <script>
    $(document).ready(function() {
      $('select').select2();

    });
  </script>
</body>

</html>