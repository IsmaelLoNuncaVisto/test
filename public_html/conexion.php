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

    /*Añade usuario a la BD
    */
    public function aniadirUsuario($emailUsuario,$psswdUsuario,$nombreUsuario){

        $patronEmail="/@prueba.com/";
        $emailValido=preg_match_all($patronEmail,$emailUsuario);
            if($emailValido){
                $aniadirSQL="INSERT INTO usuario(email,contrasenia,nombre) VALUES ('$emailUsuario','$psswdUsuario','$nombreUsuario')";
                if(mysqli_query($this->conexion,$aniadirSQL)){
                    echo "Usuario añadido";
                }else{
                    echo "<script> alert ('Usuario ya existe');</script>";    
                    exit;
                }
            }else{
                echo "<script> alert ('Email invalido. Estructura del emal----> ejemplousuario@prueba.com')</script>";
            }
    }

    /*Elimina usuario a la BD
    */
    public function eliminarUsuario($emailUsuario){
        $eliminarSQL="DELETE FROM usuario WHERE email LIKE '$emailUsuario'";
            if(mysqli_query($this->conexion,$eliminarSQL)){
                echo "Usuario eliminado";
            }else{
                echo "<script> alert ('Usuario no existe');</script>";
            }
    }

    /*Muestra a los Usuarios
        Selecciona todos los Usuarios que hay en la BD
        Recorre el Array generado
        Crea una Objeto Usuario por cada Valaor
        Hace un ECHO pr cada Objeto
    */
    public function mostrarUsuarios(){
        require("usuarioClass.php");
        $mostrarSQL="SELECT * FROM usuario";
        $resultado=mysqli_query($this->conexion,$mostrarSQL);
        while($fila=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
            $Usuario=new Usuario($fila['email'],$fila['contrasenia'],$fila['nombre']);
            echo $Usuario->getEmailUsuario() . "\t" . $Usuario->getPasswordUsuario() . "\t" . $Usuario->getNombreUsuario() . "<br>";
        }
    }

}
