<?php
require_once __DIR__ . "/vendor/autoload.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Documento sin titulo</title>
    <link rel="stylesheet" href="./ficheros_css/index.css">
</head>
<body>
<header>
</header>
<nav>
</nav>
<section>
    <form id="formulario" action="./ficheros_php/accesoUsuario.php" method="post">
        <label>Email: <input id="email" type="email" placeholder="ejemplo@prueba.com" name="email"></label>
        <p></p>
        <label>Contraseña: <input id="password" type="password" name="password"></label>
        <p></p>
        <button type="submit" name="iniciarSesion" onclick="return elementosVacios()" value="Iniciar Sesion">Iniciar sesión</button>
        <button type="submit" name="crearUsuario" value="Crear Usuario">Crear usuario</button>
    </form>


</section>

<script>
    function elementosVacios(){
        var email=document.getElementById("email").value;
        var password=document.getElementById("password").value;
        if(email==""||password==""){
            alert("Algún campo está vacío");
            return false;
        }else{
            return true;
        }
    }
</script>
</body>
</html>