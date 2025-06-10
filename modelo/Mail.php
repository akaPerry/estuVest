<?php
require_once '../mailer/PHPMailer/src/Exception.php';
require_once '../mailer/PHPMailer/src/PHPMailer.php';
require_once '../mailer/PHPMailer/src/SMTP.php';

/* 

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        try {
            // Configuración SMTP IONOS
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.ionos.es';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'estuvest@estuvest.online'; // ← reemplazar
            $this->mail->Password   = 'kKBaAq@fs9CL@xb';            // ← reemplazar
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = 587;

            // Remitente por defecto
            $this->mail->setFrom('estuvest@estuvest.online', 'Estuvest'); // ← reemplazar
            $this->mail->isHTML(true);
        } catch (Exception $e) {
            error_log("Error al configurar PHPMailer: " . $e->getMessage());
        }
    }

    public function enviar($destinatario, $asunto, $cuerpo) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($destinatario);
            $this->mail->Subject = $asunto;
            $this->mail->Body    = $cuerpo;
            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $e->getMessage());
            return false;
        }
    }
}
