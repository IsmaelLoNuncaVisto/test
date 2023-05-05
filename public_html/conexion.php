<?php

require("../src/Usuario.php");
use src\Usuario;

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

     public function encriptadoPasword($password):string{
        $hash_pasword= password_hash($password,PASSWORD_BCRYPT);
        return $hash_pasword;
     }

     public function inyeccionCredenciales($arrayElementos):Usuario{
        $arrayElementosInyectados=array() ;
        for ($i=0; $i < count($arrayElementos); $i++) { 
            $inyeccionElemento=mysqli_real_escape_string($this->conexion, $arrayElementos[$i]);
           array_push($arrayElementosInyectados,$inyeccionElemento);
        }

        //HASH de la Contraseña
        //$hash_pasword=$this->encriptadoPasword($$arrayElementos[2]);

        $usuario =  new Usuario($arrayElementosInyectados[0],
            $arrayElementosInyectados[1],
            $arrayElementosInyectados[2],
            $arrayElementosInyectados[3],
            $arrayElementosInyectados[4],
            $arrayElementosInyectados[5],
            $arrayElementosInyectados[6]);

        return $usuario;

     }

     //
     public function administradorAniadirUsuario($arrayDatos):array{
        if($this->cuantosUsuarios()!=0){
            array_push($arrayDatos,1);
            return $arrayDatos;
        }else{
            array_push($arrayDatos,0);
            return $arrayDatos;
        }
        
     }

     //CUENTA LA CANTIDAD DE USUARIOS QUE HAY EN LA TABLA usuario
     public function cuantosUsuarios():int{
        $sql="SELECT * FROM usuario";
        $arrayUsuarios=mysqli_fetch_assoc(mysqli_query($this->conexion,$sql));
        if($arrayUsuarios==null){
            return 1;
        }
        return 0;
        
     }


    public function aniadirUsuario($usuarioAniadir):bool
    {
       $usuario= $this->inyeccionCredenciales($this->administradorAniadirUsuario($usuarioAniadir));
        
        if(!$this->existeUsuario($usuario->getEmailUsuario())){
            $sentenciaSQL="INSERT INTO usuario(userName,email,psswd,nombre,age,telephone,administrador) VALUES 
            ('".$usuario->getUserNameUsuario()."',
            '".$usuario->getEmailUsuario()."',
            '".$usuario->getPasswordUsuario()."',
            '".$usuario->getNombreUsuario()."',
            ".$usuario->getAgeUsuario().",
            '".$usuario->getTelephoneUsuario()."',
            ".$usuario->getAdministrador().")";
            mysqli_query($this->conexion,$sentenciaSQL);
            return true;
        }
        return false;
    }

    /*Acceso HASH contraseña*/

    public function accesoHash($email):string{
        $sql="SELECT psswd FROM usuario WHERE email = '$email'";
        $result  = mysqli_query($this->conexion,$sql);
        $row=mysqli_fetch_assoc($result);
        $hash = $row['psswd'];
        if($hash==null){
            return "";
        }
        return $hash;
    }

    /*AccesoUsuario*/

    public function accesoUsuario($emailUsuario,$psswdUsuario):bool{
        $inyeccionEmail = mysqli_real_escape_string($this->conexion, $emailUsuario);
        $inyeccionPsswd = mysqli_real_escape_string($this->conexion,$psswdUsuario);
        $hash=$this->accesoHash($inyeccionEmail);
        if(password_verify($inyeccionPsswd,$hash)){
            return true;
        }else{
            return false;
        }
    }


    /*Direccion de página*/

    public function accesoPaginaAdministrador($emailUsuario):bool{
        $inyeccionEmail = mysqli_real_escape_string($this->conexion, $emailUsuario);
        $sentenciaSQL = "SELECT administrador FROM usuario WHERE email= '$inyeccionEmail'";
        $result=mysqli_query($this->conexion,$sentenciaSQL);
        if(mysqli_fetch_assoc($result)['administrador']==1){
        return true;
         }else{
        return false;
        }

    }


    /*Elimina usuario a la BD
    Comprueba la forma correcta del email, Error al estar mal escrita
    Comprueba que exista el usuario. Error si no existe
    En caso de Error regresa a la pagina de referencia
     */
    public function eliminarUsuario($emailUsuario):bool
    {
            $inyeccionEmail = mysqli_real_escape_string($this->conexion, $emailUsuario);
            if($this->existeUsuario($emailUsuario)){
                $eliminarSQL = "DELETE FROM usuario WHERE email = '$inyeccionEmail'";
                mysqli_query($this->conexion, $eliminarSQL);
                return true;
            }else{
                return false;
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
    public function recogerUsuarios(): array
    {
        $mostrarSQL = "SELECT * FROM usuario";
        $resultado = mysqli_query($this->conexion, $mostrarSQL);
        while ($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
            $Usuario = new Usuario($fila['userName'],$fila['email'], $fila['psswd'], $fila['nombre'], $fila['age'],$fila['telephone'],$fila['administrador']);
            $array[] = $Usuario;
        }
        return $array;
    }

    public function existeUsuario($emailUsuario): bool
    {
            $inyeccionEmail = mysqli_real_escape_string($this->conexion, $emailUsuario);
            $mostrarUsuario = "SELECT email FROM usuario WHERE email= '$inyeccionEmail'";
            $existenciaUsuario = mysqli_query($this->conexion, $mostrarUsuario);
            while ($fila = mysqli_fetch_assoc($existenciaUsuario)) {
                if($emailUsuario==$fila["email"]){
                    return true;
                }
            }
            return false;
        
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

        $sentenciaSQL = "SELECT userName,psswd,nombre,age,telephone,administrador FROM usuario WHERE email LIKE '$emailUsuario'";
        $result = mysqli_query($this->conexion, $sentenciaSQL);
            while($fila=mysqli_fetch_assoc($result)){
            $userName=$fila['userName'];
            $email = $emailUsuario;
            $password = $fila['psswd'];
            $nombre = $fila['nombre'];
            $age=$fila['age'];
            $telephone=$fila['telephone'];
            $adminitrador = $fila['administrador'];
            $Usuario = new Usuario($userName,$email, $password, $nombre,$age,$telephone, $adminitrador);
            return $Usuario;
            }
            return null;
    }

    public function actualizarDatosUsuario($emailAntiguo,$actualizarUsuario):bool{

        $usuario=$this->inyeccionCredenciales($actualizarUsuario);         
         $sentenciaSQL="UPDATE usuario SET userName = '".$usuario->getUserNameUsuario()."',
                    email='".$usuario->getEmailUsuario()."', 
                    psswd='".$usuario->getPasswordUsuario()."', 
                    nombre='".$usuario->getNombreUsuario()."',
                    age='".$usuario->getAgeUsuario()."',
                    telephone='".$usuario->getTelephoneUsuario()."',
                    administrador= ".$usuario->getAdministrador()."
                    WHERE email='$emailAntiguo'";
        if(mysqli_query($this->conexion,$sentenciaSQL)){
         return true;
        }else{
            return false;
        }
    }

    public function recuperarPassword($email,$token,$expiracion){
        $sql="UPDATE usuario SET token='$token', expiracion='$expiracion' WHERE email = '$email'";
        mysqli_query($this->conexion,$sql);
    }

    public function restablecerPassword($password,$token){

        $hash=$this->encriptadoPasword($password);

        $sql="UPDATE usuario SET psswd='$hash' WHERE token='$token'";
        mysqli_query($this->conexion,$sql);
        $this->borrarToken($token);

    }

    public function comprobarValidezToken($token):bool{
        $sql="SELECT COUNT(*) FROM usuario WHERE token = '$token' AND expiracion >= NOW()";
        $resultado = mysqli_query($this->conexion,$sql);
        $valido = (mysqli_fetch_array($resultado)[0]>0);
        if($valido){
            return true;
        }else{
            return false;
        }
    }

    public function borrarToken($token){
        $sql="UPDATE usuario SET expiracion='0000-00-00 00:00:00', token='' WHERE token='$token'";
        mysqli_query($this->conexion,$sql);
    }

}
