<?php


namespace App\Services;

use App\Database\DBIsmael;
use App\Entity\Usuario;
use PDO;
use PDOException;

class ConexionUsuario{

    private $_db;

    public function __constructor()
    {
        $this->_db=DBIsmael::getConexion();

    }

    public function establecerConexion()
    {
        $this->_db=DBIsmael::getConexion();
    }

    function encriptadoPassword($password):string{
        return password_hash($password,PASSWORD_BCRYPT);
    }

    public function aniadirUsuario(Usuario $usuario):void
    {
        try {
            $encripatdoPassword = $this->encriptadoPassword($usuario->getPasswordUsuario());

            $stm=$this->_db->prepare(
                'INSERT INTO usuario(userName,email,psswd,nombre,age,telephone,administrador) VALUES (:userName,:email,:psswd,:nombre,:age,:telephone,:administrador)'
            );
            //BINDPARAM 
            $stm->execute([
                'userName' => $usuario->getUserNameUsuario(),
                'email' => $usuario->getEmailUsuario(),
                'psswd' => $encripatdoPassword,
                'nombre' => $usuario->getNombreUsuario(),
                'age' => $usuario->getAgeUsuario(),
                'telephone' => $usuario->getTelephoneUsuario(),
                'administrador' => $usuario->getAdministrador()
            ]);
        } catch (PDOException $ex) {
            print "Fallo en aniadirUsuario()";
        }

    }

    public function actualizarUsuario(Usuario $usuario, string $emailAntiguo):void
    {
        $encripatdoPassword = 'encriptadoPassword'($usuario->getPasswordUsuario());
        try {
            $stm=$this->_db->prepare('
                update usuario
                set userName = :userName,
                    email = :email,
                    psswd = :password,
                    nombre = :nombre,
                    age = :age,
                    telephone = :telephone,
                    administrador = :administrador
                where email = :emailAntiguo
            ');
            $stm->execute([
                'userName' => $usuario->getUserNameUsuario(),
                'email' => $usuario->getEmailUsuario(),
                'password' => $encripatdoPassword,
                'nombre' => $usuario->getNombreUsuario(),
                'age' => $usuario->getAgeUsuario(),
                'telephone' => $usuario->getTelephoneUsuario(),
                'administrador' => $usuario->getAdministrador(),
                'emailAntiguo' => $emailAntiguo
            ]);
        } catch (PDOException $ex) {
            print "Fallo al ejecutar la query que muestre todos los usuarios";
        }
    }

    public function eliminarUsuario(string $email):void
    {
        try{
            $stm=$this->_db->prepare('
                delete from usuario where email = :email
            ');
            $stm->execute([
                'email' => $email
            ]);
        }catch(PDOException $ex){

        }
    }

    public function mostrarUsuarios() : array
    {
        try {
            //QUERY
            $stm=$this->_db->prepare('select * from usuario');
            //EXECUTE QUERY
            $stm->execute();
            //FETCH ALL
            $result = array();
            while ($data=$stm->fetch(PDO::FETCH_ASSOC)) {
                $usuario=new Usuario($data['userName'],$data['email'],$data['psswd'],$data['nombre'],(int)$data['age'],$data['telephone'],(int)$data['administrador']);
                array_push($result,$usuario);
            }
        } catch (PDOException $ex) {
            print "Fallo al ejecutar la query que muestre todos los usuarios";
        }

        return $result;
    }

    //Usuario escogido según su email
    public function existeUsuario(string $email):bool
    {
        try {
            $stm=$this->_db->prepare('select * from usuario where email = :email');
            $stm->execute(['email' => $email]);
            $result=$stm->fetch(PDO::FETCH_OBJ);
            if($result==null){
                return false;
            }
        } catch (PDOException $ex) {
            print "Fallo al ejecutar la query que muestre todos los usuarios";
        }
        return true;
    }

    public function usuarioEscogido(string $email):Usuario
    {
        try {
            $stm=$this->_db->prepare('select * from usuario where email = :email');
            $stm->execute(['email' => $email]);
            $data=$stm->fetch(PDO::FETCH_ASSOC);
            return new Usuario($data['userName'],$data['email'],$data['psswd'],$data['nombre'],$data['age'],$data['telephone'],$data['administrador']);
        } catch (PDOException $ex) {
            print "Fallo al ejecutar la query que muestre todos los usuarios";
        }
        return null;
    }

    //FUNCIONES EXTRAS

    public function administradorAniadirUsuarios():int
    {
        $result=0;

        if(count($this->mostrarUsuarios())==0){
            $result=1;
        }

        return $result;
    }

    public function recogerPassword(string $email):string
    {
        $result = "";
        try {
            $stm=$this->_db->prepare("SELECT psswd FROM usuario WHERE email = :email");
            $stm->execute(['email' => $email]);
            $result=$stm->fetchColumn();
        } catch (PDOException $th) {

        }
        return $result;
    }

    public function isAuthenticated(string $email, string $password):bool
    {
        $result=false;
        if(password_verify($password,$this->recogerPassword($email))){
            $result=true;
        }
        return $result;
    }

    public function accesoPaginaAdministrador(string $email):int
    {
        $result = 0;
        try {
            $stm=$this->_db->prepare('select administrador from usuario where email = :email');
            $stm->execute(['email' => $email]);
            $result=$stm->fetchColumn();
        } catch (PDOException $th) {

        }
        return $result;

    }


    public function  recogerEmailsUsuarios():array{
        try {
            $stm=$this->_db->prepare("SELECT email FROM usuario");
            $stm->execute();
            $result=array();
            While($data=$stm->fetch(PDO::FETCH_ASSOC)){
                array_push($result,$data['email']);
            }

            return $result;
        } catch (PDOException $th) {
            //throw $th;
        }
        return null;
    }


    //TOKEN
    public function tokenUsuario(string $email, string $token, string $expiracion)
    {
        try {
            $stm=$this->_db->prepare('update usuario set token = :token, expiracion = :expiracion where email = :email');
            $stm->execute(['token' => $token, 'expiracion' => $expiracion, 'email' => $email]);
        } catch (\PDOException $th) {
            
        }
    }
    
    public function existeToken(string $email):bool
    {
        try {
            $stm=$this->_db->prepare('select token from usuario where email = :email');
            $stm->execute(['email' => $email]);
            $data=$stm->fetchColumn();
            if($data===""){
                return false;
            }
        } catch (PDOException $th) {

        }
        return true;
    }

    public function tokenValidate(string $email, string $token):bool
    {
        try {
            $stm=$this->_db->prepare('select token from usuario where email = :email');
            $stm->execute(['email'=>$email]);
            if($token==$stm->fetchColumn()){
                return true;
            }
        } catch (PDOException $th) {
            //throw $th;
        }
        return false;
    }

    public function restablecerPassword(string $password,string $token)
    {
        try {
            $hash=$this->encriptadoPassword($password);
            $stm=$this->_db->prepare("UPDATE usuario SET psswd = :psswd WHERE token = :token");
            $stm->execute(['psswd'=>$hash,'token'=>$token]);
            
                return true;
            
        } catch (PDOException $th) {
            //throw $th;
        }
        return false;
    }

    public function removeToken(string $email):void
    {
        try {
            $stm=$this->_db->prepare("UPDATE usuario SET expiracion='0000-00-00 00:00:00', token=''  WHERE email = :email");
            $stm->execute(['email'=>$email]);
        } catch (PDOException $th) {
            //throw $th;
        }
    }
}

?>