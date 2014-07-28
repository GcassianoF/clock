<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Alter Itineraries");
			auth("yes");
			if (!$itineraries = $dao->Retrieve('Itineraries', @$params[0], true, true))
			{
				error_404();
			}
			$itineraries_controller = new Itineraries_Controller();
			$itineraries_controller->update($itineraries);
			$itineraries = $dao->Retrieve('Itineraries', @$params[0], true, true);
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>
			<?Menus_Controller::breadcrumbs("itineraries", "icon-picture", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-picture", "Coloque aqui o Titulo do Formulario");?>
							<?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable'));
							$form->Start();?>
								<?Form_html::form_START()?>
									<?$form->InputGroup_Start("DESCRIÇÃO")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8', 'value'=>$itineraries->descricao), 'Itinerary', 'descricao')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("ENTRADA")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span2', 'value'=>$itineraries->entrada), 'Itinerary', 'entrada')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("INTERVALO")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span2', 'value'=>$itineraries->intervalo), 'Itinerary', 'intervalo')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("RETORNO")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span2', 'value'=>$itineraries->retorno), 'Itinerary', 'retorno')?>
									<?$form->InputGroup_End()?>
									
									<?$form->InputGroup_Start("SAIDA")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span2', 'value'=>$itineraries->saida), 'Itinerary', 'saida')?>
									<?$form->InputGroup_End()?>
								<?Form_html::form_END()?>
								<?Form_html::form_actions_START()?>
									<button type="submit" class="btn btn-blue"><i class="icon-save"></i> Salvar</button>
									<a href="<?=WWWROOT?>/itineraries" class="btn btn-gold"><i class="icon-remove-sign"></i> Cancelar</a>
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
