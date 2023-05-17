<?php

require ("../vendor/autoload.php");

use App\Entity\Session;
use App\Services\ConexionUsuario;

$sesion=new Session();
$VUELTA_PAG_PRINC  = "Location: "  . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'];
$sesionId="administrador";
$nombreSesion="administrador";
$sesion->condicionesInicioSesion($sesionId,$nombreSesion,$VUELTA_PAG_PRINC);

$conexion=new ConexionUsuario;
$conexion->establecerConexion();

$usuarios=$conexion->mostrarUsuarios();

if(isset($_POST['cerrarSesion'])){
    $sesion->destroySession($nombreSesion,$sesionId,$VUELTA_PAG_PRINC);
}

if(isset($_POST['mostrarTodo'])){
    header("Location: https://wwwdes.ismael.lonuncavisto.org/paginaAdministrador1.php");
    exit;
}

if(isset($_POST['editar'])){
    $email=$_POST['email'];
    header("Location: https://wwwdes.ismael.lonuncavisto.org/editarUsuario.php?email=$email");
    exit;
}

if(isset($_POST['eliminar'])){
    $emailUsuario=$_POST['email'];
    if($conexion->existeUsuario($email)){
        $conexion->eliminarUsuario($emailUsuario);
        echo "Usuario eliminado <p></p>";
        header("Location: https://wwwdes.ismael.lonuncavisto.org/paginaAdministrador2.php");
        exit;
    }else{
        echo "El usario no existe <p></p>";
        header("Location: https://wwwdes.ismael.lonuncavisto.org/paginaAdministrador2.php");
        exit;
    }

}
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
        <td>User Name</td>
        <td>Email</td>
        <td>Contraseña</td>
        <td>Nombre</td>
        <td>Edad</td>
        <td>Teléfono</td>
        <td>Administrador</td>
    </tr>
    <?php foreach ($usuarios as $usuario) {?>
        <form action="" method="post">
        <tr>
            <td>
                <label for=""><?php echo $usuario->getUserNameUsuario();?></label>
                <input type="hidden" name="userName" value="<?php echo $usuario->getUserNameUsuario();?>">
                </td>
                <td>
                <label for=""><?php echo $usuario->getEmailUsuario();?></label>
                <input type="hidden" name="email" value="<?php echo $usuario->getEmailUsuario();?>">
                </td>
                <td>
                <label for=""><?php echo $usuario->getPasswordUsuario();?></label>
                </td>
                <td>
                <label for=""><?php echo $usuario->getNombreUsuario();?></label>
                </td>
                <td>
                <label for=""><?php echo $usuario->getAgeUsuario()?></label>
                </td>
                <td>
                <label for=""><?php echo $usuario->getTelephoneUsuario();?></label>
                </td>
                <td>
                <label for=""><?php echo $usuario->getAdministrador();?></label>
                </td>
                <td>                
                <button type="submit" name="editar">Editar</button>
                <button type="submit" name="eliminar" onclick="return confirm('¿Desea eliminar este usuario?')">Eliminar</button>
            </td>
        </tr>
        </form>
    <?php }?>
    <tr>
        <form action="" method="post">
            <button type="submit" name="mostrarTodo">Resumen</button>
            <button type="submit" name="cerrarSesion">Cerra sesión</button>
        </form>
        
    </tr>
</table>
    
</body>
</html>