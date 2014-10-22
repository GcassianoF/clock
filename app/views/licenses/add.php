<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("New Licenses");
			auth("yes");
			$licenses_controller = new Licenses_Controller();
			$licenses_controller->add();
			$Reasons = $dao->Retrieve("Reasons", "WHERE reasons.deleted_at IS NULL AND reasons.id <> 2 AND reasons.id <> 3 ORDER BY id");
			$Files = $dao->Retrieve("Files", "ORDER BY id");
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
						<?HTML::box_START("icon-circle-blank", "Horas Extraordinarias");?>
							<?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable', 'id'=>'formAu'));
							$form->Start();?>
								<?Form_html::form_START()?>
									<?$form->InputGroup_Start("")?>
										<?$form->Input(array('type'=>'hidden', 'class'=>'span8','id'=>'License_pwd'), 'License', 'pwd')?>
									<?$form->InputGroup_End()?>

									<?$form->InputGroup_Start("Registro")?>
										<?$form->Select($Reasons, array('class'=>'chzn-select span4'), 'License', 'reason_id', 'descricao')?>
									<?$form->InputGroup_End()?>

									<?$form->InputGroup_Start("Data")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span3 datepicker fill-up'), 'License', 'data')?>
									<?$form->InputGroup_End()?>

									<?$form->InputGroup_Start("Horario")?>
									<div class="input-append bootstrap-timepicker span2">
										<?$form->Input(array('type'=>'text', 'class'=>'span1 input-small', 'id'=>'time'), 'License', 'hora')?>
								            <!-- <input id="time" type="text" class="input-small"> -->
								            <span class="add-on"><i class="icon-time"></i></span>
								        </div>
									<?$form->InputGroup_End()?>

<!--
									<?$form->InputGroup_Start("DATA")?>
										<?$form->Input(array('type'=>'text', 'class'=>'span8'), 'License', 'data')?>
									<?$form->InputGroup_End()?>

									-->

									<?$form->InputGroup_Start("Justificativa")?>
										<?$form->TextArea(array('type'=>'text', 'class'=>'span8', 'rows'=>'7', 'cols'=>'10'), 'License', 'justificativa')?>
									<?$form->InputGroup_End()?>

									<?$form->InputGroup_Start("Assunto Pessoal?")?>
										<span class="span8">
											<?$form->Input(array('type'=>'radio', 'class'=>'icheck', 'checked'=>'checked', 'value'=>'1', 'id'=>'assPessoal'), 'License', 'atestado')?>
											<label>SIM</label>
											&nbsp;&nbsp;
											<?$form->Input(array('type'=>'radio', 'class'=>'icheck', 'value'=>'0', 'id'=>'assPessoal'), 'License', 'atestado') ?>
											<label>NÃO</label>
											<div id="textSelect" class="note large">
												<i class="icon-warning-sign"></i> Atenção: Se for assunto pessoal as horas utilizadas serão descontadas do seu banco de horas, caso o contrario anexe o comprovante ou atestado a esté cadastro para não haver descontos indevidos.
											</div>
		                      					</span>
									<?$form->InputGroup_End()?>

									<?$form->InputGroup_Start("Upload de Comprovante")?>
										<span class="span8">
											<?//$form->Input(array('type'=>'file', 'class'=>'span2', 'id'=>'fileUp'), 'License', 'arquivo')?>
											<input type="file" class="span8" id="fileUp" name="uploadFile" />
											<div class="note large">
		                        						<i class="icon-warning-sign"></i> Atenção: Caso exista mais de um comprovante os mesmo devem ser compactados em um unico arquivo.
		                      						</div>
		                      					</span>
									<?$form->InputGroup_End()?>

								<?Form_html::form_END()?>
								<?Form_html::form_actions_START()?>
									<button type="submit" class="btn btn-blue" id="saveNewRecord"><i class="icon-save"></i> Salvar</button>
									<a href="<?=WWWROOT?>" class="btn btn-gold"><i class="icon-remove-sign"></i> Cancelar</a>
								<?Form_html::form_actions_END()?>
							<?$form->End()?>
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
		                    <?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable','id'=>'formAutho'));
		                    $form->Start();?>
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
			$('.btn-blue').click(function(e)
			{
				var href = $(this).attr('href');
				$('#confirmation_modal_record').modal({show: true});
				$('#confirm_danger_record').click(function(e)
				{
					e.preventDefault();
				});
				e.preventDefault();
			});
		</script>
			<script type="text/javascript">
            $('#time').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            });
        </script>
		<script type="text/javascript">
			/*$(document).ready(function(){
				$('.iCheck-helper').click(function(){
				    	if ($(this).val())
				    	{
				        	$("#group_form").submit();
				    	}
				    	return false;
				    	$("#textSelect").html("Deu certo");
				});
			});*/
		</script>
	</body>
</html>
