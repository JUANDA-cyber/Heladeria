<?php

class ModeloBase{

    public $db;
    
    public function __construct(){
        $this->db = DataBase::connect();
    }
    
    public function conseguirTodos($tabla){//saca en una variable $tabla los datos de la BD
        $query = $this->db->query("SELECT * FROM $tabla ORDER BY id DESC");
        return $query;
    }
}