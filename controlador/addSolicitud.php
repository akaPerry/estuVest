<?php
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
$usuario = $_POST['id_usuario'];
$elemento = $_POST['elemento'];
$valor = $_POST['valor'];

$sql = "INSERT INTO solicitud (id_usuario, elemento, valor) VALUES (:usuario, :elemento, :valor)";
$stmt = $bd->conn->prepare($sql);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':elemento', $elemento);
$stmt->bindParam(':valor', $valor);
$stmt->execute();
$bd->cerrarBD();
}catch(PDOException $e){
    echo $e->getMessage();
}