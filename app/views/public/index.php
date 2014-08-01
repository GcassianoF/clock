<?php
   /*###################################################
   #														      #
   #	@author Giceu Cassiano / Gianfrank Zingarelli						      #
   #    @updated 20/05/2013										      #
   #   														      #
   #    Referencia: Trabalho de conclusão do curso 						      #
   #	Intituição: UnP Universidade Potiguar							      #
   #														      #
   #	Este  Software  é  destinado a o TCC (Trabalho de conclusão do Curso)	               #
   #	da minha graduação em Sistemas de Informação pela instituição sitado acima.    #
   #														      #
   ####################################################*/
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php
			head('Painel');
			auth("yes");
			$records_controller = new Records_Controller();
		?>
		<link href="<?=WEBROOT?>/plugins/css/maps/estilo.css" media="screen" rel="stylesheet" type="text/css" />
		<style type="text/css">
			${demo.css}
		</style>
		<script type="text/javascript">
			<?$records_controller->mediaRegistroForUsuario();?>

			<?$records_controller->mediaRegistroForAtrasoUsuario();?>
		</script>
		<script type="text/javascript">
			<?$records_controller->mediaRegistroForFaltasUsuario();?>
		</script>

	</head>
	<body>
		
		<?$records_controller->nowRegisterForUser();?>
		<script src="<?=WEBROOT?>/plugins/hightcharts/js/highcharts.js" type="text/javascript"></script>
		<script src="<?=WEBROOT?>/plugins/hightcharts/js/modules/exporting.js" type="text/javascript"></script>
		<?topbar();?>
		<?include DOCROOT."/app/views/protected/sidebar.php";?>
		<!-- INICIO CENTER MASTER -->
			<?HTML::main_content_START("main-content");?>
				<?bar($icon="icon-dashboard", $titulo="Dashboard", $descricao="Calendario mensal com as horas registradas por dia.");?>
				




				<?default_messages()?>
				<?HTML::container_START("container-fluid padded");?>
