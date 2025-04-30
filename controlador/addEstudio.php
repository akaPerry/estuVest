<?php 
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
    // recogemos los datos del formulario y realizamos la sentencia ara añadir el estudio a la tabla
    $nombre=$_POST["nombreCarrera"];
    $idCentro=$_POST["centro"];
    $nivel=$_POST["nivel"];
    $sql1="INSERT INTO estudio values(default, :nombre, :nivel);";
    $stmt=$bd->conn->prepare($sql1);
    $stmt->bindParam(":nombre",$nombre);
    $stmt->bindParam(":nivel",$nivel);
    $stmt->execute();
    // insertamos los ids del estudio y el centro al que perntenece en la tabla que conecta los estudios y el centro
    $idEstudio=$bd->conn->lastInsertId();
    $sql2="INSERT INTO incluye VALUES (default,:centro, :estudio);";
    $stmt=$bd->conn->prepare($sql2);
    $stmt->bindParam(":centro",$idCentro);
    $stmt->bindParam(":estudio",$idEstudio);
    $stmt->execute();
    $bd->cerrarBD();
}
catch(PDOException $e){
    echo("Error: ".$e->getMessage());
}