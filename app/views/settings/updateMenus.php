<?php
/** @author Giceu Cassiano **/
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php
		head('Editar Pagina');
		auth('yes');
		if (!$menus = $dao->Retrieve('Navigation_menus', @$params[0], true, true))
		{
			error_404();
		}
		$controller = new Settings_Controller();
		$controller->update_menu($menus);
		$menus = $dao->Retrieve('Navigation_menus', @$params[0], true, true);
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
		<?bar($icon="icon-file-alt", $titulo="Editar Menus do Sistema", $descricao="Alterações Nas Menus Do Sistema.");?>
		<!-- FIM AREA-TOP -->

		<!-- INICIO #BREADCRUMBS -->
			<?$menu = new Menus_Controller();$menu->breadcrumbs('Edicão das Painas', 'icon-edit-sign', 'Menus', 'icon-file','/settings/pages');?>
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
								Edição dos Menus do Sistema
							</span>
						</div>
						<div class="box-content">
							<?php $form = new Form_html(array('class'=>
							'form-horizontal fill-up validatable', 'id'=>'form01'));	$form->Start();?>
							<div class="padded">
								<div class="control-group">
									<label class="control-label">Nome</label>
									<div class="controls">
										<?php $form->
										Input(array('type'=>'text', 'class'=>'span8', 'value'=>$menus->nome), 'Menu', 'nome')?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">ICONE</label>
									<div class="controls">
										<?php $form->
										Input(array('type'=>'text', 'class'=>'span3', 'id'=>'icon_ex', 'style'=>'font-size:15px;color:orange','value'=>$menus->icone), 'Menu', 'icone')?>
										<a data-toggle="modal" href="#modal-simple" class="btn btn-blue" type="button">
											<i class="icon-list-ul icon-2x"></i>
										</a>
										<span class="label" >Selecione Aqui o Icone!</span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Posição</label>
									<div class="controls">
										<?php $form->
										Input(array('type'=>'number', 'min'=>'1', 'max'=>'10', 'class'=>'span1', 'value'=>$menus->posicao), 'Menu', 'posicao')?>
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

