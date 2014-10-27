<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("New Licenses");
			auth("yes");
			$licenses_controller = new Licenses_Controller();
			$licenses_controller->add();
			$Files = $dao->Retrieve("Files");
		?>
		<!-- <script type="text/javascript">
		$(document).ready(function(){
			$("ins").each(function(i){
				this.attr("id", "radioFor01"+i);
				//alert("Atributo title do link " + i );
			 });
			});
		</script> -->
		<script type="text/javascript">
			function enviar_formulario()
			{
				var formulario = document.getElementById('formAu');
				document.getElementById('License_pwd').value = document.getElementById('Session_pwd').value;
				formulario.submit();
			}
		</script>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-time", $titulo="Registro de Horas Extraordinarias", $descricao="Menu responsavel por insersão de horas extraordinarias dos funcionarios.");?>
			<?Menus_Controller::breadcrumbs("Horas Extraordinarias", "icon-circle-blank", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-time", "Regitros de Horarios Extraordinarios com ou sem atestado");?>
							<div class="box-header">
								<ul class="nav nav-tabs nav-tabs-left">
									<li class="active">
										<a href="#d01" class="" data-toggle="tab" >
											<i class="icon-plus"></i>  Cadastro
										</a>
									</li>
									<li class="">
										<a href="#d02" class="" data-toggle="tab" >
											<i class="icon-list"></i>  Listar
										</a>
									</li>
								</ul>
							</div>
							<div class="box-content" style="font-size:0.85em">
								<div class="tab-content">
									<div class="tab-pane active" id="d01">
										<?HTML::box_START("icon-circle-blank", "Horas Extraordinarias");?>
											<?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable', 'id'=>'formAu'));
											$form->Start();?>
												<?Form_html::form_START()?>
													<?$form->InputGroup_Start("")?>
														<?$form->Input(array('type'=>'hidden', 'class'=>'span8','id'=>'License_pwd'), 'License', 'pwd')?>
													<?$form->InputGroup_End()?>

													<?$form->InputGroup_Start("Data")?>
														<?$form->Input(array('type'=>'text', 'class'=>'span3 datepicker fill-up'), 'License', 'data')?>
													<?$form->InputGroup_End()?>

													<?$form->InputGroup_Start("")?>
														<div class="input-append bootstrap-timepicker span2">
															<label><strong>Inicio</strong></label>
															<?$form->Input(array('type'=>'text', 'class'=>'span1 input-small', 'id'=>'inicio'), 'License', 'inicio')?>
													            <span class="add-on"><i class="icon-time"></i></span>
													       </div>
													       <div class="input-append bootstrap-timepicker span2">
													       	<label><strong>Fim</strong></label>
															<?$form->Input(array('type'=>'text', 'class'=>'span1 input-small', 'id'=>'fim'), 'License', 'fim')?>
													            <span class="add-on"><i class="icon-time"></i></span>
													       </div>
													<?$form->InputGroup_End()?>
													<br/>
													<br/>
													<?$form->InputGroup_Start("Justificativa")?>
														<?$form->TextArea(array('type'=>'text', 'class'=>'span8', 'rows'=>'7', 'cols'=>'10'), 'License', 'justificativa')?>
													<?$form->InputGroup_End()?>

													<?$form->InputGroup_Start("Assunto Pessoal?")?>
														<span class="span8">
															<?$form->Input(array('type'=>'radio', 'class'=>'icheck', 'checked'=>'checked', 'value'=>'1', 'id'=>'isArquivo01'), 'License', 'atestado')?>
															<label>SIM</label>
															&nbsp;&nbsp;
															<?$form->Input(array('type'=>'radio', 'class'=>'icheck', 'value'=>'0', 'id'=>'isArquivo02'), 'License', 'atestado') ?>
															<label>NÃO</label>
															<div id="textSelect" class="note large">
																<i class="icon-warning-sign"></i> Atenção: Se for assunto pessoal as horas utilizadas serão descontadas do seu banco de horas, caso o contrario anexe o comprovante ou atestado a esté cadastro para não haver descontos indevidos.
															</div>
						                      					</span>
													<?$form->InputGroup_End()?>
													<div  id="isHidden">
														<?$form->InputGroup_Start("Upload de Comprovante")?>
															<span class="span8">
																<?//$form->Input(array('type'=>'file', 'class'=>'span2', 'id'=>'fileUp'), 'License', 'arquivo')?>
																<input type="file" class="span8" id="fileUp" name="uploadFile" id="uploadFile" />
																<div class="note large">
							                        						<i class="icon-warning-sign"></i> Atenção: Caso exista mais de um comprovante os mesmo devem ser compactados em um unico arquivo.
							                      						</div>
							                      					</span>
														<?$form->InputGroup_End()?>
													</div>

												<?Form_html::form_END()?>
												<?Form_html::form_actions_START()?>
													<button type="submit" class="btn btn-blue" id="saveNewRecord"><i class="icon-save"></i> Salvar</button>
													<a href="<?=WWWROOT?>" class="btn btn-gold"><i class="icon-remove-sign"></i> Cancelar</a>
												<?Form_html::form_actions_END()?>
											<?$form->End()?>
										<?HTML::box_END();?>
									</div>
									<div class="tab-pane" id="d02">
										<?HTML::box_START("icon-list", "Listagem de Horas Cadastradas");?>
											<div id="dataTables">
												<?if ($licenses_list = $licenses_controller->filter()):?>
													<table cellpadding="0" cellspacing="0" border="0" class="dTable responsive" style="font-size:1.1em">
														<thead>
															<tr>
																<th style="width:120px"><stong>DATA</stong></th>
																<th style="width:60px"><stong>INICIO</stong></th>
																<th style="width:50px"><stong>FIM</stong></th>
																<th style="width:200px"><stong>JUSTIFICATIVA</stong></th>
																<th style="width:80px"><stong>ATESTADO</stong></th>
																<th style="width:80px"><stong>ANEXO</stong></th>
															</tr>
														</thead>
														<tbody>
															<?foreach($licenses_list['query'] as $licenses):?>
																<tr>
																	<td  class="center"><?=format_date($licenses->data, "/")?></td>
																	<td  class="center"><?=$licenses->inicio?></td>
																	<td  class="center"><?=$licenses->fim?></td>
																	<td  class="center"><?=$licenses->justificativa?></td>
																	<td  class="center"><?=$licenses->atestado = $licenses->atestado == 1 ? '<span class="label label-red" style="width:30px">NÃO</span>' : '<span class="label label-green"  style="width:30px">SIM</span>'?></td>
																	<td  class="center">
																		<?if ($licenses->file_id != ''):?>
																			<a style="width:90px" target="_blank" href="<?=WWWROOT.'/core/uploadfiles/'.$licenses->rel['file']->name?>" class="btn btn-mini btn-gray tip" title="Donwload"><i class="icon-download-alt icon-white"></i> Donwload&nbsp;</a>
																		<?else:?>
																			<a style="width:90px" class="btn btn-mini btn-black tip" title="Sem Anexo"><i class="icon-ban-circle icon-white"></i> Sem Anexo</a>
																		<?endif?>
																	</td>
																</tr>
															<?endforeach?>
														</tbody>
													</table>
												<?else:?>
													<div class="alert alert-info">Sem resultados</div>
												<?endif?>
											</div>
											<?Form_html::form_actions_START()?>
												<!-- <span class="pull-right"><a href="<?=WWWROOT.'/users/add'?>" class="btn btn-blue tip" title="Novo Registro"><i class="icon-plus"></i> Novo Cadastro</a></span> -->
											<?Form_html::form_actions_END()?>
										<?HTML::box_END();?>
									</div>
								</div>
							</div>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
			<?HTML::container_END();?>
		<?HTML::main_content_END();?>
		<!-- INICIO MODAL CONFIRMAÇÃO DE INSERSÃO -->
			<div id="confirmation_modal_record" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Autenticação</h3>
				</div>
				<div class="modal-body">
					<div class="loginform-in">
						<h2><?=$_SESSION['user_name'];?></h2>
						<h5>Para execultar esta ação e preciso informa sua credêncial: <??> </h5>
						<?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable','id'=>'formAutho'));$form->Start();?>
							<?Form_html::form_START()?>
								<div class="input-prepend">
									<span class="add-on" href="#"><i class="icon-key"></i></span>
									<?php $form->Input(array('type'=>'password', 'placeholder'=>'Senha', 'style'=>'width:300px;','id'=>'Session_pwd'), 'Session', 'senha')?>
									<button type="submit" class="btn btn-blue " onclick="enviar_formulario();" style="height:35px">Autenticar <i class="icon-signin"></i></button>
								</div>
							<?Form_html::form_END()?>
						<?$form->End()?>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><i class="icon-remove-sign"></i> Cancelar</a>
				</div>
			</div>
		<!-- FIM MODAL CONFIRMAÇÃO DE INSERSÃO -->
		<?scripts();?>
		<script type="text/javascript">
			$('.btn-blue').click(function(e){
				var href = $(this).attr('href');
				$('#confirmation_modal_record').modal({show: true});
				$('#confirm_danger_record').click(function(e){
					e.preventDefault();
				});
				e.preventDefault();
			});
		</script>
		<script type="text/javascript">
	            $('#inicio').timepicker({
	                minuteStep: 1,
	                showSeconds: true,
	                showMeridian: false
	            });
      	</script>
      	<script type="text/javascript">
	            $('#fim').timepicker({
	                minuteStep: 1,
	                showSeconds: true,
	                showMeridian: false
	            });
      	</script>
      	<script type="text/javascript">
      		$(document).ready(function(){
      			if ($("#isArquivo01").is(':checked')) {$("#isHidden").hide();}
				if ($("#isArquivo02").is(':checked')) {$("#isHidden").show();}
				$(".iCheck-helper").click(function() {
					if ($("#isArquivo01").is(':checked')) {$("#isHidden").hide();$("#uploadFile").val("");}
					if ($("#isArquivo02").is(':checked')) {$("#isHidden").show();}
				});
			});
      	</script>
	</body>
</html>
