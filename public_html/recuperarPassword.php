<?php

use PHPMailer\PHPMailer\PHPMailer;
use src\Email;

$mail=new Email();


require ('conexion.php');
$conexion=new UsoBD();
$conexion->establecerConexion();



$token = uniqid();
$tiempo_vida = 3600;
$expiracion=date('Y-m-d H:i:s', time() + $tiempo_vida);

if(isset($_POST['recuperar'])){
    $email=$_POST['email'];
    if($conexion->existeUsuario($email)){
    $conexion->tokenUsuario($email,$token,$expiracion);
    $mail->enviarEmailCreacionCuenta($email,$token);
    }else{
        echo "El email no existe";
    }
}

if(isset($_POST["volver"])){
    header("Location: https://wwwdes.ismael.lonuncavisto.org");
    exit;
}

$conexion->cerrarConexion();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="inicio.css">

    <script>
    function camposVacios(){
        var email=document.getElementById("email").value;
        if(email==""){
            alert("Escriba un email");
        }
        
    }
    </script>

</head>
<body>

<form action="" method="post">
    <ul>
        <ol>
            
            <label for="email">Email:</label>
            <input type="email" placeholder="ejemplo@prueba.com" name="email" value="" id="email">
        </ol>
        <ol>
            <button type="submit" name="recuperar" onclick="camposVacios()">Recuperar Contraseña</button>
            <button type="submit" name="volver">Return</button>
        </ol>
       
    </ul>
</form>
</body>
</html>