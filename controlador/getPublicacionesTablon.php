<?php
session_start();
include_once("../modelo/BaseDatos.php");

try {
    $bd = new BaseDatos();
    $usuarioId = $_SESSION['id'];

    // Obtener publicaciones
    $sql = "
        SELECT p.*, 
               u.nick AS autor_nick,
               a.nombre_asignatura AS nombre_asignatura,
               e.nombre_estudio AS nombre_estudio
        FROM publicacion p
        INNER JOIN usuario u ON p.id_autor = u.id
        INNER JOIN asignatura a ON p.id_asignatura = a.id_asignatura
        INNER JOIN estudio e ON p.id_estudio = e.id_estudio
        WHERE p.publicado = 1
        ORDER BY p.fecha DESC;
    ";
    $stmt = $bd->conn->prepare($sql);
    $stmt->execute();
    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener todos los votos
    $votosStmt = $bd->conn->prepare("SELECT * FROM votos");
    $votosStmt->execute();
    $todosVotos = $votosStmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener todos los comentarios
    $comentariosStmt = $bd->conn->prepare("
        SELECT c.*, u.nick AS autor_comentario
        FROM comentario c
        INNER JOIN usuario u ON c.id_autor = u.id
    ");
    $comentariosStmt->execute();
    $todosComentarios = $comentariosStmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '';
    $_SESSION['publicaciones_con_comentarios'] = [];

    foreach ($publicaciones as $pub) {
        $idPub = $pub['id_publicacion'];

        // VOTOS: filtrar votos por publicación
        $votosPub = array_filter($todosVotos, fn($v) => $v['id_publicacion'] == $idPub);
        $totalVotos = count($votosPub);
        $media = $totalVotos ? round(array_sum(array_column($votosPub, 'puntuacion')) / $totalVotos) : 0;

        // COMENTARIOS: filtrar comentarios por publicación
        $comentariosPub = array_filter($todosComentarios, fn($c) => $c['id_publicacion'] == $idPub);

        // Guardar publicación con comentarios en sesión
        $_SESSION['publicaciones_con_comentarios'][$idPub] = [
            'publicacion' => $pub,
            'comentarios' => array_values($comentariosPub)
        ];

        // Ver si el usuario ya votó
        $usuarioHaVotado = in_array($usuarioId, array_column($votosPub, 'id_usuario'));

        // Estrellas promedio (arriba derecha)
        $estrellasHtml = '';
        for ($i = 1; $i <= 5; $i++) {
            $estrellasHtml .= $i <= $media
                ? '<i class="bi bi-star-fill text-warning"></i>'
                : '<i class="bi bi-star text-secondary"></i>';
        }

        // Imprimir card
        $html .= '
        <div class="card mb-3 publicaciones"
            data-asignatura="' . htmlspecialchars($pub['nombre_asignatura']) . '"
            data-autor="' . htmlspecialchars($pub['autor_nick']) . '"
            data-estudio="' . htmlspecialchars($pub['nombre_estudio']) . '"
            data-curso="' . htmlspecialchars($pub['curso']) . '"
            data-fecha="' . htmlspecialchars($pub['fecha']) . '"
        >
            <div class="card-body position-relative">
                <div class="position-absolute top-0 end-0 p-2">
                    ' . $estrellasHtml . '
                </div>

                <h5 class="card-title">' . htmlspecialchars($pub['titulo']) . '</h5>
                <h6 class="card-subtitle text-muted">Autor: ' . htmlspecialchars($pub['autor_nick']) . '</h6>
                <p class="card-text">
                    <strong>Asignatura:</strong> ' . htmlspecialchars($pub['nombre_asignatura']) . '<br>
                    <strong>Estudio:</strong> ' . htmlspecialchars($pub['nombre_estudio']) . '<br>
                    <strong>Curso:</strong> ' . htmlspecialchars($pub['curso']) . '<br>
                    <strong>Fecha:</strong> ' . htmlspecialchars($pub['fecha']) . '
                </p>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="../archivos/' . htmlspecialchars($pub['archivo']) . '" download class="btn btn-outline-secondary btn-sm me-2">Descargar</a>
                        <button class="btn btn-outline-info btn-sm ver-publicacion" data-id="' . $idPub . '">Ver publicación</button>
                    </div>

                    <div class="votacion" data-id="' . $idPub . '">';
                        if ($usuarioId == $pub['id_autor']) {
                            $html .= '<span class="text-muted">Es tu publicación</span>';
                        } elseif ($usuarioHaVotado) {
                            $html .= '<span class="text-success">¡Ya votaste!</span>';
                        } else {
                            for ($i = 1; $i <= 5; $i++) {
                                $html .= '<i class="bi bi-star vote-star text-secondary" style="cursor:pointer;" data-value="' . $i . '"></i>';
                            }
                        }
        $html .= '</div></div></div></div>';
    }

    echo $html;

} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error al obtener publicaciones: ' . $e->getMessage() . '</div>';
}
