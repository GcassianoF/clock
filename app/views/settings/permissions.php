<?php
/** @author Giceu Cassiano **/
?>


<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php
		head('Permissões');
		auth('yes');
		$controller = new Settings_Controller();
		$controller->permissions();
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
			<?bar($icon="icon-wrench", $titulo="Permições do Sistema", $descricao="Controle de Permições Por Usuário e Função.");?>
			<!-- FIM AREA-TOP -->

			<!-- INICIO #BREADCRUMBS -->
				<?php
					$menu = new Menus_Controller();
					$menu->breadcrumbs('Permições', 'icon-shield', null, null, null);
				?>
			<!-- FIM #BREADCRUMBS -->

			<!-- INICIO CENTER MASTER -->
			<div class="container-fluid padded">
				<?php default_messages()?>
				<div class="row-fluid">
					<div class="span6">
						<div class="box">
							<div class="box-header">
								<span class="title">Permições Por Paginas</span>
							</div>
							<div class="box-content">
								<?php if ($groups = $dao->Retrieve('Users_groups', 'ORDER BY nome ASC')):?>
									<?php $form = new Form_html(array('method'=>'get', 'id'=>'group_form'));
									$form->Start()?>
									<div class="padded">
										<div class="control-group">
											<label class="control-label">Selecione um Perfil</label>
											<div class="controls">
												<?php $form->Select($groups, array('class'=>'chzn-select', 'style'=>'width: 100%;', 'name'=>'users_group_id','id'=>'users_group_id'), 'Group', 'id', 'nome', @$_GET['users_group_id'], false)?>
											</div>
										</div>
									</div>
									<?php $form->End()?>
								<?php else:?>
									<div class="alert alert-info">Sem grupos cadastrados</div>
								<?php endif?>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="box">
							<div class="box-header">
								<span class="title">Permições Por Paginas</span>
							</div>
							<?php $controller->TBpermissions($_GET['users_group_id']) ?>
						</div>
					</div>
				</div>
			</div>
			<!-- FIM CENTER MASTER -->
		</div>
		<?php scripts()?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#users_group_id').change(function(){
			    	if ($(this).val())
			    	{
			        	$("#group_form").submit();
			    	}
			    	return false;
				});
				$('.checkall').click(function () {
			        $(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
			    });
			});
		</script>
	</body>
</html>
