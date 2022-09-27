<?php
    class ProductoController extends ControladorBase{

        public function __construct() {
            parent::__construct();
        }

        public function index()
        {

            $lista = new Producto();

            $all = $lista->getAll();

            $this->view("index", array( "productos" => $all ));

        }

        public function buscar()
        {
            if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
            {
                $ref = $_POST["referencia"];

                $prod = new Producto();

                $info = $prod->getByReferencia($ref);

                if($info)
                {
                     echo json_encode(array("error" => '0', 'info' => $info));
                }else echo '{"error" : "-88", "msg" : "Producto no localizado"}';
            }else   echo '{"error" : "-99", "msg" : "Operacion no permitida"}';
        }

        public function editar()
        {

            if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
            {
                    $accion = $_POST["operacion"];

                    $opc = 0;
                    $prod = new Producto();

                    $ref = $_POST["referencia"];
                    $obs = $_POST["observacion"];
                    $nom = $_POST["nombre"];
                    $pre = $_POST['precio'];
                    $imp = $_POST["impuesto"];
                    $can = $_POST["cantidad"];
                    $est = $_POST["estado"];

                    if($this->comprobarDato($ref, 3, ''))
                        echo '{"error" : "-88", "msg" : "Caracteres invalidos en la referencia"}';
                    elseif($this->comprobarDato($nom, 3, ' ÁÉÍÓÚÑ,._-'))
                        echo '{"error" : "-88", "msg" : "Caracteres invalidos en el nombre"}';
                    elseif($this->comprobarDato($obs, 3, ' ÁÉÍÓÚÑ,._-'))
                        echo '{"error" : "-88", "msg" : "Caracteres invalidos en la referencia"}';
                    elseif($this->comprobarDato($can, 1, ''))
                        echo '{"error" : "-88", "msg" : "Caracteres invalidos en la Cantidad"}';
                    elseif($this->comprobarDato($est, 2, ''))
                        echo '{"error" : "-88", "msg" : "Caracteres invalidos en el estado"}';
                    elseif($est != 'activo' && $est != 'inactivo')
                        echo '{"error" : "-88", "msg" : "Caracteres invalidos en el estado"}';
                    elseif(intval($can) < 0 || intval($can) > 9999)
                        echo '{"error" : "-88", "msg" : "Valor invalido en la Cantidad"}';

                    if($accion == 'new')
                    {
                        $info = $prod->getByReferencia($ref);

                        if($info)  $opc = 1;
                    }

                    if($opc == 0)
                    {

                        $prod->setReferencia($ref);
                        $prod->setNombre($nom);
                        $prod->setObservacion($obs);
                        $prod->setPrecio($pre);
                        $prod->setImpuesto($imp);
                        $prod->setCantidad($can);
                        $prod->setImagen($ref.'.jpg');
                        $prod->setEstado($est);

                        $prod->guardar($prod, $accion);

			            if(!empty($_FILES['userfile']['name']))
                        {
                            $targetPath = 'assets/productos/';
                            $fileName = $_FILES['userfile']['name'];
                            $tempFile = $_FILES['userfile']['tmp_name'];
                            $exteFile = explode('.' , $fileName);
                            $tipoFile = strtolower(end($exteFile));

                            $targetFile = $targetPath.$ref.'.jpg' ;
                            move_uploaded_file($tempFile, $targetFile);

                        }

                        echo '{"error" : "0", "msg" : "Proceso  realizado satisfactoriamente", "icon" : "success", "title" : "Guardando Producto" }';
                    }else echo '{"error" : "-88", "msg" : "La referencia digitada ya se encuentra asignada a otro producto", "icon" : "error", "title" : "Proceso no ejecutado"}';

            }else echo '{"error" : "-99", "msg" : "Operacion no permitida", "icon" : "error", "title" : "Error"}';

        }

        public function borrar()
        {
            if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
            {
                if(isset($_POST["refproducto"]))
                {
                    $refproducto = $_POST["refproducto"];

                    $prod = new Producto();

                    $prod->delete($refproducto);

                    echo '{"error" : "0", "msg" : "El Producto se elimino satisfactoriamente", "icon" : "success", "title" : "Eliminando Producto '.$refproducto.'"}';
                }else   echo '{"error" : "-99", "msg" : "Referencia no especificada",  "icon" : "info", "title" : "Eliminando Producto"}';
            }else       echo '{"error" : "-99", "msg" : "Operacion no permitida",  "icon" : "error", "title" : "Eliminando Producto"}';

        }

        public function datatableProductos()
        {
            $response       = new stdClass;
            $requestData= $_REQUEST;

            //$response->draw = $_POST["draw"];
            $response->draw = intval($requestData['draw']);

            $producto = new Producto();
            $results  = $producto->getAll();

            $response->recordsTotal    = count($results);
            $response->recordsFiltered = $response->recordsTotal;
            $response->data            = array();

            foreach($results as $row) {
                $data                = array();

                $data['referencia']  = $row->referencia;
                $data['nombre']		 = $row->nombre;
                $data['observacion'] = $row->observacion;
                $data['precio']		 = number_format($row->precio, 2);
                $data['impuesto']	 = number_format($row->impuesto, 2);
                $data['cantidad']    = number_format($row->cantidad, 0);
                $data['estado']  	 = $row->estado;
                $data['imagen']      = $row->imagen;

                $response->data[]    = $data;
            }

            echo json_encode($response);
        }
    }
?>
