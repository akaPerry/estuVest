<?php 
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
    $nombre=$_POST["nombreCarrera"];
    $idCentro=$_POST["centro"];
    $nivel=$_POST["nivel"];
    $sql1="INSERT INTO estudio values(default, :nombre, :nivel);";
    $stmt=$bd->conn->prepare($sql1);
    $stmt->bindParam(":nombre",$nombre);
    $stmt->bindParam(":nivel",$nivel);
    $stmt->execute();
    $idEstudio=$bd->sacarUnValor("estudio","id_centro",$idCentro,"id_estudio");
    
}
catch(PDOException $e){
    echo("Error: ".$e->getMessage());
}