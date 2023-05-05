<?php

    namespace src;

    class Usuario{
        private  string $userNameUsuario;
        private  string $emailUsuario;
        private  string $passwordUsuario;
        private  string $nombreUsuario;
        private  int $ageUsusario;
        private  string $telephoneUsuario;
        private  int  $administrador;

        public function __construct(string $userNameUsuario, string $emailUsuario, string $passwordUsuario, string $nombreUsuario, int $ageUsuario, string $telephoneUsuario, int $administrador){
            $this->userNameUsuario=$userNameUsuario;
            $this->emailUsuario = $emailUsuario;
            $this->passwordUsuario = $passwordUsuario;
            $this->nombreUsuario = $nombreUsuario;
            $this->ageUsusario= $ageUsuario;
            $this->telephoneUsuario=$telephoneUsuario;
            $this->administrador= $administrador;
        }

        public function setUserNameUsuario($userNameUsuario):void{
            $this->userNameUsuario=$userNameUsuario;
        }

        public function getUserNameUsuario():string{
            return $this->userNameUsuario;
        }

        public function setEmailUsuario($emailUsuario):void{
            $this->emailUsuario=$emailUsuario;
        }

        public function getEmailUsuario():string{
            return $this->emailUsuario;
        }

        public function setPasswordUsuario($passwordUsuario):void{
            $this->passwordUsuario=$passwordUsuario;
        }

        public function getPasswordUsuario():string{
            return $this->passwordUsuario;
        }

        public function setNombreUsuario($nombreUsuario):void{
            $this->nombreUsuario=$nombreUsuario;
        }

        public function getNombreUsuario():string{
            return $this->nombreUsuario;
        }

        public function setAgeUsuario($ageUsuario):void{
            $this->ageUsusario=$ageUsuario;
        }

        public function getAgeUsuario():string{
            return $this->ageUsusario;
        }

        public function setTelephoneUsuario($telephoneUsuario):void{
            $this->telephoneUsuario;
        }

        public function getTelephoneUsuario():string{
            return $this->telephoneUsuario;
        }

        public function setAdministrador($administrador):void{
            $this->administrador=$administrador;
        }

        public function getAdministrador():int{
            return $this->administrador;
        }

    }
    

