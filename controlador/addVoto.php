<?php
session_start();
include_once("../modelo/BaseDatos.php");

header('Content-Type: application/json');

if (!isset($_SESSION["id"])) {
    echo json_encode(["success" => false, "message" => "Usuario no autenticado"]);
    exit;
}

if (!isset($_POST['id_publicacion'], $_POST['puntuacion'])) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

$idUsuario = $_SESSION["id"];
$idPublicacion = intval($_POST['id_publicacion']);
$puntuacion = intval($_POST['puntuacion']);

if ($puntuacion < 1 || $puntuacion > 5) {
    echo json_encode(["success" => false, "message" => "Puntuación inválida"]);
    exit;
}

try {
    $bd = new BaseDatos();

    // Comprobar si ya ha votado
    $check = $bd->conn->prepare("SELECT * FROM votos WHERE id_usuario = ? AND id_publicacion = ?");
    $check->execute([$idUsuario, $idPublicacion]);

    if ($check->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "Ya has votado esta publicación"]);
        exit;
    }

    // Insertar el voto
    $insert = $bd->conn->prepare("INSERT INTO votos (id_usuario, id_publicacion, puntuacion) VALUES (?, ?, ?)");
    $insert->execute([$idUsuario, $idPublicacion, $puntuacion]);

    // Calcular nueva media
    $mediaStmt = $bd->conn->prepare("SELECT AVG(puntuacion) AS media, COUNT(*) as total FROM votos WHERE id_publicacion = ?");
    $mediaStmt->execute([$idPublicacion]);
    $resultado = $mediaStmt->fetch(PDO::FETCH_ASSOC);

    // Actualiza la publicación
    $update = $bd->conn->prepare("UPDATE publicacion SET puntuacion = ?, votos = ? WHERE id_publicacion = ?");
    $update->execute([
        round($resultado['media']),
        $resultado['total'],
        $idPublicacion
    ]);

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error en la base de datos"]);
}
