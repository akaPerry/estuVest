<?php
    require_once("../modelo/BaseDatos.php");
    $bd=new BaseDatos();
    try{
        $sql="SELECT * FROM usuario 
       natural join usuario_registrado where rol='usuario_registrado';";
        $stmt= $bd->conn->prepare($sql);
        $stmt->execute();
        $json=array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $usuario=array(
                "id"=>$row['id'],
                "nick"=>$row['nick'],
                "nombre"=>$row['nombre'],
                "apellidos"=>$row['apellidos'],
                "mail"=>$row['mail'],
                "ciudad"=>$row['ciudad'],
                "estudios"=>$row['estudios']  
            );
            $json[]=$usuario;
        }
        echo json_encode($json);

    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }