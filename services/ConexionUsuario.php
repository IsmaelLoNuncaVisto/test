<?php



namespace test\services;

require ("../database/DBIsmael.php");

use PDO;
use PDOException;
use test\src\Usuario;
use test\database\DBIsmael;

class ConexionUsuario{

    private $_db;

    public function __constructor()
    {
        $this->_db=DBIsmael::getConexion();
    }

    public function aniadirUsuario(Usuario $usuario):void{
        try {
            $stm=$this->_db->prepare(
                'insert into usuario(userName,email,psswd,nombre,age,telephone,administrador) values (:userName, :email, :password, :nombre, :age, :telephone, :administrador'
            );
            $stm->execute([
                'userName' => $usuario->getUserNameUsuario(),
                'email' => $usuario->getEmailUsuario(),
                'password' => $usuario->getPasswordUsuario(),
                'nombre' => $usuario->getNombreUsuario(),
                'age' => $usuario->getAgeUsusario(),
                'telephone' => $usuario->getTelephoneUsuario(),
                'administrador' => $usuario->getAdministrador()
            ]);
        } catch (PDOException $ex) {
            print "Fallo al ejecutar la query que muestre todos los usuarios";
        }

    }

    public function actualizarUsuario(Usuario $usuario, string $emailAntiguo):void
    {
        try {
            $stm=$this->_db->prepare('
                update usuario
                set userName = :userName,
                    email = :email,
                    password = :password,
                    nombre = :nombre,
                    age = :age,
                    telephone = :telephone,
                    administrador = :administrador
                where email = :emailAntiguo
            ');
            $stm->execute([
                'userName' => $usuario->getUserNameUsuario(),
                'email' => $usuario->getEmailUsuario(),
                'password' => $usuario->getPasswordUsuario(),
                'nombre' => $usuario->getNombreUsuario(),
                'age' => $usuario->getAgeUsusario(),
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

    public function mostrarUsuarios() : ?Array
    {
        $result = [];
        try {
            //QUERY
            $stm=$this->_db->prepare('select * from usuario');
            //EXECUTE QUERY
            $stm->execute();
            //FETCH ALL
            $result=$stm->fetchAll(PDO::FETCH_CLASS, '\\TEST\\src\\USUARIO');
        } catch (PDOException $ex) {
            print "Fallo al ejecutar la query que muestre todos los usuarios";
        }

        return $result;
    }

    //Usuario escogido según su email
    public function existeUsuario(string $email): ?Usuario
    {
        $result = null;

        try {
            $stm=$this->_db->prepare('select * from usuario where email = :email');
            $stm->execute(['email' => $email]);
            $data=$stm->fetchObject('\\TEST\\src\\USUARIO');
            if($data){
                $result=$data;
            }
        } catch (PDOException $ex) {
            print "Fallo al ejecutar la query que muestre todos los usuarios";
        }

        return $result;
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
            $stm=$this->_db->prepare('select psswd from usuario where email = :email');
            $stm->execute(['email' => $email]);
            $result=$stm->fetchColumn();
        } catch (PDOException $th) {

        }
        return $result;
    }

    public function accesoUsuario(string $email, string $password):bool
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
        $result = false;
        try {
            $stm=$this->_db->prepare('select token from usuario where email = :email');
            $stm->execute(['email' => $email]);
            $data=$stm->fetchColumn();
            if($data===""){
                return true;
            }
        } catch (PDOException $th) {

        }
        return $result;
    }
}

?>