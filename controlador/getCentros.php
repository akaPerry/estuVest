<?php 
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
    $centros=$bd->sacarTabla("centro");
    $centros=json_encode($centros);
    echo $centros;
}
catch(PDOException $e){
    echo("Error: ".$e->getMessage());
}