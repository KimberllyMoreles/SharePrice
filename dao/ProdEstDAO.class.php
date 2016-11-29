<?php

require_once 'Conexao.class.php';
class ProdEstDAO {
    private $pdo;
    
    public function __construct(){
        //AQUI é feita a conexão com o Banco
        $conexao = new Conexao();
        $this->pdo = $conexao->getPDO();
    }
    //Listar
    public function listar($idprod)
    {   
        $parametros = Array();
        $sql = "SELECT 
        		p.nomeprod AS produto,
        		e.nome AS estabelecimento,
        		pe.preco,
        		pe.data,
        		pe.idprod,
        		pe.idestabelecimento
        	    FROM 
        	    	prodest pe
        	    LEFT JOIN 
        	    		estabelecimento e
        	    	ON 
        	    		e.idestabelecimento = pe.idestabelecimento
        	    LEFT JOIN 
				produto p
			ON
        	    		p.idprod = pe.idprod
        	    WHERE 
        	    	pe.idprod = $idprod
        	    AND
        	    	pe.data_exclusao IS NULL";
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
        ':idprod' => $obj->idprod,
        'idestabelecimento' => $obj->idestabelecimento,
        ':preco' => $obj->preco,
        ':data' => $obj->data
        );
    
        //prepara o sql
        $sql = "INSERT INTO 
        		prodest(idprod, idestabelecimento, preco, data) 
        	   VALUES
        	   	(:idprod, :idestabelecimento, :preco, :data)";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
        
        return $retorno->rowCount();
        
    }
    
    public function excluir($idprod, $idestabelecimento, $data) {
    	$hoje = Date("d/m/y");
        $sql = "UPDATE 
        		prodest 
        	   SET 
        	   	data_exclusao = '$hoje' 
        	   WHERE 
        	   	idprod =$idprod 
        	   AND 
        	   	idestabelecimento=$idestabelecimento 
        	   AND 
        	   	data='$data'";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute();
        
        return $retorno->rowCount();
    }
    
    public function alterar($obj)
    {
        $parametros = array(
         ':data' => $obj->data,
        ':idprod' => $obj->idprod,
        'idestabelecimento' => $obj->idestabelecimento,
        ':preco' => $obj->preco
        );
        
        $sql = "UPDATE 
        		prodest 
        	   SET 
        	   	idprod = :idprod, 
                	idestabelecimento= :idestabelecimento,
                	preco= :preco,
                	data=:data
                 WHERE 
                 	idprod= :idprod
                 AND 
        	   	idestabelecimento=:idestabelecimento 
        	 AND 
        	   	data=:data";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
              
        return $retorno->rowCount();
    }
    
    public function buscar($idprod)
    {
        $sql = "SELECT * FROM 
        		prodest 
        	   WHERE 
        	   	idprod = $idprod
        	   AND 
        	   	data_exclusao IS NULL";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute();
        
      	return $retorno->rowCount();
         
    }
}
