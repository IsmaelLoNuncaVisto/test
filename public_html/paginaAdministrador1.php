<?php

require ("../src/Sesiones.php");
require("conexion.php");

use src\Session;

$sesion=new Session();
$VUELTA_PAG_PRINC  = "Location: "  . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'];
$sesionId="administrador";
$nombreSesion="administrador";
$sesion->condicionesInicioSesion($sesionId,$nombreSesion,$VUELTA_PAG_PRINC);

$conexion=new UsoBD;
$conexion->establecerConexion();
$emails=$conexion->recogerEmailsUsuarios();



if(isset($_POST['cerrarSesion'])){
    $sesion->destroySession($nombreSesion,$sesionId,$VUELTA_PAG_PRINC);
}

if(isset($_POST['mostrarTodo'])){
    header("Location: https://wwwdes.ismael.lonuncavisto.org/paginaAdministrador2.php");
    exit;
}

if(isset($_POST['editar'])){
    $email=$_POST['email'];
    header("Location: https://wwwdes.ismael.lonuncavisto.org/editarUsuario.php?email=$email");
    exit;
}

if(isset($_POST['eliminar'])){
    $email=$_POST['email'];
    if($conexion->eliminarUsuario($email)){
        echo "Usuario eliminado <p></p>";
        header("Location: https://wwwdes.ismael.lonuncavisto.org/paginaAdministrador1.php");
        exit;
    }else{
        echo "El usario no existe <p></p>";
        header("Location: https://wwwdes.ismael.lonuncavisto.org/paginaAdministrador1.php");
        exit;
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
    <title>PaginaAdministrador</title>
</head>
<body>

<table>
    <tr>
        <td>Email:</td>
    </tr>
    <?php foreach ($emails as $email) {?>
        <form action="" method="post">
        <tr>
            <td>
                <label for=""><?php echo $email;?></label>
                <input type="hidden" name="email" value="<?php echo $email;?>">
                <button type="submit" name="editar">Editar</button>
                <button type="submit" name="eliminar" onclick="confirm('¿Desea eliminar este usuario?')">Eliminar</button>
            </td>
        </tr>
        </form>
    <?php }?>
    <tr>
        <form action="" method="post">
            <button type="submit" name="mostrarTodo">Mostrar todo</button>
            <button type="submit" name="cerrarSesion">Cerra sesión</button>
        </form>
        
    </tr>
</table>
    
</body>
</html>