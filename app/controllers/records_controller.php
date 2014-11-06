<?php
	class Records_Controller extends App_Controller
	{

		private $records = false;
		public $show = false;
		public $mais = "00:00:00";
		public $menos = "00:00:00";
		public $totalJobMes = "00:00:00";

		public static function add()
		{
			global $DATA;
			global $MSG;

			if($DATA['Record'])
			{
				$dao = new DAO();
				if ($DATA['Record']['pwd'])
				{
					$data = array(
						'email' => $_SESSION['user_email'],
						'senha' => md5($DATA['Record']['pwd'])
					);

					// se houver um usuário no banco de dados com essas credenciais inicia-se a sessão
					if ($user = $dao->Retrieve('Users', $data, true, true))
					{
						$dateTime = date("Y-m-d H:i:s");
						$dateVar = date("d/m/Y");
						$var = explode(" ",$dateTime,2);
						$date = $var[0];
						$time = $var[1];
						$Users = $dao->get("Users", $_SESSION['user_id']);
						$Itinenary = $Users->rel['itineraries'];
						$Reason = $dao->get("Reasons", $DATA['Record']['reason_id']);

						if ($teste = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE data = CURRENT_DATE AND records.reason_id = ".$DATA['Record']['reason_id']." AND records.user_id = ".$_SESSION['user_id'])) {
							$MSG->info[] = "Atenção! voçê já  possui registro  de ".$Reason->descricao." para a data de hoje ".$dateVar;
						}else
						{
							$DATA['Record']['user_id'] 	= $_SESSION['user_id'];
							$DATA['Record']['data'] 	= $date;
							$DATA['Record']['hora'] 	= $time;
							$DATA['Record']['dataHora'] 	= $dateTime;

							if ($Reason->descricao === "ENTRADA") {
								$e = sum_time($Itinenary->entrada, "00:15:00");
								$j  = strtotime($e);
								$d = strtotime($time);

								$sub = sub_time($Itinenary->entrada, "00:15:00");
								$jsub  = strtotime($sub);
								$dsub = strtotime($time);

								if ($d > $j) {
									if ($DATA['Record']['justificativa'] == "") {
										$MSG->error[] = "O campo Justificativa e obrigatorio";
										$MSG->alert[] = "Seu horário de entrada é as ".$Itinenary->entrada." e você esta tentando efetuar um registro acima dos 15 minustos de tolerância sem justificativa.";
										return false;
									}
								}
								if ($dsub < $jsub) {
									$MSG->alert[] = "Seu horário de entrada é as ".$Itinenary->entrada." e você esta tentando efetuar um registro abaixo dos 15 minustos de tolerância.";
									return false;
								}
							}

							if ($Reason->descricao === "RETORNO") {

								if($RecordsNow = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE records.reason_id = 2 AND records.user_id = ".$_SESSION['user_id']))
								{
									$interv = sub_time($Itinenary->retorno, $Itinenary->intervalo);
									$registInt = $RecordsNow[0]->hora;
									$nowRet = $DATA['Record']['hora'];

									$sumTot = sum_time($interv, $registInt);
									$falta = sub_time($sumTot, $nowRet);

									$varT = strtotime($sumTot);
									$varS = strtotime($nowRet);
									$rest = substr($interv, -7, 1);
									if ($varS < $varT) {
										$MSG->error[] = "Seu tempo de intervalo e de  ".$rest." hora(s)";
										$MSG->alert[] = "Voçê ainda tem ".$falta." de intervalo";
										return false;
									}
								}
							}

							// valida as funções acima caso de erro retorna p/ o usuario
							if(check_errors())
							{
								return false;
							}

							// caso não haja error o objeto DAO e instanciado
							// instacia o objeto da Class principal
							$record = new Record($DATA['Record']);

							if($dao->Create($record))
							{
								$MSG->success[] = "Cadastro efetuado!";
								$_POST = array();
							}else
							{
								$MSG->error[] = "Erro no Cadastro. Entre em contato com o Administrador do Sistema!";
							}
						}
					}else
					{
						$MSG->error[] = 'Erro ao Autenticar. Verifique os dados.';
					}
				}else
				{
					$MSG->alert[] = "Atenção, Favor informa suas credênciais";
				}

			}
			return false;
		}

		public static function addRecords()
		{
			global $DATA;
			global $MSG;

			$dao = new DAO();
			if($DATA['Record'])
			{
				$Reason = $dao->get("Reasons", $DATA['Record']['reason_id']);

				$data = date("Y-m-d", strtotime($DATA['Record']['data']));
				$dateCompare = date("d/m/Y", strtotime($DATA['Record']['data']));
				$DATA['Record']['data'] = $data;
				$dh = $data." ".$DATA['Record']['hora'];
				$dateConv = strtotime($dh);
				$dataHora = date('Y-m-d H:i:s', $dateConv);

				$DATA['Record']['dataHora'] = $dataHora;


				validates_presence_of('Record', 'hora', 'HORA');
				validates_presence_of('Record', 'data', 'DATA');
				validates_presence_of('Record', 'justificativa', 'JUSTIFICATIVA');
				validates_presence_of('Record', 'user_id', 'USUARIO');


				if(check_errors())
				{
					return false;
				}

				if ($validade = $dao->get("Records", " WHERE data = '".$DATA['Record']['data']."'  AND records.reason_id = ".$DATA['Record']['reason_id']." AND records.user_id = ".$DATA['Record']['user_id']))
				{
					$MSG->info[] = "Atenção! O usuario já possui registro  de ".$Reason->descricao." para a data informada ".$dateCompare;
					return false;
				}else{
					if ($DATA['Record']['reason_id'] == 2)
					{
						if ($entrada = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE data = '".$DATA['Record']['data']."' AND records.reason_id = 1 AND records.user_id = ".$DATA['Record']['user_id']))
						{
							$horaAnterior 	= $entrada[0]->hora;
							$horaAtual 		= $DATA['Record']['hora'];

							$varCac01 = strtotime($horaAnterior);
							$varCac02 = strtotime($horaAtual);
							if ($varCac01 > $varCac02)
							{
								$MSG->info[] = "A hora de \"".$Reason->descricao."\" não pode ser menor que a horar de \"ENTRADA\". ";
								return false;
							}
						} else {
							$MSG->info[] = "O Usuario não possui registro  de \"ENTRADA\" para a data informada \"".$dateCompare."\", Registre primeiro a \"ENTRADA\" para poder registrar \"".$Reason->descricao."\"";
							return false;
						}
					} elseif ($DATA['Record']['reason_id'] == 3)
					{
						if ($intervalo = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE data = '".$DATA['Record']['data']."' AND records.reason_id = 2 AND records.user_id = ".$DATA['Record']['user_id']))
						{
							$horaAnterior 	= $entrada[0]->hora;
							$horaAtual 		= $DATA['Record']['hora'];

							$varCac01 = strtotime($horaAnterior);
							$varCac02 = strtotime($horaAtual);
							if ($varCac01 > $varCac02)
							{
								$MSG->info[] = "A hora de \"".$Reason->descricao."\" não pode ser menor que a horar de \"INTERVALO\". ";
								return false;
							}
						} else {
							$MSG->info[] = "O Usuario não possui registro  de \"INTERVALO\" para a data informada \"".$dateCompare."\", Registre primeiro a \"INTERVALO\" para poder registrar  \"".$Reason->descricao."\"";
							return false;
						}
					} elseif ($DATA['Record']['reason_id'] == 4)
					{
						if ($retorno = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE data = '".$DATA['Record']['data']."' AND records.reason_id = 3 AND records.user_id = ".$DATA['Record']['user_id']))
						{
							$horaAnterior 	= $entrada[0]->hora;
							$horaAtual 		= $DATA['Record']['hora'];

							$varCac01 = strtotime($horaAnterior);
							$varCac02 = strtotime($horaAtual);
							if ($varCac01 > $varCac02)
							{
								$MSG->info[] = "A hora de \"".$Reason->descricao."\" não pode ser menor que a horar de \"RETORNO\". ";
								return false;
							}
						} else {
							$MSG->info[] = "O Usuario não possui registro  de \"RETORNO\" para a data informada \"".$dateCompare."\", Registre primeiro a \"RETORNO\" para poder registrar  \"".$Reason->descricao."\"";
							return false;
						}
					}

					$record = new Record($DATA['Record']);

					if($dao->Create($record))
					{
						$MSG->success[] = "Cadastro efetuado!";
						$_POST = array();
					}else
					{
						$MSG->error[] = "Erro no Cadastro. Entre em contato com o Administrador do Sistema!";
					}
				}
			}
			return false;
		}

		public function update($record)
		{
			global $DATA;
			global $MSG;

			if($DATA['Record'])
			{
				// campos obrigatoios
				validates_presence_of('Record', 'user_id', 'USER_ID');
				validates_presence_of('Record', 'reason_id', 'REASON_ID');
				validates_presence_of('Record', 'data', 'DATA');
				validates_presence_of('Record', 'hora', 'HORA');

				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();

				$record = batch_update($record, $DATA['Record']);
				if($dao->Update($record))
				{
					$MSG->success[] = "Dados Atualizados!";
				}
			}
		}

		public function filter()
		{
			$dao  = new DAO();
			$sql  = "SELECT records.id FROM records ";
			$sql .= " WHERE records.deleted_at IS NULL ";
			$page = 1;
			if($_GET)
			{
				$page = @$_GET['page'] ? @$_GET['page'] : $page;
				$sql .= @$_GET['user_id'] ? " AND records.user_id LIKE '%".@$_GET['user_id']."%' " : "";
				$sql .= @$_GET['reason_id'] ? " AND records.reason_id LIKE '%".@$_GET['reason_id']."%' " : "";
				$sql .= @$_GET['data'] ? " AND records.data LIKE '%".@$_GET['data']."%' " : "";
				$sql .= @$_GET['hora'] ? " AND records.hora LIKE '%".@$_GET['hora']."%' " : "";
			}

			$q = mysql_query($sql) or die(mysql_error());
			if (!mysql_num_rows($q)) return false;
			while ($row = mysql_fetch_assoc($q))
			{
				$this->records[] = $dao->Retrieve('Records', $row['id'], true, true);
			}
			return parent::paginate($this->records, $page, $limit);
		}

		public function mesAtual()
		{
			$mesAtual = date('F');
			if ($mesAtual === 'January') {
				return 'Janeiro';
			}elseif ($mesAtual === 'February') {
				return 'Fevereiro';
			}elseif ($mesAtual === 'March') {
				return 'Março';
			}elseif ($mesAtual === 'April') {
				return 'Abril';
			}elseif ($mesAtual === 'May') {
				return 'Maio';
			}elseif ($mesAtual === 'June') {
				return 'Junho';
			}elseif ($mesAtual === 'July') {
				return 'Julho';
			}elseif ($mesAtual === 'August') {
				return 'Agosto';
			}elseif ($mesAtual === 'September') {
				return 'Setembro';
			}elseif ($mesAtual === 'October') {
				return 'Outubro';
			}elseif ($mesAtual === 'November') {
				return 'Novembro';
			}elseif ($mesAtual === 'December') {
				return 'Dezembro';
			}
		}

		public function nameDiaAtual($d,$m,$a,$completo=null)
		{
			$test = new DateTime(''.$a.'-'.$m.'-'.$d.'');
			$diasDasemanaCompleto = array (
			1 => "Segunda-Feira",
			2 => "Terça-Feira",
			3 => "Quarta-Feira",
			4 => "Quinta-Feira",
			5 => "Sexta-Feira",
			6 => "Sábado",
			0 => "Domingo");
			$diasDasemana = array (
			1 => "Segunda",
			2 => "Terça",
			3 => "Quarta",
			4 => "Quinta",
			5 => "Sexta",
			6 => "Sábado",
			0 => "Domingo");
			$x = date_format($test, 'w');
			if ($completo == TRUE) {
				return $diasDasemanaCompleto["$x"];
			}else{
				return $diasDasemana["$x"];
			}
		}

		public function fimDeSemana($d,$m,$a)
		{
			$test = new DateTime(''.$a.'-'.$m.'-'.$d.'');
			$x = date_format($test, 'w');
			if ($x == 6 || $x == 0) {
				return ";background-color: #c4c4c4;border:1px solid #827d7d;";
			}else{
				return "";
			}
		}

		public function impr_calendar( $mes='', $ano='')
		{
			/*send_email($destinatario="gcassianof@gmail", $menssagem="teste", $titulo="teste");*/
			$dao  = new DAO();
			$mes = !$mes ? date('m') : $mes;
			$ano = !$ano ? date('Y') : $ano;
			$estiloMes    = "";
			$estiloSemana = "";
			$estiloDia    = "";
			$estiloDiaAtual    = "";
			$totalMes = "00:00:00";

			echo '<div align="center"><table class="responsive" style="border-collapse: collapse;">
			<thead>
				<tr >
					<th style="font-size:0.8em;width:30px;height:30px"></th>
					<th style="font-size:0.8em;width:30px;height:30px"></th>
					<th style="font-size:0.8em;width:30px;height:30px"></th>
					<th style="font-size:0.8em;width:30px;height:30px"></th>
					<th style="font-size:0.8em;width:95px;height:30px"><span class="label label-success" style="font-weight: normal;width:80px;"><i class="icon-arrow-up"></i>  ENTRADA</span></th>
					<th style="font-size:0.8em;width:95px;height:30px"><span class="label label-gray" style="font-weight: normal;width:80px"><i class="icon-arrow-down"></i>  INTERVALO</span></th>
					<th style="font-size:0.8em;width:95px;height:30px"><span class="label label-info" style="font-weight: normal;width:80px"><i class="icon-arrow-up"></i>  RETORNO</span></th>
					<th style="font-size:0.8em;width:95px;height:30px"><span class="label label-important" style="font-weight: normal;width:80px"><i class="icon-arrow-down"></i>  SAIDA</span></th>
					<th style="font-size:0.8em;width:100px;height:30px"><span class="label label-black" style="font-weight: normal;width:80px"><i class="icon-time"></i>  HORAS</span></th>
					<th style="font-size:0.8em;width:100px;height:30px"><span class="label" style="font-weight: normal;width:80px"><i class="icon-plus"></i>  EXTRA</span></th>
					<th>&nbsp;&nbsp;&nbsp;</th>
				</tr>
			</thead>';
			$dia = 1;
			echo '<tbody>';

			while ( $dia <= cal_days_in_month(1, $mes, $ano) )
			{
				for ( $i = 0; $i <= 6; $i++ )
				{
					$entrada	 = null;
					$intervalo	 = null;
					$retorno	 = null;
					$saida	 	 = null;
					$extraInicio	 = null;
					$extraFim	 = null;
					$diaExtenso = null;
					if ( $dia <= cal_days_in_month(1, $mes, $ano) )
					{
						if ( date('w', mktime(0,0,0,$mes,$dia,$ano)) == $i )
						{
							$dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
							$mes = strlen($mes) <= 1 ? 0 . $mes : $mes;
							if ($dia == date('d') && $mes == date('m') && $ano == date('Y'))
							{
								$diaExtenso = $this->nameDiaAtual($dia,$mes,$ano,FALSE);
								echo '<tr style="">';
									echo '<td align="center" ><i class="icon-play"></i></td>';
									echo '<td align="right" style="background-color: #b3f5a6;font-weight:bold">'.$diaExtenso.'</td>';
									echo '<td align="center" style="background-color: #b3f5a6;">-</td>';
									echo '<td align="center" style="background-color: #b3f5a6;">'. $dia. '</td>';
									if ($entrada = $dao->get("Records", " inner join reasons r on r.id=records.reason_id
									where records.data = '".$ano."-".$mes."-".$dia."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'ENTRADA' AND records.deleted_at IS NULL")) {echo '<td align="center" style="background-color: #b3f5a6;border:1px solid #827d7d"><span class=\'label label-success\'> '.$entrada[0]->hora.'</span></td>';}else{echo '<td align="center" style="background-color: #b3f5a6;border:1px solid #827d7d"> --:--:--</td>';}
									if ($intervalo = $dao->get("Records", " inner join reasons r on r.id=records.reason_id
									where records.data = '".$ano."-".$mes."-".$dia."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'INTERVALO' AND records.deleted_at IS NULL")) {echo '<td align="center" style="background-color: #b3f5a6;border:1px solid #827d7d"><span class=\'label label-gray\'> '.$intervalo[0]->hora.'</span></td>';}else{echo '<td align="center" style="background-color: #b3f5a6;border:1px solid #827d7d"> --:--:--</td>';}
									if ($retorno = $dao->get("Records", " inner join reasons r on r.id=records.reason_id
									where records.data = '".$ano."-".$mes."-".$dia."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'RETORNO' AND records.deleted_at IS NULL")) {echo '<td align="center" style="background-color: #b3f5a6;border:1px solid #827d7d"><span class=\'label label-info\'> '.$retorno[0]->hora.'</span></td>';}else{echo '<td align="center" style="background-color: #b3f5a6;border:1px solid #827d7d"> --:--:--</td>';}
									if ($saida = $dao->get("Records", " inner join reasons r on r.id=records.reason_id
									where records.data = '".$ano."-".$mes."-".$dia."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'SAIDA' AND records.deleted_at IS NULL")) {echo '<td align="center" style="background-color: #b3f5a6;border:1px solid #827d7d"><span class=\'label label-important\'> '.$saida[0]->hora.'</span></td>';}else{echo '<td align="center" style="background-color: #b3f5a6;border:1px solid #827d7d"> --:--:--</td>';}
									$this->calcularTotalJob($ano."-".$mes."-".$dia);
									echo '<td>&nbsp;&nbsp;&nbsp;</td>';
								echo '</tr>';

							}else
							{
								/*$this->fimDeSemana($dia,$mes,$ano)*/
								echo '<tr>';
									echo '<td align="center" style="border:none"></td>';
									echo '<td align="right" style="border:none'.$this->fimDeSemana($dia,$mes,$ano).' border:none" >'. $this->nameDiaAtual($dia,$mes,$ano) . '</td>';
									echo '<td align="center" style="border:none'.$this->fimDeSemana($dia,$mes,$ano).' border:none">-</td>';
									echo '<td align="center" style="border:none'.$this->fimDeSemana($dia,$mes,$ano).' border:none">'. $dia . '</td>';
									if ($entrada = $dao->get("Records", " inner join reasons r on r.id=records.reason_id
									where records.data = '".$ano."-".$mes."-".$dia."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'ENTRADA' AND records.deleted_at IS NULL")) {echo '<td align="center" style="border:1px solid #827d7d'.$this->fimDeSemana($dia,$mes,$ano).'"><span class=\'label label-success\'> '.$entrada[0]->hora.'</span></td>';}else{echo '<td align="center" style="border:1px solid #827d7d'.$this->fimDeSemana($dia,$mes,$ano).'"> --:--:--</td>';}
									if ($intervalo = $dao->get("Records", " inner join reasons r on r.id=records.reason_id
									where records.data = '".$ano."-".$mes."-".$dia."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'INTERVALO' AND records.deleted_at IS NULL")) {echo '<td align="center" style="border:1px solid #827d7d'.$this->fimDeSemana($dia,$mes,$ano).'"><span class=\'label label-gray\'> '.$intervalo[0]->hora.'</span></td>';}else{echo '<td align="center" style="border:1px solid #827d7d'.$this->fimDeSemana($dia,$mes,$ano).'"> --:--:--</td>';}
									if ($retorno = $dao->get("Records", " inner join reasons r on r.id=records.reason_id
									where records.data = '".$ano."-".$mes."-".$dia."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'RETORNO' AND records.deleted_at IS NULL")) {echo '<td align="center" style="border:1px solid #827d7d'.$this->fimDeSemana($dia,$mes,$ano).'"><span class=\'label label-info\'> '.$retorno[0]->hora.'</span></td>';}else{echo '<td align="center" style="border:1px solid #827d7d'.$this->fimDeSemana($dia,$mes,$ano).'"> --:--:--</td>';}
									if ($saida = $dao->get("Records", " inner join reasons r on r.id=records.reason_id
									where records.data = '".$ano."-".$mes."-".$dia."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'SAIDA' AND records.deleted_at IS NULL")) {echo '<td align="center" style="border:1px solid #827d7d'.$this->fimDeSemana($dia,$mes,$ano).'"><span class=\'label label-important\'> '.$saida[0]->hora.'</span></td>';}else{echo '<td align="center" style="border:1px solid #827d7d'.$this->fimDeSemana($dia,$mes,$ano).'"> --:--:--</td>';}
									$this->calcularTotalJob($ano."-".$mes."-".$dia);
									echo '<td>&nbsp;&nbsp;&nbsp;</td>';
								echo '</tr>';


							}
							$dia++;
						}
					}
				}
			}
			echo '<tr>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td align="center" style="font-weight:bold">Mês</td>';
				echo '<td align="center" style="font-weight:bold">Extra</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;</td>';
				echo '<td id="totalVal"></td>';
				echo '<td align="center" style="font-weight:bold">'.$this->totalJobMes.'</td>';
				echo '<td align="center" style="font-weight:bold">'.$this->mais.'</td>';
			echo '</tr>';
			echo"</tbody>";
			echo"</table>";
			echo '<br/><div>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;Dia Atual: <i style="background-color:#b3f5a6; width:20px;height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>     Fim de Semana: <i style="background-color:#c4c4c4; width:20px;height:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></p>

			</div></div>';
		}

		public function calendarioDash($mes='', $ano='')
		{
			if($_GET)
			{
				$dao  = new DAO();
				$mes = $_GET['codigo'];
				$ano = !$ano ? date('Y') : $ano;

				echo
				'
					<div class="box-header">
						<ul class="nav nav-tabs nav-tabs-left">
				';
				$dia = 1;
				while ( $dia <= cal_days_in_month(1, $mes, $ano) )
				{
					for ( $i = 0; $i <= 6; $i++ )
					{
						$entrada	 = null;
						$intervalo	 = null;
						$retorno	 = null;
						$saida	 	 = null;
						$diaExtenso = null;
						if ( $dia <= cal_days_in_month(1, $mes, $ano) )
						{
							if ( date('w', mktime(0,0,0,$mes,$dia,$ano)) == $i )
							{
								$dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
								$mes = strlen($mes) <= 1 ? 0 . $mes : $mes;

								if ($dia == date('d') && $mes == date('m') && $ano == date('Y'))
								{
									echo
									'	<li class="active">
											<a href="#d00'.$dia.'" class="" data-toggle="tab" >
												<span class="label label-red">
													'.$dia.'/'.$mes.'/'.$ano.'
												</span>
											</a>
										</li>
									';
								}else
								{
									echo
									'	<li class="">
											<a href="#d00'.$dia.'" class="" data-toggle="tab" >
												<span class="label label-black">
													'.$dia.'/'.$mes.'/'.$ano.'
												</span>
											</a>
										</li>
									';
								}

								$dia++;
							}
						}
					}
				}

				$dia = 1;


				echo
				'
						</ul>
						<div class="title"><h4>'.$this->mesAtual().'</h4></div>
					</div>
					<div class="box-content" style="font-size:0.85em">
						<div class="tab-content">
				';

				while ( $dia <= cal_days_in_month(1, $mes, $ano) )
				{
					for ( $i = 0; $i <= 6; $i++ )
					{
						$entrada	 = null;
						$intervalo	 = null;
						$retorno	 = null;
						$saida	 	 = null;
						$diaExtenso = null;
						if ( $dia <= cal_days_in_month(1, $mes, $ano) )
						{
							if ( date('w', mktime(0,0,0,$mes,$dia,$ano)) == $i )
							{
								$dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
								$mes = strlen($mes) <= 1 ? 0 . $mes : $mes;

								if ($dia == date('d') && $mes == date('m') && $ano == date('Y'))
								{
									echo
									'
										<div class="tab-pane active" id="d00'.$dia.'">
											<br/>
											<div align="center" class="well">
												<span class="pull-right label label-blue">'.$dia.'/'.$mes.'/'.$ano.'</span>
												<legend>Registro Diario</legend>
												<br/>
									';
									$this->nowRegister($ano."-".$mes."-".$dia);
									echo
									'
												<br/>
											</div>
										</div>
									';
								}else
								{
									echo
									'
										<div class="tab-pane" id="d00'.$dia.'">
											<br/>
											<div align="center" class="well">
												<span class="pull-right label label-blue">'.$dia.'/'.$mes.'/'.$ano.'</span>
												<legend>Registro Diario</legend>
												<br/>
									';
									$this->nowRegister($ano."-".$mes."-".$dia);
									echo
									'
												<br/>
											</div>
										</div>
									';
								}
								$dia++;
							}
						}
					}
				}

				echo
				'
						</div>
					</div>
				';
			}else{
				$dao  = new DAO();
				$mes = !$mes ? date('m') : $mes;
				$ano = !$ano ? date('Y') : $ano;

				echo
				'
					<div class="box-header">
						<ul class="nav nav-tabs nav-tabs-left">
				';
				$dia = 1;
				while ( $dia <= cal_days_in_month(1, $mes, $ano) )
				{
					for ( $i = 0; $i <= 6; $i++ )
					{
						$entrada	 = null;
						$intervalo	 = null;
						$retorno	 = null;
						$saida	 	 = null;
						$diaExtenso = null;
						if ( $dia <= cal_days_in_month(1, $mes, $ano) )
						{
							if ( date('w', mktime(0,0,0,$mes,$dia,$ano)) == $i )
							{
								$dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
								$mes = strlen($mes) <= 1 ? 0 . $mes : $mes;

								if ($dia == date('d') && $mes == date('m') && $ano == date('Y'))
								{
									echo
									'	<li class="active">
											<a href="#d00'.$dia.'" class="" data-toggle="tab" >
												<span class="label label-red">
													'.$dia.'/'.$mes.'/'.$ano.'
												</span>
											</a>
										</li>
									';
								}else
								{
									echo
									'	<li class="">
											<a href="#d00'.$dia.'" class="" data-toggle="tab" >
												<span class="label label-black">
													'.$dia.'/'.$mes.'/'.$ano.'
												</span>
											</a>
										</li>
									';
								}

								$dia++;
							}
						}
					}
				}

				$dia = 1;


				echo
				'
						</ul>
						<div class="title"><h4>'.$this->mesAtual().'</h4></div>
					</div>
					<div class="box-content" style="font-size:0.85em">
						<div class="tab-content">
				';

				while ( $dia <= cal_days_in_month(1, $mes, $ano) )
				{
					for ( $i = 0; $i <= 6; $i++ )
					{
						$entrada	 = null;
						$intervalo	 = null;
						$retorno	 = null;
						$saida	 	 = null;
						$diaExtenso = null;
						if ( $dia <= cal_days_in_month(1, $mes, $ano) )
						{
							if ( date('w', mktime(0,0,0,$mes,$dia,$ano)) == $i )
							{
								$dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
								$mes = strlen($mes) <= 1 ? 0 . $mes : $mes;

								if ($dia == date('d') && $mes == date('m') && $ano == date('Y'))
								{
									echo
									'
										<div class="tab-pane active" id="d00'.$dia.'">
											<br/>
											<div align="center" class="well">
												<span class="pull-right label label-blue">'.$dia.'/'.$mes.'/'.$ano.'</span>
												<legend>Registro Diario</legend>
												<br/>
									';
									$this->nowRegister($ano."-".$mes."-".$dia);
									echo
									'
												<br/>
											</div>
										</div>
									';
								}else
								{
									echo
									'
										<div class="tab-pane" id="d00'.$dia.'">
											<br/>
											<div align="center" class="well">
												<span class="pull-right label label-blue">'.$dia.'/'.$mes.'/'.$ano.'</span>
												<legend>Registro Diario</legend>
												<br/>
									';
									$this->nowRegister($ano."-".$mes."-".$dia);
									echo
									'
												<br/>
											</div>
										</div>
									';
								}
								$dia++;
							}
						}
					}
				}

				echo
				'
						</div>
					</div>
				';
			}
		}

		public function calcularTotalJob($data=NULL)
		{
			$dao  		= new DAO();
			if (($entrada = $dao->get("Records", " INNER JOIN reasons r ON r.id=records.reason_id WHERE records.data = '".$data."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'ENTRADA' AND records.deleted_at IS NULL"))
				&& ($intervalo = $dao->get("Records", " INNER JOIN reasons r ON r.id=records.reason_id WHERE records.data = '".$data."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'INTERVALO' AND records.deleted_at IS NULL"))
				&& ($retorno  = $dao->get("Records", " INNER JOIN reasons r ON r.id=records.reason_id WHERE records.data = '".$data."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'RETORNO' AND records.deleted_at IS NULL"))
				&& ($saida = $dao->get("Records", " INNER JOIN reasons r ON r.id=records.reason_id WHERE records.data = '".$data."' AND records.user_id = ".$_SESSION['user_id']." AND r.descricao = 'SAIDA' AND records.deleted_at IS NULL")))
			{
				$inicio = new DateTime($entrada[0]->dataHora);
				$pausa = new DateTime($intervalo[0]->dataHora);
				$reinicio = new DateTime($retorno[0]->dataHora);
				$fim = new DateTime($saida[0]->dataHora);
				//echo $inicio.$fim;
				/*$inicio = DateTime::createFromFormat('d/m/Y H:i:s', $inicio);
				$fim = DateTime::createFromFormat('d/m/Y H:i:s', $fim);*/
				$periodo01 = $inicio->diff($pausa);
				$periodo02 = $reinicio->diff($fim);

				$value01 = $periodo01->format('%H:%I:%S');
				$value02 = $periodo02->format('%H:%I:%S');
				$total = sum_time($value01, $value02);

				$var01 = strtotime($total);
				$var02 = strtotime('08:00:00');

				if ($var01 > $var02)
				{
					$dif = sub_time($total, '08:00:00');
					$this->totalJobMes = sum_time("08:00:00", $this->totalJobMes);
					$this->mais = sum_time($this->mais, $dif);
					echo '<td align="center"  style="border:none;font-weight:bold"> 08:00:00</td>';
					echo '<td align="center" id="valHora" style="border:none;color:#468847;font-weight:bold"> + '.$dif.'</td>';
				} else {
					$dif = sub_time('08:00:00',$total);
					$this->totalJobMes = sum_time($total, $this->totalJobMes);
					$this->mais = sub_time($this->mais, $dif);
					echo '<td align="center" style="border:none;font-weight:bold"> '.$total.'</td>';
					echo '<td align="center" id="valHora" style="border:none;color:#B94A48;font-weight:bold"> - '.$dif.'</td>';
				}

				//echo '<td align="center" style="border:none"> '.$total.'</td>';
			} else {
				echo '<td align="center" style="border:none"> --:--:--</td>';
				echo '<td align="center" style="border:none"> --:--:--</td>';
			}
		}

		public function calcularTotalJobResult($data=NULL, $user=NULL)
		{
			$dao = new DAO();
			if (($entrada = $dao->get("Records", " INNER JOIN reasons r ON r.id=records.reason_id WHERE records.data = '".$data."' AND records.user_id = ".$user." AND r.descricao = 'ENTRADA' AND records.deleted_at IS NULL"))
				&& ($intervalo = $dao->get("Records", " INNER JOIN reasons r ON r.id=records.reason_id WHERE records.data = '".$data."' AND records.user_id = ".$user." AND r.descricao = 'INTERVALO' AND records.deleted_at IS NULL"))
				&& ($retorno  = $dao->get("Records", " INNER JOIN reasons r ON r.id=records.reason_id WHERE records.data = '".$data."' AND records.user_id = ".$user." AND r.descricao = 'RETORNO' AND records.deleted_at IS NULL"))
				&& ($saida = $dao->get("Records", " INNER JOIN reasons r ON r.id=records.reason_id WHERE records.data = '".$data."' AND records.user_id = ".$user." AND r.descricao = 'SAIDA' AND records.deleted_at IS NULL")))
			{
				$inicio = new DateTime($entrada[0]->dataHora);
				$pausa = new DateTime($intervalo[0]->dataHora);
				$reinicio = new DateTime($retorno[0]->dataHora);
				$fim = new DateTime($saida[0]->dataHora);
				//echo $inicio.$fim;
				/*$inicio = DateTime::createFromFormat('d/m/Y H:i:s', $inicio);
				$fim = DateTime::createFromFormat('d/m/Y H:i:s', $fim);*/
				$periodo01 = $inicio->diff($pausa);
				$periodo02 = $reinicio->diff($fim);

				$value01 = $periodo01->format('%H:%I:%S');
				$value02 = $periodo02->format('%H:%I:%S');
				$total = sum_time($value01, $value02);

				$var01 = strtotime($total);
				$var02 = strtotime('08:00:00');

				if ($var01 > $var02)
				{
					$dif = sub_time($total, '08:00:00');
					echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;font-weight:bold"> 08:00:00</td>';
					echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;color:#468847;font-weight:bold"> + '.$dif.'</td>';
				} else {
					$dif = sub_time('08:00:00',$total);
					echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;font-weight:bold"> '.$total.'</td>';
					echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;color:#B94A48;font-weight:bold"> - '.$dif.'</td>';
				}

				//echo '<td align="center" style="border:none"> '.$total.'</td>';
			} else {
				echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"> --:--:--</td>';
				echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"> --:--:--</td>';
			}
		}

		public function showItinerary()
		{
			$dao  = new DAO();
			$wq = $dao->get("Users", $_SESSION['user_id']);
			$it = $wq->rel['itineraries'];
			$result = '<span class="label label-success"><i class="icon-arrow-up"></i>  ENTRADA</span> '.$It->entrada.' <span class="label label-gray"><i class="icon-arrow-down"></i>  INTERVALO</span> ['.$It->intervalo.'] <span class="label label-info"><i class="icon-arrow-up"></i>  RETORNO</span> ['.$It->retorno.'] <span class="label label-success"><i class="icon-arrow-down"></i>  SAIDA</span> ['.$It->saida.'] ';
			return  $It->entrada;
		}

		public function nowRegister($data=NULL)
		{
			$dao  = new DAO();
			$Users = $dao->Retrieve("Users", " ORDER BY nome ");

			echo '
				<table class="table-normal responsive">
					<thead>
						<tr >
							<th style="font-size:1em;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;height:30px"></th>
							<th style="font-size:0.8em;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;width:95px;height:30px"><span class="label label-success" style="font-weight: normal;width:80px;"><i class="icon-arrow-up"></i>  ENTRADA</span></th>
							<th style="font-size:0.8em;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;width:95px;height:30px"><span class="label label-gray" style="font-weight: normal;width:80px"><i class="icon-arrow-down"></i>  INTERVALO</span></th>
							<th style="font-size:0.8em;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;width:95px;height:30px"><span class="label label-info" style="font-weight: normal;width:80px"><i class="icon-arrow-up"></i>  RETORNO</span></th>
							<th style="font-size:0.8em;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;width:95px;height:30px"><span class="label label-important" style="font-weight: normal;width:80px"><i class="icon-arrow-down"></i>  SAIDA</span></th>
							<th style="font-size:0.8em;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;width:100px;height:30px"><span class="label label-black" style="font-weight: normal;width:80px"><i class="icon-time"></i>  HORAS</span></th>
							<th style="font-size:0.8em;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;width:100px;height:30px"><span class="label" style="font-weight: normal;width:80px"><i class="icon-plus"></i>  EXTRA</span></th>
						</tr>
					</thead>'
			;
				echo '<tbody>';
			if ($data != NULL) {
				$hoje = $data;
			}else
			{
				$hoje = date('Y-m-d');
			}
			foreach ($Users as  $usuario)
			{
				$nome = "";
				if ($usuario->nome != '')
				{
					$array=explode(" ",$usuario->nome);
					if ($array[1])
					{
						$nome = $array[0].' '.$array[1];
					}else
					{
						$nome = $usuario->nome;
					}
				}else
				{
					$nome = " ";
				}

				echo '<tr>';
				echo '<td align="left" style=" font-size:1.2em;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;" >'.$nome. '</td>';
				if ($entrada = $dao->get("Records", " left join reasons r on r.id=records.reason_id
				where records.data = '".$hoje."' AND records.user_id = ".$usuario->id." AND r.descricao = 'ENTRADA' AND records.deleted_at IS NULL")) {echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"><span class=\'label label-success\'> '.$entrada[0]->hora.'</span></td>';}else{echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"> --:--:--</td>';}
				if ($intervalo = $dao->get("Records", " left join reasons r on r.id=records.reason_id
				where records.data = '".$hoje."' AND records.user_id = ".$usuario->id." AND r.descricao = 'INTERVALO' AND records.deleted_at IS NULL")) {echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"><span class=\'label label-gray\'> '.$intervalo[0]->hora.'</span></td>';}else{echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"> --:--:--</td>';}
				if ($retorno = $dao->get("Records", " left join reasons r on r.id=records.reason_id
				where records.data = '".$hoje."' AND records.user_id = ".$usuario->id." AND r.descricao = 'RETORNO' AND records.deleted_at IS NULL")) {echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"><span class=\'label label-info\'> '.$retorno[0]->hora.'</span></td>';}else{echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"> --:--:--</td>';}
				if ($saida = $dao->get("Records", " left join reasons r on r.id=records.reason_id
				where records.data = '".$hoje."' AND records.user_id = ".$usuario->id." AND r.descricao = 'SAIDA' AND records.deleted_at IS NULL")) {echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"><span class=\'label label-important\'> '.$saida[0]->hora.'</span></td>';}else{echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"> --:--:--</td>';}
				/*if ($extraInicio = $dao->get("Records", " left join reasons r on r.id=records.reason_id
				where records.data = '".$hoje."' AND records.user_id = ".$usuario->id." AND r.descricao = 'EXTRA-INICIO' AND records.deleted_at IS NULL")) {echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"><span class=\'label label-warning\'> '.$extraInicio[0]->hora.'</span></td>';}else{echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"> --:--:--</td>';}
				if ($extraFim = $dao->get("Records", " left join reasons r on r.id=records.reason_id
				where records.data = '".$hoje."' AND records.user_id = ".$usuario->id." AND r.descricao = 'EXTRA-FIM' AND records.deleted_at IS NULL")) {echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"><span class=\'label\'> '.$extraFim[0]->hora.'</span></td>';}else{echo '<td align="center" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#000000;"> --:--:--</td>';}*/
				$this->calcularTotalJobResult($hoje, $usuario->id);
				echo '</tr>';
			}
			echo"</tbody>";
			echo"</table>";
		}

		public function primeSegName($nome)
		{
			if ($nome != '')
			{
				$array=explode(" ",$nome);
				if ($array[1])
				{
					echo $array[0].' '.$array[1];
				}else
				{
					echo $nome;
				}
			}else
			{
				echo " ";
			}
		}

		public function mediaRegistroForUsuario()
		{
			$dao  = new DAO();
			$Users = $dao->Retrieve("Users", " ORDER BY nome ");

			$this-> totalAtrasosPorMes();
			echo "
			$(function () {
			$('#container').highcharts({
			chart: {
			type: 'column'
			},
			title: {
			text: 'Media de Registros Mensal dos Usuarios'
			},
			subtitle: {
			text: 'São Computados Apenas Registros Completos (ENTRADA, INTERVALO, RETORNO, SAIDA)'
			},
			xAxis: {
			type: 'category',
			labels: {
			rotation: -45,
			style: {
			fontSize: '13px',
			fontFamily: 'Verdana, sans-serif'
			}
			}
			},
			yAxis: {
			min: 0,
			title: {
			text: 'Dias Trabalhaveis No Mês Atual (".$this->mesAtual()."):  ".$this->diasTrabalhaveis()." Dias'
			}
			},
			legend: {
			enabled: false
			},
			tooltip: {
			pointFormat: 'Quantidades de Dias Registrado no Mês Atual: <b>{point.y:.1f} dias</b> de <b>".$this->diasTrabalhaveis()." dias</b> passiveis de trabalho',
			},
			series: [{
			name: 'Usuarios',
			data: [
			";
			echo "['<b style=\"color:blue\">Dias Trabalhaveis</b>', ".$this->diasTrabalhaveis()."],";
			$result = count($Users);
			$js = "";
			foreach ($Users as  $usuario)
			{
				$nome = "";
				if ($usuario->nome != '')
				{
					$array=explode(" ",$usuario->nome);
					if ($array[1])
					{
						$nome = $array[0].' '.$array[1];
					}else
					{
						$nome = $usuario->nome;
					}
				}else
				{
					$nome = " ";
				}
				$valor = $this->calendarioMesnsal($usuario->id);
				$js .= "['<b>".$nome."</b>', ".$valor."]";
				$result = $result - 1;
				if ($result > 0) {
					$js .= ",";
				}
			}
			echo $js;
			echo"
			],
			dataLabels: {
			enabled: true,
			rotation: -90,
			color: '#FFFFFF',
			align: 'right',
			x: 4,
			y: 10,
			style: {
			fontSize: '13px',
			fontFamily: 'Verdana, sans-serif',
			textShadow: '0 0 3px black'
			}
			}
			}]
			});
			});
			";
		}

		public function mediaRegistroForAtrasoUsuario()
		{
			$nowAno = date('Y');
			echo "$(function () {
			$('#containerAtraso').highcharts({
			chart: {
			type: 'column',
			margin: 75,
			options3d: {
			enabled: true,
			alpha: 10,
			beta: 25,
			depth: 70
			}
			},
			title: {
			text: 'Atrasos no Ano: ".$nowAno."'
			},
			subtitle: {
			text: 'Total de atrasos no ano de todos os Usuarios'
			},
			plotOptions: {
			column: {
			depth: 50
			}
			},
			xAxis: {
			categories: Highcharts.getOptions().lang.shortMonths
			},
			yAxis: {
			opposite: true
			},
			series: [{
			name: 'Atrasos',";
			echo "data: [";
			$var = 12;
			$js = "";
			for ($i=0; $i < 12; $i++) {
				$mes = $i+1;
				$ano = date('Y');
				$dia = date("t", mktime(0, 0, 0, $mes, 1, $ano));

				$js .=  $this->totalAtrasosPorMesAno($dia,$mes);
				if ($i != 11) {
					$js .= ",";
				}
			}
			echo $js;
			echo"]
			}]
			});
			});";

		}

		public function mediaRegistroForFaltasUsuario()
		{
			$dao 	= new DAO();
			$Users = $dao->Retrieve("Users", " ORDER BY nome ");

			$nowAno = date('Y');
			echo "$(function () {
			$('#containerFaltas').highcharts({
			chart: {
			type: 'bar',
			margin: 75,
			options3d: {
			enabled: true,
			alpha: 10,
			beta: 25,
			depth: 70
			}
			},
			title: {
			text: 'Faltas no Ano: ".$nowAno."'
			},
			subtitle: {
			text: 'Total de faltas no ano de todos os Usuarios'
			},
			plotOptions: {
			column: {
			depth: 50
			}
			},
			xAxis: {
			categories: Highcharts.getOptions().lang.shortMonths
			},
			yAxis: {
			opposite: false
			},
			series: [{
			name: 'Faltas',";
			echo "data: [";
			$var = 12;
			$js = "";
			$Janeiro	=	0;
			$Fevereiro	=	0;
			$Marco	=	0;
			$Abril		=	0;
			$Maio		=	0;
			$Junho	=	0;
			$Julho	=	0;
			$Agosto	=	0;
			$Setembro	=	0;
			$Outubro	=	0;
			$Novembro	=	0;
			$Dezembro	=	0;
			for ($i=0; $i < 12; $i++) {
				$count = 0;
				$mes = $i+1;
				if ($mes == 1) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Janeiro = $count;
				}
				if ($mes == 2) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Fevereiro = $count;
				}
				if ($mes == 3) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Marco = $count;
				}
				if ($mes == 4) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Abril = $count;
				}
				if ($mes == 5) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Maio = $count;
				}
				if ($mes == 6) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Junho = $count;
				}
				if ($mes == 7) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Julho = $count;
				}
				if ($mes == 8) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Agosto = $count;
				}
				if ($mes == 9) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Setembro = $count;
				}
				if ($mes == 10) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Outubro = $count;
				}
				if ($mes == 11) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Novembro = $count;
				}
				if ($mes == 12) {
					foreach ($Users as $use) {
						$count += $this->calendarioMesnsalFaltas($usuario->id,$mes);
					}
					$Dezembro = $count;
				}

			}
			echo $Janeiro.",".$Fevereiro.",".$Marco.",".$Abril.",".$Maio.",".$Junho.",".$Julho.",".$Agosto.",".$Setembro.",".$Outubro.",".$Novembro.",".$Dezembro;
			echo"]
			}]
			});
			});";

		}

		function verificarRegistroCompleto($data=NULL, $user=NULL,$model=TRUE)
		{
			$dao  	 = new DAO();
			$e		 = false;
			$i 		 = false;
			$r		 = false;
			$s 		 = false;
			$now 	 = date('Y-m-d');
			if ($data <= $now) {
				if($data != NULL && $user != NULL)
				{
					if($ent = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE data = '".$data."' AND records.reason_id = 1 AND records.user_id = ".$user." "))
					{
						$e 	= true;
					}
					if($int = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE data = '".$data."' AND records.reason_id = 2 AND records.user_id = ".$user." "))
					{
						$i 	= true;
					}
					if($ret = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE data = '".$data."' AND records.reason_id = 3 AND records.user_id = ".$user." "))
					{
						$r 	= true;
					}
					if($sai = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE data = '".$data."' AND records.reason_id = 4 AND records.user_id = ".$user." "))
					{
						$s 	= true;
					}

				}
				if ($model)
				{
					if ($e == true && $i == true && $r == true && $s == true)
					{
						return  true;
					}else
					{
						return false;
					}
				}else
				{
					if ($e == false)
					{
						return  true;
					}else
					{
						return false;
					}
				}
			}else
			{
				return false;
			}
		}

		function calendarioMesnsal($usuario=NULL)
		{
			$mes = null;
			$ano = null;
			$mes = !$mes ? date('m') : $mes;
			$ano = !$ano ? date('Y') : $ano;
			$dia = 1;
			$totalRegistros = 0;
			while ($dia <= cal_days_in_month(1, $mes, $ano) )
			{
				for ( $i = 0; $i <= 6; $i++ )
				{
					if ( $dia <= cal_days_in_month(1, $mes, $ano) )
					{
						if ( date('w', mktime(0,0,0,$mes,$dia,$ano)) == $i )
						{
							$dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
							$mes = strlen($mes) <= 1 ? 0 . $mes : $mes;
							$dataVar = $ano."-".$mes."-".$dia;
							if ($this->verificarRegistroCompleto($dataVar, $usuario, TRUE))
							{
								$totalRegistros = $totalRegistros+1;
							}
							$dia++;
						}
					}
				}
			}
			return $totalRegistros;
		}

		function calendarioMesnsalFaltas($usuario=NULL,$mesPesquisa=NULL)
		{
			$mes = $mesPesquisa;
			$ano = null;
			if ($mes == null) {
				$mes = date('m');
			}
			$ano = !$ano ? date('Y') : $ano;
			$dia = 1;
			$totalRegistros = 0;
			while ($dia <= cal_days_in_month(1, $mes, $ano) )
			{
				for ( $i = 0; $i <= 6; $i++ )
				{
					if ( $dia <= cal_days_in_month(1, $mes, $ano) )
					{
						if ( date('w', mktime(0,0,0,$mes,$dia,$ano)) == $i )
						{
							$dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
							$mes = strlen($mes) <= 1 ? 0 . $mes : $mes;
							$dataVar = $ano."-".$mes."-".$dia;
							if (!$this->fimDeSemanaAtual($dataVar))
							{
								if ($this->verificarRegistroCompleto($dataVar, $usuario, FALSE))
								{
									$totalRegistros = $totalRegistros+1;
								}
							}
							$dia++;
						}
					}
				}
			}

			return $totalRegistros;
		}

		public function diasTrabalhaveis()
		{
			$mes = null;
			$ano = null;
			$mes = !$mes ? date('m') : $mes;
			$ano = !$ano ? date('Y') : $ano;
			$dia = 1;
			$totalRegistros = 0;
			while ($dia <= cal_days_in_month(1, $mes, $ano) )
			{
				for ( $i = 0; $i <= 6; $i++ )
				{
					if ( $dia <= cal_days_in_month(1, $mes, $ano) )
					{
						if ( date('w', mktime(0,0,0,$mes,$dia,$ano)) == $i )
						{
							$dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
							$mes = strlen($mes) <= 1 ? 0 . $mes : $mes;
							$dataVar = $ano."-".$mes."-".$dia;
							if ($this->fimDeSemanaAtual($dataVar))
							{
								$totalRegistros = $totalRegistros+1;
							}
							$dia++;
						}
					}
				}
			}
			$result = $dia - $totalRegistros;
			return $result;
		}

		public function totalAtrasosPorMes($userId=4)
		{
			$dao 		= new DAO();
			$user		= $userId;
			$dataInicio = date('Y')."-".date('m')."-01";
			$dataFinal	= date('Y-m-d');
			$sql 		= "SELECT COUNT(*) AS total FROM records r
			INNER JOIN reasons rs ON rs.id = r.reason_id
			INNER JOIN users u ON u.id = r.user_id
			INNER JOIN itineraries i ON i.id = u.itineraries_id
			WHERE r.reason_id = 1
			AND r.user_id = {$user}
			AND r.hora > (ADDTIME(i.entrada, '00:15:00'))
			AND r.data BETWEEN '{$dataInicio}' AND '{$dataFinal}'";
			$count = 0;
			$count = $dao->SQLcount($sql);
			if ($count)
			{
				return $count;
			}else
			{
				return 0;
			}
		}

		public function totalAtrasosPorMesAno($dia,$mes)
		{
			$dao 		= new DAO();
			$user		= $userId;
			$dataInicio = date('Y')."-".$mes."-01";
			$dataFinal	= date('Y')."-".$mes."-".$dia;
			$sql 		= "SELECT COUNT(*) AS total FROM records r
			INNER JOIN reasons rs ON rs.id = r.reason_id
			INNER JOIN users u ON u.id = r.user_id
			INNER JOIN itineraries i ON i.id = u.itineraries_id
			WHERE r.reason_id = 1
			AND r.hora > (ADDTIME(i.entrada, '00:15:00'))
			AND r.data BETWEEN '{$dataInicio}' AND '{$dataFinal}'";
			$count = 0;
			$count = $dao->SQLcount($sql);
			if ($count)
			{
				return $count;
			}else
			{
				return 0;
			}
		}

		public function atrasosPorMesPorUser()
		{
			$dao 	= new DAO();
			$Users = $dao->Retrieve("Users", " ORDER BY nome ");
			$total = 0;
			foreach ($Users as  $usuario)
			{
				$total = $total + $this->totalAtrasosPorMes($usuario->id);
			}
			echo '<div class="well" align="center">
					<span class="pull-right label label-blue"> Total Geral: '.$total.'</span>';
					echo'<legend> Atrasos No Mês</legend>';
			echo '<table class="table table-normal responsive">';
				echo'<thead>
						<tr >
							<th style="font-size:1em;height:30px"></th>
							<th style="font-size:1em;height:30px;text-align:center">Total: <strong>'.$this->mesAtual().'</strong></th>
						</tr>
					</thead>
				';
				echo '<tbody>';
					foreach ($Users as  $usuario)
					{
						$nome = "";
						if ($usuario->nome != '')
						{
							$array=explode(" ",$usuario->nome);
							if ($array[1])
							{
								$nome = $array[0].' '.$array[1];
							}
							else
							{
								$nome = $usuario->nome;
							}
						}
						else
						{
							$nome = " ";
						}
						$count = $this->totalAtrasosPorMes($usuario->id);
						echo '<tr>';
							echo '<td align="left" style=" font-size:1.2em;" >'.$nome. '</td>';
							echo '<td align="right" style=" font-size:1.2em;text-align:center" ><span class="label label-important">'.$count.'</span></td>';
						echo '</tr>';
					}
				echo '</tbody>';
			echo '</table>';
			echo '</div>';
		}

		public function fimDeSemanaAtual($d)
		{
			$test = new DateTime(''.$d.'');
			$x = date_format($test, 'w');
			if ($x == 6 || $x == 0) {
				return true;
			}else{
				return false;
			}
		}

		public function totalFaltasPorUser()
		{
			$dao 	= new DAO();
			$Users = $dao->Retrieve("Users", " ORDER BY nome ");
			$total = 0;
			foreach ($Users as  $usuario)
			{
				$total = $total + $this->calendarioMesnsalFaltas($usuario->id);
			}
			echo '<div class="well" align="center">
					<span class="pull-right label label-blue"> Total Geral: '.$total.'</span>';
					echo'<legend> Faltas No Mês</legend>';
			echo '<table class="table table-normal responsive">';
				echo'<thead>
						<tr >
							<th style="font-size:1em;height:30px"></th>
							<th style="font-size:1em;height:30px;text-align:center">Total: <strong>'.$this->mesAtual().'</strong></th>
						</tr>
					</thead>
				';
				echo '<tbody>';
					foreach ($Users as  $usuario)
					{
						$nome = "";
						if ($usuario->nome != '')
						{
							$array=explode(" ",$usuario->nome);
							if ($array[1])
							{
								$nome = $array[0].' '.$array[1];
							}
							else
							{
								$nome = $usuario->nome;
							}
						}
						else
						{
							$nome = " ";
						}
						$count = $this->calendarioMesnsalFaltas($usuario->id);
						echo '<tr>';
							echo '<td align="left" style=" font-size:1.2em;" >'.$nome. '</td>';
							echo '<td align="right" style=" font-size:1.2em;text-align:center" ><span class="label label-important">'.$count.'</span></td>';
						echo '</tr>';
					}
				echo '</tbody>';
			echo '</table>';
			echo '</div>';
		}

		public function statusUserNow()
		{
			$dao 	= new DAO();
			$Users = $dao->Retrieve("Users", " ORDER BY nome ");
			$total = 0;
			foreach ($Users as  $usuario)
			{
				$nome = "";
				if ($usuario->nome != '')
				{
					$array=explode(" ",$usuario->nome);
					if ($array[1])
					{
						$nome = $array[0].' '.$array[1];
					}
					else
					{
						$nome = $usuario->nome;
					}
				}
				else
				{
					$nome = " ";
				}
				$count = $this->nowRegisterForUser($usuario->id);
				echo '<li><a href="#"><span style="min-width:220px;"><strong>'.$nome. '</strong></span>&nbsp;&nbsp;&nbsp;&nbsp;<span style="min-width:220px;">'.$count.'</span></a></li>';
			}
		}

		public function nowRegisterForUser($userId)
		{
			$dao 	 = new DAO();
			$var	 = false;
			$user = $userId;
			$now  = date('Y-m-d');
			if($user != NULL)
			{
				if($ent = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE data = '".$now."' AND records.user_id = ".$user." ORDER BY records.id DESC"))
				{
					$var = $ent[0]->rel['reason']->descricao;

					if ($var == "ENTRADA")
					{
						return '<span class="label label-success" title="Registro de Entrada" OnMouseOver="this.style.cursor=\'pointer\';" ><i class="icon-arrow-up"></i> ENTRADA</span>';
					}
					elseif($var == "INTERVALO")
					{
						return '<span class="label label-gray" title="Registro de Saida para Intervalo" OnMouseOver="this.style.cursor=\'pointer\';" ><i class="icon-arrow-down"></i> INTERVALO</span>';
					}
					elseif($var == "RETORNO")
					{
						return '<span class="label label-info" title="Registro de Retorno de Interval" OnMouseOver="this.style.cursor=\'pointer\';"><i class="icon-arrow-up"></i> RETORNO INTERVALO</span>';
					}
					elseif($var == "SAIDA")
					{
						return '<span class="label label-important" title="Registro de Saida" OnMouseOver="this.style.cursor=\'pointer\';"><i class="icon-arrow-down"></i> SAIDA</span>';
					}
					elseif($var == "EXTRA-INICIO")
					{
						return '<span class="label label-warning" title="Registro de Inicio de Hora Extra" OnMouseOver="this.style.cursor=\'pointer\';"><i class="icon-arrow-up"></i> INICIO EXTRA</span>';
					}
					elseif($var == "EXTRA-FIM")
					{
						return '<span class="label" title="Registro de Saida de Hora Extra" OnMouseOver="this.style.cursor=\'pointer\';"><i class="icon-arrow-down"></i> FIM EXTRA</span>';
					}
				}else{
					return '<span class="label" style="background-color:#890575" title="Sem Registro" OnMouseOver="this.style.cursor=\'pointer\';"><i class="icon-ban-circle"></i> SEM RESGISTRO</span>';
				}
			}
		}

		public static function authentication()
		{
			// variáveis globais a serem usadas, basicamente são sempre essas
			global $DATA;
			global $MSG;

			// verifica se houve envio de formulário
			if ($DATA['Session']['senha'])
			{
				// caso tudo ocorra bem o objeto DAO é instanciado
				$dao = new DAO();

				// e os dados do login são informados neste bonito array
				$data = array(
					'email' => $_SESSION['user_email'],
					'senha' => md5($DATA['Session']['senha'])
				);

				// se houver um usuário no banco de dados com essas credenciais inicia-se a sessão
				if ($user = $dao->Retrieve('Users', $data, true, true))
				{
					$this->add();
				}
				// se os dados não conferem joga uma mensagem de erro
				else
				{
					$MSG->error[] = 'Erro ao Autenticar. Verifique os dados.';
				}
			}
			return false;
		}

		public  function timeForFinish()
		{
			$dao 	= new DAO();
			$data 	= date('Y-m-d');
			$user 	= $_SESSION['user_id'];
			$entradaNow = $dao->get("Records", "INNER JOIN reasons r ON r.id = records.reason_id WHERE data = '".$data."' AND records.reason_id = 1 AND records.user_id = ".$user." ");
			if ($entradaNow) {
				$data_chegada = date('m/d/Y H:i:s', strtotime('+8 hour', strtotime($entradaNow[0]->dataHora)));
				echo ", beforeDateTime:'".$data_chegada."'";
			} else {
				echo ", showSecond:false, tick:function(){return new Date('00,00,00');}";
			}
		}

		public  function timeForServidor()
		{
			$dataHoraServidor = date('m/d/Y H:i:s');
			echo $dataHoraServidor;
		}
	}
?>
