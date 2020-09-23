<?php
require_once 'models/producto.php';

class productoController{
    public function index(){
         
        $producto = new Producto();
        $productos = $producto->getRandom(6);
        //var_dump($productos->num_rows);

        // renderizar vista
        require_once 'views/producto/destacados.php';        
    }

    public function ver(){

        if(isset($_GET['id'])){
            $id = $_GET['id'];
          
            $producto = new Producto();
            $producto->setId($id);

            $product = $producto->getOne();
        }
        require_once 'views/producto/ver.php';
    }

    public function gestion(){
        Utils::isAdmin();

        $producto = new Producto();//crea una instancia
        $productos = $producto->getAll();//return en la variable el metodo getAll

        require_once 'views/producto/gestion.php';//lo renderiza
    }

    public function crear(){
        Utils::isAdmin();
        require_once 'views/producto/crear.php';
    }
    
    public function save(){
        Utils::isAdmin();
        if(isset($_POST)){//validar que los datos sean los correctos
            //var_dump($_POST); //probar que los datos llegan correctamente

            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false; 
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false; 
            $precio = isset($_POST['precio']) ? $_POST['precio'] : false; 
            $stock = isset($_POST['stock']) ? $_POST['stock'] : false; 
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false; 
            //$imagen = isset($_POST['imagen']) ? $_POST['imagen'] : false; 

            if($nombre && $descripcion && $precio && $stock && $categoria){
                $producto = new Producto();
                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setPrecio($precio);
                $producto->setStock($stock);
                $producto->setCategoria_id($categoria);


                //guardar la imagen
                if(isset($_FILES['imagen'])){

                    $file = $_FILES['imagen'];//nombre del campo en el formulario de crear
                    $filename = $file['name'];
                    $mimetype = $file['type'];

                    //buscar en google los tipos de mimetypes images
                    if($mimetype == "image/jpg" || $mimetype == "image/jpeg" || $mimetype == "image/png" || $mimetype == "image/gif"){

                        if(!is_dir('uploads/images')){
                            mkdir('uploads/images', 0777, true);
                        }

                        move_uploaded_file($file['tmp_name'], 'uploads/images/'.$filename);
                        $producto->setImagen($filename);
                    }
                }


                //diferencia la actualizacion o el guardado de los datos de la bd 
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $producto->setId($id);

                    $save = $producto->edit();
                }else{
                    $save = $producto->save();
                }                


                if($save){
                    $_SESSION['producto'] = "complete";
                }else{
                    $_SESSION['producto'] = "failed";
                }
            }else{
                $_SESSION['producto'] = "failed";
            }
        }else{
            $_SESSION['producto'] = "failed";
        }
        header('Location:'.base_url.'producto/gestion');
    }//save


    public function editar(){//var_dump($_GET);
        Utils::isAdmin();        

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $edit = true;

            $producto = new Producto();
            $producto->setId($id);

            $pro = $producto->getOne();
             

            require_once 'views/producto/crear.php';
        }else{
            header('Location:'.base_url.'producto/gestion');
        }

    }

    public function eliminar(){
        //var_dump($_GET);
        Utils::isAdmin();

        if(isset($_GET['id'])){

            $id = $_GET['id'];
            $producto = new Producto();
            $producto->setId($id);
            $delete = $producto->delete();

            if($delete){
                $_SESSION['delete'] = 'complete';
            }else{
                $_SESSION['delete'] = 'failed';
            }       
        }else{
            $_SESSION['delete'] = 'failed';
        }

    header('Location:'.base_url.'producto/gestion');
    }



}