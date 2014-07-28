<?php
/** @author Giceu Cassiano **/
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php
		head('Editar Pagina');
		auth('yes');
		if (!$pagina = $dao->Retrieve('Navigation_pages', @$params[0], true, true))
		{
			error_404();
		}
		$groups = $dao->Retrieve('Navigation_menus', 'ORDER BY nome');
		$controller = new Settings_Controller();
		$controller->update_page($pagina);
		$pagina = $dao->Retrieve('Navigation_pages', @$params[0], true, true);
		$exibir = array('SIM' => 1, 'NÃO' => 0 );
	?>
</head>
<body>
	<!-- INICIO TOP -->
	<?topbar();?>
	<!-- FIM TOP -->
	<!-- INICIO SIDEBAR -->
	<?include DOCROOT."/app/views/protected/sidebar.php";?>
	<!-- FIM SIDEBAR -->
	<div class="main-content">
		<!-- INICIO AREA-TOP -->
		<?bar($icon="icon-file-alt", $titulo="Editar Paginas do Sistema", $descricao="Alterações Nas Paginas Do Sistema.");?>
		<!-- FIM AREA-TOP -->

		<!-- INICIO #BREADCRUMBS -->
			<?$menu = new Menus_Controller();$menu->breadcrumbs('Edicão das Painas', 'icon-edit-sign', 'Paginas', 'icon-file','/settings/pages');?>
		<!-- FIM #BREADCRUMBS -->

		<!-- INICIO CENTER MASTER -->
		<div class="container-fluid padded">
			<?php default_messages()?>
			<div class="row-fluid">
				<div class="span12">
					<div class="box">
						<div class="box-header">
							<span class="title">
								<i class="icon-edit"></i>
								Cadastro de Uma Nova Pagina do Sistema
							</span>
						</div>
						<div class="box-content">
							<?php $form = new Form_html(array('class'=>
							'form-horizontal fill-up validatable', 'id'=>'form01'));	$form->Start();?>
							<div class="padded">
								<div class="control-group">
									<label class="control-label">Menu:</label>
									<div class="controls">
										<?php $form->
										Select($groups, array('class'=>'chzn-select span8'), 'Pagina', 'navigation_menu_id', 'nome', $pagina->navigation_menu_id)?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Nome</label>
									<div class="controls">
										<?php $form->
										Input(array('type'=>'text', 'class'=>'span8', 'value'=>$pagina->nome), 'Pagina', 'nome')?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">URL</label>
									<div class="controls">
										<?php $form->
										Input(array('type'=>'text', 'class'=>'span8', 'value'=>$pagina->url), 'Pagina', 'url')?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">ICONE</label>
									<div class="controls">
										<?php $form->
										Input(array('type'=>'text', 'class'=>'span3', 'id'=>'icon_ex', 'style'=>'font-size:15px;color:orange','value'=>$pagina->icone), 'Pagina', 'icone')?>
										<a data-toggle="modal" href="#modal-simple" class="btn btn-blue" type="button">
											<i class="icon-list-ul icon-2x"></i>
										</a>
										<span class="label" >Selecione Aqui o Icone!</span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Exibir Pagina no Menu</label>
									<div class="controls">
										<div>
											<?php $form->
												Input(array('type'=>'radio', 'class'=>'icheck','data-prompt-position'=>'topLeft', 'value'=>'1'), 'Pagina', 'mostrar')
											?>
											<label for="Pagina_Mostrar"><span class="label label-green"  style="font-size:1.3em">SIM</span></label>
										</div>
										<div>
											<?php $form->
												Input(array('type'=>'radio', 'class'=>'icheck','data-prompt-position'=>'topLeft', 'value'=>'0'), 'Pagina', 'mostrar')
											?>
											<label for="Pagina_Mostrar"><span class="label label-red" style="font-size:1.2em">NÃO</span></label>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<button type="submit" class="btn btn-blue">
									<i class="icon-save"></i>
									Salvar
								</button>
								<div class="pull-right">
									<div></div>
								</div>
							</div>
							<?php $form->End()?></div>
						<!-- INICIO TOP -->
						<?php include(DOCROOT.'/app/views/public/modal_icon.php');?>
						<!-- FIM TOP -->
					</div>
				</div>
			</div>

		</div>
		<!-- FIM CENTER MASTER -->
	</div>
</body>
</html>

