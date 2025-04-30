<?php
require_once("../modelo/BaseDatos.php");



try {
   
    $bd = new BaseDatos();
    $sql = "DELETE FROM usuario WHERE id = :id";
    $stmt = $bd->conn->prepare($sql);
    $stmt->bindParam(':id', $_POST['id']);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Usuario eliminado correctamente";
        
        // Verificar si realmente se eliminó algún registro
        if ($stmt->rowCount() === 0) {
            $response['success'] = false;
            $response['message'] = "No se encontró el usuario con ID " . $_POST['id'];
        }
    } else {
        $response['message'] = "Error al ejecutar la consulta";
    }
} catch (PDOException $e) {
    $response['error'] = $e->getMessage();
    $response['message'] = "Error en la base de datos";
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
