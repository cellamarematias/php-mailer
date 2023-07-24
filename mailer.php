<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader

require './php-mailer/Exception.php';
require './php-mailer/PHPMailer.php';
require './php-mailer/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Recibir los datos enviados desde React
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $agentEmail = $_POST['agentEmail'];
    $agentEmailRecipient = $_POST['agentEmailRecipient'];
    $agentEmailRecipientCopy = $_POST['agentEmailRecipientCopy'];

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $agentEmail;                     //SMTP username
    $mail->Password   = 'Matiazz788';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($agentEmail, 'Mailer');
    // Verificar si hay una copia en CC antes de agregarla
    if (!empty($agentEmailRecipient)) {
        $mail->addCC($agentEmailRecipient);
    }
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    // Verificar si hay una copia en CC antes de agregarla
    if (!empty($agentEmailRecipientCopy)) {
        $mail->addCC($agentEmailRecipientCopy);
    }
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    // Establecer la codificación del contenido del correo como UTF-8
    $mail->CharSet = 'UTF-8';


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;

    // Estilos para el cuerpo del correo
    $body = '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333; line-height: 1.6em;">';
    $body .= '<h2 style="color: #ED525E;">Contacto desde formulario de Sitio Web</h2>';
    $body .= '<p><strong>Nombre:</strong> ' . htmlspecialchars($name) . '</p>';
    $body .= '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>';
    $body .= '<p><strong>Mensaje:</strong><br>' . nl2br(htmlspecialchars($message)) . '</p>';
    $body .= '</div>';

    $mail->Body = $body;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
