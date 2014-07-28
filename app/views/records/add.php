<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("New Records");
			auth("yes");
			$records_controller = new Records_Controller();
			$records_controller->add();
			$Users = $dao->Retrieve("Users", "ORDER BY id");
			$Reasons = $dao->Retrieve("Reasons", "ORDER BY id");
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>
			<?Menus_Controller::breadcrumbs("records", "icon-picture", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-picture", "Coloque aqui o Titulo do Formulario");?>
							<?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable'));
							$form->Start();?>
								<?Form_html::form_START()?>
									
									<?$form->InputGroup_Start("Users")?>
										<?$form->Select($Users, array('class'=>'chzn-select span4'), 'Record', 'user_id', 'id')?>
									<?$form->InputGroup_End()?>
									
									
									<?$form->InputGroup_Start("Reasons")?>
										<?$form->Select($Reasons, array('class'=>'chzn-select span4'), 'Record', 'reason_id', 'id')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("DATA")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8'), 'Record', 'data')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("HORA")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8'), 'Record', 'hora')?>
									<?$form->InputGroup_End()?>
									
								<?Form_html::form_END()?>
								<?Form_html::form_actions_START()?>
									<button type="submit" class="btn btn-blue"><i class="icon-save"></i> Salvar</button>
									<a href="<?=WWWROOT?>/records" class="btn btn-gold"><i class="icon-remove-sign"></i> Cancelar</a>
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
