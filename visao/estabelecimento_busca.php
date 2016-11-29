<?php
	require '../dao/EstabelecimentoDAO.class.php';
	require '../modelo/Estabelecimento.class.php';
	
	$dao = new EstabelecimentoDAO();
	$id = $_POST['id'];
	
	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$retorno = $dao -> buscarChavePrimaria($id);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
 
?>
