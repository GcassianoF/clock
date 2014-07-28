<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Detail Navigation_menus");
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
							<?if ($Navigation_menu = $dao->Retrieve('Navigation_menu', $params[0], true, true)):?>
								<?HTML::show_header_START();?>
									<div class="span4">
										<h1 class="pull-right" style="color:#FFFFFF"><?=sobreNome("O Texto Que Você Quiser!")?></h1>
									</div>
									<div class="span5">
										<p>Detalhes do Cadastro</p>
									</div>
									<div class="span2 pull-right">
										<?HTML::show_config();?>
									</div>
								<?HTML::show_header_END();?>
								<?HTML::show_content_START();?>
									<?HTML::show_content_title('Texto a Sua Escolha', 'icon-picture');?>
									<?HTML::show_content_box_START()?>
												<?HTML::show_content_field('ID', 'icon-picture', $Navigation_menu->id);?>
												<?HTML::show_content_field('NOME', 'icon-picture', $Navigation_menu->nome);?>
												<?HTML::show_content_field('ICONE', 'icon-picture', $Navigation_menu->icone);?>
												<?HTML::show_content_field('DESCRICAO', 'icon-picture', $Navigation_menu->descricao);?>
												<?HTML::show_content_field('POSICAO', 'icon-picture', $Navigation_menu->posicao);?>
												<?HTML::show_content_field('CREATED_AT', 'icon-picture', format_date($Navigation_menu->created_at, "/", $t=false));?>
												<?HTML::show_content_field('UPDATED_AT', 'icon-picture', format_date($Navigation_menu->updated_at, "/", $t=false));?>
												<?HTML::show_content_field('DELETED_AT', 'icon-picture', format_date($Navigation_menu->deleted_at, "/", $t=false));?>
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
