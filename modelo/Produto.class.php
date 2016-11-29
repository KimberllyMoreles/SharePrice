<?php

class Produto {
    private $idprod;
    private $nomeprod;
    private $idgenero;
    private $idmarca;
    
    //método de captura de valores para o objeto
    public function __get($key){
        return $this->$key;
    }
    
    //método de retorno de valores do objeto
    public function __set($key, $value){
        $this->$key = $value;
    }
}
