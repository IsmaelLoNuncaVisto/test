<?php

require "../vendor/autoload.php";

use App\Entity\Email;
use App\Entity\Usuario;
use App\Services\ConexionUsuario;

if(isset($_POST["create"])){

    $conexionUsuario = new ConexionUsuario();

    $conexionUsuario->establecerConexion();

    //CREAMOS UN TOKEN QUE SE ENVIARÁ AL MAIL
    $token=uniqid();
    $tiempo_vida = 3600;
    $expiracion=date('Y-m-d H:i:s', time() + $tiempo_vida);

    
    $userName=$_POST["userName"];
    $email=$_POST["email"];
    $psswd=$_POST["password"];
    $nombre=$_POST["name"];
    $age=$_POST["age"];
    $telephone=$_POST["telephoneNumber"];
    $administrador=$conexionUsuario->administradorAniadirUsuarios();

    $fallos=dataValidate($userName,$email,$psswd,$nombre,$age,$telephone,$administrador);

    if($fallos==""){
       
   

    $usuario=new Usuario($userName,$email,$psswd,$nombre,$age,$telephone,$administrador);



    //SE ENVÍA EL CORREO

    if(!$conexionUsuario->existeUsuario($email)){
        $mail=new Email();
        $mail->enviarEmailCreacionCuenta($email,$token);
        $conexionUsuario->aniadirUsuario($usuario);
        $conexionUsuario->tokenUsuario($email,$token,$expiracion);
        echo "Se ha enviado un email para confirmar la cuenta a: " . $email;
    }else{
        echo "El usuario ya existe";
    }

    }else{
        echo $fallos;
    }


}

if(isset($_POST["volver"])){
    header("Location: https://wwwdes.ismael.lonuncavisto.org");
    exit;
}

function dataValidate(string $userName, string $email, string $password, string $nombre, int $age, string $telephone, string $administrador):string
    {
        if($userName==""||!preg_match_all("/[A-Za-z0-9]*/",$userName)){
            return "El userName debe contener caractéres alfanuméricos";
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return "El email introducido no cumple los requisitos";
        }

        if(strlen($password)<8||strlen($password)>20){
            return "La password debe contener entre 8 - 20 caracteres";
        }

        switch ($password) {
            case !preg_match("/[!.?*]+/",$password):
                return "La contraseña debe contener por lo menos 1 de estos elementos (! . ? *)";
                break;
                case !preg_match("/[A-Za-z0-9]*/",$password):
                    return "La contraseña debe contener valores alfanuméricos";
                break;
        }
         if(!preg_match("/[A-Za-z]*/",$nombre)){
            return "El nombre solamente puede contener caracteres alfabéticos";
         }

         if(!preg_match("/[0-9]{2}/",$age)){
            return "La edad debe contener 2 cifras";
         }

         if(!preg_match("/[0-9]{9}/",$telephone)){
            return "El número de teléfono debe tener este aspecto: 999999999";
         }
         if($administrador!=0&&$administrador!=1){
            return "Error en el administrador";
         }

         return "";
        

    }


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
        function validarFormulario(){
        const userName=document.getElementById("inputuserName").value;
        const email=document.getElementById("inputemail").value;
        const password=document.getElementById("inputpassword").value;
        const passwordRepeat=document.getElementById("inputpasswordConfirm").value;
        const nombre=document.getElementById("inputnombre").value;
        const age=document.getElementById("inputage").value;
        const telephone=document.getElementById("inputtelephone").value;
        let fallos ="";
        
        /*
        if(userName===''||email===''||password===''||passwordRepeat===''||name===''||telephone===''){
                alert("Hay algún campo vacío");
                event.preventDefault();
        }
        */
        

        if(password!=passwordRepeat){
                alert("Las contraseñas no coinciden");
                event.preventDefault();
            }

        if(userName.length>20){
            fallos+=userName + "|";
        }

        if(email.length>100){
            fallos+=email + "|";
        }

        if(password.length>15){
            fallos+=password + "|";
        }
        if(age.length>99){
            fallos+=age + "|";
        }
        if(telephone.length>13){
            fallos+=telephone + "|";
        }
        if(fallos.length>0){
            alert("Estos valores no son correctos: " + fallos);
            event.preventDefault();
        }
        }

    </script>

</head>
<body>
    <form action="" method="post">
        <ul>
            <ol>
                <label for="userName">User Name:</label>
                <input type="text" name="userName" id="inputuserName">
            </ol>
            <ol>
                <label for="email">Email:</label>
                <input type="email" placeholder="ejemplo@prueba.com" name="email" id="inputemail">
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
                <label for="name">Name:</label>
                <input type="text" name="name" id="inputnombre">
            </ol>
            <ol>
                <label for="age">Age:</label>
                <input type="number" min="0" max="99" name="age" id="inputage">
            </ol>
            <ol>
                <label for="telephoneNumber">Telephone:</label>
                <input type="tel" name="telephoneNumber" placeholder="+34123456789" id="inputtelephone">
            </ol>
            <ol>
                <button type="submit" name="create" onclick="validarFormulario();">Create Account</button>
                <button type="submit" name="volver">Return</button>
            </ol>
        </ul>
    </form>
</body>
</html>



