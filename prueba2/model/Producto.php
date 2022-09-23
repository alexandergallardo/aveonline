<?php
    class Producto extends EntidadBase{
        private $referencia;
        private $nombre;
        private $observacion;
        private $precio;
        private $impuesto;
        private $cantidad;
        private $estado;
        private $imagen;

        public function __construct() {
            parent::__construct("producto");
        }

        /**
         * @return mixed
         */
        public function getReferencia()
        {
            return $this->referencia;
        }

        /**
         * @param mixed $referencia
         * @return Producto
         */
        public function setReferencia($referencia)
        {
            $this->referencia = $referencia;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getNombre()
        {
            return $this->nombre;
        }

        /**
         * @param mixed $nombre
         * @return Producto
         */
        public function setNombre($nombre)
        {
            $this->nombre = $nombre;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getObservacion()
        {
            return $this->observacion;
        }

        /**
         * @param mixed $observacion
         * @return Producto
         */
        public function setObservacion($observacion)
        {
            $this->observacion = $observacion;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getPrecio()
        {
            return $this->precio;
        }

        /**
         * @param mixed $precio
         * @return Producto
         */
        public function setPrecio($precio)
        {
            $this->precio = $precio;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getImpuesto()
        {
            return $this->impuesto;
        }

        /**
         * @param mixed $impuesto
         * @return Producto
         */
        public function setImpuesto($impuesto)
        {
            $this->impuesto = $impuesto;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getCantidad()
        {
            return $this->cantidad;
        }

        /**
         * @param mixed $cantidad
         * @return Producto
         */
        public function setCantidad($cantidad)
        {
            $this->cantidad = $cantidad;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getEstado()
        {
            return $this->estado;
        }

        /**
         * @param mixed $estado
         * @return Producto
         */
        public function setEstado($estado)
        {
            $this->estado = $estado;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getImagen()
        {
            return $this->imagen;
        }

        /**
         * @param mixed $imagen
         * @return Producto
         */
        public function setImagen($imagen)
        {
            $this->imagen = $imagen;
            return $this;
        }




        public function guardar($prod, $accion){

            if($accion == 'new')
            {
                $query = "INSERT INTO producto(referencia, nombre, observacion, precio, impuesto, cantidad, estado, imagen)  
                VALUES('".$prod->getReferencia()."', 
                       '".$prod->getNombre()."', 
                       '".$prod->getObservacion()."',"
                         .$prod->getPrecio().", "
                         .$prod->getImpuesto().", "
                         .$prod->getCantidad().", 
                       '".$prod->getEstado()."', 
                       '".$prod->getImagen()."'  )";
            }else{
                $query = "UPDATE producto SET nombre='".$prod->getNombre()."', 
                                              observacion='".$prod->getObservacion()."',
                                              estado='".$prod->getEstado()."',  
                                              imagen='".$prod->getImagen()."', 
                                              precio=".$prod->getPrecio()." , 
                                              impuesto=".$prod->getImpuesto().", 
                                              cantidad=".$prod->getCantidad()." 
                                where  referencia = '".$prod->getReferencia()."'";

            }

            $procesar = $this->getDb()->query($query);

            return $procesar;
        }

        public function getAll()
        {
            $query = $this->getDb()->query("SELECT * FROM $this->tabla ");

            //  if($query)
            while ($row = $query->fetch_object()) {
                $resultSet[] = $row;
            }

            return isset($resultSet) ? $resultSet : array();
        }

        public function getByReferencia($referencia){
            $query = $this->getDb()->query("SELECT * FROM producto WHERE  referencia = '".$referencia."'");

            if($row = $query->fetch_object())
            {
                $resultSet = $row;
            }

            return isset($resultSet) ? $resultSet : false;
        }

        public function delete($referencia)
        {
            $query = $this->getDb()->query("DELETE FROM  producto  WHERE referencia = '".$referencia."'");

            return $query;
        }
    }
?>
