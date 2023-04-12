<?php

$db_host="localhost";
$db_nombre="ismael";
$db_user="ismael";
$db_contrasenia="ismael";

$conexion= mysqli_connect($db_host,$db_user,$db_contrasenia,$db_nombre);

if(mysqli_connect_errno()){
    echo "Fallo al conectar con al abase de datos";

    exit();

}
mysqli_select_db($conexion,$db_nombre) or die ("No se encuentra la BBDD");

?>