<?php
include_once("../modelo/BaseDatos.php");
$bd = new BaseDatos();
header('Content-Type: application/json'); // Muy importante

try {
    $centros = $bd->sacarTabla("centro");
    echo json_encode($centros);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}