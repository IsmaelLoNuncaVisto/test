<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>



    <?php 

session_start();

if(!isset( $_SESSION['email'])){
    header('Location: https://wwwdes.ismael.lonuncavisto.org/index.php');
    exit;
}  
            $email=$_GET['email'];
            //Establece conexión con la BD
            require("conexion.php");
            $conexion= new UsoBD();
            $conexion->establecerConexion();
            require("usuarioClass.php");
            $usuario=$conexion->usuarioEscogido($email);
            $emailAntiguo=$usuario->getEmailUsuario();  
    ?>

    <form action="" method="post">
        <table>
            <tr>
                <td><label >Email</label></td>
                <td><label >Contraseña</label></td>
                <td><label >Nombre</label></td>
                <td><label>Administrador</label></td>
            </tr>
            <tr>
                <td><input type="text" name="email" value="<?php echo $usuario->getEmailUsuario()?>"></td>
                <td><input type="text" name="password" value="<?php echo $usuario->getPasswordUsuario()?>"></td>
                <td><input type="text" name="nombre" value="<?php echo $usuario->getNombreUsuario()?>"></td>
                <td><input type="text" name="administrador" value="<?php echo $usuario->getAdministrador()?>"></td>
            </tr>

        </table>

        <p></p>
        <div>
            <input type="submit" name="actualizar" onclick="return confirm()" value="Actualizar">
            <input type="submit" name="cancelar" value="Cancelar">
            <button type="submit" name="cerrarSesion"  value="CerrarLaSesion">CerrarSesion</button>

        </div>
    </form>

    <?php $conexion->cerrarConexion();?>

</body>
</html>

<?php
    $conexion->establecerConexion();
    $actualizar=isset($_POST["actualizar"]);
    $cancelar=isset($_POST["cancelar"]);

    $emailNuevo=$_POST["email"];
    $passwordNueva=$_POST["password"];
    $nombreNuevo=$_POST["nombre"];
    $administradorNuevo=$_POST["administrador"];

    if($actualizar){
        $conexion->actualizarDatosUsuario($email,$emailNuevo,$passwordNueva,$nombreNuevo,$administradorNuevo);
        header('Location: https://wwwdes.ismael.lonuncavisto.org/iniciarSesionAdministrador.php');
    exit;    
}

    if($cancelar){
        header('Location: https://wwwdes.ismael.lonuncavisto.org/iniciarSesionAdministrador.php');
    exit;
    }
    $cerrarSesion=isset($_POST['cerrarSesion']);
if($cerrarSesion){
    session_destroy();
    header('Location: https://wwwdes.ismael.lonuncavisto.org/index.php');
    exit;
}

    $conexion->cerrarConexion();
?>
