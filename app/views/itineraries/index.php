<?/** @author Giceu Cassiano **/?>
<!DOCTYPE hmtl>
<html lang="pt-br">
	<head>
		<?
			head("Itineraries");
			auth("yes");
			$itineraries_controller = new Itineraries_Controller();
			if (array_key_exists('deleted', $_SESSION))
			{
				$MSG->success[] = "Itineraries Excluido.";
				unset($_SESSION['deleted']);
			}
		?>
	</head>
	<body>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<?HTML::main_content_START("main-content");?>
			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>
			<?Menus_Controller::breadcrumbs("itineraries", "icon-picture", null, null, null);?>
			<?default_messages()?>
			<?HTML::container_START("container-fluid padded");?>
				<?HTML::row_START("row-fluid");?>
					<?HTML::span_START("12");?>
						<?HTML::box_START("icon-list", "Coloque aqui o Titulo da Lista");?>
							<div id="dataTables">
								<?if ($itineraries_list = $itineraries_controller->filter()):?>
									<table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">
										<thead>
											<tr>
												<th><stong>CODIGO</stong></th>	
												<th><stong>DESCRIÇÃO</stong></th>
												<th><stong>ENTRADA</stong></th>
												<th><stong>INTERVALO</stong></th>
												<th><stong>RETORNO</stong></th>
												<th><stong>SAIDA</stong></th>
												<th style="width:120px"><stong>Opções</stong></th>
											</tr>
										</thead>
										<tbody>
											<?foreach($itineraries_list['query'] as $itineraries):?>
												<tr>
													<td class="center"><?=$itineraries->id?></td>
													<td class="center"><?=$itineraries->descricao?></td>
													<td class="center"><?=$itineraries->entrada?></td>
													<td class="center"><?=$itineraries->intervalo?></td>
													<td class="center"><?=$itineraries->retorno?></td>
													<td class="center"><?=$itineraries->saida?></td>
													<td class="center">
														<a href="<?=WWWROOT.'/itineraries/show/'.$itineraries->id?>" class="btn btn-mini btn-gray tip" title="Detalhes"><i class="icon-list-alt"></i></a>
														<a href="<?=WWWROOT.'/itineraries/update/'.$itineraries->id?>" class="btn btn-mini btn-black tip" title="Editar"><i class="icon-edit"></i></a>
														<a href="<?=WWWROOT.'/itineraries/delete/'.$itineraries->id?>" class="btn btn-mini btn-red tip" title="Excluir"><i class="icon-trash icon-white"></i></a>
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
								<span class="pull-right"><a href="<?=WWWROOT.'/itineraries/add'?>" class="btn btn-blue tip" title="Detalhes"><i class="icon-plus"></i> Novo Cadastro</a></span>
							<?Form_html::form_actions_END()?>
						<?HTML::box_END();?>
					<?HTML::span_END();?>
				<?HTML::row_END();?>
			<?HTML::container_END();?>
		<?HTML::main_content_END();?>
		<?scripts();?>
	</body>
</html>
