<?php
	require '../dao/GeneroDAO.class.php';
	require '../modelo/Genero.class.php';
	
	$dao = new GeneroDAO();
	$id = $_POST['id'];
	
	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$retorno = $dao -> buscarChavePrimaria($id);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
 
?>
