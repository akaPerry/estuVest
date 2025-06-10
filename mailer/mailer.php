<?php



use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;



require 'PHPMailer/src/Exception.php';

require 'PHPMailer/src/PHPMailer.php';

require 'PHPMailer/src/SMTP.php';



$mail = new PHPMailer(true);    // Crear una instancia de PHPMailer



try {

    //definiciones 

    $mail = new PHPMailer();

    $mail->IsSMTP();

    $mail->SMTPDebug = 1; //da info en excepción. cambiar a 0 para no verla

    $mail->SMTPAuth = true;

    $mail->SMTPSecure = "TLS";

    $mail->Host = "smtp.gmail.com";

    $mail->Port = 587; //puerto para TLS

    //datos user

    $mail->Username = "iespruebaspaco@gmail.com"; // Usuario de google 

    $mail->Password = "jkdcyaytifkwxmxs"; // Clave 

    $mail->SetFrom('iespruebaspaco@gmail.com', 'Paco'); //mail y nombre de remitente

    

    //contenido mail

    $mail->CharSet = 'UTF-8'; //para que detecte los caracteres bien

    $mail->Subject = "Aviso meteorológico"; //título

    $mail->MsgHTML($msj); //mensaje

    //$mail->addAttachment("Meme.png"); // Adjuntos si los hay

    //info de destinatarios

   // $mail->AddAddress('j.agraz@hotmail.com', "Test");

    //mail->AddAddress('jose.elviro@iesmariamoliner.com', "Test");

    //$mail->addCC("viendolateleenelbusxD@hotmail.com"); //copia

    $mail->addbcc($value2["correo"]); //copia oculta

    //envío

    $result = $mail->Send();



    if (!$result) { //Se comprueba según se haya enviado 

        echo "Error" . $mail->ErrorInfo;

    } else {

        echo "Enviado";

    }

} catch (Exception $ex) {

    echo "Error detectado: " . $ex;

}

   

