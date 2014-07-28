<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("New Users");
			auth("yes");
			$users_controller = new Users_Controller();
			$users_controller->add();
			$Users_groups = $dao->Retrieve("Users_groups", "ORDER BY id");
			$Itineraries = $dao->Retrieve("Itineraries", "ORDER BY id");
			array_unshift($Users_groups, 'Selecione');
			array_unshift($Itineraries, 'Selecione');
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-plus", $titulo="Novo Usuario", $descricao="Cadastro de Um Novo Usuario No Sistema");?>
			<?Menus_Controller::breadcrumbs("Novo Usuario", "icon-plus", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-file-alt", "Novo Cadastro");?>
							<?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable'));
							$form->Start();?>
								<?Form_html::form_START()?>
									
									<?$form->InputGroup_Start("GRUPO DE USUARIO")?>
										<?$form->Select($Users_groups, array('class'=>'chzn-select span4'), 'User', 'users_group_id', 'nome')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("CARGA HORARIA")?>
										<?$form->Select($Itineraries, array('class'=>'chzn-select span4'), 'User', 'itineraries_id', 'descricao')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("NOME")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8'), 'User', 'nome')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("CPF")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8'), 'User', 'cpf')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("EMAIL")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8'), 'User', 'email')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("SENHA")?>
										<?$form->Input(array('type'=>'password', 'class'=>'span2'), 'User', 'senha')?>
									<?$form->InputGroup_End()?>

									<?$form->InputGroup_Start("CONFIRME A SENHA")?>
										<?$form->Input(array('type'=>'password', 'class'=>'span2'), 'Confirm', 'password')?>
									<?$form->InputGroup_End()?>
									
								<?Form_html::form_END()?>
								<?Form_html::form_actions_START()?>
									<button type="submit" class="btn btn-blue"><i class="icon-save"></i> Salvar</button>
									<a href="<?=WWWROOT?>/users" class="btn btn-gold"><i class="icon-remove-sign"></i> Cancelar</a>
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
