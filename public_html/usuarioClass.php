<?php
    class Usuario{

        private $emailUsuario;
        private $passwordUsuario;
        private $nombreUsuario;

        public function __construct($emailUsuario,$passwordUsuario,$nombreUsuario){
            $this->emailUsuario = $emailUsuario;
            $this->passwordUsuario = $passwordUsuario;
            $this->nombreUsuario = $nombreUsuario;
        }

        public function setEmailUsuario($emailUsuario){
            $this->emailUsuario=$emailUsuario;
        }

        public function getEmailUsuario(){
            return $this->emailUsuario;
        }

        public function setPasswordUsuario($passwordUsuario){
            $this->passwordUsuario=$passwordUsuario;
        }

        public function getPasswordUsuario(){
            return $this->passwordUsuario;
        }

        public function setNombreUsuario($nombreUsuario){
            $this->nombreUsuario=$nombreUsuario;
        }

        public function getNombreUsuario(){
            return $this->nombreUsuario;
        }

    }
?>