<div id="breadcrumbs" style="height:40px">			
<div id="TickerStatus" >
<ul><?$records_controller->statusUserNow();?></ul>
</div>						
</div>
<br/><br/>
					<?HTML::row_START("row-fluid");?>
						<?HTML::span_START("12");?>
							<div class="box">
								<div class="box-header">
									<ul class="nav nav-tabs nav-tabs-left">
										<li class="active">
											<a href="#d001" class="" data-toggle="tab" >
												<span class="label label-black">
													<?=date('d/m/Y');?>
												</span>
											</a>
										</li>
										<li class="">
											<a href="#d002" data-toggle="tab">
												<span class="label label-black">
													<?
														$totime = strtotime("-1 days");
														$time = date("d/m/Y",$totime);
														echo $time;
													?>
												</span>
											</a>
										</li>
										<li class="">
											<a href="#d003" data-toggle="tab">
												<span class="label label-black">
													<?
														$totime = strtotime("-2 days");
														$time = date("d/m/Y",$totime);
														echo $time;
													?>
												</span>
											</a>
										</li>
										<li class="">
											<a href="#d004" data-toggle="tab">
												<span class="label label-black">
													<?
														$totime = strtotime("-3 days");
														$time = date("d/m/Y",$totime);
														echo $time;
													?>
												</span>
											</a>
										</li>
										<li class="">
											<a href="#d005" data-toggle="tab">
												<span class="label label-black">
													<?
														$totime = strtotime("-4 days");
														$time = date("d/m/Y",$totime);
														echo $time;
													?>
												</span>
											</a>
										</li>
									</ul>
									<div class="title">Registro dos 5 ultimos dias</div>
								</div>
								<div class="box-content" style="font-size:0.85em">
									<div class="tab-content">
										<div class="tab-pane active" id="d001">
											<br/>
											<div align="center" class="well">
												<span class="pull-right label label-blue"><?=date('d/m/Y');?></span>
												<legend>Registro Diario</legend>
												<br/>
													<?$records_controller->nowRegister();?>
												<br/>
											</div>
										</div>
										<div class="tab-pane" id="d002">
											<br/>
											<div align="center" class="well">
												<span class="pull-right label label-blue">
													<?
														$totime = strtotime("-1 days");
														$time = date("d/m/Y",$totime);
														$obj = explode("/", $time);
														$var = $obj[2]."-".$obj[1]."-".$obj[0];
														echo $time;
													echo '</span>';
													echo '<legend>Registro Diario</legend>';
													echo '<br/>';
													$records_controller->nowRegister($var);
													?>
												<br/>
											</div>
										</div>
										<div class="tab-pane" id="d003">
											<br/>
											<div align="center" class="well">
												<span class="pull-right label label-blue">
													<?
														$totime = strtotime("-2 days");
														$time = date("d/m/Y",$totime);
														$obj = explode("/", $time);
														$var = $obj[2]."-".$obj[1]."-".$obj[0];
														echo $time;
													echo '</span>';
													echo '<legend>Registro Diario</legend>';
													echo '<br/>';
													$records_controller->nowRegister($var);
													?>
												<br/>
											</div>
										</div>
										<div class="tab-pane" id="d004">
											<br/>
											<div align="center" class="well">
												<span class="pull-right label label-blue">
													<?
														$totime = strtotime("-3 days");
														$time = date("d/m/Y",$totime);
														$obj = explode("/", $time);
														$var = $obj[2]."-".$obj[1]."-".$obj[0];
														echo $time;
													echo '</span>';
													echo '<legend>Registro Diario</legend>';
													echo '<br/>';
													$records_controller->nowRegister($var);
													?>
												<br/>
											</div>
										</div>
										<div class="tab-pane" id="d005">
											<br/>
											<div align="center" class="well">
												<span class="pull-right label label-blue">
													<?
														$totime = strtotime("-4 days");
														$time = date("d/m/Y",$totime);
														$obj = explode("/", $time);
														$var = $obj[2]."-".$obj[1]."-".$obj[0];
														echo $time;
													echo '</span>';
													echo '<legend>Registro Diario</legend>';
													echo '<br/>';
													$records_controller->nowRegister($var);
													?>
												<br/>
											</div>
										</div>
									</div>
								</div>
								<div class="box-footer padded">

								</div>
							</div>
						<?HTML::span_END();?>
					<!--	<?HTML::span_START("3");?>
							<div class="box" style="font-size:0.8em">
								<div class="box-header">
									<span class="title"> <b><?=date('d/m/Y');?></b></span>
								</div>
								<div class="box-content padded">
									
								</div>
								<div class="box-footer padded">

								</div>
							</div>
						<?HTML::span_END();?> -->
					<?HTML::row_END();?>
					<?HTML::row_START("row-fluid");?>
						<?HTML::span_START("6");?>
							<div class="box">
								<div class="box-header">
									<span class="title">&nbsp;</span>
								</div>
								<div class="box-content">
									<br/>
									<?$records_controller->atrasosPorMesPorUser();?>
								</div>
								<div class="box-footer padded">

								</div>
							</div>
						<?HTML::span_END();?>
						<?HTML::span_START("6");?>
							<div class="box">
								<div class="box-header">
									<span class="title">&nbsp;</span>
								</div>
								<div class="box-content">
									<br/>
									<?$records_controller->totalFaltasPorUser();?>
								</div>
								<div class="box-footer padded">

								</div>
							</div>
						<?HTML::span_END();?>
					<?HTML::row_END();?>
					<?HTML::row_START("row-fluid");?>
						<?HTML::span_START("6");?>
							<div class="box">
								<div class="box-header">
									<span class="title">&nbsp;</span>
								</div>
								<div class="box-content">
									<div id="containerAtraso" style="min-width: 440px; height: 350px; margin: 0 auto"></div>
								</div>
								<div class="box-footer padded">

								</div>
							</div>
						<?HTML::span_END();?>
						<?HTML::span_START("6");?>
							<div class="box">
								<div class="box-header">
									<span class="title">&nbsp;</span>
								</div>
								<div class="box-content">
									<div id="containerFaltas" style="min-width: 440px; height: 350px; margin: 0 auto"></div>
								</div>
								<div class="box-footer padded">

								</div>
							</div>
						<?HTML::span_END();?>
					<?HTML::row_END();?>
					<?HTML::row_START("row-fluid");?>
						<?HTML::span_START("12");?>
							<div class="box">
								<div class="box-header">
									<span class="title">&nbsp;</span>
								</div>
								<div class="box-content">
									<div id="container" style=""></div>
								</div>
								<div class="box-footer padded">

								</div>
							</div>
						<?HTML::span_END();?>
					<?HTML::row_END();?>
				<?HTML::container_END();?>
			<?HTML::main_content_END();?>
			<?scripts();?>
		<!-- FIM CENTER MASTER -->
	</body>
</html>