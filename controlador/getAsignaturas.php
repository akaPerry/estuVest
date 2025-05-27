<?php
include_once("../modelo/BaseDatos.php");
$bd = new BaseDatos();
try {
    if (!isset($_POST['id']) && !isset($_POST['idGrado']))
        $sql = "SELECT a.id_asignatura as 'id',
 a.nombre_asignatura as 'asignatura',
 CONCAT(c.nombre_centro,'-',e.nombre_estudio) as 'grado',
 a.anio as 'curso',
 i.id_estudio as 'id_grado'
 FROM asignatura a 
JOIN incluye i ON a.id_centro_estudio=id_relacion 
NATURAL JOIN centro c
JOIN estudio e ON i.id_estudio=e.id_estudio
ORDER BY c.id_centro;";
    elseif (isset($_POST['idGrado'])) {
        $idGrado = $_POST['idGrado'];
        $sql = "SELECT a.id_asignatura as 'id',
    a.nombre_asignatura as 'asignatura',
    CONCAT(c.nombre_centro,'-',e.nombre_estudio) as 'grado',
    a.anio as 'curso',
    a.id_centro_estudio as 'id_grado'
    FROM asignatura a
    JOIN incluye i ON a.id_centro_estudio=id_relacion
    NATURAL JOIN centro c
    JOIN estudio e ON i.id_estudio=e.id_estudio
    WHERE a.id_centro_estudio=$idGrado";
    } else {
        $id = $_POST['id'];
        $sql = "SELECT a.id_asignatura as 'id',
    a.nombre_asignatura as 'asignatura',
    CONCAT(c.nombre_centro,'-',e.nombre_estudio) as 'grado',
    a.anio as 'curso',
    a.id_centro_estudio as 'id_grado'
    FROM asignatura a
    JOIN incluye i ON a.id_centro_estudio=id_relacion
    NATURAL JOIN centro c
    JOIN estudio e ON i.id_estudio=e.id_estudio
    WHERE a.id_asignatura=$id";
    }
    $stmt = $bd->conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo (json_encode($data));
    $bd->cerrarBD();
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
