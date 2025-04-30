<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === 0) {
        $archivoTmp = $_FILES['pdf']['tmp_name'];
        $nombreArchivo = basename($_FILES['pdf']['name']);
        $rutaDestino = "../archivos/" . uniqid() . "_" . $nombreArchivo;

        // Validar tipo MIME
        $mime = mime_content_type($archivoTmp);
        if ($mime !== 'application/pdf') {
            echo "❌ El archivo no es un PDF válido.";
            exit;
        }


        if (move_uploaded_file($archivoTmp, $rutaDestino)) {
            echo "✅ Publicación subida con éxito. Será publicada en web cuando sea validada por un administrador.";
            // Guardar publicación en base de datos
            include_once("../controlador/addPublicacionController.php");
        } else {
            echo "❌ Error al guardar el archivo.";
        }
    } else {
        echo "❌ No se recibió ningún archivo o hubo un error.";
    }
} else {
    echo "❌ Petición no válida.";
}