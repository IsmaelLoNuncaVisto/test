<?php

        $aniadir=isset($_POST["aniadidura"]);
        $mostrar=isset($_POST["mostrado"]);
        $eliminar=isset($_POST["eliminacion"]);
        
         

        $email=$_POST["email"];
        $contrasenia=$_POST["contrasenia"];
        $nombre=$_POST["nombre"];

        require("conexion.php");

        //echo "Esto es una prueba de que funciona el php";
        
        if($aniadir){
            $aniadirSQL="INSERT INTO usuario(email,contrasenia,nombre) VALUES ('$email','$contrasenia','$nombre')";
            $resultados=mysqli_query($conexion,$aniadirSQL);
        
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

        

        mysqli_close($conexion);
        

    ?>