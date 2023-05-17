<?php

require_once "../vendor/autoload.php";

use App\Services\ConexionUsuario;

$conexion= new ConexionUsuario;
$conexion->establecerConexion();

if(isset($_POST["confirmarToken"])){

    if($conexion->tokenValidate($_GET['email'],$_POST['token'])){
        echo "Usuario añadido";
        $conexion->removeToken($_GET['email']);
        sleep(2);
        header("Location: https://wwwdes.ismael.lonuncavisto.org");
        exit;
    }else{
        if($usuario->tiempoExpirado($_GET['email'])){
            echo "El tiempo para dar de alta al usuario ha expirado, debe volver a ingresar sus credenciales";
        }else{
        echo "El token no es correcto";
        }
    }

}

if(isset($_POST["cancelar"])){
    $email=$_GET['email'];
    $usuario-> eliminarUsuario($email);
    header("Location: https://wwwdes.ismael.lonuncavisto.org/crearUsuario.php");
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
                <input type="text" name="token" id="token" value="<?php echo $_GET['token'];?>">
            </ol>
            <ol>
                <button type="submit" name="confirmarToken" onclick="valoresCorrectos();">Comprobar token</button>
                <button type="submit" name="cancelar">Cancelar</button>
            </ol>
        </ul>
    </form>
</body>
</html>