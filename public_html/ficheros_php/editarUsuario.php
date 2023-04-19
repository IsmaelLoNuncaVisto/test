<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<script>
    function confirmarActualizacion(){
        if(confirm("¿Desea actualizar los cambios?")){
            return true;
        }return false;
    }
</script>

    <?php 
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
            <input type="submit" name="actualizar" onclick="return confirmarActualizacion()" value="Actualizar">
            <input type="submit" name="cancelar" value="Cancelar">

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
        echo "<script>window.location.href = 'https://wwwdes.ismael.lonuncavisto.org/iniciarSesionAdministrador.php'</script>";
    }

    if($cancelar){
        echo "<script>window.location.href = 'https://wwwdes.ismael.lonuncavisto.org/iniciarSesionAdministrador.php'</script>";
    }

    $conexion->cerrarConexion();
?>
