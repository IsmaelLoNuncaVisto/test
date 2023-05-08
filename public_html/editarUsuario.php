<?php

require ("../src/Sesiones.php");
require("conexion.php");

use src\Session;

$sesion=new Session();
$VUELTA_PAG_PRINC  = "Location: "  . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'];
$sesionId="cookieDeSesion";
$nombreSesion="administrador";
$sesion->condicionesInicioSesion($sesionId,$nombreSesion,$VUELTA_PAG_PRINC);


    $conexion=new UsoBD;
    $conexion->establecerConexion();


    $email=$_GET['email'];
    $usuario=$conexion->usuarioEscogido($email);

    



    if(isset($_POST["actualizar"])){
        $userName=$_POST['userName'];
        $emailActualizar=$_POST['email'];
        $password=$_POST['psswd'];
        $name=$_POST['name'];
        $age=$_POST['age'];
        $telephone=$_POST['telephone'];
        $administrador=$_POST['administrador'];
        $crearUsuario=array($userName,$emailActualizar,$password,$name,$age,$telephone,$administrador);
        if($conexion->actualizarDatosUsuario($email,$crearUsuario)){
            echo "Usuario actualizado";
            header("Location: https://wwwdes.ismael.lonuncavisto.org/editarUsuario.php?email=$emailActualizar");
            exit;
        }else{
            echo "Fallo al actualizar el usuario";
            header("Location: https://wwwdes.ismael.lonuncavisto.org/editarUsuario.php?email=$email");
            exit;
        }
    }

    if(isset($_POST["cancelar"])){
        header("Location: https://wwwdes.ismael.lonuncavisto.org/editarUsuario.php?email=$email");
        exit;
    }

    if(isset($_POST["cerrarSesion"])){
        $sesion->destroySession($sesionId,$VUELTA_PAG_PRINC);
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


var fallos ="";

function valoresCorrectos(){

var userName=document.getElementById("userName").value;
var email=document.getElementById("email").value;
var password=document.getElementById("password").value;
var nombre=document.getElementById("nombre").value;
var age=document.getElementById("age").value;
var telephone=document.getElementById("telephone").value;
var administrador=document.getElementById("administrador").value;


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

if(administrador.length!=0 || administrador.length!=1 ){
    fallos+=administrador + "|";
}


if(fallos.length>0){
    alert("Estos valores no son correctos: " + fallos);
    event.preventDefault();
}
}
/*
function camposVacios(){
            if(userName==""||email==""||password==""||name==""||age==""||telephone==""||administrador==""){
                alert("Hay algún campo vacío");
                event.preventDefault();
            }
        }
        */

</script>
</head>
<body>
<table>
    <tr>
        <td>User Name</td>
        <td>Email</td>
        <td>Contraseña</td>
        <td>Nombre</td>
        <td>Edad</td>
        <td>Teléfono</td>
        <td>Administrador</td>
    </tr>
    
        <form action="" method="post">
        <tr>
            <td>
                <input type="text" name="userName" id="userName" value="<?php echo $usuario->getUserNameUsuario();?>">
                </td>
                <td>
                <input type="text" name="email" id="email"value="<?php echo $usuario->getEmailUsuario();?>">
                </td>
                <td>
                <input type="text" name="psswd" id="password"value="<?php echo $usuario->getPasswordUsuario();?>">                
                </td>
                <td>
                <input type="text" name="name" id="nombre" value="<?php echo $usuario->getNombreUsuario();?>">                 
                </td>
                <td>
                <input type="text" name="age" id="age" value="<?php echo $usuario->getAgeUsuario();?>">                 
                </td>
                <td>
                <input type="text" name="telephone" id="telephone" value="<?php echo $usuario->getTelephoneUsuario();?>">                
                </td>
                <td>
                <input type="text" name="administrador" id="administrador" value="<?php echo $usuario->getAdministrador();?>">                 
                </td>
        </tr>
        <tr>
        <button type="submit" name="actualizar" onclick="camposVacios();valoresCorrectos();confirm('¿Desea actualizar este usuario?')">Actualizar</button>
        <button type="submit" name="cancelar">Cancelar</button>
        <button type="submit" name="cerrarSesion">CerrarSesión</button>
        </tr>
        </form>
</table>
</body>
</html>