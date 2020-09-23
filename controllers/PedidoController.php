<?php

require_once 'models/pedido.php';

class pedidoController{
    public function hacer(){
        //echo "controlador pedidos, accion index ";

        require_once 'views/pedido/hacer.php';
    }

    public function add(){
        //var_dump($_POST);
        if(isset($_SESSION['identity'])){
            $usuario_id = $_SESSION['identity']->id;
            //var_dump($usuario_id);
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
            
            $stats = Utils::statsCarrito();
            $coste = $stats['total'];

            if($provincia && $localidad && $direccion){
                //guardar datos en la bd
                $pedido = new Pedido();
                $pedido->setUsuario_id($usuario_id);
                $pedido->setProvincia($provincia);
                $pedido->setLocalidad($localidad);
                $pedido->setDireccion($direccion);
                $pedido->setCoste($coste);

                $save = $pedido->save();

                //guardar linea pedido
                $save_linea = $pedido->save_linea();

                if($save && $save_linea){
                    $_SESSION['pedido'] = "complete";
                }else{
                    $_SESSION['pedido'] = "failed";
                }
                //var_dump($pedido);

            }else{
                $_SESSION['pedido'] = "failed";
            }

            header("Location:".base_url.'pedido/confirmado');

        }else{
            //redirigir al index
            header("location:".base_url);

        }
    }

    public function confirmado(){
        if(isset($_SESSION['identity'])){
            $identity = $_SESSION['identity'];
            $pedido = new Pedido();
            $pedido->setUsuario_id($identity->id);

            $pedido = $pedido->getOneByUser(); //saca el pedido

            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($pedido->id);
        }  
        require_once 'views/pedido/confirmado.php';
    }

    public function mis_pedidos(){
        Utils::isIdentity(); //debes estar logueado para poder acceder aca
        $usuario_id = $_SESSION['identity']->id; //acceder a una propiedad de un array - solo se puede en las versiones de php5
        $pedido = new Pedido(); //objeto

        //sacar los pedidos del usuario
        $pedido->setUsuario_id($usuario_id);
        $pedidos = $pedido->getAllByUser();     

        require_once 'views/pedido/mis_pedidos.php';
    }

    public function detalle(){
        Utils::isIdentity();
        
        //recoger el id del pedido por la url
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            //sacar los datos del pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido = $pedido->getOne();

            //sacar los productos
            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($id);
                        
            //sacar los usuarios
            $usuario_productos = new Pedido();
            $usuarios = $usuario_productos->getUsuarioByPedido($id);                    

            require_once 'views/pedido/detalle.php';

        }else{
            header("Location".base_url.'pedido/mis_pedidos');
        }
    }

    public function gestion(){
        Utils::isAdmin();
        $gestion = true;

        $pedido = new Pedido();
        $pedidos = $pedido->getAll();
        require_once 'views/pedido/mis_pedidos.php';
    }

    public function estado(){
        Utils::isAdmin();

        if(isset($_POST['pedido_id']) && isset($_POST['estado'])){
            //recoger datos del formulario 
            $id = $_POST['pedido_id'];
            $estado =$_POST['estado'];

            //update del pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido->setEstado($estado);
            $pedido->edit();

            header("Location:".base_url.'pedido/detalle&id='.$id);
        }else{
            header("Location:".base_url);
        }
    }

}