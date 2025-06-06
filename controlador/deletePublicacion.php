<?php
include_once("../modelo/BaseDatos.php");
try {   
    $bd = new BaseDatos();
    $sql = "DELETE FROM publicacion WHERE id_publicacion = :id";
    $stmt = $bd->conn->prepare($sql);
    $stmt->bindParam(':id', $_POST['id']);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Publicación eliminado correctamente";
        
        // Verificar si realmente se eliminó algún registro
        if ($stmt->rowCount() === 0) {
            $response['success'] = false;
            $response['message'] = "No se encontró la publicación con ID " . $_POST['id'];
        }
    } else {
        $response['message'] = "Error al ejecutar la consulta";
    }
    $bd->cerrarBD();
} catch (PDOException $e) {
    $response['error'] = $e->getMessage();
    $response['message'] = "Error en la base de datos";
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);