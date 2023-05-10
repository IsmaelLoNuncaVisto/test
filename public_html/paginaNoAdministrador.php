<?php

require ("../src/Sesiones.php");

use src\Session;

$sesion=new Session();
$VUELTA_PAG_PRINC  = "Location: "  . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'];
$sesionId="cookieDeSesion";
$nombreSesion="noAdministrador";
$sesion->condicionesInicioSesion($sesionId,$nombreSesion,$VUELTA_PAG_PRINC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina 1</title>
</head>
<body>
    <h1>Hola No Administrador!</h1>
</body>
</html>