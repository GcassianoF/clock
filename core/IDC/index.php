<?php
  /*#####################################################################################
   #																					#
   #	@author Giceu Cassiano 															#
   #    @updated 20/05/2013																#
   #																					#
   #####################################################################################*/
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php
			head('Painel');
			auth('yes');
			$controller_framework = new Framework_Controller();
			$controller_framework->createModel();
			$controller_framework->createController();
			$controller_framework->createView();
		?>
	</head>
	<body>
		<!-- INICIO TOP -->
		<?topbarUID();?>
		<!-- FIM TOP -->
		<!-- INICIO SIDEBAR -->
		<?menu_framework();?>
		<!-- FIM SIDEBAR -->

		<div class="main-content">
		<?bar($icon="fa fa-code", $titulo="UICD", $descricao="User Interface Code Development.");?>


			<!-- INICIO CENTER MASTER -->
			<div class="container-fluid padded">
				<?php default_messages()?>
				<div class="row-fluid">
					<div class="well cor-fundo1 span4 exemplo">
						<legend><strong>MVC</strong><small> Files</small></legend>
						<ul style="list-style-type: none;">
							<li style="list-style-type: none;">
								<a href="#" id="app_id"><i id="app_icon" class="icon-folder-open-alt"></i><strong style="color:#000"> <?=APP?></strong></a>
								<div id="app">
									<?arvore(APPROOT);?>
								</div>
							</li>
						</ul>
					</div>
					<div class="span8">
						<div class="box">
							<div class="box-header" >
								<ul class="nav nav-tabs nav-tabs-left" style="width:90%">
									<li><span class="title" style="background-color:#11161A;color:white" ><i class="fa fa-code fa-1g"></i></span></li>
									<li class="active"><a href="#model" data-toggle="tab"><i class="icon-retweet"></i> <span>Create Models for Tables</span></a></li>
									<li><a href="#controll" data-toggle="tab"><i class="fa fa-sitemap"></i> <span>Crete Controllers for Models</span></a></li>
									<li><a href="#pages" data-toggle="tab"><i class="fa fa-files-o"></i> <span>Create Views Model/Controller</span></a></li>
								</ul>
							</div>
							<div class="box-content">
								<div class="tab-content">
									<div class="tab-pane active" id="model">
										<?php if ($table_list = $controller_framework->listTables()):?>
										<?php $form = new Form_html();
										$form->Start();
										?>
           								<ul class="box-list">
											<?php foreach($table_list as $table):?>
												<li>
													<input type="checkbox" class="icheck" value="<?=$table?>" id="<?=$table?>_check_table" name="tabelas[]">
													<label for="<?=$table?>_check_tab"><strong><?=$table?> </strong>&nbsp;&nbsp;
														<?filds_campo_typo($table);?></label>
												</li>												
											<?php endforeach?>
										</ul>
										<?php else:?>
											<div class="alert alert-info">Sem resultados</div>
										<?php endif?>
										<div class="box-footer padded">
											<div class="pull-left">
           										<input type="checkbox"  class="" id="selecionarTodosTables"/> 
           										<label for="selecionarTodosTables">Selecionar Todos: </label>
											</div>
											<span class="pull-right">
												<button type="submit" class="btn btn-inverse"><i class="icon-plus"></i> Create Model</button>
											</span>
										</div>
										<?php $form->End();?>
									</div>
									<div class="tab-pane" id="controll">
										<?php if ($models_list = $controller_framework->listModels()):?>
										<?php $form = new Form_html();
										$form->Start();?>
										<?php sort($models_list);?>
           								<ul class="box-list">
											<?php foreach($models_list as $models):?>
												<li>
													<input type="checkbox" id="<?=$models?>_check_model" class="icheck" value="<?=$models?>" name="modelos[]">
													<label for="<?=$models?>_check_model"><strong><?=$models?></strong></label>
												</li>												
											<?php endforeach?>
										</ul>
										<?php else:?>
											<div class="alert alert-info">Sem resultados</div>
										<?php endif?>
										<div class="box-footer padded">
											<span class="pull-left label">
           										Selecionar Todos:&nbsp;&nbsp;<input type="checkbox"  class="" id="selecionarTodosModels"/> 
											</span>
											<span class="pull-right">
												<button type="submit" class="btn btn-inverse"><i class="icon-plus"></i> Create Controller</button>
											</span>
										</div>
										<?php $form->End();?>										
									</div>
									<div class="tab-pane" id="pages">
										<?php if ($controller_list = $controller_framework->listControllers()):?>
										<?php $form = new Form_html();
										$form->Start();?>
										<?php sort($controller_list);?>
           								<ul class="box-list">
											<?php foreach($controller_list as $controllers):?>
												<li>
													<input type="radio" id="<?=str_replace(".php", "", $controllers);?>_check_controller" class="icheck" value="<?=$controllers?>" name="controlador">
													<label for="<?=str_replace(".php", "", $controllers);?>_check_controller"><strong><?=$controllers?></strong></label>
												</li>												
											<?php endforeach?>
										</ul>
										<?php else:?>
											<div class="alert alert-info">Sem resultados</div>
										<?php endif?>
										<div class="box-footer padded">
											<span class="pull-right">
												<button type="submit" class="btn btn-inverse"><i class="icon-plus"></i> Create View</button>
											</span>
										</div>
										<?php $form->End();?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				$(".exemplo #app_id").click(function(){
					$(".exemplo #app_icon").removeClass("icon-folder-open-alt");
					$(".exemplo #app_icon").addClass("icon-folder-close");
					$("#app").slideUp();
				}).dblclick(function(){
					$(".exemplo #app_icon").removeClass("icon-folder-close");
					$(".exemplo #app_icon").addClass("icon-folder-open-alt");
					$("#app").slideDown();
				});
				$('#selecionarTodosModels').click(function() {
			        if(this.checked == true){
			            $("input[type=checkbox]").each(function() {
			                this.checked = true;
			            });
			        } else {
			            $("input[type=checkbox]").each(function() {
			                this.checked = false;
			            });
			        }
			    });
			    $('#selecionarTodosTables').click(function() {
			        if(this.checked == true){
			            $("input[type=checkbox]").each(function() {
			                this.checked = true;
			            });
			        } else {
			            $("input[type=checkbox]").each(function() {
			                this.checked = false;
			            });
			        }
			    });
			});
		</script>
	</body>
</html>
