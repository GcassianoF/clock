<?php
/** @author Giceu Cassiano **/
?>


<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php
			head('Páginas');
			auth('yes');
			$menus = $dao->Retrieve('Navigation_menus');
			$controller = new Settings_Controller();
			$controller->add_page();
			$controller->add_menu();
			if (array_key_exists('deleted', $_SESSION))
			{
				$MSG->info[] = "Registro Excluido.";
				unset($_SESSION['deleted']);
			}
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
			<?bar($icon="icon-file", $titulo="Configurações das Páginas do Sistema", $descricao="Edição de Paginas e Menus do Sistema");?>
			<!-- FIM AREA-TOP -->

			<!-- INICIO #BREADCRUMBS -->
			<?$menu = new Menus_Controller();$menu->breadcrumbs('Paginas', 'icon-file', null, null, null);?>
			<!-- FIM #BREADCRUMBS -->

			<!-- INICIO CENTER MASTER -->
			<div class="container-fluid padded">
			<?php default_messages()?>
			<div class="row-fluid">
				<div class="span12">
					<div class="box">
						<div class="box-header">
							<ul class="nav nav-tabs nav-tabs-left">
								<li class="active">
									<a href="#menus" data-toggle="tab">
										<i class="icon-th-large"></i> <span>Novo Menu</span>
									</a>
								</li>
								<li class="">
									<a href="#menusList" data-toggle="tab">
										<i class="icon-list-ol"></i> <span>Lista de Menus</span>
									</a>
								</li>
								<li class="">
									<a href="#paginas" data-toggle="tab">
										<i class="icon-th"></i> <span>Nova Pagina</span>
									</a>
								</li>
								<li class="">
									<a href="#paginasForMenus" data-toggle="tab">
										<i class="icon-list-ul"></i> <span>Lista de Paginas</span>
									</a>
								</li>
							</ul>
							<div class="title">Configurações</div>
						</div>
						<br>
						<div class="box-content">
							<div class="tab-content">
								<div class="tab-pane active" id="menus">
									<div class="row-fluid" >
										<div class="span10 offset1">
											<div class="box">
				      							<div class="box-header">
				        								<span class="title"><i class="icon-edit"></i> Cadastro de Um Novo Menus do Sistema</span>
				      							</div>
				      							<div class="box-content">
										      		<?php $form = new Form_html(array('class'=>'form-horizontal fill-up validatable'));
										      		$form->Start();?>
					          								<div class="padded">
															<div class="control-group">
																<label class="control-label">Nome</label>
																<div class="controls">
																	<?php $form->Input(array('type'=>'text', 'class'=>'validate[required] span8', 'data-prompt-position'=>'topLeft'), 'Menu', 'nome')?>
																</div>
															</div>
															<div class="control-group">
																<label class="control-label">ICONE</label>
																<div class="controls">
																	<?php
																		$form->Input(array('type'=>'text', 'class'=>'validate[required] span3 uneditable-input', 'data-prompt-position'=>'topLeft', 'id'=>'icon_01', 'style'=>'font-size:15px;color:orange'), 'Menu', 'icone')
																	?>
																	<a data-toggle="modal" href="#modal-icon-01" class="btn btn-blue" type="button">
																		<i class="icon-list-ul icon-2x"></i>
																	</a>
																	<span class="label" >Selecione Aqui o Icone!</span>
																</div>
															</div>
															<div class="control-group">
																<label class="control-label">POSIÇÃO</label>
																<div class="controls">
																	<?php $form->Input(array('type'=>'number', 'min'=>'1', 'max'=>'10', 'class'=>'validate[required] span1', 'data-prompt-position'=>'topLeft'), 'Menu', 'posicao')?>
																</div>
															</div>
														</div>
														<div class="form-actions">
															<button type="submit" class="btn btn-green"><i class="icon-save"></i>   Salvar</button>
															<div class="pull-right">
																<div>
																</div>
															</div>
														</div>
													<?php $form->End()?>
			         								</div>
			      							</div>
		      							</div>
	      							</div>
      							</div>

								<div class="tab-pane" id="menusList">
									<div class="row-fluid" >
										<div class="span10 offset1">
											<div class="box">
				      							<div class="box-header">
				        								<span class="title"><i class="icon-edit"></i> Lista dos Menus Cadastrados no Sistema</span>
				      							</div>
				      							<div class="box-content">
				          								<div class="padded">
														<?php $controller->menusList(); ?>
													</div>
			         								</div>
			      							</div>
		      							</div>
	      							</div>
      							</div>

								<div class="tab-pane" id="paginas">
									<div class="row-fluid" >
										<div class="span10 offset1">
											<div class="box">
				      							<div class="box-header">
				        								<span class="title"><i class="icon-edit"></i> Cadastro de Uma Nova Pagina do Sistema</span>
				      							</div>
				      							<div class="box-content">
										      		<?php $form = new Form_html(array('class'=>'form-horizontal fill-up validatable'));
										      		$form->Start();?>
					          								<div class="padded">
													            <div class="control-group">
													            	<label class="control-label">Menu:</label>
													             	<div class="controls">
																		<?php $form->Select($menus, array('class'=>'chzn-select span8', 'data-prompt-position'=>'topLeft'), 'Page', 'navigation_menu_id', 'nome')?>
					              									</div>
					            								</div>
															<div class="control-group">
																<label class="control-label">Nome</label>
																<div class="controls">
																	<?php $form->Input(array('type'=>'text', 'class'=>'validate[required] span8', 'data-prompt-position'=>'topLeft'), 'Page', 'nome')?>
																</div>
															</div>
															<div class="control-group">
																<label class="control-label">URL</label>
																<div class="controls">
																	<?php $form->Input(array('type'=>'text', 'class'=>'validate[required] span8', 'data-prompt-position'=>'topLeft'), 'Page', 'url')?>
																</div>
															</div>
															<div class="control-group">
																<label class="control-label">ICONE</label>
																<div class="controls">
																	<?php
																		$form->Input(array('type'=>'text', 'class'=>'validate[required] span3 uneditable-input', 'data-prompt-position'=>'topLeft', 'id'=>'icon_02', 'style'=>'font-size:15px;color:orange'), 'Page', 'icone')
																	?>
																	<a data-toggle="modal" href="#modal-icon-02" class="btn btn-blue" type="button">
																		<i class="icon-list-ul icon-2x"></i>
																	</a>
																	<span class="label" >Selecione Aqui o Icone!</span>
																</div>
															</div>
															<div class="control-group">
																<label class="control-label">Exibir Pagina no Menu</label>
																<div class="controls">
																	<div id="divSim">
																		<?php $form->
																			Input(array('type'=>'radio', 'class'=>'icheck','data-prompt-position'=>'topLeft', 'value'=>'1'), 'Pagina', 'mostrar')
																		?>
																		<label ><span class="label label-green"  style="font-size:1.3em">SIM</span>
																			&nbsp;<span class="label" >Atenção! Por padrão toda nova pagina criada inicia-se desabilitada.</span></label>
																	</div>
																	<div class="disabled">
																		<?php $form->
																			Input(array('type'=>'radio', 'checked'=>'checked', 'class'=>'icheck','data-prompt-position'=>'topLeft', 'value'=>'0'), 'Pagina', 'mostrar')
																		?>
																		<label ><span class="label label-red" style="font-size:1.2em">NÃO</span></label>
																	</div>
																</div>
															</div>
														</div>
														<div class="form-actions">
															<button type="submit" class="btn btn-green"><i class="icon-save"></i>   Salvar</button>
															<div class="pull-right">
															</div>
														</div>
													<?php $form->End()?>
				         							</div>
					         					</div>
										</div>
									</div>
								</div>
								<?php $controller->pagesList(); ?>
								<div class="box-footer padded">

								</div>
								<?php icons();?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?scripts();?>
		<script>$("#divSim").children().attr("disabled","disabled");</script>
	</body>
</html>