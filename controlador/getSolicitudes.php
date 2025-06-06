<?php
include_once("../modelo/BaseDatos.php");
$bd = new BaseDatos();

try {
    header('Content-Type: application/json');

    if (isset($_POST['id'])) {
        // Obtener una solicitud concreta
        $id = $_POST['id'];
        $sql = "SELECT s.id_solicitud, s.elemento AS tipo, s.valor, s.id_usuario, u.nick AS usuario
                FROM solicitud s
                JOIN usuario u ON s.id_usuario = u.id
                WHERE s.id_solicitud = :id";
        $stmt = $bd->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($solicitud ?: ["error" => "Solicitud no encontrada"]);
    } else {
        // Obtener todas las solicitudes pendientes
        $sql = "SELECT s.id_solicitud, s.elemento AS tipo, s.valor, s.id_usuario, u.nick AS usuario
                FROM solicitud s
                JOIN usuario u ON s.id_usuario = u.id
                WHERE s.estado = 0";
        $stmt = $bd->conn->prepare($sql);
        $stmt->execute();
        $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($solicitudes);
    }

    $bd->cerrarBD();
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}