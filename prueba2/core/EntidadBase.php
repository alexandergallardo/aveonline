<?php
    require_once 'Conectar.php';

    class EntidadBase
    {
        protected $tabla;
        protected $db;
        protected $conectar;

        public function __construct($tabla) {
            $this->tabla = (string) $tabla;

            $this->conectar = new Conectar();
            $this->db       = $this->conectar->conexion();
        }

        public function getConetar()
        {
            return $this->conectar;
        }

        public function getDb()
        {
            return $this->db;
        }

        public function getTabla()
        {
            return $this->tabla;
        }

    }
?>
