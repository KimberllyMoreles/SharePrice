<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php
		require("head.php");
		require("cabecalho.php");
		require '../dao/MarcaDAO.class.php';
		
		if (isset($_GET['acao'])=='excluir'){
			$dao = new MarcaDAO();
			$chaveprimaria = $_GET['idmarca'];
			$retorno = $dao -> excluir($chaveprimaria);
			echo '<script language="Javascript">
					    location.href="marca.php";
					  </script>';
		}
		
		if (isset($_GET['retorno'])){
			switch ($_GET['retorno']) {
				case 1:
					echo '<script language="Javascript">
					    alert("Registro excluído com sucesso!");
					  </script>';
					break;
				case 2:
					echo '<script language="Javascript">
					    alert("Registro nao pode ser excluído!");
					  </script>';
					break;
				case 3:
					echo '<script language="Javascript">
					    alert("Registro alterado com sucesso!");
					  </script>';
					break;
				case 4:
					echo '<script language="Javascript">
					    alert("Não foi possível alterar! Verifique os dados e tente novamente.");
					    history.back();
					  </script>';
					break;
				case 5:
					echo '<script language="Javascript">
					    alert("Registro salvo com sucesso!");
					  </script>';
					break;
				case 6:
					echo '<script language="Javascript">
					    alert("Não foi possível salvar! Verifique os dados e tente novamente.");
					    history.back();
					  </script>';
					break;
			}
		}
		
		$dao = new MarcaDAO();  
		
		$lista = $dao->listar(); 
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

				$('#salvar').click(function() {
					var dados = $('#cadMarca').serialize();
					if ($("input[name=id]").val() != "") {
						var r=confirm("Alterar o registro selecionado?");
						if (r==false) {
							return false;
						}
					}

					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: 'marca_save.php',
						async: true,
						data: dados,
						success: function(response) {
							if(response > 0){
								alert("Adicionado com sucesso");
							}
							else{
								alert("Erro ao adicionar");
							}							
							$('#cadMarca input[id=id]').val('');
							$('#cadMarca input[id=nome]').val('');
							location.href='marca.php';
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
					var left = ($(window).width() / 3.5) - ($(id).width() / 3.5);
					var top = ($(window).height() / 3.5) - ($(id).height() / 3.5);
					$(id).css({'top': top, 'left': left});
					$(id).show();
					$("input[id=nome]").focus();		
				});
		
				$("#example").on('click','a[rel=modal]',function(ev) {
					valor = $(this).attr("valor");		
					if (valor != null) {
						$.ajax({
							type: 'POST',
							dataType: 'json',
							url: 'marca_busca.php',
							async: true,
							data: { id: valor},
							success: function(response) {
								$("input[name=id]").val(valor);
								$("input[name=nome]").val(response.nome);	                    
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
					var left = ($(window).width() / 3.5) - ($(id).width() / 3.5);
					var top = ($(window).height() / 3.5) - ($(id).height() / 3.5);
					$(id).css({'top': top, 'left': left});
					$(id).show();
					$("input[id=nome]").focus();			
				});

				$("#mascara").click(function() {
					$(this).hide();
					$(".window").hide();					
					$("#cadMarca input[id=id]").val('');
					$("#cadMarca input[id=nome]").val('');
				});

				$('.fechar').click(function fechar(ev) {
					ev.preventDefault();
					$("#mascara").hide();
					$(".window").hide();
					$("#cadMarca input[id=id]").val('');
					$("#cadMarca input[id=nome]").val('');
				});
			});
		</script>
		
			<div id="content" class="container_16 clearfix">
			
				<div class="grid_4">
					<h2>Marcas/Editoras</h2>
					
				</div>
				
				<div class="window grid_4" id="editar">
					<a href="#" class="fechar">X Fechar</a>
					<h4>Marca/Editora</h4>
					<form id="cadMarca" action="" method="POST">					
						<input type="hidden" id="id" maxlength=60 name="id" />
						<label>Nome:</label> <input type="text" id="nome" maxlength=60 name="nome" />
						<br/><br/><br/>
						<input type="submit" value="Salvar" id="salvar"/>
					</form>
				</div>
				
				<a href='#editar' rel='popup' class='add' id='salvar'><img src="images/1460591802_199_CircledPlus.png"></a>

				<div class="grid_16">
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Marca</th>
								<th>Ações</th>
								<th></th>
							</tr>
						</thead>
				
						<tbody>
							 <?php
							 	if($lista != 0){
									foreach($lista as $obj){
										$id = $obj -> idmarca;
										$nome = $obj -> nome;
                                			echo "							
<tr>
	<td>$nome</td>	
	<td><a href='#editar' rel='modal' class='salvar' id='salvar' name='salvar' title='Editar' valor='$id'> Editar</a></td>";?>
	<td><a href="marca.php?acao='excluir'&&idmarca=<?php echo  $id?>" onClick="return valida_exc()" class="delete">Excluir</a></td>
</tr>
							 
							<?php       
								}
						 	}	
							else{
							 echo "<tr><td colspan = '4' >Nenhum registro encontrado no banco de dados!</td></tr>";
							}
							?>

						</tbody>

						<tfoot>
							<tr>
								<th>Marca</th>
								<th>Ações</th>
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
	</body>
</html>
