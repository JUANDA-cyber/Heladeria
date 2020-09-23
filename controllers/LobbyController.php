<?php

class lobbyController {

    public function index(){
        Utils::isIdentity();
            require_once 'views/lobby/lobby.php';        
    }
}