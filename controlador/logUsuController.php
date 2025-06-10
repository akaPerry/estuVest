<?php
include_once "../modelo/BaseDatos.php";

$usu=$_POST["nick"];
$psd=$_POST["contrasenia"];

try{
    $bd=new BaseDatos();
    if($bd->logearUsu($usu,$psd)){
        session_start();
        $_SESSION["nick"]=$usu;
        
        //redirigimos al usuario según es admin o no
        $id=$bd->sacarUnValor("usuario","nick",$_SESSION["nick"],"id");
        $_SESSION["id"]=$id;
        session_write_close();
        if($bd->buscarEnTabla("usuario_registrado","id",$id, true)){
            header("Location: ../vista/vistaUsuReg.php");
        }
        else{
            header("Location: ../vista/vistaAdmin.php?url=false");
        }
        
    }
}
catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}