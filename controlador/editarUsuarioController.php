<?php
include_once("../modelo/BaseDatos.php");
try{
    $bd=new BaseDatos();
    $sql1 = "UPDATE usuario 
    SET nombre=:nombre, 
        apellidos=:apellidos, 
        mail=:mail, 
        nick=:nick 
    WHERE id=:id";

$stmt1 = $bd->conn->prepare($sql1);
$stmt1->bindParam(':nombre', $_POST['nombre']);
$stmt1->bindParam(':apellidos', $_POST['apellidos']);
$stmt1->bindParam(':mail', $_POST['mail']);
$stmt1->bindParam(':nick', $_POST['nick']);
$stmt1->bindParam(':id', $_POST['id']);
$stmt1->execute();

if($_POST['rol']=='usuario_registrado'){
$sql2 = "UPDATE usuario_registrado 
    SET ciudad=:ciudad, 
        estudios=:estudios 
    WHERE id=:id";

$stmt2 = $bd->conn->prepare($sql2);
$stmt2->bindParam(':ciudad', $_POST['ciudad']);
$stmt2->bindParam(':estudios', $_POST['estudios']);
$stmt2->bindParam(':id', $_POST['id']);
$stmt2->execute();
$bd->cerrarBD();
}
echo "Datos actualizados correctamente";

}
catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}

