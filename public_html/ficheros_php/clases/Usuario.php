<?php

    class Usuario{
        private  string $emailUsuario;
        private  string $passwordUsuario;
        private  string $nombreUsuario;
        private  int  $administrador;

        public function __construct(string $emailUsuario, string $passwordUsuario, string $nombreUsuario, int $administrador){
            $this->emailUsuario = $emailUsuario;
            $this->passwordUsuario = $passwordUsuario;
            $this->nombreUsuario = $nombreUsuario;
            $this->administrador= $administrador;
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

        public function setAdministrador($administrador):void{
            $this->administrador=$administrador;
        }

        public function getAdministrador():int{
            return $this->administrador;
        }

    }
    

