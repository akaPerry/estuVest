<?php
session_start();
include_once("../modelo/BaseDatos.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["id"])) {
    echo "<p>Debes iniciar sesión para ver tus publicaciones.</p>";
    exit;
}

$id_autor = $_SESSION["id"];

try {
    $bd = new BaseDatos();

    $sql = "SELECT
                p.*
            FROM
                publicacion p
            WHERE
                p.id_autor = :id_autor";

    $stmt = $bd->conn->prepare($sql);
    $stmt->bindParam(':id_autor', $id_autor, PDO::PARAM_INT);
    $stmt->execute();
    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($publicaciones) > 0) {
        $html = '<div class="row">'; // Iniciar la fila para las columnas

        foreach ($publicaciones as $pub) {
            $idPub = htmlspecialchars($pub['id_publicacion']); // Escapar la ID
            $publicado = htmlspecialchars($pub['publicado']);
            $id_asignatura = htmlspecialchars($pub['id_asignatura']);

            // Subconsulta para obtener el nombre de la asignatura
            $sql_asignatura = "SELECT nombre_asignatura, id_centro_estudio FROM asignatura WHERE id_asignatura = :id_asignatura";
            $stmt_asignatura = $bd->conn->prepare($sql_asignatura);
            $stmt_asignatura->bindParam(':id_asignatura', $id_asignatura, PDO::PARAM_INT);
            $stmt_asignatura->execute();
            $asignatura = $stmt_asignatura->fetch(PDO::FETCH_ASSOC);
            $id_relacion=$asignatura ? htmlspecialchars($asignatura['id_centro_estudio']) : 'N/A';
            $nombre_asignatura = $asignatura ? htmlspecialchars($asignatura['nombre_asignatura']) : 'N/A';

            // Subconsulta para obtener el nombre del estudio
            $id_estudio = htmlspecialchars($pub['id_estudio']);
            $sql_estudio = "SELECT nombre_estudio FROM estudio WHERE id_estudio = :id_estudio";
            $stmt_estudio = $bd->conn->prepare($sql_estudio);
            $stmt_estudio->bindParam(':id_estudio', $id_estudio, PDO::PARAM_INT);
            $stmt_estudio->execute();
            $estudio = $stmt_estudio->fetch(PDO::FETCH_ASSOC);
            $nombre_estudio = $estudio ? htmlspecialchars($estudio['nombre_estudio']) : 'N/A';

            // Subconsulta para obtener el nombre del centro
            $sql_centro = "SELECT c.nombre_centro
                           FROM centro c
                            JOIN incluye i ON i.id_centro = c.id_centro
                           WHERE i.id_relacion=:id_relacion";
            $stmt_centro = $bd->conn->prepare($sql_centro);
            $stmt_centro->bindParam(":id_relacion", $id_relacion);
            $stmt_centro->execute();
            $centro = $stmt_centro->fetch(PDO::FETCH_ASSOC);
            $nombre_centro = $centro ? htmlspecialchars($centro['nombre_centro']) : 'N/A';


            $html .= '
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title">' . htmlspecialchars($pub['titulo']) . '</h5>
                                <p class="card-text">
                                    <strong>Asignatura:</strong> ' . $nombre_asignatura . '<br>
                                    <strong>Centro:</strong> ' . $nombre_centro . '<br>
                                    <strong>Estudio:</strong> ' . $nombre_estudio . '<br>
                                    <strong>Fecha:</strong> ' . htmlspecialchars($pub['fecha']) . '<br>
                                    <strong>Curso:</strong> ' . htmlspecialchars($pub['curso']) . '
                                </p>
                            </div>
                            <div class="col-6 text-end">'; // Alineación a la derecha
                                if ($publicado == 0) {
                                    $html .= '<button class="btn btn-danger btn-sm eliminar-publicacion" data-id="' . $idPub . '">Eliminar</button>';
                                } else {
                                    $html .= '<button class="btn btn-danger btn-sm eliminar-publicacion" data-id="' . $idPub . '">Eliminar</button>
                                              <a href="publicacion_comentarios.php?id=' . $idPub . '" class="btn btn-primary btn-sm">Ver publicación</a>';
                                }
            $html .= '
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }

        $html .= '</div>'; // Cerrar la fila
        echo $html;
    } else {
        echo "<p>No has creado ninguna publicación todavía.</p>";
    }

    $bd->cerrarBD();

} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
