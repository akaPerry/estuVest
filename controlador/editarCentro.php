<?php 
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
   $centro=$_POST['centro'];
   $ciudad=$_POST['ciudad'];
   $tipo=$_POST['tipo'];
   $id=$_POST['id_centro'];
   $sql="UPDATE centro 
            SET
            nombre_centro=:centro,
            ciudad=:ciudad,
            tipo=:tipo
            WHERE 
            id_centro=:id;";
   $stmt=$bd->conn->prepare($sql);
   $stmt->bindParam(":centro",$centro);
   $stmt->bindParam("ciudad",$ciudad);
   $stmt->bindParam(":tipo",$tipo);
   $stmt->bindParam(":id", $id);

   $stmt->execute();
    echo "Centro actualizado con exito";
}catch(PDOException $e){
    echo "Error: ".$e->getMessage();
}