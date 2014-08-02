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

<style type="text/css">

.clock {margin:0 auto; padding:30px; border:1px solid #333; color:#fff; }

#Date { font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; font-size:36px; text-align:center; text-shadow:0 0 5px #00c6ff; }

.hms { display:inline; font-size:2.5em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff; }

#point { position:relative; -moz-animation:mymove 1s ease infinite; -webkit-animation:mymove 1s ease infinite; padding-left:10px; padding-right:10px; }


</style>
<script type="text/javascript">
$(document).ready(function() {
// Create two variable with the names of the months and days in an array
var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ]; 
var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]

// Create a newDate() object
var newDate = new Date();
// Extract the current date from Date object
newDate.setDate(newDate.getDate());
// Output the day, date, month and year    
$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

setInterval( function() {
	// Create a newDate() object and extract the seconds of the current time on the visitor's
	var seconds = new Date().getSeconds();
	// Add a leading zero to seconds value
	$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
	},1000);
	
setInterval( function() {
	// Create a newDate() object and extract the minutes of the current time on the visitor's
	var minutes = new Date().getMinutes();
	// Add a leading zero to the minutes value
	$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
    },1000);
	
setInterval( function() {
	// Create a newDate() object and extract the hours of the current time on the visitor's
	var hours = new Date().getHours();
	// Add a leading zero to the hours value
	$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    }, 1000);
	
}); 
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
<div class="BreakingNewsController easing" id="breakingnews">
        	<div class="bn-title"></div>
            <ul>
        	<?$records_controller->statusUserNow();?>
 </ul>
            <div class="bn-arrows"><span class="bn-arrows-left"></span><span class="bn-arrows-right"></span></div>	
        </div>
<br/>
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