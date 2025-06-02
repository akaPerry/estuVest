<?php
include_once("../modelo/BaseDatos.php");
$bd=new BaseDatos();
try{
    $sql="SELECT 
            p.*, 
            u.nick AS autor, 
            a.nombre_asignatura AS asignatura, 
            e.nombre_estudio AS estudio
        FROM publicacion p
        JOIN usuario u ON p.id_autor = u.id
        JOIN asignatura a ON p.id_asignatura = a.id_asignatura
        JOIN estudio e ON p.id_estudio = e.id_estudio;";
    $stmt=$bd->conn->prepare($sql);
    $publicaciones=$stmt->execute();
    $publicaciones=$stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($publicaciones);
}catch(PDOException $e){
    echo $e->getMessage();
}