<?php

session_start();

$iniciar = isset($_POST["iniciarSesion"]);
$crearUsuario= isset($_POST["crearUsuario"]);

$email = $_POST["email"];
$contrasenia = $_POST["password"];

//Establece conexión con la BD
require "conexion.php";
$conexion = new UsoBD();
$conexion->establecerConexion();
if ($iniciar && $conexion->existeUsuario($email, $contrasenia)) {
    if ($conexion->controlAdministrador($email) == 0) {
        $_SESSION['email']=$email;
        header("Location: https://wwwdes.ismael.lonuncavisto.org/iniciarSesionNoAdministrador.php");
        exit;
    } else{
        $_SESSION['email']=$email;
        header("Location: https://wwwdes.ismael.lonuncavisto.org/iniciarSesionAdministrador.php");
        exit;
    }
}

if($crearUsuario){
    header("Location: https://wwwdes.ismael.lonuncavisto.org/crearUsuario.html");
    exit;
}


