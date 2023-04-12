<?php


        //Recoger datos de HTML
        $aniadir=isset($_POST["aniadidura"]);
        $mostrar=isset($_POST["mostrado"]);
        $eliminar=isset($_POST["eliminacion"]);

        $email=$_POST["email"];
        $contrasenia=$_POST["contrasenia"];
        $nombre=$_POST["nombre"];

        //Establece conexión con el servidor
        require("conexion.php");
        
        $conexion= new UsoBD();

        $conexion->establecerConexion();

        if($aniadir){
            $conexion->aniadirUsuario($email,$contrasenia,$nombre);
        
        }

         if($eliminar){
            $conexion->eliminarUsuario($email);

        }

         if($mostrar){
            $conexion->mostrarUsuarios();
        }

        $conexion->cerrarConexion();

        
        

    ?>