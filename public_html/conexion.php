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
    public function cerrarConexion()
    {
        mysqli_close($this->conexion);
    }

    /*Añade usuario a la BD
     */
    public function aniadirUsuario($emailUsuario, $psswdUsuario, $nombreUsuario)
    {
        //$emailValido = preg_match_all("/@prueba.com$/", $emailUsuario);
        $emailValido =filter_var($emailUsuario,FILTER_VALIDATE_EMAIL);
        try {
            if ($emailValido==false) {
                throw new Exception("<script> alert ('Email invalido. Estructura del emal----> ejemplousuario@prueba.com')</script>"
                                    . "<script>window.location.href = document.referrer;</script>");
            }
            $aniadirSQL = "INSERT INTO usuario(email,contrasenia,nombre) VALUES ('$emailUsuario','$psswdUsuario','$nombreUsuario')";
            if (!mysqli_query($this->conexion, $aniadirSQL)) {
                throw new mysqli_sql_exception("<script> alert ('Usuario ya existe');</script>"
                                             . "<script>window.location.href = document.referrer;</script>");
            }
            echo "<script> alert ('Usuario añadido');</script>";
        } catch (mysqli_sql_exception $me) {
            echo $me->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    /*Elimina usuario a la BD
     */
    public function eliminarUsuario($emailUsuario, $psswdUsuario, $nombreUsuario)
    {
        //$emailValido = preg_match_all("/@prueba.com$/", $emailUsuario);        
        $emailValido=filter_var($emailUsuario,FILTER_VALIDATE_EMAIL);
        try {
            if (!$emailValido) {
                
                throw new Exception("<script> alert ('Email invalido. Estructura del emal----> ejemplousuario@prueba.com')</script>" 
                                    . "<script>window.location.href = document.referrer;</script>");
                
            }

            $inyeccionEmail=mysqli_real_escape_string($this->conexion, $emailUsuario);

            $mostrarUsuario="SELECT email FROM usuario WHERE email= '$inyeccionEmail'AND contrasenia='$psswdUsuario' AND nombre='$nombreUsuario'";
            $existenciaEmail=mysqli_query($this->conexion,$mostrarUsuario);

            while ($fila=mysqli_fetch_assoc($existenciaEmail)) {
                $email=$fila['email'];
            }

            if($email==""){
                throw new mysqli_sql_exception("<script> alert ('Usuario no existe');</script>"
                                            . "<script>window.location.href = document.referrer;</script>");
            } 
            $inyeccionContrasenia=mysqli_real_escape_string($this->conexion, $psswdUsuario);
            //$inyeccionNombre=mysqli_real_escape_string($this->conexion, $nombreUsuario);
            $eliminarSQL = "DELETE FROM usuario WHERE email = '$inyeccionEmail' AND contrasenia='$inyeccionContrasenia' AND nombre='$nombreUsuario' ";
            mysqli_query($this->conexion, $eliminarSQL);
            echo "<script> alert ('Usuario eliminado');</script>";
        } catch (mysqli_sql_exception $me) {
            echo $me->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /*Muestra a los Usuarios
    Selecciona todos los Usuarios que hay en la BD
    Recorre el Array generado
    Crea una Objeto Usuario por cada Valaor
    Hace un ECHO pr cada Objeto
     */
    public function mostrarUsuarios()
    {
        require "usuarioClass.php";
        $mostrarSQL = "SELECT * FROM usuario";
        $resultado = mysqli_query($this->conexion, $mostrarSQL);
        while ($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
            $Usuario = new Usuario($fila['email'], $fila['contrasenia'], $fila['nombre']);
            echo $Usuario->getEmailUsuario() . "\t" . $Usuario->getPasswordUsuario() . "\t" . $Usuario->getNombreUsuario() . "<br>";
        }
    }

}
