<?php
include_once("../modelo/BaseDatos.php");
header('Content-Type: application/json');
session_start();

$response = array('success' => false, 'message' => '');

try {
    $bd = new BaseDatos();

    if (!isset($_POST['id_comentario']) || !is_numeric($_POST['id_comentario'])) {
        $response['message'] = "ID de comentario inválido.";
        echo json_encode($response);
        exit;
    }

    $id_comentario = (int)$_POST['id_comentario'];

    // Obtener el id_publicacion antes de eliminar el comentario
    $sql_select = "SELECT id_publicacion FROM comentario WHERE id_comentario = :id";
    $stmt_select = $bd->conn->prepare($sql_select);
    $stmt_select->bindParam(':id', $id_comentario, PDO::PARAM_INT);
    $stmt_select->execute();

    if ($stmt_select->rowCount() === 0) {
        $response['message'] = "No se encontró el comentario con ID " . $id_comentario . ".";
        echo json_encode($response);
        exit;
    }

    $id_publicacion = $stmt_select->fetch(PDO::FETCH_ASSOC)['id_publicacion'];

    // Eliminar el comentario
    $sql_delete = "DELETE FROM comentario WHERE id_comentario = :id";
    $stmt_delete = $bd->conn->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $id_comentario, PDO::PARAM_INT);

    if ($stmt_delete->execute()) {
        if ($stmt_delete->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = "Comentario eliminado correctamente.";

            // Actualizar la sesión $_SESSION['publicaciones_con_comentarios']
            if (isset($_SESSION['publicaciones_con_comentarios'][$id_publicacion])) {
                // Filtrar los comentarios para eliminar el comentario eliminado
                $_SESSION['publicaciones_con_comentarios'][$id_publicacion]['comentarios'] = array_filter(
                    $_SESSION['publicaciones_con_comentarios'][$id_publicacion]['comentarios'],
                    function ($comentario) use ($id_comentario) {
                        return $comentario['id_comentario'] != $id_comentario;
                    }
                );
                //Reindexar el array de comentarios
                $_SESSION['publicaciones_con_comentarios'][$id_publicacion]['comentarios'] = array_values($_SESSION['publicaciones_con_comentarios'][$id_publicacion]['comentarios']);
            }

        } else {
            $response['message'] = "No se encontró el comentario con ID " . $id_comentario . " o no tienes permiso para eliminarlo.";
        }
    } else {
        $response['message'] = "Error al ejecutar la consulta.";
        $response['error'] = $stmt_delete->errorInfo();
    }

    $bd->cerrarBD();

} catch (PDOException $e) {
    $response['message'] = "Error en la base de datos: " . $e->getMessage();
    $response['error'] = $e->getMessage();
} catch (Exception $e) {
    $response['message'] = "Error: " . $e->getMessage();
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>
