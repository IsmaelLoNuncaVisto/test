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
    Comprueba la forma correcta del email, Error al estar mal escrita
    Comprueba que exista el usuario. Error si existe
    En caso de Error regresa a la pagina de referencia
     */
    public function aniadirUsuario($emailUsuario, $psswdUsuario, $nombreUsuario, $psswdRepetirContrasenia)
    {
        //$emailValido = preg_match_all("/@prueba.com$/", $emailUsuario);
        $emailValido = filter_var($emailUsuario, FILTER_VALIDATE_EMAIL);
        try {
            if ($emailValido == false) {
                throw new Exception("<script> alert ('Email invalido. Estructura del emal----> ejemplousuario@prueba.com')</script>"
                    . "<script>window.location.href = document.referrer;</script>");
            }

            if ($psswdUsuario != $psswdRepetirContrasenia) {
                throw new Error("<script> alert ('Contraseñas no coinciden')</script>"
                    . "<script>window.location.href = document.referrer;</script>");
            }
            $usuarios = "SELECT * FROM usuario";
            $resultado = mysqli_query($this->conexion, $usuarios);
            $cnt = 0;
            while ($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                $cnt++;
            }
            if ($cnt == 0) {
                $aniadirSQL = "INSERT INTO usuario(email,contrasenia,nombre,administrador) VALUES ('$emailUsuario','$psswdUsuario','$nombreUsuario',1)";
            } else {
                $aniadirSQL = "INSERT INTO usuario(email,contrasenia,nombre,administrador) VALUES ('$emailUsuario','$psswdUsuario','$nombreUsuario',0)";
            }
            if (!mysqli_query($this->conexion, $aniadirSQL)) {
                throw new mysqli_sql_exception("<script> alert ('Usuario ya existe');</script>"
                    . "<script>window.location.href = document.referrer;</script>");
            }
            echo "<script> alert ('Usuario añadido');</script>"
                . "<script>window.location.href = document.referrer;</script>";
        } catch (Error $er) {
            echo $er->getMessage();
        } catch (mysqli_sql_exception $me) {
            echo $me->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    /*Elimina usuario a la BD
    Comprueba la forma correcta del email, Error al estar mal escrita
    Comprueba que exista el usuario. Error si no existe
    En caso de Error regresa a la pagina de referencia
     */
    public function eliminarUsuario($emailUsuario)
    {

        try {
            $inyeccionEmail = mysqli_real_escape_string($this->conexion, $emailUsuario);
            $mostrarUsuario = "SELECT email FROM usuario WHERE email= '$inyeccionEmail'";
            $existenciaEmail = mysqli_query($this->conexion, $mostrarUsuario);
            while ($fila = mysqli_fetch_assoc($existenciaEmail)) {
                $email = $fila['email'];
            }
            if ($email == "") {

                throw new mysqli_sql_exception("<script> alert ('Usuario no existe');</script>"
                    . "<script>window.location.href = document.referrer;</script>");
            }

            //$inyeccionNombre=mysqli_real_escape_string($this->conexion, $nombreUsuario);
            $eliminarSQL = "DELETE FROM usuario WHERE email = '$inyeccionEmail'  ";
            mysqli_query($this->conexion, $eliminarSQL);
            echo "<script> alert ('Usuario eliminado');</script>"
                . "<script>window.location.href = document.referrer;</script>";
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

    //Devuelve array con los emails de los alumnos
    public function recogerEmailsUsuarios(): array
    {

        $sentenciaSQL = "SELECT email FROM usuario";
        $result = mysqli_query($this->conexion, $sentenciaSQL);
        while ($fila = mysqli_fetch_assoc($result)) {
            $array[] = $fila['email'];
        }
        return $array;

    }

    //Hace un select y luego un echo de los alumnos
    public function mostrarUsuarios(): array
    {
        $mostrarSQL = "SELECT * FROM usuario";
        $resultado = mysqli_query($this->conexion, $mostrarSQL);
        while ($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
            $Usuario = new Usuario($fila['email'], $fila['contrasenia'], $fila['nombre'], $fila['administrador']);
            $array[] = $Usuario;
        }
        return $array;

    }

    public function existeUsuario($emailUsuario, $psswdUsuario): bool
    {
        $emailValido = filter_var($emailUsuario, FILTER_VALIDATE_EMAIL);
        try {
            if (!$emailValido) {

                throw new Exception("<script> alert ('Email invalido. Estructura del emal----> ejemplousuario@prueba.com')</script>"
                    . "<script>window.location.href = document.referrer;</script>");

            }

            $inyeccionEmail = mysqli_real_escape_string($this->conexion, $emailUsuario);

            $mostrarUsuario = "SELECT email FROM usuario WHERE email= '$inyeccionEmail'AND contrasenia='$psswdUsuario'";
            $existenciaEmail = mysqli_query($this->conexion, $mostrarUsuario);

            while ($fila = mysqli_fetch_assoc($existenciaEmail)) {
                $email = $fila['email'];
            }

            if ($email == "") {

                throw new mysqli_sql_exception("<script> alert ('Usuario no existe');</script>"
                    . "<script>window.location.href = document.referrer;</script>");
            }

            return true;

        } catch (mysqli_sql_exception $me) {
            echo $me->getMessage();
            return false;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function controlAdministrador($emailUsuario): int
    {
        $mostrarUsuario = "SELECT administrador FROM usuario WHERE email='$emailUsuario'";
        $devolverAdministrador = mysqli_query($this->conexion, $mostrarUsuario);
        while ($fila = mysqli_fetch_assoc($devolverAdministrador)) {
            return $fila['administrador'];
        }
    }

    public function usuarioEscogido($emailUsuario): Usuario
    {

        $email = '';
        $password = '';
        $nombre = '';
        $adminitrador = 0;

        $sentenciaSQL = "SELECT * FROM usuario WHERE email LIKE '$emailUsuario'";
        $result = mysqli_query($this->conexion, $sentenciaSQL);
        while ($fila = mysqli_fetch_assoc($result)) {
            $email = $fila['email'];
            $password = $fila['contrasenia'];
            $nombre = $fila['nombre'];
            $adminitrador = $fila['administrador'];
        }

        $Usuario = new Usuario($email, $password, $nombre, $adminitrador);

        return $Usuario;
    }

    public function actualizarDatosUsuario($emailAntiguo,$emailNuevo,$passwordNueva,$nombreNuevo,$administradorNuevo){
         $sentenciaSQL="UPDATE usuario SET email='$emailNuevo', 
                    contrasenia='$passwordNueva', 
                    nombre='$nombreNuevo',
                    administrador= $administradorNuevo
                    WHERE email='$emailAntiguo'";
        mysqli_query($this->conexion,$sentenciaSQL);
        echo "<script> alert ('Usuario actualizado');</script>";
        
    }

}
