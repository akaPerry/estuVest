<?php
$codigoUsuario = $_POST["codigo"] ?? '';
$codigoCookie = $_COOKIE["codigo_2fa"] ?? '';

if ($codigoUsuario === $codigoCookie) {
    echo "ok";
} else {
    echo "error";
}
