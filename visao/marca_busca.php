<?php
	require '../dao/MarcaDAO.class.php';
	require '../modelo/Marca.class.php';
	
	$dao = new MarcaDAO();
	$id = $_POST['id'];
	
	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$retorno = $dao -> buscarChavePrimaria($id);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
 
?>
