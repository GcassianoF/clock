<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Navigation_menus");
			auth("yes");
			$navigation_menus_controller = new Navigation_menus_Controller();
			if (array_key_exists('deleted', $_SESSION))
			{
				$MSG->success[] = "Navigation_menus Excluido.";
				unset($_SESSION['deleted']);
			}
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>
			<?Menus_Controller::breadcrumbs("navigation_menus", "icon-picture", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-list", "Coloque aqui o Titulo da Lista");?>
							<div id="dataTables">
								<?if ($navigation_menus_list = $navigation_menus_controller->filter()):?>
									<table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
										<thead>
											<tr>
												<th><stong>ID</stong></th>
												<th><stong>NOME</stong></th>
												<th><stong>ICONE</stong></th>
												<th><stong>DESCRICAO</stong></th>
												<th><stong>POSICAO</stong></th>
												<th><stong>CREATED_AT</stong></th>
												<th><stong>UPDATED_AT</stong></th>
												<th><stong>DELETED_AT</stong></th>
												<th style="width:120px"><stong>Opções</stong></th>
											</tr>
										</thead>
										<tbody>
											<?foreach($navigation_menus_list['query'] as $navigation_menus):?>
												<tr>
													<td><?=$navigation_menus->id?></td>
													<td><?=$navigation_menus->nome?></td>
													<td><?=$navigation_menus->icone?></td>
													<td><?=$navigation_menus->descricao?></td>
													<td><?=$navigation_menus->posicao?></td>
													<td style="text-align:center"><?=format_date($navigation_menus->created_at, "/")?></td>
													<td style="text-align:center"><?=format_date($navigation_menus->updated_at, "/")?></td>
													<td style="text-align:center"><?=format_date($navigation_menus->deleted_at, "/")?></td>
													<td class="center">
														<a href="<?=WWWROOT.'/navigation_menus/show/'.$navigation_menus->id?>" class="btn btn-mini btn-gray tip" title="Detalhes"><i class="icon-list-alt"></i></a>
														<a href="<?=WWWROOT.'/navigation_menus/update/'.$navigation_menus->id?>" class="btn btn-mini btn-black tip" title="Editar"><i class="icon-edit"></i></a>
														<a href="<?=WWWROOT.'/navigation_menus/delete/'.$navigation_menus->id?>" class="btn btn-mini btn-red tip" title="Excluir"><i class="icon-trash icon-white"></i></a>
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
								<span class="pull-right"><a href="<?=WWWROOT.'/navigation_menus/add'?>" class="btn btn-blue tip" title="Detalhes"><i class="icon-plus"></i> Novo Cadastro</a></span>
							<?Form_html::form_actions_END()?>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
			<?HTML::container_END();?>
		<?HTML::main_content_END();?>
		<?scripts();?>
	</body>
</html>
