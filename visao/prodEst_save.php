<?php
	
	require '../dao/ProdEstDAO.class.php';
	require '../modelo/ProdEst.class.php';

	//instanciar o objeto ProdEst
	
	//pego os campos do formulário e preencho a classe
	$prodEst = new ProdEst();
	$dao = new ProdEstDAO();
	$prodEst -> idestabelecimento = $_POST["estabelecimento"];
	$prodEst -> idprod = $_POST["id"];
	$prodEst -> data = $_POST["data"];
	$prodEst -> preco = $_POST["preco"];

	//Chamo a DAO e mando inserir

	
		$retorno = $dao->inserir($prodEst);		
	
	
	echo json_encode($retorno);
?>        

