<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $name;
    
    public function __construct($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
    }

    public function sendWelcomeMessage() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
    
        $mail->setFrom("no-reply@sysop.com");
        $mail->addAddress($this->email, $this->name);
        $mail->Subject = 'Bienvenido a SysOp';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';
        $content .= "<p>Bienvenido a SysOp a partir de este momento formaras parte de una de las empresas más grandes de marketing digital y diseño web de Monterrey</p>";
        $content .= '</html>';
        $mail->Body = $content;

        //Enviar el mail
        $mail->send();

    }

}