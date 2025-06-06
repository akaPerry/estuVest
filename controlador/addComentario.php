<?php
session_start();
include_once("../modelo/BaseDatos.php");

header('Content-Type: application/json');

if (!isset($_POST['comentario'], $_POST['id_publicacion'], $_SESSION['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos.']);
    exit;
}

$comentario = trim($_POST['comentario']);
$idPublicacion = (int) $_POST['id_publicacion'];
$idUsuario = $_SESSION['id'];

if ($comentario === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Comentario vacío.']);
    exit;
}

try {
    $bd = new BaseDatos();

    // Obtener nombre del autor
    $stmtUser = $bd->conn->prepare("SELECT nick FROM usuario WHERE id = :id");
    $stmtUser->bindParam(':id', $idUsuario, PDO::PARAM_INT);
    $stmtUser->execute();
    $autor = $stmtUser->fetchColumn();

    // Insertar comentario
    $stmt = $bd->conn->prepare("
        INSERT INTO comentario (id_autor, fecha, id_publicacion, texto)
        VALUES (:id_autor, NOW(), :id_publicacion, :texto)
    ");
    $stmt->bindParam(':id_autor', $idUsuario);
    $stmt->bindParam(':id_publicacion', $idPublicacion);
    $stmt->bindParam(':texto', $comentario);
    $stmt->execute();

    // Enviar respuesta con datos del comentario
    echo json_encode([
        'autor' => htmlspecialchars($autor),
        'fecha' => date("Y-m-d, H:i"),
        'texto' => nl2br(htmlspecialchars($comentario))
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la base de datos']);
}
