<?php
	require 'Conexao.class.php';
	
	class UsuarioDAO {
		private $pdo;
	    
		public function __construct(){
			//AQUI é feita a conexão com o Banco
			$conexao = new Conexao();
			$this->pdo = $conexao->getPDO();
		}
	    
		public function inserir($obj){
			//Monta os parâmetros
			$parametros = array(
				':usuario' => $obj->usuario,
				':senha' => $obj->senha,
				':nome' => $obj->nome
			);

			//prepara o sql
			$sql = "INSERT INTO usuario (usuario, senha, nome) VALUES (:usuario, :senha, :nome)";
			$retorno = $this->pdo->prepare($sql);
			$retorno->execute($parametros);

			return $retorno->rowCount();
		}
	    
		public function buscarChavePrimaria($chaveprimaria){
			$sql = "SELECT * FROM livro WHERE cod_livro = :cod_livro";
			$retorno = $this->pdo->prepare($sql);
			$retorno->bindParam(":cod_livro",$chaveprimaria);
			$retorno->execute();

			if($obj = $retorno->fetchObject()){
				return $obj;
			}
			else{
				return null;
			}
		}
	}
