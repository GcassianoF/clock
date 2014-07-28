<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Users");
			auth("yes");
			$users_controller = new Users_Controller();
			if (array_key_exists('deleted', $_SESSION))
			{
				$MSG->success[] = "Usuario Excluido do Sistema.";
				unset($_SESSION['deleted']);
			}
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-cogs", $titulo="Gerencia Usuarios do Sistema", $descricao="Exibir, Alterar e Excluir");?>
			<?Menus_Controller::breadcrumbs("Gerenciar Usuarios", "icon-group", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-list", "Listagem dos Usuarios");?>
							<div id="dataTables">
								<?if ($users_list = $users_controller->filter()):?>
									<table cellpadding="0" cellspacing="0" border="0" class="dTable responsive" style="font-size:1.1em">
										<thead>
											<tr>
												<th><stong>CODIGO</stong></th>
												<th><stong>GRUPO</stong></th>
												<th><stong>HORARIO</stong></th>
												<th><stong>NOME</stong></th>
												<th><stong>CPF</stong></th>
												<th><stong>EMAIL</stong></th>
												<th style="width:120px"><stong>Opções</stong></th>
											</tr>
										</thead>
										<tbody>
											<?foreach($users_list['query'] as $users):?>
												<?/*var_dump($users);exit();*/?>
												<tr>
													<td  class="center"><?=$users->id?></td>
													<td  class="center"><?=$users->rel['users_group']->nome?></td>
													<td  class="center"><?=$users->rel['itineraries']->descricao?></td>
													<td><?=$users->nome?></td>
													<td class="center"><?=$users->cpf?></td>
													<td><?=$users->email?></td>
													<td class="center">
														<a href="<?=WWWROOT.'/users/show/'.$users->id?>" class="btn btn-mini btn-gray tip" title="Detalhes"><i class="icon-list-alt"></i></a>
														<a href="<?=WWWROOT.'/users/update/'.$users->id?>" class="btn btn-mini btn-black tip" title="Editar"><i class="icon-edit"></i></a>
														<a href="<?=WWWROOT.'/users/delete/'.$users->id?>" class="btn btn-mini btn-red tip" title="Excluir"><i class="icon-trash icon-white"></i></a>
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
								<span class="pull-right"><a href="<?=WWWROOT.'/users/add'?>" class="btn btn-blue tip" title="Novo Registro"><i class="icon-plus"></i> Novo Cadastro</a></span>
							<?Form_html::form_actions_END()?>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
			<?HTML::container_END();?>
		<?HTML::main_content_END();?>
		<?scripts();?>
	</body>
</html>
