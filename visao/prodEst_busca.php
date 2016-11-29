<?php
	require '../dao/ProdEstDAO.class.php';
	require '../modelo/ProdEst.class.php';
	
	$dao = new ProdEstDAO();
	$id = $_POST['id'];	
	
	$retorno = $dao -> listar($id);
	
	echo json_encode($retorno); 
?>
