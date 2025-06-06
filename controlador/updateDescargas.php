<?php
header('Content-Type: application/json');
include_once("../modelo/BaseDatos.php");

$bd = new BaseDatos();

try {
    if (!isset($_POST['id'])) {
        echo json_encode(['error' => 'ID no recibido']);
        exit;
    }

    $idPub = $_POST['id'];

    $sql = "UPDATE publicacion SET descargas = descargas + 1 WHERE id_publicacion = :id";
    $stmt = $bd->conn->prepare($sql);
    $stmt->bindParam(":id", $idPub);
    $stmt->execute();

    echo json_encode(['success' => true, 'id' => $idPub]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}