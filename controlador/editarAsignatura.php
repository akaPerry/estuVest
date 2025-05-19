<?php
include_once("../modelo/BaseDatos.php");
$bd = new BaseDatos();

try {
    $idAsig = $_POST["id_asignatura"];
    $nombreAs = $_POST["asignatura"];
    $estudioCentro = $_POST["grado"];
    $anio = $_POST["curso"];

    var_dump($_POST);

    $sql = "UPDATE asignatura
            SET id_centro_estudio = :idRel,
                nombre_asignatura = :nombre,
                anio = :anio
            WHERE id_asignatura = :idAsig;";
    
    $stmt = $bd->conn->prepare($sql);
    $stmt->bindParam(":idRel", $estudioCentro);
    $stmt->bindParam(":nombre", $nombreAs);
    $stmt->bindParam(":anio", $anio);
    $stmt->bindParam(":idAsig", $idAsig);
    $stmt->execute();

    echo "Asignatura actualizada correctamente.";
    $bd->cerrarBD();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}