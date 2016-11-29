<?php
	
	require '../dao/GeneroDAO.class.php';
	require '../modelo/Genero.class.php';

	//instanciar o objeto Genero
	
	//pego os campos do formulário e preencho a classe
	$genero = new Genero();
	$dao = new GeneroDAO();
	$genero -> idgenero = $_POST["id"];
	$genero -> nome = $_POST["nome"];

	//Chamo a DAO e mando inserir

	if ((!isset($_POST['id'])) || ($_POST['id'] == '')){		
		$retorno = $dao->inserir($genero);		
	}
	
	else{		
		$retorno = $dao->alterar($genero);		
	}
	
	echo json_encode($retorno);
?>        

