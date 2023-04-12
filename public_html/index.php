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
            $eliminarSQL="DELETE FROM usuario WHERE email LIKE '$email'";
            $resultados=mysqli_query($conexion,$eliminarSQL);

        }

         if($mostrar){
            $consulta="SELECT * FROM usuario";

            $resultados=mysqli_query($conexion,$consulta);
            
            while ($fila=mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
                echo "<table><tr><td>";
                echo $fila['email'] . "</td><td>";
                echo $fila['contrasenia'] . "</td><td>";
                echo $fila['nombre'] . "</td></tr></table>";
                echo  "<br>";
            }
        }

        $conexion->cerrarConexion();

        
        

    ?>