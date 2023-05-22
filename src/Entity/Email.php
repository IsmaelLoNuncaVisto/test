<?php

namespace App\Entity;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public static function enviarEmailCreacionCuenta($email,$token){

        $mail=new PHPMailer();

        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->Host = 'imap.lonuncavisto.com';
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='STARTTLS';
        $mail->Port=587;
     
        $mail->setFrom('ismael@lonuncavisto.com','Remitente');
        $mail->addAddress($email);
        $mail->Subject='Creación cuenta';
        $mail->Body='Se creo una cuenta en: wwwdes.ismael.lonuncavisto.org, confirme con el siguiente enlace: https://wwwdes.ismael.lonuncavisto.org/paginaConfirmacionEmail.php?email=' . $email . '&token=' . $token . PHP_EOL . 'Su token será: ' .  $token;
     
        if(!$mail->send()){
         echo 'Error al enviar correo electrónico: ' . $mail->ErrorInfo;
        }

    }

    public static function enviarEmailModificacionPassword($email,$token){

        $mail=new PHPMailer();

        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->Host = 'imap.lonuncavisto.com';
        $mail->SMTPAuth=true;
        $mail->Username='ismael@lonuncavisto.com';
        $mail->Password='hd29823bd0.9aqP';
        $mail->SMTPSecure='STARTTLS';
        $mail->Port=587;
     
        $mail->setFrom('ismael@lonuncavisto.com','Remitente');
        $mail->addAddress($email);
        $mail->Subject='Recuperaqción contraseña';
        $mail->Body='Se creo una cuenta en: wwwdes.ismael.lonuncavisto.org, confirme con el siguiente enlace: https://wwwdes.ismael.lonuncavisto.org/establecerPassword.php?email=' . $email . '&token=' . $token . PHP_EOL . 'Su token será: ' .  $token;
     
        if(!$mail->send()){
         echo 'Error al enviar correo electrónico: ' . $mail->ErrorInfo;
        }

    }

    

}

?>