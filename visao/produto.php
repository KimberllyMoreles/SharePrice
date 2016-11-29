<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php
		require("head.php");
		require("cabecalho.php");
		require '../dao/ProdutoDAO.class.php';
		require '../dao/ProdEstDAO.class.php';
		require '../dao/GeneroDAO.class.php';
		require '../dao/MarcaDAO.class.php';
		require '../dao/EstabelecimentoDAO.class.php';
				
		if (isset($_GET['acao'])=='excluir'){
			$dao = new ProdutoDAO();
			$chaveprimaria = $_GET['idprod'];
			$retorno = $dao -> excluir($chaveprimaria);
			echo '<script language="Javascript">
					    location.href="produto.php";
					  </script>';	
		}
		
		if (isset($_GET['action'])=='excluirpe'){
			$daope = new ProdEstDAO();
			$idprod = $_GET['idprod'];
			$retornot = $daope -> buscar($idprod);
			
			if($retornot < 2){
				echo '<script language="Javascript">
					    alert("Registro nao pode ser excluído!");
					    location.href="produto.php";
					  </script>';						
			}
			else{
				$idestabelecimento = $_GET['idestabelecimento'];
				$data = $_GET['data'];
				$retorno = $daope -> excluir($idprod, $idestabelecimento, $data);
				echo '<script language="Javascript">
					    location.href="produto.php";
					  </script>';	
			}
		}
		
		$dao = new ProdutoDAO();  
		$daoG = new GeneroDAO();
		$daoM = new MarcaDAO();
		$daoE = new EstabelecimentoDAO();
		
		$lista = $dao->listar(); 
		$gLista = $daoG -> listar();
		$mLista = $daoM -> listar();
		$eLista = $daoE -> listar();
	?>
		
		<script type="text/javascript" language="javascript">
			function valida_exc() {
				var retorno = confirm('Confirma exclusao do registro?');
				return (retorno);
			}

			$(document).ready(function() {
				$('#example').DataTable({
					"order": [1, "desc"],
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
					}
				});
				
				/*
				*
				*
				* SALVAR
				*
				*
				*/	
				
				$('#salvar').click(function() {
					var dados = $('#cadProduto').serialize();
					if ($("input[name=id]").val() != "") {
						var r=confirm("Alterar o registro selecionado?");
						if (r==false) {
							return false;
						}
					}

					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: 'produto_save.php',
						async: true,
						data: dados,
						success: function(response) {
							if(response > 0){
								alert("Adicionado com sucesso");
							}
							else{
								alert("Erro ao adicionar");
							}							
							$('#cadProduto input[id=id]').val('');
							$('#cadProduto input[id=nome]').val('');
							$("select[name=genero]").val('');
							$("select[name=marca]").val('');
							$("select[name=estabelecimento]").val('');
							$('#cadProduto input[id=preco]').val('');
							$('#cadProduto input[id=inicio]').val('');
							location.href='produto.php';
						}
					});
					return false;
				}); 

				$("a[rel=popup]").click(function(ev) {		
					ev.preventDefault();
					var id = $(this).attr("href");
					var alturaTela = $(document).height();
					var larguraTela = $(window).width();
					$('#mascara').css({'width': larguraTela, 'height': alturaTela});
					$('#mascara').fadeIn(500);
					$('#mascara').fadeTo("slow", 0.8);
					var left = ($(window).width() / 5) - ($(id).width() / 5);
					var top = ($(window).height() / 4) - ($(id).height() / 2);
					$(id).css({'top': top, 'left': left});
					$(id).show();
					$("input[id=nome]").focus();		
				});
				
				/*
				*
				*
				* EDITAR
				*
				*
				*/				
					
				$("#example").on('click','a[rel=modal]',function(ev) {
					valor = $(this).attr("valor");	
					
					$("#cadProduto select[name=estabelecimento]").prop('disabled', true);
					$('#cadProduto input[id=preco]').prop('disabled', true);
					$('#cadProduto input[id=inicio]').prop('disabled', true);  				
					$('#cadProduto input[id=bt_inicio]').prop('disabled', true);	
					
					if (valor != null) {
						$.ajax({
							type: 'POST',
							dataType: 'json',
							url: 'produto_busca.php',
							async: true,
							data: { id: valor},
							success: function(response) {
								$('#cadProduto input[id=id]').val(valor);
								$('#cadProduto input[id=nome]').val(response.nomeprod);
								$("#cadProduto select[name=genero]").val(response.idgenero);
								$("#cadProduto select[name=marca]").val(response.idmarca);
								$("#cadProduto select[name=estabelecimento]").prop('disabled', true);
								$('#cadProduto input[id=preco]').prop('disabled', true);
								$('#cadProduto input[id=inicio]').prop('disabled', true);  				
								$('#cadProduto input[id=bt_inicio]').prop('disabled', true);	
							}
						});				
					}
			
					ev.preventDefault();
					var id = $(this).attr("href");
					var alturaTela = $(document).height();
					var larguraTela = $(window).width();
					$('#mascara').css({'width': larguraTela, 'height': alturaTela});
					$('#mascara').fadeIn(500);
					$('#mascara').fadeTo("slow", 0.8);
					var left = ($(window).width() / 5) - ($(id).width() / 5);
					var top = ($(window).height() / 4) - ($(id).height() / 2);
					$(id).css({'top': top, 'left': left});
					$(id).show();
					$("input[id=nome]").focus();			
				});
				
				/*
				*
				*
				* PRODEST
				*
				*
				*/	
				
				/*
				*
				*
				* SALVAR
				*
				*
				*/	
				
				$('#salvarpe').click(function() {
					var dados = $('#cadProdEst').serialize();

					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: 'prodEst_save.php',
						async: true,
						data: dados,
						success: function(response) {
							if(response > 0){
								alert("Adicionado com sucesso");
							}
							else{
								alert("Erro ao adicionar");
							}							
							$('#cadProdEst input[id=id]').val('');
							$("#cadProdEst select[name=estabelecimento]").val('');
							$('#cadProdEst input[id=preco]').val('');
							$('#cadProdEst input[id=data]').val('');
							location.href='produto.php';
						}
					});
					return false;
				}); 

				$("a[rel=popuppe]").click(function(ev) {		
					ev.preventDefault();
					var id = $(this).attr("href");
					var alturaTela = $(document).height();
					var larguraTela = $(window).width();
					$('#mascara').css({'width': larguraTela, 'height': alturaTela});
					$('#mascara').fadeIn(500);
					$('#mascara').fadeTo("slow", 0.8);
					var left = ($(window).width() / 4) - ($(id).width() / 5);
					var top = ($(window).height() / 4) - ($(id).height() / 2);
					$(id).css({'top': top, 'left': left});
					$(id).show();
					$("input[id=nome]").focus();		
				});
				
				$("#example").on('click','a[rel=prodEst]',function(ev) {
					valor = $(this).attr("valor");
					
					$('#tab_prodEst').empty();	
					if (valor != null) {
						$.ajax({
							type: 'POST',
							dataType: 'json',
							url: 'prodEst_busca.php',
							async: true,
							data: { id: valor},
							success: function(response) {	
								$("#cadProdEst input[id=id]").val(valor);					
								$("#nomeproduto").text(response[0].produto);
								var excluir = 'excluirpe';
								for(var i=0;response.length>i;i++){							
									//Adicionando registros retornados na tabela									
									$('#tab_prodEst').append('<tr><td>'+
									response[i].estabelecimento+'</td><td>'+
									response[i].preco+'</td><td>'+
									response[i].data+'</td>'+
			"<td><a href='produto.php?action=" + excluir +"&&idprod="+
				response[i].idprod+"&&idestabelecimento="+
				response[i].idestabelecimento+"&&data="+
				response[i].data + "' onClick='return valida_exc()' class='delete'>Excluir</a></td></tr>");
								}
							}
						});				
					}
			
					ev.preventDefault();
					var id = $(this).attr("href");
					var alturaTela = $(document).height();
					var larguraTela = $(window).width();
					$('#mascarab').css({'width': larguraTela, 'height': alturaTela});
					$('#mascarab').fadeIn(500);
					$('#mascarab').fadeTo("slow", 0.8);
					var left = ($(window).width() / 3) - ($(id).width() / 2);
					var top = ($(window).height() / 4) - ($(id).height()/1.5);
					$(id).css({'top': top, 'left': left});
					$(id).show();
					//$("input[id=nome]").focus();			
				});
							
				$("#mascara").click(function() {
					$(this).hide();
					$(".window").hide();						
					$('#cadProduto input[id=id]').val('');
					$('#cadProduto input[id=nome]').val('');
					$("select[name=genero]").val('');
					$("select[name=marca]").val('');
					$("select[name=estabelecimento]").val('');
					$('#cadProduto input[id=preco]').val('');
					$('#cadProduto input[id=inicio]').val('');
					$('#cadProdEst input[id=id]').val('');
					$("#cadProdEst select[name=estabelecimento]").val('');
					$('#cadProdEst input[id=preco]').val('');
					$('#cadProdEst input[id=data]').val('');
				});
				
				$("#mascarab").click(function() {
					$(this).hide();
					$(".windowb").hide();						
					$('#cadProduto input[id=id]').val('');
					$('#cadProduto input[id=nome]').val('');
					$("select[name=genero]").val('');
					$("select[name=marca]").val('');
					$("select[name=estabelecimento]").val('');
					$('#cadProduto input[id=preco]').val('');
					$('#cadProduto input[id=inicio]').val('');
				});

				$('.fechar').click(function fechar(ev) {
					ev.preventDefault();
					$("#mascara").hide();
					$(".window").hide();
					$('#cadProduto input[id=id]').val('');
					$('#cadProduto input[id=nome]').val('');
					$("select[name=genero]").val('');
					$("select[name=marca]").val('');
					$("select[name=estabelecimento]").val('');
					$('#cadProduto input[id=preco]').val('');
					$('#cadProduto input[id=inicio]').val('');
					$('#cadProdEst input[id=id]').val('');
					$("#cadProdEst select[name=estabelecimento]").val('');
					$('#cadProdEst input[id=preco]').val('');
					$('#cadProdEst input[id=data]').val('');
				});
				
				$('.fecharb').click(function fechar(ev) {
					ev.preventDefault();
					$("#mascarab").hide();
					$(".windowb").hide();
					$('#cadProduto input[id=id]').val('');
					$('#cadProduto input[id=nome]').val('');
					$("select[name=genero]").val('');
					$("select[name=marca]").val('');
					$("select[name=estabelecimento]").val('');
					$('#cadProduto input[id=preco]').val('');
					$('#cadProduto input[id=inicio]').val('');
				});
			});
		</script>
		
			<div id="content" class="container_16 clearfix">
			
				<div class="grid_4">
					<h2>Produtos</h2>					
				</div>
				
				<div class="window grid_11" id="editar">
					<a href="#" class="fechar">X Fechar</a>
					<h4>Produto</h4>
					
					<form id="cadProduto" action="" method="POST">					
						<input type="hidden" id="id" name="id" />
						
						<div class="grid_4 form">
							<p>
								<label>Produto:</label> <input type="text" class="grid_4" id="nome" maxlength=60 name="nome" />
								<br/><br/>
							</p>
							<p>
								<label>G&ecirc;nero</label>
								<select name="genero" class="grid_5">
									<option value="">Escolha um g&ecirc;nero:</option><?php							
									foreach($gLista as $objg){
										$idgenero = $objg -> idgenero;
										$nomeg = $objg -> nome;							
										echo "<option value='$idgenero' >$nomeg</option>";	
									}?>									
								</select><br/><br/>
							</p>
							<p>
								<label>Pre&ccedil;o:</label> <input type="text" id="preco" class="grid_4" maxlength=9 name="preco" /><small>Formato: 35.00</small>
							</p>
						</div>
						<div class="grid_4">
							<p>
								<label>Marca</label>
								<select name="marca" class="grid_5">
									<option value="">Escolha uma marca:</option><?php								
									foreach($mLista as $objm){
										$idmarca = $objm -> idmarca;
										$nomem = $objm -> nome;							
										echo "<option value='$idmarca' >$nomem</option>";	
									}?>									
								</select><br/><br/>
							</p>				
							<p>
								<label>Estabelecimento</label>
								<select name="estabelecimento" class="grid_5">
									<option value="">Escolha um estabelecimento:</option><?php								
									foreach($eLista as $obje){
										$idestabelecimento = $obje -> idestabelecimento;
										$nomee = $obje -> nome;
										echo "<option value='$idestabelecimento' >$nomee</option>";	
									}?>									
								</select><br/><br/>	
							</p>
							
							<label>Data</label>						
							<div>	
								<p class="grid_5">	
									<tr>
										<td>
											<input type='text' id='inicio' name='inicio' class="grid_4" size='20' value=''>
											<input type="reset" id="bt_inicio" value=" ... ">

											<script type="text/javascript">
												Calendar.setup({
													inputField	 :	"inicio",
													ifFormat	   :	"%d/%m/%Y %H:%M:%S",
													showsTime	  :	true,
													button		 :	"bt_inicio",
													singleClick	:	true,
													step		   :	1,
													disableFunc: function(date) {
														var now= new Date();
														return (date.getTime() > now.getTime());
													}
												});
											</script>			
										</td>
									</tr>
								</p>
							</div>							
						</div>	
						
						<br/><br/>
						<div class="grid_4">
							<p>
								<input type="reset" value="Limpar" id="limpa"/>
								<input type="submit" value="Salvar" id="salvar"/>
							</p>
						</div>
					</form>
				</div>
				
				<a href='#editar' rel='popup' class='add' id='salvar'><img src="images/1460591802_199_CircledPlus.png"></a>
							
				<div class="window grid_5" id="editarpe">
					<a href="#" class="fechar">X Fechar</a>
					<h4>Pre&ccedil;os</h4>
					
					<form id="cadProdEst" action="" method="POST">					
						<input type="hidden" id="id" name="id" />
						
						<div class="grid_4 form">
							
							<p>
								<label>Pre&ccedil;o:</label> <input type="text" id="preco" class="grid_4" maxlength=9 name="preco" /><small>Formato: 35.00</small>
							</p>
							
							<p>
								<label>Estabelecimento</label>
								<select name="estabelecimento" class="grid_5">
									<option value="">Escolha um estabelecimento:</option><?php								
									foreach($eLista as $obje){
										$idestabelecimento = $obje -> idestabelecimento;
										$nomee = $obje -> nome;
										echo "<option value='$idestabelecimento' >$nomee</option>";	
									}?>									
								</select><br/><br/>	
							</p>
							
							<label>Data</label>						
							<div>	
								<p class="grid_5">	
									<tr>
										<td>
											<input type='text' id='data' name='data' class="grid_4" size='20' value=''>
											<input type="reset" id="bt_data" value=" ... ">

											<script type="text/javascript">
												Calendar.setup({
													inputField	 :	"data",
													ifFormat	   :	"%d/%m/%Y %H:%M:%S",
													showsTime	  :	true,
													button		 :	"bt_data",
													singleClick	:	true,
													step		   :	1,
													disableFunc: function(date) {
														var now= new Date();
														return (date.getTime() > now.getTime());
													}
												});
											</script>			
										</td>
									</tr>
								</p>
							</div>							
						
							<p>
								<input type="reset" value="Limpar" id="limpa"/>
								<input type="submit" value="Salvar" id="salvarpe"/>
							</p>
						</div>
					</form>
				</div>
				
				<div class="windowb grid_13" id="prodEst">
					<a href="#" class="fecharb">X Fechar</a>
					<h4>Hist&oacute;rico de Pre&ccedil;os</h4>
					<h5>
						<table class="smp">
							<tr>
								<td class="smp"><div id="nomeproduto" name="nomeproduto" ></div></td>
								<input type="hidden" id="id" name="id" />
								<td class="smp"><a href='#editarpe' rel='popuppe' id='salvarpe'><img src="images/circle.png"></a></td>
							</tr>
						</table>						
					</h5>
					
					<table id="tablepe" name="tablepe" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Estabelecimento</th>
								<th>Pre&ccedil;o</th>
								<th>Data</th>
								<th>A&ccedil;&otilde;es</th>								
								<th></th>
							</tr>
						</thead>
				
						<tbody id="tab_prodEst" name="tab_prodEst">							 				
							<!--<tr>
								<td id="tdproduto" name="tdproduto"></td>
								<td id="tdestabelecimento" name="tdestabelecimento"></td>
								<td id="tdpreco" name="tdpreco"></td>
								<td id="tddata" name="tddata"></td>
								<td><a href='#editar' rel='modal' class='salvar' id='salvar' name='salvar' title='Editar' valor='$id'> Editar</a></td>
								<td><a href="produto.php?acao='excluir'&&idprod=<?php echo  $id?>" onClick="return valida_exc()" class="delete">Excluir</a></td>
							</tr>-->						 
						</tbody>

						<tfoot>
							<tr>
								<th>Estabelecimento</th>
								<th>Pre&ccedil;o</th>
								<th>Data</th>
								<th>A&ccedil;&otilde;es</th>								
								<th></th>
							</tr>
						</tfoot>
					</table>
				</div>
				
				<div class="grid_16">
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Produto</th>
								<th>G&ecirc;nero</th>
								<th>Marca/Editora</th>
								<th>A&ccedil;&otilde;es</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
				
						<tbody>
							 <?php
							 	if($lista != 0){
									foreach($lista as $obj){
										$idprod = $obj -> idprod;
										$produto = $obj -> produto;
										$genero = $obj -> genero;
										$marca = $obj -> marca;
                                			echo "							
<tr>
	<td>$produto</td>
	<td>$genero</td>
	<td>$marca</td>	"?>
	<td><a href='#prodEst' rel='prodEst' class='prodEst' id='prodEst' name='prodEst' title='Listar' valor='<?php echo  $idprod?>'>Listar pre&ccedil;os</a></td>
	<td><a href='#editar' rel='modal' class='salvar' id='salvar' name='salvar' title='Editar' valor='<?php echo  $idprod?>'> Editar</a></td>
	<td><a href="produto.php?acao='excluir'&&idprod=<?php echo  $idprod?>" onClick="return valida_exc()" class="delete">Excluir</a></td>
</tr>
							 
							<?php       
								}
						 	}	
							else{
								echo "<tr><td colspan = '6' >Nenhum registro encontrado no banco de dados!</td></tr>";
							}
							?>
						</tbody>

						<tfoot>
							<tr>
								<th>Produto</th>
								<th>G&ecirc;nero</th>
								<th>Marca/Editora</th>
								<th>A&ccedil;&otilde;es</th>
								<th></th>
								<th></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		
		<div id="foot">
					<a href="#">Contact Me</a>
				
		</div>
		<div id="mascara"></div>
		<div id="mascarab"></div>
	</body>
</html>
