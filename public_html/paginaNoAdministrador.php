<?php

$options =array('lifetime'=>1800, 'secure'=>true);

session_set_cookie_params(1800);

session_start();
if(!isset($_SESSION["noAdministrador"])){
    header("Location: https://wwwdes.ismael.lonuncavisto.org");
    exit;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Esta es la página del no administrador;
</body>
</html>