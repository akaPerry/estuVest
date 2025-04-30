<?php
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
$sql="SELECT * FROM estudio NATURAL JOIN incluye NATURAL JOIN centro ORDER BY nivel;";
$stmt=$bd->conn->prepare($sql);
$data=$stmt->execute();
echo (json_encode($data));
}
catch(PDOException $e){
    echo ("Error: ".$e->getMessage());
}