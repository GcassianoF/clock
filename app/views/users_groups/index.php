<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Users_groups");
			auth("yes");
			$users_groups_controller = new Users_groups_Controller();
			if (array_key_exists('deleted', $_SESSION))
			{
				$MSG->success[] = "Users_groups Excluido.";
				unset($_SESSION['deleted']);
			}
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>
			<?Menus_Controller::breadcrumbs("users_groups", "icon-picture", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-list", "Coloque aqui o Titulo da Lista");?>
							<div id="dataTables">
								<?if ($users_groups_list = $users_groups_controller->filter()):?>
									<table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
										<thead>
											<tr>
												<th><stong>CODIGO</stong></th>
												<th><stong>NOME</stong></th>
												<th><stong>DESCRIÇÃO</stong></th>
												<th style="width:120px"><stong>OPÇÕES</stong></th>
											</tr>
										</thead>
										<tbody>
											<?foreach($users_groups_list['query'] as $users_groups):?>
												<tr>
													<td><?=$users_groups->id?></td>
													<td><?=$users_groups->nome?></td>
													<td><?=$users_groups->descricao?></td>
													<td class="center">
														<a href="<?=WWWROOT.'/users_groups/show/'.$users_groups->id?>" class="btn btn-mini btn-gray tip" title="Detalhes"><i class="icon-list-alt"></i></a>
														<a href="<?=WWWROOT.'/users_groups/update/'.$users_groups->id?>" class="btn btn-mini btn-black tip" title="Editar"><i class="icon-edit"></i></a>
														<a href="<?=WWWROOT.'/users_groups/delete/'.$users_groups->id?>" class="btn btn-mini btn-red tip" title="Excluir"><i class="icon-trash icon-white"></i></a>
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
								<span class="pull-right"><a href="<?=WWWROOT.'/users_groups/add'?>" class="btn btn-blue tip" title="Detalhes"><i class="icon-plus"></i> Novo Cadastro</a></span>
							<?Form_html::form_actions_END()?>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
			<?HTML::container_END();?>
		<?HTML::main_content_END();?>
		<?scripts();?>
	</body>
</html>
