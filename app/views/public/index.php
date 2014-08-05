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
				<?Menus_Controller::breadcrumbs("", "", null, null, null);?>
				<?default_messages()?>
				<?HTML::container_START("container-fluid padded");?>
					<?HTML::row_START("row-fluid");?>
						<div align="center" class="well"><img src="<?=WEBROOT?>/images/indra.png" alt="Indra Company" style="margin:9px 5px 5px 0px" height="100%" width="100%"></div>
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