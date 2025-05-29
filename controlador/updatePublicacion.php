<?php
include_once("../modelo/BaseDatos.php");

if (isset($_POST['id'], $_POST['accion'])) {
    $id = (int) $_POST['id'];
    $accion = $_POST['accion'];

    try {
        $bd = new BaseDatos();
        $conn = $bd->conn;

        switch ($accion) {
            case 'aceptar':
                $sql = "UPDATE publicacion SET publicado = 1 WHERE id_publicacion = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$id]);
                echo "✅ Publicación aceptada correctamente.";
                break;

            case 'rechazar':
               
                echo "❌ Publicación marcada como rechazada (pendiente de comentario).";
                break;
                
            default:
                echo "⚠️ Acción no válida.";
        }

    } catch (PDOException $e) {
        echo "❌ Error en la base de datos: " . $e->getMessage();
    }

} else {
    echo "⚠️ Datos insuficientes para procesar la solicitud.";
}
