<?php
include_once("../modelo/BaseDatos.php");

try {
    $bd = new BaseDatos();
    $conn = $bd->conn;

    $sql = "
        SELECT 
            p.*, 
            u.nick AS autor_nick, 
            a.nombre_asignatura AS nombre_asignatura, 
            e.nombre_estudio AS nombre_estudio
        FROM publicacion p
        JOIN usuario u ON p.id_autor = u.id
        JOIN asignatura a ON p.id_asignatura = a.id_asignatura
        JOIN estudio e ON p.id_estudio = e.id_estudio
        WHERE p.publicado = 0;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = count($publicaciones);
        
        $html = '<div id="contenedorPublicaciones" data-count="' . $total . '">';
        //$html .= '<p class="mb-3">Tienes ' . $total . ' publicaciones pendientes de validar</p>';

        foreach ($publicaciones as $pub) {
            $html .= '
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">' . htmlspecialchars($pub['titulo']) . '</h5>
                    <small class="text-muted">' . htmlspecialchars($pub['fecha']) . '</small>
                </div>
                <div class="card-body">
                    <p><strong>Autor:</strong> ' . htmlspecialchars($pub['autor_nick']) . '</p>
                    <p><strong>Asignatura:</strong> ' . htmlspecialchars($pub['nombre_asignatura']) . '</p>
                    <p><strong>Estudio:</strong> ' . htmlspecialchars($pub['nombre_estudio']) . '</p>
                    <p><strong>Curso:</strong> ' . htmlspecialchars($pub['curso']) . '</p>

                    <a href="' . htmlspecialchars($pub['archivo']) . '" class="btn btn-primary mb-2" target="_blank">
                        Ver archivo
                    </a>

                    <div class="mt-3">
                        <button class="btn btn-success me-2" data-id="' . $pub['id_publicacion'] . '" onclick="aceptarPublicacion(this)">Aceptar</button>
                        <button class="btn btn-danger" data-id="' . $pub['id_publicacion'] . '" onclick="rechazarPublicacion(this)">Rechazar</button>
                    </div>
                </div>
            </div>';
        }

        $html .= '</div>'; // cierre del contenedor
        echo $html;
    } else {
        echo '<div class="alert alert-info">No hay publicaciones pendientes de aprobación.</div>';
    }
} catch(PDOException $e) {
    echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
}
