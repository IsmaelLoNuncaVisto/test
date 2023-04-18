<?php

$iniciar = isset($_POST["iniciarSesion"]);

$email = $_POST["email"];
$contrasenia = $_POST["contrasenia"];

//Establece conexión con la BD
require "conexion.php";
$conexion = new UsoBD();
$conexion->establecerConexion();
if ($iniciar) {
    if ($email != "" && $contrasenia != "") {

        if ($conexion->existeUsuario($email, $contrasenia)) {

            if ($conexion->controlAdministrador($email) == 0) {
                echo "<script>window.open('https://wwwdes.ismael.lonuncavisto.org/iniciarSesionNoAdministrador.php');</script>";
                echo "<script>window.close();</script>";
            } else {
                echo "<script>window.open('https://wwwdes.ismael.lonuncavisto.org/iniciarSesionAdministrador.php');</script>";
                echo "<script>window.close();</script>";
            }
        }
    } else {
        echo "<script>alert ('Ha dejado algún espacio en blanco');</script>";
        echo "<script>window.history.back();</script>";
    }
}
