<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Licenses");
			auth("yes");
			$licenses_controller = new Licenses_Controller();
			if (array_key_exists('deleted', $_SESSION))
			{
				$MSG->success[] = "Licenses Excluido.";
				unset($_SESSION['deleted']);
			}
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>
			<?Menus_Controller::breadcrumbs("licenses", "icon-picture", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-list", "Coloque aqui o Titulo da Lista");?>
							<div id="dataTables">
								<?if ($licenses_list = $licenses_controller->filter()):?>
									<table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
										<thead>
											<tr>
												<th><stong>ID</stong></th>
												<th><stong>USER_ID</stong></th>
												<th><stong>FILE_ID</stong></th>
												<th><stong>DATA</stong></th>
												<th><stong>HORA</stong></th>
												<th><stong>DATAHORA</stong></th>
												<th><stong>JUSTIFICATIVA</stong></th>
												<th><stong>ATESTADO</stong></th>
												<th><stong>CREATED_AT</stong></th>
												<th><stong>UPDATED_AT</stong></th>
												<th><stong>DELETED_AT</stong></th>
												<th style="width:120px"><stong>Opções</stong></th>
											</tr>
										</thead>
										<tbody>
											<?foreach($licenses_list['query'] as $licenses):?>
												<tr>
													<td><?=$licenses->id?></td>
													<td><?=$licenses->user_id?></td>
													<td><?=$licenses->file_id?></td>
													<td><?=$licenses->data?></td>
													<td><?=$licenses->hora?></td>
													<td style="text-align:center"><?=format_date($licenses->dataHora, "/")?></td>
													<td><?=$licenses->justificativa?></td>
													<td><?=$licenses->atestado?></td>
													<td style="text-align:center"><?=format_date($licenses->created_at, "/")?></td>
													<td style="text-align:center"><?=format_date($licenses->updated_at, "/")?></td>
													<td style="text-align:center"><?=format_date($licenses->deleted_at, "/")?></td>
													<td class="center">
														<a href="<?=WWWROOT.'/licenses/show/'.$licenses->id?>" class="btn btn-mini btn-gray tip" title="Detalhes"><i class="icon-list-alt"></i></a>
														<a href="<?=WWWROOT.'/licenses/update/'.$licenses->id?>" class="btn btn-mini btn-black tip" title="Editar"><i class="icon-edit"></i></a>
														<a href="<?=WWWROOT.'/licenses/delete/'.$licenses->id?>" class="btn btn-mini btn-red tip" title="Excluir"><i class="icon-trash icon-white"></i></a>
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
								<span class="pull-right"><a href="<?=WWWROOT.'/licenses/add'?>" class="btn btn-blue tip" title="Detalhes"><i class="icon-plus"></i> Novo Cadastro</a></span>
							<?Form_html::form_actions_END()?>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
			<?HTML::container_END();?>
		<?HTML::main_content_END();?>
		<?scripts();?>
	</body>
</html>
