<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '../vendor/autoload.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';


$crearUsuario=isset($_POST["create"]);
$volver=isset($_POST["volver"]);

//VariablesCrearUsuario
$userName=$_POST["userName"];
$email=$_POST["email"];
$psswd=$_POST["password"];
$nombre=$_POST["name"];
$age=$_POST["age"];
$telephone=$_POST["telephoneNumber"];

//AccesoConexion

require("conexion.php");
$conexion= new UsoBD;
$conexion->establecerConexion();

if(isset($_POST["create"])){
    


   $mail=new PHPMailer();

   $mail->isSMTP();
   $mail->Host = 'imap.lonuncavisto.com';
   $mail->SMTPAuth=true;
   $mail->Username='ismael@lonuncavisto.com';
   $mail->Password='hd29823bd0.9aqP';
   $mail->SMTPSecure='STARTTLS';
   $mail->Port=587;

   $mail->setFrom('ismael@lonuncavisto.com','Remitente');
   $mail->addAddress($email);
   $mail->Subject='Creación contraseña';
   $mail->Body='Se creo una cuenta en: wwwdes.ismael.lonuncavisto.org';

   if(!$mail->send()){
    echo 'Error al enviar correo electrónico: ' . $mail->ErrorInfo;
   }

    //Primero creamos el HASH porque al mandar un array no pasaría la encriptación y habría que
    //regenerar el array a la hora de ingresar las credenciales
    $hash=$conexion->encriptadoPasword($psswd);
    $crearUsuario=array($userName,$email,$hash,$nombre,$age,$telephone);

    if($conexion->aniadirUsuario($crearUsuario)){
        echo "Usuario añadido";
    }else{
        echo "El usuario ya existe";
    }
}

if($volver){
    header("Location: https://wwwdes.ismael.lonuncavisto.org");
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
        
        var userName=document.getElementById("inputuserName").value;
        var email=document.getElementById("inputemail").value;
        var password=document.getElementById("inputpassword").value;
        var nombre=document.getElementById("inputnombre").value;
        var age=document.getElementById("inputage").value;
        var telephone=document.getElementById("inputtelephone").value;

        if(userName.length>20){
            fallos+=userName + "|";
        }

        if(email.length>25){
            fallos+=email + "|";
        }

        if(password.length>15){
            fallos+=password + "|";
        }
        if(age.length>99){
            fallos+=age + "|";
        }
        if(telephone.length>12){
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
                <input type="text" name="telephoneNumber" id="inputtelephone">
            </ol>
            <ol>
                <button type="submit" name="create" onclick="coincidenciaContrasenias();valoresCorrectos();">Create Account</button>
                <button type="submit" name="volver">Return</button>
            </ol>
        </ul>
    </form>
</body>
</html>



