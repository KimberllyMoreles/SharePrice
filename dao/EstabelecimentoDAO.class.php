<?php

require_once 'Conexao.class.php';
class EstabelecimentoDAO {
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
        $sql = "SELECT * FROM estabelecimento WHERE data_exclusao IS NULL";
       
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
        ':nome' => $obj->nome,
        'endereco' => $obj->endereco,
        ':telefone' => $obj->telefone
        );
        
        //prepara o sql
        $sql = "INSERT INTO estabelecimento(nome, endereco, telefone) VALUES(:nome, :endereco, :telefone)";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
        
        return $retorno->rowCount();
        
    }
    
    public function excluir($chaveprimaria)
    {
    	$hoje = Date("d/m/y");
        $sql = "UPDATE estabelecimento SET data_exclusao = '$hoje' WHERE idestabelecimento = :idestabelecimento";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":idestabelecimento", $chaveprimaria);
        $retorno->execute();
        
        return $retorno->rowCount();
    }
    
    public function alterar($obj)
    {
        $parametros = array(
         ':idestabelecimento' => $obj->idestabelecimento,
        ':nome' => $obj->nome,
        'endereco' => $obj->endereco,
        ':telefone' => $obj->telefone
        );
        
        $sql = "UPDATE estabelecimento SET "
                . "nome = :nome, "
                . "endereco= :endereco,"
                . "telefone= :telefone "
                . " WHERE idestabelecimento= :idestabelecimento";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
        
        return $retorno->rowCount();
    }
    
    public function buscarChavePrimaria($chaveprimaria)
    {
        $sql = "SELECT * FROM estabelecimento WHERE idestabelecimento = :idestabelecimento";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":idestabelecimento",$chaveprimaria);
        $retorno->execute();
        
        if($obj = $retorno->fetchObject())
        {
            return $obj;
        }
        else
        {
            return null;
        }
         
    }
}
