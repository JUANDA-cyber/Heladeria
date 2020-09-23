<?php

class Pedido{
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;

    private $db;


    public function __construct(){
        $this->db = DataBase::connect();
    }

    function getId(){
        return $this->id;
    }
    function getUsuario_id(){
        return $this->usuario_id;
    }
    function getProvincia(){
        return $this->provincia;
    }
    function getLocalidad(){
        return $this->localidad;
    }
    function getDireccion(){
        return $this->direccion;
    }
    function getCoste(){
        return $this->coste;
    }
    function getEstado(){
        return $this->estado;
    }
    function getFecha(){
        return $this->fecha;
    }
    function getHora(){
        return $this->hora;
    }


    function setId($id){
        $this->id = $id;
    }
    function setUsuario_id($usuario_id){
        $this->usuario_id = $usuario_id;
    }
    function setProvincia($provincia){
        $this->provincia = $this->db->real_escape_string($provincia);
    }
    function setLocalidad($localidad){
        $this->localidad = $this->db->real_escape_string($localidad);
    }
    function setDireccion($direccion){
        $this->direccion = $this->db->real_escape_string($direccion);
    }
    function setCoste($coste){
        $this->coste = $coste;
    }
    function setEstado($estado){
        $this->estado = $estado;
    }
    function setFecha($fecha){
        $this->fecha = $fecha;
    }
    function setHora($hora){
        $this->hora = $hora;
    }

    //metodo para listar, se llama en el controlador
    public function getAll(){
        $productos = $this->db->query("SELECT * FROM pedidos ORDER BY id DESC");
        return $productos;
    }

    //metodo para listar un solo dato, sirve para editar productos .crear.php, se llama en el controlador
    public function getOne(){ //detalle.php
        $producto = $this->db->query("SELECT * FROM pedidos WHERE id = {$this->getId()}");
        return $producto->fetch_object();
    }

    //saca el ultimo registro de pedido de un usuario, buscame un pedido por usuario
    public function getOneByUser(){ //confirmado.php
        $sql = "SELECT p.id, p.coste FROM pedidos p "                            //quiero sacar la id, coste, de los productos de la tabla pedidos con el alias de p
            //. "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "     //lp alias de lineas_pedidos, uniendo las lineas "inner join" cuando pedido_id sea igual a la id de la tabla pedidos
            . "WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC LIMIT 1"; //cuando EL usuario_id sea igual al usuario que esta en el get, sacaen orden descentente la id, con un limite de 1, la ultima
        $pedido = $this->db->query($sql);
        return $pedido->fetch_object();
    }

    //saca todos los pedidos de un usuario
    public function getAllByUser(){ //mis_pedidos.php
        $sql = "SELECT p.* FROM pedidos p "  //quiero sacar todo de la tabla pedido,
            . "WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC "; //DONDE EL usuario_id sea igual al usuario que esta en el set, sacaen orden descentente la id
        $pedido = $this->db->query($sql);
        return $pedido;
    }

    //hace una consulta en la bd, que saque los productos por una id que le voy a pasar por parametro
    public function getProductosByPedido($id){ //$id es el id de pedido detalle.php
        //$sql = "SELECT * FROM productos WHERE id IN "    //sacame los productos cuyo id exista en esta sub consulta
        //    . "(SELECT producto_id FROM lineas_pedidos WHERE pedido_id={$id})";
        $sql = "SELECT pr.*, lp.unidades FROM productos pr "
            . "INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id "
            . "WHERE lp.pedido_id={$id}";
            
        $productos = $this->db->query($sql);
        
        return $productos;
    }

    public function getUsuarioByPedido($id){
        // $sql = "SELECT us.* FROM usuarios us "  //quiero sacar todo de la tabla usuario,
        //     . "INNER JOIN pedidos p ON us.id = p.usuario_id "
        //     ."INNER JOIN lineas_pedidos lp ON p.id = lp.pedido_id"
        //     . "WHERE lp.pedido_id={$id}"; 
        $sql = "SELECT us.* FROM usuarios us "  //quiero sacar todo de la tabla usuario,
            . "INNER JOIN pedidos p ON us.id = p.usuario_id "
            . "WHERE p.id={$id}";              
        $usuario = $this->db->query($sql);
        
        return $usuario->fetch_object();
    }

    public function save(){//guarda los datos del formulario que estan en views/producto/crear.php
        
        $sql = "INSERT INTO pedidos VALUES(NULL, {$this->getUsuario_id()},'{$this->getProvincia()}', '{$this->getLocalidad()}', '{$this->getDireccion()}', {$this->getCoste()}, 'confirm', CURDATE(), CURTIME());";
        $save = $this->db->query($sql);

        /* codigo para depurar y consultar los errores
        
        echo $sql;
        echo "</br>";
        echo $this->db->error;
        die();
        */

        $result = false;
        if($save){
            $result = true;
        }
        return $result;
    }//save

    public function save_linea(){
        $sql = "SELECT LAST_INSERT_ID() as 'pedido';";  //ultima id del registro de los pedidos
        $query = $this->db->query($sql);     //ejecuta la consulta en una variable
        $pedido_id = $query->fetch_object()->pedido;    //se guarda el query en pedido_id

        foreach($_SESSION['carrito'] as $elemento){
            $producto = $elemento['producto'];

            $insert = "INSERT INTO lineas_pedidos VALUES(NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']})";
            $save = $this->db->query($insert); //guarda en la bd

            /*var_dump($producto);
            var_dump($insert);
            echo $this->db->error;
            die();*/
            
        }
        //var_dump($pedido_id);
        //comprobar si la ultima consulta es correcta
        $result = false;
        if($save){
            $result = true;
        }
        return $result;        
    }

    //actualizar un pedido en concreto views/pedido/detalle
    public function edit(){        
        $sql = "UPDATE pedidos SET estado='{$this->getEstado()}' ";
        $sql .= " WHERE id={$this->getId()};";
            
        $save = $this->db->query($sql);

        $result = false;
        if($save){
            $result = true;
        }
        return $result;
    }
        
    

}
