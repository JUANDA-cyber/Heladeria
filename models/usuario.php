<?php

class Usuario{
    
    private $db;
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $rol;
    private $codigo;
    private $fecha_recuperacion;
    private $telefono;

    
    public function __construct(){
        $this->db = DataBase::connect();
    }

    function getId(){
        return $this->id;
    }
    function getNombre(){
        return $this->nombre;
    }
    function getApellido(){
        return $this->apellido;
    }
    function getEmail(){
        return $this->email;
    }
    function getPassword(){
        return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]); 
    }
    function getRol(){
        return $this->rol;
    }
    function getCodigo(){
        return $this->codigo;
    }  
    function getFecha_recuperacion(){
        return $this->fecha_recuperacion;
    }
    function getTelefono(){
        return $this->telefono;
    }
    

    
    function setId($id){
        $this->id = $id;
    }
    function setNombre($nombre){
        $this->nombre = $this->db->real_escape_string($nombre);
    }
    function setApellido($apellido){
        $this->apellido = $this->db->real_escape_string($apellido);
    }
    function setEmail($email){
        $this->email =  $this->db->real_escape_string($email);
    }
    function setPassword($password){
        $this->password = $password;
    }
    function setRol($rol){
        $this->rol = $rol;
    }
    function setCodigo($codigo){
        $this->codigo =  $this->db->real_escape_string($codigo);
    }
    function setFecha_recuperacion($fecha_recuperacion){
        $this->fecha_recuperacion = $fecha_recuperacion;
    }
    function setTelefono($telefono){
        $this->telefono = $telefono;
    }
    
    

    public function save(){
        $sql ="INSERT INTO usuario VALUES(NULL, '{$this->getNombre()}', '{$this->getApellido()}', '{$this->getEmail()}', '{$this->getPassword()}', {$this->getTelefono()}, 'user', 'NULL', 'NULL')";
        $save = $this->db->query($sql);
        echo mysqli_error($this->db);

        $result = false;
        if($save){
            $result = true;
        }
        
        return $result;
    }

    public function conseguirEmail($tabla){//saca en una variable $tabla los datos de la BD
        
        $email = $this->email;         
        
        //comprobar si existe
        $sql = "SELECT email FROM usuario WHERE email = '$email'";
        $login = $this->db->query($sql);
        $usuario = $login->fetch_object();
       
        if($usuario == null){
            $result = true;   
            // return $result;
        }else{
            $result = false;
            // return $result;
        }        
        return $result;
    }

    public function EmailporUser($tabla){//saca en una variable $tabla los datos de la BD
        $email = $this->email;  
        //comprobar si existe
        $sql = "SELECT * FROM usuario WHERE email = '$email'";
        $login = $this->db->query($sql);
        $usuario = $login->fetch_object();
       
        if($usuario){
            $result = $usuario;
            // return $result;
        }else{
            $result = false;
            // return $result;
        }           
        return $result;
    }

    public function UserporCodigo($tabla){//saca en una variable $tabla los datos de la BD
        $codigo = $this->codigo;  
        //comprobar si existe
        $sql = "SELECT * FROM usuario WHERE codigo = '$codigo' LIMIT 1";
        $login = $this->db->query($sql);
        $usuario = $login->fetch_object();
       
        if($usuario){
            $result = $usuario;
            // return $result;
        }else{
            $result = false;
            // return $result;
        }           
        return $result;
    }

    public function recoverPassword($tabla){
        $email = $this->email;  
        $sql = "UPDATE usuario SET codigo='{$this->getCodigo()}', fecha_recuperacion='{$this->getFecha_recuperacion()}' WHERE email = '$email' ";
        $save = $this->db->query($sql);

        $result = false;
        if($save){
            $result = true;
        }
        return $result;        
    }

    public function UpdatePasswordWithRecover($tabla){
        $id = $this->id; 
        // $password = $this->getPassword();  

        $sql = "UPDATE $tabla SET password = '{$this->getPassword()}', codigo = 'NULL', fecha_recuperacion = 'NULL' WHERE id = '$id' ";
        $save = $this->db->query($sql);

        $result = false;
        if($save){
            $result = true;
        }
        return $result;        
    }

    public function login(){
        $result = false;
        $email = $this->email; 
        $password = $this->password;

        //comprobar si existe
        $sql = "SELECT * FROM usuario WHERE email = '$email'";
        $login = $this->db->query($sql);

        if($login && $login->num_rows == 1){
            $usuario = $login->fetch_object();
            //verifica contraseña
            $verify = password_verify($password, $usuario->password);
            if($verify){
                $result = $usuario;
            }
            else{
                $result = "contraseña incorrecta";
            }
        }
        return $result;
    }

    public function conseguirTodos($tabla){//saca en una variable $tabla los datos de la BD
        $query = $this->db->query("SELECT * FROM $tabla ORDER BY id DESC");
        return $query;
    }

    public function conseguirUno($tabla){//saca en una variable $tabla los datos de la BD
        $query = $this->db->query("SELECT u.id,  u.nombre, u.apellido, u.email, u.telefono 
        FROM $tabla u 
        WHERE u.id = {$this->getId()} LIMIT 1");
        $usuario = $query->fetch_object();       
        return $usuario; 
    }

    public function UpdateUser($tabla){
        $id = $this->id;    
              
        $sql = "UPDATE $tabla SET nombre='{$this->getNombre()}', apellido='{$this->getApellido()}', telefono={$this->getTelefono()}, WHERE id='$id' ";
        $save = $this->db->query($sql);
        
        // $otr = $save->fetch_object();    

        $result = false;
        if($save){
            $result = true;
        }
        return $result;        
    }



}
