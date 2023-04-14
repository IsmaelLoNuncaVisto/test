<?php
    class Usuario{

        private  string $emailUsuario;
        private  string $passwordUsuario;
        private  string $nombreUsuario;

        public function __construct(string $emailUsuario, string $passwordUsuario, string $nombreUsuario){
            $this->emailUsuario = $emailUsuario;
            $this->passwordUsuario = $passwordUsuario;
            $this->nombreUsuario = $nombreUsuario;
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

    }
?>