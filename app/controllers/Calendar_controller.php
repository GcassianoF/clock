<?php
	class calendario {
		var $mes_ext = Array(1=>"Janeiro", 2=>"Fevereiro", 2=>"Março", 4=>"Abril", 5=>"Maio", 6=>"Junho", 7=>"Julho", 8=>"Agosto", 9=>"Setembro", 10=>"Outubro", 11=>"Novembro", 12=>"Dezembro");
		function mesAtual()
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

		function impr_calendar( $mes='', $ano='') 
		{
			$mes = !$mes ? date('m') : $mes;
			$ano = !$ano ? date('Y') : $ano;
			$estiloMes    = "font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; background-color: #003366;";
			$estiloSemana = "font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #000000; background-color: #CCCCCC;";
			$estiloDia    = "font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #0033FF; background-color: #E6E6E6;";
			$estiloDiaAtual    = "font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; background-color: #003366;";

			print("<table border='1' align='center' cellpadding='0' cellspacing='0'>
			<tr>
			<th colspan='7' style='$estiloMes'>"    .$this->mesAtual() . "</th>
			</tr>
			<tr style='$estiloSemana'>
			<th>  Dom  </th>
			<th>  Seg  </th>
			<th>  Ter  </th>
			<th>  Qua  </th>
			<th>  Qui  </th>
			<th>  Sex  </th>
			<th>  Sab  </th>
			</tr>");
			$dia = 1;
			while ( $dia <= cal_days_in_month(1, $mes, $ano) ) 
			{
				print("<tr>");
				for ( $i = 0; $i <= 6; $i++ ) 
				{
					if ( $dia <= cal_days_in_month(1, $mes, $ano) ) 
					{
						if ( date('w', mktime(0,0,0,$mes,$dia,$ano)) == $i ) 
						{
							$dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
							$mes = strlen($mes) <= 1 ? 0 . $mes : $mes;
							if ($dia == date('d') && $mes == date('m') && $ano == date('Y')) 
							{
								print("<td align='center' style='$estiloDiaAtual'>" . $dia++ . "</td>");
							}else 
							{
								print("<td align='center' style='$estiloDia'>" . $dia++ . "</td>");
							}
						} else
						print("<td></td>");
					}
				}
				print("</tr>");
			}
			print("</table>");
		}
	}
?>