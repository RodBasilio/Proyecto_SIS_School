<?php
    class conexionG {
        private $servidor;
        private $usuario;
        private $contrasena;
        private $basedatos;
        private $conexion;
    
        public function __construct() {
            $this->servidor = "localhost";
            $this->usuario = "root";
            $this->contrasena = "";
            $this->basedatos = "sis_school";
        }
    
        public function conectarG() {
            $this->conexion = new mysqli($this->servidor, $this->usuario, $this->contrasena, $this->basedatos);
            $this->conexion->set_charset('utf8');
        }
    
        public function obtenerConexion() {
            return $this->conexion;
        }
    
        public function cerrar() {
            $this->conexion->close();
        }

        
    }
?>