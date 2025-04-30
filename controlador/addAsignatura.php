<?php
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
    $nombreAs=$_POST["nombreAsignatura"];
}
catch(PDOException $e){
    echo "Error: ".$e->getMessage();
}