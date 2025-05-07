<?php 
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
    $sql="SELECT id_centro as 'id', nombre_centro as 'centro', ciudad, tipo
     FROM centro;";
     $stmt=$bd->conn->prepare($sql);
     $stmt->execute();
     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
     echo (json_encode($data));
    $bd->cerrarBD();
}
catch(PDOException $e){
    echo("Error: ".$e->getMessage());
}