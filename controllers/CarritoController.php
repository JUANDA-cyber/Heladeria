<?php
require_once 'models/producto.php';

class carritoController{
    public function index(){
        if(isset($_SESSION['carrito']) && count($_SESSION['carrito'])>=1){//comprobar si hay productos en el carrito
            //var_dump($_SESSION['carrito']); para ver el arreglo que se creo y los elementos
            $carrito = ($_SESSION['carrito']);
        }else{//si no, es un array vacio
            $carrito = array();
        }
        require_once 'views/carrito/index.php';
    }

    public function add(){
        if(isset($_GET['id'])){//llega variable por la url
            $producto_id = $_GET['id'];
        }else{
            header('Location:'.base_url);
        }

        if(isset($_SESSION['carrito'])){//funcionalidad al carrito, si el carrito ya existe
            $counter = 0;
            foreach($_SESSION['carrito'] as $indice=> $elemento){//recorre el carrito y en cada iteracion saca el indice del array y consigue el valor que es el producto
                if($elemento['id_producto'] == $producto_id){//si el id del producto que esta en elemento, es igual, al $producto_id que guarda la id que llega por la url
                    $_SESSION['carrito'][$indice]['unidades']++;//le sumo 1 a las unidades del carrito
                    $counter++;
                }
            }
        }if(!isset($counter) || $counter == 0){// si el contador es igual a 0 o no existe 
            //conseguir producto
            $producto = new Producto();
            $producto->setId($producto_id);
            $producto = $producto->getOne();
            //anadir al carrito
            if(is_object($producto)){
                $_SESSION['carrito'][] = array(//se añade un elemento al carrito
                    "id_producto" => $producto->id,
                    "precio" => $producto->precio,
                    "unidades" => 1,
                    "producto" => $producto
                );
            }
        }
        header('Location:'.base_url."carrito/index");

    }

    public function delete(){
        if(isset($_GET['index'])){
            $index =$_GET['index'];
            unset($_SESSION['carrito'][$index]);
        }
        header("Location:".base_url."carrito/index");
    }

    public function up(){
        if(isset($_GET['index'])){
            $index =$_GET['index'];
            $_SESSION['carrito'][$index]['unidades']++;
        }
        header("Location:".base_url."carrito/index");
    }
    
    public function down(){
        if(isset($_GET['index'])){
            $index =$_GET['index'];
            $_SESSION['carrito'][$index]['unidades']--;
            if($_SESSION['carrito'][$index]['unidades'] == 0){
                unset($_SESSION['carrito'][$index]);
            }
        }
        header("Location:".base_url."carrito/index");
    }


    public function delete_All(){
        unset($_SESSION['carrito']);
        header("Location:".base_url."carrito/index");
    }

}