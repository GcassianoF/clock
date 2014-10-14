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
				<div class="BreakingNewsController easing" id="breakingnews">
					<div class="bn-title"></div>
					<ul>
						<?$records_controller->statusUserNow();?>
					</ul>
					<div class="bn-arrows"><span class="bn-arrows-left"></span><span class="bn-arrows-right"></span></div>
				</div>
				<?bar($icon="icon-dashboard", $titulo="Dashboard", $descricao="Calendario mensal com as horas registradas por dia.");?>
				<?default_messages()?>
				<?HTML::container_START("container-fluid padded");?>
					<?HTML::row_START("row-fluid");?>
						<?HTML::span_START("12");?>
							<div class="box">
								<?$records_controller->calendarioDash();?>
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
		<!-- FIM CENTER MASTER -->
	</body>
</html>