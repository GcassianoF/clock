<?php
	class Itineraries_Controller extends App_Controller
	{
		
		private $itineraries = false;
		
		public static function add()
		{
			global $DATA;
			global $MSG;
			
			if($DATA['Itinerary'])
			{
				// campos obrigatoios
				validates_presence_of('Itinerary', 'descricao', 'DESCRICAO');
				validates_presence_of('Itinerary', 'entrada', 'ENTRADA');
				validates_presence_of('Itinerary', 'intervalo', 'INTERVALO');
				validates_presence_of('Itinerary', 'retorno', 'RETORNO');
				validates_presence_of('Itinerary', 'saida', 'SAIDA');
				
				
				
				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();
				
				// instacia o objeto da Class principal
				$itinerary = new Itinerary($DATA['Itinerary']);
				
				if($dao->Create($itinerary))
				{
					$MSG->success[] = "Cadastro efetuado!";
					$_POST = array();
				}else
				{
					$MSG->error[] = "Erro no Cadastro. Entre em contato com o Administrador do Sistema!";
				}
			}
			return false;
		}
		
		public function update($itinerary)
		{
			global $DATA;
			global $MSG;
			
			if($DATA['Itinerary'])
			{
				// campos obrigatoios
				validates_presence_of('Itinerary', 'descricao', 'DESCRICAO');
				validates_presence_of('Itinerary', 'entrada', 'ENTRADA');
				validates_presence_of('Itinerary', 'intervalo', 'INTERVALO');
				validates_presence_of('Itinerary', 'retorno', 'RETORNO');
				validates_presence_of('Itinerary', 'saida', 'SAIDA');
				
				
				
				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();
				
				
				$itinerary = batch_update($itinerary, $DATA['Itinerary']);
				if($dao->Update($itinerary))
				{
					$MSG->success[] = "Dados Atualizados!";
				}
			}
		}
		
		public function filter()
		{
			$dao  = new DAO();
			$sql  = "SELECT itineraries.id FROM itineraries ";
			$sql .= " WHERE itineraries.deleted_at IS NULL ";
			$page = 1;
			if($_GET)
			{
				$page = @$_GET['page'] ? @$_GET['page'] : $page;
				$sql .= @$_GET['descricao'] ? " AND itineraries.descricao LIKE '%".@$_GET['descricao']."%' " : "";
				$sql .= @$_GET['entrada'] ? " AND itineraries.entrada LIKE '%".@$_GET['entrada']."%' " : "";
				$sql .= @$_GET['intervalo'] ? " AND itineraries.intervalo LIKE '%".@$_GET['intervalo']."%' " : "";
				$sql .= @$_GET['retorno'] ? " AND itineraries.retorno LIKE '%".@$_GET['retorno']."%' " : "";
				$sql .= @$_GET['saida'] ? " AND itineraries.saida LIKE '%".@$_GET['saida']."%' " : "";
			}
				
			$q = mysql_query($sql) or die(mysql_error());
			if (!mysql_num_rows($q)) return false;
			while ($row = mysql_fetch_assoc($q))
			{
				$this->itineraries[] = $dao->Retrieve('Itineraries', $row['id'], true, true);
			}
			return parent::paginate($this->itineraries, $page, $limit);
		}
	}
?>
