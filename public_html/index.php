<?php

$mysqli = new mysqli("localhost","ismael","ismael");

if($mysqli->connect_errno){
    echo "Fallo al conectar MariaDB";
}

echo $mysqli->host_info . "\n";


?>