<?php

$iniciar=isset($_POST["iniciarSesion"]);

$email=$_POST["email"];
$contrasenia=$_POST["contrasenia"];

        //Establece conexión con la BD
        require("conexion.php");
        $conexion= new UsoBD();
        $conexion->establecerConexion();
        if($iniciar){
        if($email!=""&&$contrasenia!=""){
            $conexion->existeUsuario($email,$contrasenia);
           
            //echo "<a href: 'https://wwwdes.ismael.lonuncavisto.org/iniciar.html'></a>";
            }else{
                echo "<script>alert ('Ha dejado algún espacio en blanco');</script>";
                echo "<script>window.history.back();</script>";
            }
        }


?>