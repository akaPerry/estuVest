<?php
include_once("../modelo/BaseDatos.php");
$bd = new BaseDatos();

try {
    $idEstudio = $_POST['id_estudio'];
    $estudio = $_POST['estudio'];
    $idCentro = $_POST['centro'];
    $nivel = $_POST['nivel'];
    $idRelacion = $_POST['id_relacion'];

    // Actualizar la tabla estudio
    $sql1 = "UPDATE estudio
             SET nombre_estudio = :estudio,
                 nivel = :nivel
             WHERE id_estudio = :id;";
    $stmt = $bd->conn->prepare($sql1);
    $stmt->bindParam(":estudio", $estudio);
    $stmt->bindParam(":nivel", $nivel);
    $stmt->bindParam(":id", $idEstudio);
    $stmt->execute();

    // Verificar si ya existe la relación en incluye
    $sql2 = "SELECT COUNT(*) FROM incluye WHERE id_relacion = :id_relacion";
    $stmt = $bd->conn->prepare($sql2);
    $stmt->bindParam(":id_relacion", $idRelacion);
    $stmt->execute();
    $existe = $stmt->fetchColumn();

    if ($existe) {
        // Si la relación ya existe, actualizarla
        $sql3 = "UPDATE incluye
                 SET id_estudio = :id_estudio, id_centro = :id_centro
                 WHERE id_relacion = :id_relacion;";
    } else {
        // Si no existe, insertarla
        $sql3 = "INSERT INTO incluye (id_relacion, id_centro, id_estudio)
                 VALUES (:id_relacion, :id_centro, :id_estudio);";
    }

    $stmt = $bd->conn->prepare($sql3);
    $stmt->bindParam(":id_relacion", $idRelacion);
    $stmt->bindParam(":id_centro", $idCentro);
    $stmt->bindParam(":id_estudio", $idEstudio);
    $stmt->execute();
    $bd->cerrarBD();
    echo "Actualización realizada correctamente.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>