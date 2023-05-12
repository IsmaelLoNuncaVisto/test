<?php

require_once ("../src/Sesiones.php");
require_once ("../services/ConexionUsuario.php");

use test\services\ConexionUsuario;
use src\Session;

$sesion = new Session();
$conexionUsuario = new ConexionUsuario();

if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($conexionUsuario->accesoUsuario($email, $password)&& $conexionUsuario->existeToken($email)) {

        if ($conexionUsuario->accesoPaginaAdministrador($email)==1) {

            if (isset($_POST["guardarUsuario"]) && $_POST["guardarUsuario"] == "1") {

                $sesion->cookieSession("administrador","idSession");
                
            } else {

                $sesion->startSession();
                $sesion->setSession("administrador", $email);

            }

            header("Location: https://wwwdes.ismael.lonuncavisto.org/paginaAdministrador1.php");
            exit;

        } else {

            if (isset($_POST["guardarUsuario"]) && $_POST["guardarUsuario"] == "1") {

                $sesion->cookieSession("noAdministrador","idSession");
                
            } else {

                $sesion->startSession();
                $sesion->setSession("noAdministrador", $email);

            }
            header("Location: https://wwwdes.ismael.lonuncavisto.org/paginaNoAdministrador.php");
            exit;
        }
    } else {
        echo "Acceso denegado";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="inicio.css">

    <script>
        function camposVacios() {

            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            if (email == "" || password == "") {
                alert("Algunos de los parámetros está vacío");
                event.preventDefault();
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
                <label for="password">Pasword:</label>
                <input type="password" name="password" id="password">
            </ol>
            <ol>
                <button type="submit" name="login" onclick="camposVacios()">Login</button>
            </ol>
            <ol>
                <a href="recuperarPassword.php">¿Olvidó su contraseña?</a>
            </ol>
            <ol>
                <a href="crearUsuario.php">Crear una nueva cuenta</a>
            </ol>
            <ol>
                <label for="">
                    <input type="checkbox" name="guardarUsuario" value="1">
                    Recordar mi sesión
                </label>
            </ol>
        </ul>
    </form>
</body>

</html>