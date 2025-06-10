<?php
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
$tabla=$_POST['tabla'];
$campo="id_".$tabla;
$valor=$_POST['id'];
 // Verificar que los nombres no sean maliciosos (evita inyecciones SQL)
 $permitidas = ['centro', 'asignatura', 'estudio'];
 if (!in_array($tabla, $permitidas)) {
     throw new Exception("Tabla no permitida.");
 }
$sql="DELETE FROM $tabla WHERE $campo = :valor ;";
$stmt=$bd->conn->prepare($sql);
$stmt->bindParam(":valor",$valor);
$stmt->execute();
echo json_encode(['success' => true]);
}
catch(PDOException $e){
    echo json_encode(['error' => $e->getMessage()]);
}