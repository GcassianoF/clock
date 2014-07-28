<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Alter Navigation_menus");
			auth("yes");
			if (!$navigation_menus = $dao->Retrieve('Navigation_menus', @$params[0], true, true))
			{
				error_404();
			}
			$navigation_menus_controller = new Navigation_menus_Controller();
			$navigation_menus_controller->update($navigation_menus);
			$navigation_menus = $dao->Retrieve('Navigation_menus', @$params[0], true, true);
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>
			<?Menus_Controller::breadcrumbs("navigation_menus", "icon-picture", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-picture", "Coloque aqui o Titulo do Formulario");?>
							<?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable'));
							$form->Start();?>
								<?Form_html::form_START()?>
									<?$form->InputGroup_Start("NOME")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8', 'value'=>$navigation_menus->nome), 'Navigation_menu', 'nome')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("ICONE")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8', 'value'=>$navigation_menus->icone), 'Navigation_menu', 'icone')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("DESCRICAO")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8', 'value'=>$navigation_menus->descricao), 'Navigation_menu', 'descricao')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("POSICAO")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8', 'value'=>$navigation_menus->posicao), 'Navigation_menu', 'posicao')?>
									<?$form->InputGroup_End()?>
									
								<?Form_html::form_END()?>
								<?Form_html::form_actions_START()?>
									<button type="submit" class="btn btn-blue"><i class="icon-save"></i> Salvar</button>
									<a href="<?=WWWROOT?>/navigation_menus" class="btn btn-gold"><i class="icon-remove-sign"></i> Cancelar</a>
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
