<?php
namespace APP\clasesBasicas;



class Usuario{

    private  string $userNameUsuario;
    private  string $emailUsuario;
    private  string $passwordUsuario;
    private  string $nombreUsuario;
    private  int $ageUsusario;
    private  string $telephoneUsuario;
    private  int  $administrador;

    public function __construct(string $userNameUsuario, string $emailUsuario, string $passwordUsuario, string $nombreUsuario, int $ageUsuario, string $telephoneUsuario, int $administrador)
    {
        $this->userNameUsuario=$userNameUsuario;
        $this->emailUsuario = $emailUsuario;
        $this->passwordUsuario = self::encriptadoPassword($passwordUsuario);
        $this->nombreUsuario = $nombreUsuario;
        $this->ageUsusario= $ageUsuario;
        $this->telephoneUsuario=$telephoneUsuario;
        $this->administrador= $administrador;
    }

    public function getUserNameUsuario()
    {
        return $this->userNameUsuario;
    }

    public function setUserNameUsuario($userNameUsuario)
    {
        $this->userNameUsuario = $userNameUsuario;
        return $this;
    }

    public function getEmailUsuario()
    {
        return $this->emailUsuario;
    }

    public function setEmailUsuario($emailUsuario)
    {
        $this->emailUsuario = $emailUsuario;
        return $this;
    }

    public function getPasswordUsuario()
    {
        return $this->passwordUsuario;
    }

    public function setPasswordUsuario($passwordUsuario)
    {
        $this->passwordUsuario = $passwordUsuario;
        return $this;
    }
 
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }
 
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
        return $this;
    }

    public function getAgeUsusario()
    {
        return $this->ageUsusario;
    }

    public function setAgeUsusario($ageUsusario)
    {
        $this->ageUsusario = $ageUsusario;
        return $this;
    }

    public function getTelephoneUsuario()
    {
        return $this->telephoneUsuario;
    }

    public function setTelephoneUsuario($telephoneUsuario)
    {
        $this->telephoneUsuario = $telephoneUsuario;
        return $this;
    }
 
    public function getAdministrador()
    {
        return $this->administrador;
    }
 
    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;
        return $this;
    }

    /*
    *
    *USO DE BASES DE DATOS DEL USUARIO
    *
    */

    //HASH PASWORD

    public static function encriptadoPassword($password):string{
        return password_hash($password,PASSWORD_BCRYPT);
    }

}
