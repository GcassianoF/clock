<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Detail Users_groups");
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
							<?if ($Users_group = $dao->Retrieve('Users_group', $params[0], true, true)):?>
								<?HTML::show_header_START();?>
									<div class="span4">
										<h1 class="pull-right" style="color:#FFFFFF"><?=sobreNome("")?></h1>
									</div>
									<div class="span5">
										<p>Detalhes do Cadastro</p>
									</div>
									<div class="span2 pull-right">
										<?HTML::show_config();?>
									</div>
								<?HTML::show_header_END();?>
								<?HTML::show_content_START();?>
									<?HTML::show_content_title('Perfil', 'icon-list');?>
									<?HTML::show_content_box_START()?>
										<?HTML::show_content_field('CODIGO', 'icon-asterisc', $Users_group->id);?>
										<?HTML::show_content_field('NOME', 'icon-group', $Users_group->nome);?>
										<?HTML::show_content_field('DESCRIÇÃO', 'icon-tag', $Users_group->descricao);?>
										<?HTML::show_content_field('CRIADO', 'icon-calendar', format_date($Users_group->created_at, "/", $t=false));?>
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
