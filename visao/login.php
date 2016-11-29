<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php
		require("head.php");
		
		require("cabecalho.php");
		
		   if(isset($_POST["btentrar"])) {
            session_start();
            $dao = new UsuarioDAO();
            $obj = $dao->loginUsuario($_POST["txtusername"]);
        
            if($obj != NULL) {
                
                if ($obj->senha == $_POST["txtsenha"]) {
                $_SESSION["usuario"] = $_POST["txtusername"];
                header("location:html/veterinario/index.php");
                
                }
            }
        else {
            $msg = "Login ou senha incorretos!";
            }

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
					var dados = $('#cadAtendente').serialize();		
					if ($("input[name=usuario]").val() != "") {
						var r=confirm("Alterar o registro selecionado?");
						if (r==false) {
							return false;
						}
					}

					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: 'login_save.php',
						async: true,
						data: dados,
						success: function(response) {
							location.reload();
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
					$("input[id=usuario]").focus();		
				});

				$("#mascara").click(function() {
					$(this).hide();
					$(".window").hide();
				});

				$('.fechar').click(function(ev) {
					ev.preventDefault();
					$("#mascara").hide();
					$(".window").hide();
					$('#cadAtendente input[type=text]').each(function(){
						$(this).val('');
					});
				});
			});
		</script>
		
			<div id="content" class="container_16 clearfix">				
				<div class="window grid_4" id="editar">
					<a href="#" class="fechar">X Fechar</a>
					<h4>Usuario</h4>
					<form id="cadAtendente" action="" method="POST">
						<label>Usu&aacute;rio:</label> <input type="text" id="usuario" maxlength=40 name="usuario" />
						<br/><br/>
						<label>Senha:</label> <input type="password" id="senha" maxlength=10 name="senha" />						<br/><br/>
						<label>Nome:</label> <input type="text" id="nome" maxlength=60 name="nome" />
						<br/><br/><br/>
						<input type="submit" value="Salvar" id="salvar"/>
					</form>
				</div>
				
				<a href='#editar' rel='popup' class='add' id='salvar'><img src="images/1460591802_199_CircledPlus.png"></a>

				<div class="grid_7 alinha_centro">
					<form action="login-save.php?acao=login" method="post" name="formulario" onSubmit="return valida()">
					<h2>Login</h2>
					<p>
						<label for="usuario">Usu&aacute;rio: <small>Must contain alpha-numeric characters.</small></label>
						<input type="text" id="txtusuario" name="txtusuario" />
						<label for="senha">Senha: <small>Must contain alpha-numeric characters.</small></label>
						<input type="password" id="txtsenha" name="txtsenha" />		
					</p>
					<p class="submit alinha_centro">
						<input type="reset" value="Reset" />
						<input type="submit" value="Post" name="btentrar"/>
					</p>
				</div>
			</div>
		
		<div id="foot">
			<a href="#">Contact Me</a>				
		</div>
		<div id="mascara"></div>
	</body>
</html>
