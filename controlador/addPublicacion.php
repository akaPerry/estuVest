<?php
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
$autor=$_SESSION['id'];
$ruta=$rutaDestino;
$asignauta=$_POST['asignatura'];
$estudio=$_POST['estudio'];
$titulo=$_POST['titulo'];
$curso=$_POST['curso'];
//a veces SQL es una pesadilla
$sql="INSERT INTO publicacion 
(archivo, id_autor, id_asignatura, id_estudio, titulo, curso, fecha)
VALUES (:ruta, :autor, :asignatura, (SELECT e.id_estudio 
FROM estudio e NATURAL JOIN incluye i
WHERE i.id_relacion=:estudio), :titulo, :curso, now());";
$stmt=$bd->conn->prepare($sql);
$stmt->bindParam(":ruta",$ruta);
$stmt->bindParam(":autor",$autor);
$stmt->bindParam(":asignatura",$asignauta);
$stmt->bindParam(":estudio", $estudio);
$stmt->bindParam(":titulo",$titulo);
$stmt->bindParam(":curso",$curso);
$stmt->execute();
$bd->cerrarBD();
}
catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}