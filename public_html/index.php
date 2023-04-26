<?php
require_once __DIR__ . "/vendor/autoload.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
</head>
<body>


<form action="">
    <ul>
        <li>
            
            <label for="email">Email:</label>
            <input type="email" placeholder="ejemplo@prueba.com" name="email" value="">
        </li>
        <li>
            <label for="password">Pasword</label>
            <input type="password" name="password">
        </li>
        <li>
            <button type="submit">Login</button>
        </li>
        <li>
            <a href="">¿Olvidó su contraseña?</a>
        </li>
        <li>
            <a href="http://localhost:3000/public_html/creacionCuenta.php">Crear una nueva cuenta</a>
        </li>
    </ul>
</form>

    
</body>
</html>