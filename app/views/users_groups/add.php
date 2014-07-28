<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("New Users_groups");
			auth("yes");
			$users_groups_controller = new Users_groups_Controller();
			$users_groups_controller->add();
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-group", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>
			<?Menus_Controller::breadcrumbs("users_groups", "icon-picture", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-picture", "Coloque aqui o Titulo do Formulario");?>
							<?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable'));
							$form->Start();?>
								<?Form_html::form_START()?>
									<?$form->InputGroup_Start("NOME")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8'), 'Users_group', 'nome')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("DESCRIÇÃO")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8'), 'Users_group', 'descricao')?>
									<?$form->InputGroup_End()?>
									
								<?Form_html::form_END()?>
								<?Form_html::form_actions_START()?>
									<button type="submit" class="btn btn-blue"><i class="icon-save"></i> Salvar</button>
									<a href="<?=WWWROOT?>/users_groups" class="btn btn-gold"><i class="icon-remove-sign"></i> Cancelar</a>
								<?Form_html::form_actions_END()?>
							<?$form->End()?>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
			<?HTML::container_END();?>
		<?HTML::main_content_END();?>
		<?scripts();?>
	</body>
</html>
