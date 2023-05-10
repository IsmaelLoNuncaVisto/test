<?php



    require "conexion.php";
    $conexion = new UsoBD();
    $conexion->establecerConexion();

    if(isset($_POST["restablecerPassword"])){
        $token=$_POST["token"];
        $password=$_POST["password"];
        if($conexion->comprobarValidezToken($token)){
            $conexion->restablecerPassword($password,$token);
            echo "Se ha restablecido la contraseña";
            sleep(2);
            header ("Location: https://wwwdes.ismael.lonuncavisto.org");
            exit;
        }else{
            echo "El token ha expirado";
        }
    }
    $conexion->cerrarConexion();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrearUsuario</title>
    <link rel="stylesheet" href="inicio.css">

    <script>


        var fallos ="";
        

        function coincidenciaContrasenias(){
            var password=document.getElementById("inputpassword").value;
            var passwordRepeat=document.getElementById("inputpasswordConfirm").value;
            if(password!=passwordRepeat){
                alert("Las contraseñas no coinciden");
                event.preventDefault();
            }
        }

        function valoresCorrectos(){
        var token=document.getElementById("token").value;
        var password=document.getElementById("inputpassword").value;
        var passwordConfirm=document.getElementById("inputpasswordConfirm").value;

        if(password==""||passwordConfirm==""||token==""){
            alert("Alguno de los valores está vacío");
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
                <label for="password">Password:</label>
                <input type="password" name="password" id="inputpassword">
            </ol>
            <ol>
                <label for="passwordConfirm">Confirm Password:</label>
                <input type="password" name="passwordConfirm" id="inputpasswordConfirm">
            </ol>
            <ol>
                <button type="submit" name="restablecerPassword" onclick="coincidenciaContrasenias();valoresCorrectos();">Restablecer Password</button>
                <button type="submit" name="volver">Return</button>
            </ol>
        </ul>
    </form>
</body>
</html>