<?php
session_start();
require_once "../modelo/Mail.php";
include_once "../modelo/BaseDatos.php";

// Sanitizamos los inputs
$nick = $_POST["nick"] ?? '';
$contrasenia = $_POST["contrasenia"] ?? '';

if (empty($nick) || empty($contrasenia)) {
    echo "error:Campos vacíos";
    exit;
}

try {
    $bd = new BaseDatos();

    // Verificar que el usuario exista y obtener su correo
    $sql = "SELECT mail, contrasenia FROM usuario WHERE nick = :nick LIMIT 1";
    $stmt = $bd->conn->prepare($sql);
    $stmt->bindParam(":nick", $nick);
    $stmt->execute();

    if ($stmt->rowCount() !== 1) {
        echo "error:Usuario no encontrado";
        exit;
    }

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $hash_guardado = $usuario["contrasenia"];
    $correo_usuario = $usuario["mail"];

    // Comparar contraseñas (plaintext vs hash o texto directo)
    if (!password_verify($contrasenia, $hash_guardado) && $contrasenia !== $hash_guardado) {
        echo "error:Contraseña incorrecta";
        exit;
    }

    // Generar código y enviar
    $codigo = rand(100000, 999999);

    $asunto = "🔐 Código de verificación - Estuvest";
    $cuerpo = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f9f9f9;
                padding: 20px;
                color: #333;
            }
            .container {
                background-color: #ffffff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                max-width: 500px;
                margin: 0 auto;
                box-shadow: 0 0 10px rgba(0,0,0,0.05);
            }
            h2 {
                color: #4A90E2;
                text-align: center;
            }
            .code {
                font-size: 32px;
                font-weight: bold;
                color: #1a73e8;
                text-align: center;
                margin: 20px 0;
                letter-spacing: 5px;
            }
            p {
                font-size: 15px;
                line-height: 1.6;
            }
            .footer {
                font-size: 12px;
                text-align: center;
                color: #888;
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Verificación en dos pasos</h2>
            <p>Hola <strong>$nick</strong>,</p>
            <p>Has solicitado iniciar sesión en <strong>Estuvest</strong>. Para continuar, introduce el siguiente código de verificación:</p>
            <div class='code'>$codigo</div>
            <p>Este código estará disponible durante los próximos <strong>10 minutos</strong>. Si no has solicitado este acceso, ignora este mensaje.</p>
            <div class='footer'>Estuvest - Plataforma educativa segura</div>
        </div>
    </body>
    </html>
    ";

    $mail = new Mail();
    if ($mail->enviar($correo_usuario, $asunto, $cuerpo)) {
        setcookie("codigo_2fa", $codigo, time() + 600, "/");
        echo "ok";
    } else {
        echo "error:No se pudo enviar el correo";
    }
} catch (PDOException $e) {
    echo "error:Error al acceder a la base de datos";
}
