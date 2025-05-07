<?php
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
$sql="SELECT  e.id_estudio as 'id',
e.nombre_estudio as 'estudio',
c.nombre_centro as 'centro',
e.nivel as 'nivel',
i.id_relacion as 'id_relacion'
FROM estudio e NATURAL JOIN incluye i
NATURAL JOIN centro c ORDER BY nivel;";
$stmt=$bd->conn->prepare($sql);
$data=$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo (json_encode($data));
}
catch(PDOException $e){
    echo ("Error: ".$e->getMessage());
}