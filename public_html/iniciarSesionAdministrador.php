<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

        <script>
            function confirmarBorrado(){
                if(confirm("¿Desea borrar al usuario?")){
                    return true;
                }else{
                    return false;
                }
            }
        </script>

        <?php
            require("./ficheros_php/conexion.php");
            $conexion = new UsoBD();
            $conexion->establecerConexion();
            $emailUsuarios=$conexion->recogerEmailsUsuarios();
        ?>
        
        <div>
            <div>Email:</div>
            <?php foreach ($emailUsuarios as $email) { ?>
                <div><?php echo $email; ?>
                    <a href="">Editar</a> 
                    <a href="./ficheros_php/eliminarUsuario.php?email=<?php echo urlencode($email);?>" onclick="return confirmarBorrado()">Eliminar</a>  
                </div> 
            <?php }?>
            <div><a href="">Mostrar todos los datos</a></div>
        </div>

        <?php $conexion->cerrarConexion(); ?>        
    </body>
</html>