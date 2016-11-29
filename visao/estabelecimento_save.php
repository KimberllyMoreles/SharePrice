<?php
	
	require '../dao/EstabelecimentoDAO.class.php';
	require '../modelo/Estabelecimento.class.php';

	//instanciar o objeto Estabelecimento
	
	//pego os campos do formulário e preencho a classe
	$estabelecimento = new Estabelecimento();
	$dao = new EstabelecimentoDAO();
	$estabelecimento -> idestabelecimento = $_POST["id"];
	$estabelecimento -> nome = $_POST["nome"];
	$estabelecimento -> endereco = $_POST["endereco"];
	$estabelecimento -> telefone = $_POST["telefone"];

	//Chamo a DAO e mando inserir

	if ((!isset($_POST['id'])) || ($_POST['id'] == '')){		
		$retorno = $dao->inserir($estabelecimento);		
	}
	
	else{		
		$retorno = $dao->alterar($estabelecimento);		
	}
	
	echo json_encode($retorno);
?>        

