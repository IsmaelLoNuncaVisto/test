<?php

        $aniadir=isset($_GET["aniadidura"]);
        $mostrar=isset($_GET["mostrado"]);
        $eliminar=isset($_GET["eliminacion"]);
        
         

        $email=$_GET["email"];
        $contrasenia=$_GET["contrasenia"];
        $nombre=$_GET["nombre"];

        $db_host="localhost";
        $db_nombre="ismael";
        $db_user="ismael";
        $db_contrasenia="ismael";

        $conexion= mysqli_connect($db_host,$db_user,$db_contrasenia,$db_nombre);

        if(mysqli_connect_errno()){
            echo "Fallo al conectar con al abase de datos";

            exit();

        }

        

        mysqli_select_db($conexion,$db_nombre) or die ("No se encuentra la BBDD");


        
        if($aniadir){
            $aniadirSQL="INSERT INTO usuario(email,contraseña,nombre) VALUES ('$email','$contrasenia','$nombre')";
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
                echo $fila['contraseña'] . "</td><td>";
                echo $fila['nombre'] . "</td></tr></table>";
                echo  "<br>";
            }
        }

        

        mysqli_close($conexion);
        

    ?>