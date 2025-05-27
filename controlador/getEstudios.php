<?php
include_once("../modelo/BaseDatos.php");
$bd = new BaseDatos();
try {
    if (!isset($_POST['id']) && !isset($_POST['idCentro'])) {
        $sql1 = "SELECT  e.id_estudio as 'id',
e.nombre_estudio as 'estudio',
c.nombre_centro as 'centro',
c.id_centro as 'id_centro',
e.nivel as 'nivel',
i.id_relacion as 'id_relacion'
FROM estudio e NATURAL JOIN incluye i
NATURAL JOIN centro c ORDER BY nivel;";
        $stmt = $bd->conn->prepare($sql1);
        $data = $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo (json_encode($data));
    } elseif (isset($_POST['idCentro'])) {
        $idCentro = $_POST['idCentro'];
        $sql3 = "SELECT  e.id_estudio as 'id',
 e.nombre_estudio as 'estudio',
 c.nombre_centro as 'centro',
 c.id_centro as 'id_centro',
 e.nivel as 'nivel',
 i.id_relacion as 'id_relacion'
 FROM estudio e NATURAL JOIN incluye i
 NATURAL JOIN centro c WHERE i.id_centro = '$idCentro' ORDER BY id_centro;";
        $stmt = $bd->conn->prepare($sql3);
        $data = $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo (json_encode($data));
    } else {
        $id = $_POST['id'];
        $sql3 = "SELECT  e.id_estudio as 'id',
 e.nombre_estudio as 'estudio',
 c.nombre_centro as 'centro',
 c.id_centro as 'id_centro',
 e.nivel as 'nivel',
 i.id_centro as 'id_relacion'
 FROM estudio e NATURAL JOIN incluye i
 NATURAL JOIN centro c WHERE e.id_estudio = '$id' ORDER BY nivel;";
        $stmt = $bd->conn->prepare($sql2);
        $data = $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo (json_encode($data));
    }
} catch (PDOException $e) {
    echo ("Error: " . $e->getMessage());
}
