<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Records");
			auth("yes");
			$records_controller = new Records_Controller();
			$records_controller->add();
			$Users = $dao->Retrieve("Users", "ORDER BY id");
			$Reasons = $dao->Retrieve("Reasons", "ORDER BY id");
			if (array_key_exists('deleted', $_SESSION))
			{
				$MSG->success[] = "Records Excluido.";
				unset($_SESSION['deleted']);
			}
		?>
		<script type="text/javascript">
			function enviar_formulario()
			{ 
				var formulario = document.getElementById('formAu');
				document.getElementById('Record_pwd').value = document.getElementById('Session_pwd').value;
				formulario.submit();
			}
		</script>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<div class="BreakingNewsController easing" id="breakingnews">
				<div class="bn-title"></div>
				<ul>
					<?$records_controller->statusUserNow();?>
				</ul>
				<div class="bn-arrows"><span class="bn-arrows-left"></span><span class="bn-arrows-right"></span></div>	
			</div>
			<?bar($icon="icon-calendar", $titulo="Calendario Mensal", $descricao="Calendario mensal com as horas registradas por dia.");?>
			<?Menus_Controller::breadcrumbs("Registro de Horas", "icon-time", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("",' ', 'style="text-align:center" ', '<h3>'.$records_controller->mesAtual().'</h3>');?>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("4","","");?>
						<?HTML::box_START("icon-time", "Novo Registro de Horas");?>
							<?$form = new Form_html(array('class'=>'form-horizontal fill-up validatable','id'=>'formAu'));
							$form->Start();?>
 								<?Form_html::form_START()?>
									<?$form->InputGroup_Start("Registrar")?>
										<?$form->Select($Reasons, array('class'=>'chzn-select span12','id'=>'Record_reasons'), 'Record', 'reason_id', 'descricao')?>										
									<?$form->InputGroup_End()?>
									<?$form->InputGroup_Start("Justificativa")?>
										<?$form->TextArea(array('type'=>'text', 'class'=>'span12', 'rows'=>'7', 'cols'=>'50'), 'Record', 'justificativa')?>
									<?$form->InputGroup_End()?>
									<?$form->InputGroup_Start("")?>
										<?$form->Input(array('type'=>'hidden', 'class'=>'span8','id'=>'Record_pwd'), 'Record', 'pwd')?>
									<?$form->InputGroup_End()?>
								<?Form_html::form_END()?>
								<?Form_html::form_actions_START()?>
									<button type="submit" class="btn btn-blue" id="saveNewRecord"><i class="icon-save"></i> Salvar</button>
									<a href="<?=WWWROOT?>/records" class="btn btn-gold"><i class="icon-remove-sign"></i> Cancelar</a>
								<?Form_html::form_actions_END()?>
							<?$form->End()?>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
					<?HTML::span_START("8");?>
						<?HTML::box_START("", "<i class='icon-calendar'></i>  <strong>Calendario Mensal</strong>");?>
							<?$records_controller->impr_calendar();?>
							<?Form_html::form_actions_START()?>
		
							<?Form_html::form_actions_END()?>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
			<?HTML::container_END();?>
			<!-- INICIO MODAL CONFIRMAÇÃO DE INSERSÃO -->
			    <div id="confirmation_modal_record" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
			        <div class="modal-header">
			            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			            <h3 id="myModalLabel">Autenticação</h3>
			        </div>
			        <div class="modal-body">
			            <div class="loginform-in">
			                <h2><?$records_controller->primeSegName($_SESSION['user_name']);?></h2>
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
		<?HTML::main_content_END();?>
		<?scripts();?>
		<script type="text/javascript">
			$('.btn-blue').click(function(e)
			{
				var href = $(this).attr('href');
				$('#confirmation_modal_record').modal({show: true});
				$('#confirm_danger_record').click(function(e)
				{
					//window.location = href;
					e.preventDefault();
				});
				e.preventDefault();
			});
		</script>
		<script>
			$("#breakingnews").BreakingNews
			({
				background	: 	'#FBFBFB',
				title		   	: 	'Situação Atual dos Usuarios',
				titlecolor	   	:  	'#FFF',
				titlebgcolor	   	: 	'#151B20',
				linkcolor	   	: 	'#333',
				linkhovercolor	: 	'#CC0C35',
				fonttextsize	   	: 	13,
				isbold		   	: 	false,
				border	   	: 	'solid 2px #EEEEEF',
				width			: 	'100%',
				timer			: 	2000,
				autoplay		: 	true,
				effect			: 	'slide'
			});   
		</script>
	</body>
</html>
