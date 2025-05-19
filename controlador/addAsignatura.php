<?php
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
    $nombreAs=$_POST["asignatura"];
    $estudioCentro=$_POST["grado"];
    $anio=$_POST["curso"];
    var_dump($_POST);

$sql="INSERT INTO asignatura VALUES(default, :idRel, :nombre, :anio);";
$stmt = $bd->conn->prepare($sql);
$stmt->bindParam(":idRel",$estudioCentro);
$stmt->bindParam(":nombre",$nombreAs);
$stmt->bindParam(":anio",$anio);
$stmt->execute();
$bd->cerrarBD();

}
catch(PDOException $e){
    echo "Error: ".$e->getMessage();
}