<?php
include_once("../modelo/BaseDatos.php");
 $bd=new BaseDatos();
 try{
   $nombre=$_POST['nombreCentro'];
   $ciudad=$_POST['ciudad'];
   $tipo=$_POST['tipoCentro'];

   $sql="INSERT INTO centro VALUES (default, :nombre, :ciudad, :tipo);";
   $stmt=$bd->conn->prepare($sql);
   $stmt->bindParam(":nombre",$nombre);
   $stmt->bindParam(":ciudad",$ciudad);
   $stmt->bindParam(":tipo",$tipo);
   $stmt->execute();

}
catch(PDOException $e){
    echo("Error: ".$e->getMessage());
}