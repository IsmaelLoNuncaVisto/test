<?php

class UsoBD
{

    private $conexion;

    //Se crea la conexion xon la base de datos
    public function establecerConexion()
    {
        $db_host = "localhost";
        $db_nombre = "ismael";
        $db_user = "ismael";
        $db_contrasenia = "ismael";

        $this->conexion = mysqli_connect($db_host, $db_user, $db_contrasenia, $db_nombre);

        if (mysqli_connect_errno()) {
            echo "Fallo al conectar con al abase de datos";
            exit();

        }
        mysqli_select_db($this->conexion, $db_nombre) or die("No se encuentra la BBDD");
    }

    //Se cierra la conexión con la base de datos
    public function cerrarConexion(){
        mysqli_close($this->conexion);
    }

    //Funcion para añadir usuario a la BD
    public function aniadirUsuario($emailUsuario,$psswdUsuario,$nombreUsuario){
            $aniadirSQL="INSERT INTO usuario(email,contrasenia,nombre) VALUES ('$emailUsuario','$psswdUsuario','$nombreUsuario')";
            if(mysqli_query($this->conexion,$aniadirSQL)){
                
            }
    }

}
