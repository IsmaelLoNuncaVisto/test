<?php

session_start();
if(!isset($_SESSION["administrador"])){
    header("Location: https://wwwdes.ismael.lonuncavisto.org");
    exit;
}else{
    $inactive=30;
    if(isset($_SESSION["finSesion"])){
        $terminarSesion=time()-$_SESSION["finSesion"];
        if($terminarSesion>$inactive){
            session_destroy();
            header("Location: https://wwwdes.ismael.lonuncavisto.org");
            exit;
        }
        $_SESSION['finSesion']=time();
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