
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

    <?php
    
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: https://wwwdes.ismael.lonuncavisto.org/index.php');
    exit;
}

require ("ficheros_php/conexion.php");
$conexion = new UsoBD();
$conexion->establecerConexion();
$emailUsuarios = $conexion->recogerEmailsUsuarios();

$usuario = $conexion->mostrarUsuarios();

?>

<form method="post">
            <button type="submit" name="resumen"  value="VolverAlResumen">Volver al resumen</button>
            <button type="submit" name="mostrar"  value="MostrarTodosLosdatos">Mostrar todos los datos</button>
            <button type="submit" name="cerrarSesion"  value="CerrarLaSesion">CerrarSesion</button>
        </form>
        <?php if (isset($_POST['resumen'])) {?>

            <table>
                <tr>
                <td><label >Email</label></td>
                </tr>
                <?php foreach ($emailUsuarios as $email) {?>
                <form action="" method="post">
                <tr>
                    <td><input type="hidden" name="email" value="<?php echo $email; ?>"><?=$email;?></td>
                    <td><input type="submit" name="editar" value="Editar"></td>
                    <td><input type="submit" name="eliminar" onclick="return confirm()" value="Eliminar"></td>
                </tr>
                </form>
                <?php }?>
            </table>



        <?php }?>
           <?php if (isset($_POST['mostrar'])) {?>
                <table>
                <tr>
                <td><label >Email</label></td>
                <td><label >Contraseña</label></td>
                <td><label >Nombre</label></td>
                <td><label>Administrador</label></td>
            </tr>

            <?php for ($i = 0; $i < count($usuario); $i++) {?>
                <form action="" method="post">
            <tr>
                <td><input type="hidden" name="email" value="<?php echo $usuario[$i]->getEmailUsuario() ?>"><?php echo $usuario[$i]->getEmailUsuario() ?></td>
                <td><input type="hidden" name="password" value="<?php echo $usuario[$i]->getPasswordUsuario() ?>"><?php echo $usuario[$i]->getPasswordUsuario() ?></td>
                <td><input type="hidden" name="nombre" value="<?php echo $usuario[$i]->getNombreUsuario() ?>"><?php echo $usuario[$i]->getNombreUsuario() ?></td>
                <td><input type="hidden" name="administrador" value="<?php echo $usuario[$i]->getAdministrador() ?>"><?php echo $usuario[$i]->getAdministrador() ?></td>
                <td><input type="submit" name="editar"  value="Editar"></td>
                <td><input type="submit" name="eliminar" onclick="return confirm()" value="Eliminar"></td>
            </tr>
            </form>
            <?php }?>
                </table>
        <?php }?>
        <?php $conexion->cerrarConexion();?>
    </body>
</html>

<?php

$eliminar = isset($_POST["eliminar"]);
$editar = isset($_POST["editar"]);

$emailClickado = $_POST["email"];

//Establece conexión con la BD
$conexion = new UsoBD();
$conexion->establecerConexion();

if ($eliminar) {
    $conexion->eliminarUsuario($emailClickado);
}

if ($editar) {
    header('Location: https://wwwdes.ismael.lonuncavisto.org/ficheros_php/editarUsuario.php?email=$emailClickado');
    exit;
}

$cerrarSesion = isset($_POST['cerrarSesion']);
if ($cerrarSesion) {
    session_destroy();
    header('Location: https://wwwdes.ismael.lonuncavisto.org/index.php');
    exit;
}

$conexion->cerrarConexion();
?>