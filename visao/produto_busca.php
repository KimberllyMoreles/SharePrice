<?php
	require '../dao/ProdutoDAO.class.php';
	require '../modelo/Produto.class.php';
	
	$dao = new ProdutoDAO();
	$id = $_POST['id'];
	
	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$retorno = $dao -> buscarChavePrimaria($id);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
 
?>
