<?php
include_once "../modelo/BaseDatos.php";

$usu = $_POST["nick"];
$psd = $_POST["contrasenia"];

try {
    $bd = new BaseDatos();
    if ($bd->logearUsu($usu, $psd)) {
        session_start();
        $_SESSION["nick"] = $usu;

        $id = $bd->sacarUnValor("usuario", "nick", $_SESSION["nick"], "id");
        $_SESSION["id"] = $id;
        session_write_close();

        if ($bd->buscarEnTabla("usuario_registrado", "id", $id)) {
            echo "redirect:../vista/vistaUsuReg.php";
        } else {
            echo "redirect:../vista/vistaAdmin.php?url=false";
        }
    } else {
        echo "error:Usuario o contraseña incorrectos";
    }
} catch (PDOException $e) {
    echo "error:" . $e->getMessage();
}
