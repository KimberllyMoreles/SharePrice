<?php
	
	require_once '../dao/ProdutoDAO.class.php';
	require_once '../modelo/Produto.class.php';
	require_once '../dao/ProdEstDAO.class.php';
	require_once '../modelo/ProdEst.class.php';

	//instanciar o objeto Produto
	
	//pego os campos do formulário e preencho a classe
	$produto = new Produto();
	$dao = new ProdutoDAO();
	
	$produto -> nomeprod = $_POST["nome"];
	$produto -> idgenero = $_POST["genero"];
	$produto -> idmarca = $_POST["marca"];

	//Chamo a DAO e mando inserir

	if ((!isset($_POST['id'])) || ($_POST['id'] == '')){		
		$retornob = $dao->inserir($produto);
		$id = $retornob;
        
		$prodEst = new ProdEst();
		$dao = new ProdEstDAO();

		$prodEst -> idprod = $id;
		$prodEst -> idestabelecimento =  $_POST["estabelecimento"];
		$prodEst -> preco = $_POST["preco"];
		$prodEst -> data = $_POST["inicio"];
	
		$retorno = $dao->inserir($prodEst);		
	}
	
	else{		
		$produto -> idprod = $_POST["id"];	
		$retorno = $dao->alterar($produto);		
	}
	
	echo json_encode($retorno);
?>        

