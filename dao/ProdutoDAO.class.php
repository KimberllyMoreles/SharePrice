<?php

require_once 'Conexao.class.php';
class ProdutoDAO {
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
        $sql = "SELECT 
        		p.idprod,
        		p.nomeprod AS produto,
        		g.nome AS genero,
        		m.nome AS marca
        	   FROM 
        	   	produto p
        	   LEFT JOIN 
        	   		genero g 
        	   	ON 
        	   		g.idgenero = p.idgenero
        	   LEFT JOIN
        	   		marca m
        	   	ON
        	   		m.idmarca = p.idmarca
        	   WHERE 
        	   	p.data_exclusao IS NULL";
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
        ':nomeprod' => $obj->nomeprod,
        'idgenero' => $obj->idgenero,
        ':idmarca' => $obj->idmarca
        );
    
        //prepara o sql
        $sql = "INSERT INTO produto(nomeprod, idgenero, idmarca) VALUES(:nomeprod, :idgenero, :idmarca)";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
             
        
        return $this->pdo->lastInsertId('produto_idprod_seq');
    }
    
    public function excluir($chaveprimaria) {
    	$hoje = Date("d/m/y");
        $sql = "UPDATE 
        		produto 
        	    SET 
        	    	data_exclusao = '$hoje' 
        	    WHERE 
        	    	idprod = :idprod";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":idprod", $chaveprimaria);
        $retorno->execute();
         
        return $retorno->rowCount();
    }
    
    public function alterar($obj)
    {
        $parametros = array(
         ':idprod' => $obj->idprod,
        ':nomeprod' => $obj->nomeprod,
        'idgenero' => $obj->idgenero,
        ':idmarca' => $obj->idmarca
        );
        
        $sql = "UPDATE produto SET "
                . "nomeprod = :nomeprod, "
                . "idgenero= :idgenero,"
                . "idmarca= :idmarca"
                . " WHERE idprod= :idprod";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);        
     	
        return $retorno->rowCount();
    }
    
    public function buscarChavePrimaria($chaveprimaria)
    {
        $sql = "SELECT * FROM produto WHERE idprod = :idprod";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":idprod",$chaveprimaria);
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
