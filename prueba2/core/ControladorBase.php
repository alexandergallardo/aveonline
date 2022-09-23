<?php
    class ControladorBase
    {

        public function __construct() {
            require_once 'Conectar.php';
            require_once 'EntidadBase.php';

            foreach(glob("model/*.php") as $file){
                require_once $file;
            }
        }

        public function view($vista, $info){
            foreach ($info as $id => $valor) {
                ${$id} = $valor;
            }

            require_once 'core/AyudaVistas.php';

            $helper = new AyudaVistas();

            require_once 'view/'.$vista.'View.php';
        }

        public function redirect($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO)
        {
            header("Location:index.php?controller=".$controlador."&action=".$accion);
        }

        public 	function comprobarDato($cadena, $opc, $otr)
        {
            //compruebo que los caracteres sean los permitidos
            $numeros  = '0123456789';
            $letras   = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $caract   = ' @?¿!#$%&()*,-./:;<=>_áéíóúÁÉÍÓÚñÑ';

            $permitidos    = '';

            if($opc == 1)
            {
                $permitidos = $numeros;
            }elseif($opc == 2)
            {
                $permitidos = $letras;
            }elseif($opc == 3)
            {
                $permitidos = $numeros.$letras;
            }else $permitidos = $numeros.$letras.$caract;

            $permitidos.=$permitidos.$otr;

            for ($i=0; $i<strlen($cadena); $i++)
            {
                if (strpos($permitidos, substr($cadena,$i,1))===false)
                {
                    return true;
                }
            }

            return false;
        }
    }
?>
