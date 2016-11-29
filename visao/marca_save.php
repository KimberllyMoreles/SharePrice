<?php
	
	require '../dao/MarcaDAO.class.php';
	require '../modelo/Marca.class.php';

	//instanciar o objeto Marca
	
	//pego os campos do formulário e preencho a classe
	$marca = new Marca();
	$dao = new MarcaDAO();
	$marca -> idmarca = $_POST["id"];
	$marca -> nome = $_POST["nome"];

	//Chamo a DAO e mando inserir

	if ((!isset($_POST['id'])) || ($_POST['id'] == '')){		
		$retorno = $dao->inserir($marca);		
	}
	
	else{		
		$retorno = $dao->alterar($marca);		
	}
	
	echo json_encode($retorno);
?>        

