<?php
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
$sql="";
}
catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}