<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Detail Itineraries");
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
							<?if ($Itinerary = $dao->Retrieve('Itinerary', $params[0], true, true)):?>
								<?HTML::show_header_START();?>
									<div class="span4">
										<h1 class="pull-right" style="color:#FFFFFF">Itinerarios</h1>
									</div>
									<div class="span5">
										<p>Detalhes do Cadastro</p>
									</div>
									<div class="span2 pull-right">
										<?HTML::show_config();?>
									</div>
								<?HTML::show_header_END();?>
								<?HTML::show_content_START();?>
									<?HTML::show_content_title('Detalhes', '');?>
									<?HTML::show_content_box_START()?>
												<?HTML::show_content_field('CODIGO', 'icon-asterisk', $Itinerary->id);?>
												<?HTML::show_content_field('DESCRIÇÃO', 'icon-time', $Itinerary->descricao);?>
												<?HTML::show_content_field('ENTRADA', 'icon-time', $Itinerary->entrada);?>
												<?HTML::show_content_field('INTERVALO', 'icon-time', $Itinerary->intervalo);?>
												<?HTML::show_content_field('RETORNO', 'icon-time', $Itinerary->retorno);?>
												<?HTML::show_content_field('SAIDA', 'icon-time', $Itinerary->saida);?>
									<?HTML::show_content_box_END()?>
								<?HTML::show_content_END();?>
							<?else:?>
								<div class="alert alert-info">Sem resultados</div>
							<?endif?>
						<?HTML::box_END();?>
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
