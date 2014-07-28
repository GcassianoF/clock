<?php

// arquivo que guarda variáveis globais

global $FIELDS;
global $MSG;
global $DATA;
global $MONTHS;
global $YEARS;
global $SEXO;

// default definitions
$dao = new DAO();

// default messages
$MSG = new stdClass();
$MSG->success = NULL;// green
$MSG->error   = NULL;// red
$MSG->alert   = NULL;// yellow
$MSG->info  = NULL;// blues

$DATA = @$_POST['data'] ? @$_POST['data'] : FALSE;

if ($_SESSION)
{
    // instância do usuário corrente
    $USER = $dao->Retrieve("Users", $_SESSION['user_id'], TRUE, TRUE);
}

// define mysqli link
global $MYSQLI; 
$MYSQLI = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);


// meses do ano
$MONTHS = array(
	1=>'Janeiro', 
	2=>'Fevereiro', 
	3=>'Março', 
	4=>'Abril', 
	5=>'Maio', 
	6=>'Junho', 
	7=>'Julho', 
	8=>'Agosto', 
	9=>'Setembro', 
	10=>'Outubro', 
	11=>'Novembro', 
	12=>'Dezembro'
);

//sexo
$SEXO = array(
	1=>'MASCULINO',
	2=>'FEMININO'
);

$YEARS = array();

$to_year = date('Y');
$to_year += 1;// permite relatórios para o próximo ano

for ($i=2012;$i<=$to_year;$i++)
{
	$YEARS[$i] = $i;
}

// status das chamadas
$call_status = array(
	'1' => 'Sucesso',
	'2' => 'Falha',
	'3' => 'Ocupado'
);
// tipos de campos
$fields_types = array(
	'1' => 'Texto',
	'2' => 'Lista',    // campo select
	'3' => 'Múltiplo', // campos checkboxes
	'4' => 'Moeda',    // campo texto formatado moeda
	'5' => 'Data',     // campo texto formatado data
	'6' => 'Hora',     // campo texto formatado hora
);
?>