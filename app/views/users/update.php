<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Alter Users");
			auth("yes");
			if (!$users = $dao->Retrieve('Users', @$params[0], true, true))
			{
				error_404();
			}
			$Users_groups = $dao->Retrieve("Users_groups", "ORDER BY nome");
			$Itineraries = $dao->Retrieve("Itineraries", "ORDER BY descricao");
			array_unshift($Users_groups, 'Selecione');
			array_unshift($Itineraries, 'Selecione');
			$users_controller = new Users_Controller();
			$users_controller->update($users);
			$users = $dao->Retrieve('Users', @$params[0], true, true);
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-edit", $titulo="Editar Usuario", $descricao="Edição dos Dados Cadastrais do Usuario: <strong>".$users->nome."</strong>");?>
			<?Menus_Controller::breadcrumbs('Editar Usuario', 'icon-edit', 'Gerenciamento dos Usuarios', 'icon-user', '/users');?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-edit", "Alterar Registro");?>
							<?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable'));
							$form->Start();?>
								<?Form_html::form_START()?>
									
									<?$form->InputGroup_Start("GRUPO DE USUARIO")?>
										<?$form->Select($Users_groups, array('class'=>'chzn-select span4'), 'User', 'users_group_id', 'nome', $users->users_group_id)?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("CARGA HORARIA")?>
										<?$form->Select($Itineraries, array('class'=>'chzn-select span4'), 'User', 'itineraries_id', 'descricao', $users->itineraries_id)?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("NOME")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8', 'value'=>$users->nome), 'User', 'nome')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("CPF")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8', 'value'=>$users->cpf), 'User', 'cpf')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("EMAIL")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8', 'value'=>$users->email), 'User', 'email')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("SENHA")?>
										<?$form->Input(array('type'=>'password', 'class'=>'span2'), 'User', 'senha')?>
									<?$form->InputGroup_End()?>

									<?$form->InputGroup_Start("CONFIRME A SENHA")?>
										<?$form->Input(array('type'=>'password', 'class'=>'span2'))?>
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
