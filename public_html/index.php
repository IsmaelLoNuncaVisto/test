<?php


        //Recoger datos de HTML
        $aniadir=isset($_POST["aniadidura"]);
        $mostrar=isset($_POST["mostrado"]);
        $eliminar=isset($_POST["eliminacion"]);

        $email=$_POST["email"];
        $contrasenia=$_POST["contrasenia"];
        $nombre=$_POST["nombre"];

        //Establece conexión con la BD
        require("conexion.php");
        $conexion= new UsoBD();
        $conexion->establecerConexion();


        /*
        Comprueba si están vacíos o no los campos Email, Contraseña y Nombre
        Si están rellenos ejecuta el método 'aniadirUsuario()'
        Si están vacíos lanza 'alert()'
        */
        if($aniadir){
            if($email!=""&&$contrasenia!=""&&$nombre!=""){
            $conexion->aniadirUsuario($email,$contrasenia,$nombre);
            }else{
                echo "<script>alert ('Ha dejado algún espacio en blanco');</script>";
            }
        }

        /*
        Comprueba si están vacíos o no los campos Email, Contraseña y Nombre
        Si están rellenos ejecuta el método 'eliminarUsuario()'
        Si están vacíos lanza 'alert()'
        */
         if($eliminar){
            if($email!=""&&$contrasenia!=""&&$nombre!=""){
                $conexion->eliminarUsuario($email);
                }else{
                    echo "<script>alert ('Ha dejado algún espacio en blanco');</script>";
                }
            
        }
         if($mostrar){
            $conexion->mostrarUsuarios();
        }

        $conexion->cerrarConexion();
    ?>