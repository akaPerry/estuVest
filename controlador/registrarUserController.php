<?php
include_once "../modelo/BaseDatos.php";
include_once "../modelo/UsuarioReg.php";

$usu = new UsuarioReg(
    $_POST["nick"],
$_POST["contrasenia"],
$_POST["email"],
$_POST["nombre"],
$_POST["apellidos"],
$_POST["ciudad"],
$_POST["estudios"]);
try{
$bd=new BaseDatos();
if($bd->buscarEnTabla("usuario","nick",$usu->getNick())){
    echo "El usuario ya existe</br>";
}else{
    $bd->insertarUsuReg(
        $usu->getNombre(),
        $usu->getApellidos(),
        $usu->getEmail(),
        $usu->getNick(),
        password_hash($usu->getContrasenia(),PASSWORD_DEFAULT),
        $usu->getCiudad(),
        $usu->getEstudios()
    );
    $bd->cerrarBD();
    header("Location: ../vista/logUsu.php");
}

}
catch(PDOException $e){
    echo $e->getMessage();
}
