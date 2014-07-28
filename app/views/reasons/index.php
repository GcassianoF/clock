<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Reasons");
			auth("yes");
			$reasons_controller = new Reasons_Controller();
			if (array_key_exists('deleted', $_SESSION))
			{
				$MSG->success[] = "Reasons Excluido.";
				unset($_SESSION['deleted']);
			}
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>
			<?Menus_Controller::breadcrumbs("reasons", "icon-picture", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-list", "Coloque aqui o Titulo da Lista");?>
							<div id="dataTables">
								<?if ($reasons_list = $reasons_controller->filter()):?>
									<table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
										<thead>
											<tr>
												<th style="width:60px"><stong>CODIGO</stong></th>
												<th><stong>DESCRIÇÃO</stong></th>
												<th><stong>STATUS</stong></th>
												<th style="width:120px"><stong>Opções</stong></th>
											</tr>
										</thead>
										<tbody>
											<?foreach($reasons_list['query'] as $reasons):?>
												<tr>
													<td class="center"><?=$reasons->id?></td>
													<td class="center"><?=$reasons->descricao?></td>
													<td class="center"><?=$reasons->status?></td>
													<td class="center">
														<a href="<?=WWWROOT.'/reasons/show/'.$reasons->id?>" class="btn btn-mini btn-gray tip" title="Detalhes"><i class="icon-list-alt"></i></a>
														<a href="<?=WWWROOT.'/reasons/update/'.$reasons->id?>" class="btn btn-mini btn-black tip" title="Editar"><i class="icon-edit"></i></a>
														<a href="<?=WWWROOT.'/reasons/delete/'.$reasons->id?>" class="btn btn-mini btn-red tip" title="Excluir"><i class="icon-trash icon-white"></i></a>
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
								<span class="pull-right"><a href="<?=WWWROOT.'/reasons/add'?>" class="btn btn-blue tip" title="Detalhes"><i class="icon-plus"></i> Novo Cadastro</a></span>
							<?Form_html::form_actions_END()?>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
			<?HTML::container_END();?>
		<?HTML::main_content_END();?>
		<?scripts();?>
	</body>
</html>
