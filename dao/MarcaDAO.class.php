<?php

require_once 'Conexao.class.php';
class MarcaDAO {
    private $pdo;
    
    public function __construct(){
        //AQUI é feita a conexão com o Banco
        $conexao = new Conexao();
        $this->pdo = $conexao->getPDO();
    }
    //Listar
    public function listar()
    {   
        $parametros = Array();
        $sql = "SELECT * FROM marca WHERE data_exclusao IS NULL";
       
        //lista de alunos
        $lista = array();
        $query = $this->pdo->prepare($sql);
        
        $query->execute($parametros);
        //percorrer meus registros
        //tratando-os como objeto
        while($obj = $query->fetchObject()){
            $lista[] = $obj;
        }
          return $lista;
    }
    
    public function inserir($obj)
    {
        //Monta os parâmetros
        $parametros = array(
        	':nome' => $obj->nome
        );
        
        //prepara o sql
        $sql = "INSERT INTO marca (nome) VALUES (:nome)";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
        
        return $retorno->rowCount();
        
    }
    
    public function excluir($chaveprimaria)
    {
    	$hoje = Date("d/m/y");
        $sql = "UPDATE marca SET data_exclusao = '$hoje' WHERE idmarca = :idmarca";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":idmarca", $chaveprimaria);
        $retorno->execute();
        
        return $retorno->rowCount();
    }
    
    public function alterar($obj)
    {
        $parametros = array(
         ':idmarca' => $obj->idmarca,
        ':nome' => $obj->nome
        );
        
        $sql = "UPDATE marca SET nome = :nome WHERE idmarca= :idmarca";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
        
        return $retorno->rowCount();
    }
    
    public function buscarChavePrimaria($chaveprimaria){
        $sql = "SELECT nome FROM marca WHERE idmarca = :idmarca";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":idmarca",$chaveprimaria);
        $retorno->execute();
        
        if($obj = $retorno->fetchObject()){
            return $obj;
        }
        else{
            return null;
        }
         
    }
}
