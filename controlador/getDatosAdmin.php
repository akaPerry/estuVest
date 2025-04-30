<?php
include_once("../modelo/BaseDatos.php");

try {
    session_start();

    if (!isset($_SESSION['id'])) {
        echo json_encode(["error" => "No hay sesión activa"]);
        exit;
    }

    $bd = new BaseDatos();
    $id = $_SESSION['id'];

    // Preparar la consulta
    $sql = "SELECT nombre, apellidos, nick, mail FROM usuario WHERE id = :id;";
    $stmt = $bd->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Enviar los datos como JSON
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}
?>
