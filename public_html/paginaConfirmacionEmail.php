<?php

require ("conexion.php");
$conexion= new UsoBD();
$conexion->establecerConexion();

if(isset($_POST["confirmarToken"])){

    if($conexion->comprobarValidezToken($_POST['token'])){
        echo "Usuario añadido";
        $conexion->borrarToken($_POST['token']);
        header("Location: https://wwwdes.ismael.lonuncavisto.org");
        exit;
    }else{
        if($conexion->tiempoExpirado($_GET['email'])){
            echo "El tiempo para dar de alta al usuario ha expirado, debe volver a ingresar sus credenciales";
        }else{
        echo "El token no es correcto";
        }
    }

}

if(isset($_POST["cancelar"])){
    $email=$_GET['email'];
    $conexion-> eliminarUsuario($email);
    header("Location: https://wwwdes.ismael.lonuncavisto.org/crearUsuario.php");
    exit;

}

$conexion->cerrarConexion();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        
        function valoresCorrectos(){
        var token=document.getElementById("token").value;

        if(token==""){
            alert("El token no puede estar vacío");
        }

        }
    </script>
</head>
<body>
<form action="" method="post">
        <ul>
            <ol>
                <label for="token">Token:</label>
                <input type="text" name="token" id="token">
            </ol>
            <ol>
                <button type="submit" name="confirmarToken" onclick="valoresCorrectos();">Comprobar token</button>
                <button type="submit" name="cancelar">Cancelar</button>
            </ol>
        </ul>
    </form>
</body>
</html>