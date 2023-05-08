<?php

$VUELTA_PAG_PRINC  = "Location: "  . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'];

if(isset($_COOKIE["cookieDeSesion"])){
    session_id($_COOKIE["cookieDeSesion"]);
    session_start();

}else{
    session_start();
    if(!isset($_SESSION['administrador'])){
    header($VUELTA_PAG_PRINC);
    exit;
    }
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