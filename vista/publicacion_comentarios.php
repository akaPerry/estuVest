<?php
session_start();

// Obtener ID por GET
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID de publicación no especificado.</div>";
    exit;
}

$user = [
    'nick' => $_SESSION['nick'],
];

$id = $_GET['id'];

if (!isset($_SESSION['publicaciones_con_comentarios'][$id])) {
    echo "<div class='alert alert-danger'>Publicación no encontrada en sesión.</div>";
    exit;
}

$datos = $_SESSION['publicaciones_con_comentarios'][$id];
$pub = $datos['publicacion'];
$comentarios = $datos['comentarios'];

// Calcular estrellas promedio para mostrar
$totalVotos = $pub['puntuacion'] ?? 0;
$estrellasHtml = '';
for ($i = 1; $i <= 5; $i++) {
    $estrellasHtml .= $i <= $totalVotos
        ? '<i class="bi bi-star-fill text-warning"></i>'
        : '<i class="bi bi-star text-secondary"></i>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Publicación</title>
  <script type="text/javascript" src="../JQuery/jquery-3.7.1.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../controlador/vista_comentarios.js"></script>

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
<body class="bg-light">


<!-- Barra superior -->
<nav class="navbar navbar-light bg-light px-3 mb-4">
  <a href="vistaUsuReg.php" class="btn btn-outline-secondary me-2">
    <i class="bi bi-arrow-left"></i>
  </a>
  <span class="navbar-text me-auto">Bienvenido, <?= htmlspecialchars($user['nick']) ?></span>
  <a href="../controlador/logout.php" class="btn btn-outline-danger">Cerrar Sesión</a>
</nav>




<div class="container my-4">
  <div class="row g-4">
    <!-- Columna 1: Datos -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($pub['titulo']) ?></h5>
          <h6 class="card-subtitle text-muted mb-2">Autor: <?= htmlspecialchars($pub['autor_nick']) ?></h6>
          <p class="card-text">
            <strong>Asignatura:</strong> <?= htmlspecialchars($pub['nombre_asignatura']) ?><br>
            <strong>Estudio:</strong> <?= htmlspecialchars($pub['nombre_estudio']) ?><br>
            <strong>Curso:</strong> <?= htmlspecialchars($pub['curso']) ?><br>
            <strong>Fecha:</strong> <?= htmlspecialchars($pub['fecha']) ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Columna 2: PDF + estrellas -->
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <iframe src="../archivos/<?= htmlspecialchars($pub['archivo']) ?>" class="w-100" height="400px"></iframe>
          <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="../archivos/<?= htmlspecialchars($pub['archivo']) ?>" download class="btn btn-secondary">Descargar PDF</a>
            <div><?= $estrellasHtml ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sección: Comentar -->
  <div class="mt-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Deja un comentario</h5>
        <form action="publicar_comentario.php" method="post">
          <input type="hidden" name="id_publicacion" value="<?= $id ?>">
          <textarea name="comentario" class="form-control mb-2" rows="3" placeholder="Escribe tu comentario..." required></textarea>
          <button type="submit" class="btn btn-primary">Publicar comentario</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Sección: Comentarios -->
  <div class="mt-4">
    <h4>Comentarios (<?= count($comentarios) ?>)</h4>
    <?php if (empty($comentarios)): ?>
      <div class="alert alert-info">Aún no hay comentarios.</div>
    <?php else: ?>
      <?php foreach ($comentarios as $c): ?>
        <div class="card mb-2 shadow-sm">
          <div class="card-body">
            <h6 class="card-subtitle mb-1 text-muted">Por <?= htmlspecialchars($c['autor_comentario']) ?> el <?= htmlspecialchars($c['fecha']) ?></h6>
            <p class="card-text"><?= nl2br(htmlspecialchars($c['texto'])) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

</body>
</html>