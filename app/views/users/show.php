<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Detail Users");
			auth("yes");
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::show_container_START()?>
							<?if ($User = $dao->Retrieve('User', $params[0], true, true)):?>
								<?HTML::show_header_START();?>
									<div class="span4">
										<h1 class="pull-right" style="color:#FFFFFF"><?=sobreNome($User->nome)?></h1>
									</div>
									<div class="span5">
										<p>Detalhes do Cadastro</p>
									</div>
									<div class="span2 pull-right">
										<?HTML::show_config();?>
									</div>
								<?HTML::show_header_END();?>
								<?HTML::show_content_START();?>
									<? 
										if ($User->rel['itineraries'] != null) {
											$var =  '<h5>Jornada de Trabalho</h5><span class="pull-left"><i class=""></i>'.$User->rel['itineraries']->descricao.'</span><br/><br/><table><tr><td>Entrada:</td><td><span class="label label-success"><i class=" icon-arrow-up"></i> 	'.$User->rel['itineraries']->entrada.'</span></td><tr><td>Intervalo:</td><td><span class="label label-gray"><i class=" icon-arrow-down"></i> 	'.$User->rel['itineraries']->intervalo.'</span></td></tr><tr><td>Retorno:</td><td><span class="label label-info"><i class=" icon-arrow-up"></i> 	'.$User->rel['itineraries']->retorno.'</span></td></tr><tr><td>Saida:</td><td><span class="label label-important"><i class=" icon-arrow-down"></i> 	'.$User->rel['itineraries']->saida.'</span></td></tr>
											</table>';
										}else{
											$var = '<div class="alert alert-info">Usuario sem Horario cadastrado!</div>';
										}
									?>
									<?HTML::show_content_title('PERFIL', '',$var);?>
									<?HTML::show_content_box_START()?>
										<?HTML::show_content_field('NOME', 'icon-user', '&nbsp;'.$User->nome);?>
										<?HTML::show_content_field('MATRICULA', 'icon-user', '&nbsp;'.$User->matricula);?>
										<?HTML::show_content_field('CPF', 'icon-asterisk', '&nbsp;'.$User->cpf);?>
										<?HTML::show_content_field('GRUPO', 'icon-group', '&nbsp;'.$User->rel['users_group']->nome);?>
										<?HTML::show_content_field('EMAIL', 'icon-envelope-alt', '&nbsp;'.$User->email);?>
										<?HTML::show_content_field('SENHA', 'icon-lock', '&nbsp;'.'********');?>
										<?HTML::show_content_field('RESGISTRO', 'icon-calendar', '&nbsp;'.format_date($User->created_at, "/", $t=false));?>
									<?HTML::show_content_box_END()?>
								<?HTML::show_content_END();?>
							<?else:?>
								<div class="alert alert-info">Sem resultados</div>
							<?endif?>
						<?HTML::show_container_END()?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
			<?HTML::container_END();?>
		<?HTML::main_content_END();?>
		<?scripts();?>
		<script>
			$(document).ready(function(){
				$("#paint").hide();
				$(".controller2 #colorir").click(function(){
					$("#paint").slideDown();
				}).dblclick(function(){
					$("#paint").slideUp();
				});
			});
		</script>
	</body>
</html>
