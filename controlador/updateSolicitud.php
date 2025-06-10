<?php
include_once("../modelo/BaseDatos.php");
try{
    $bd = new BaseDatos();
    $id = (int) $_POST['id'];
    $sql = "UPDATE solicitud SET estado = 1 WHERE id_solicitud = :id";
    $stmt = $bd->conn->prepare($sql);
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    echo "✅ Publicación aceptada correctamente.";
}
catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}
