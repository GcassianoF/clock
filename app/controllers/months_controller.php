<?php
	class Months_Controller extends App_Controller
	{
		
		private $months = false;
		
		public static function add()
		{
			global $DATA;
			global $MSG;
			
			if($DATA['Month'])
			{
				// campos obrigatoios
				validates_presence_of('Month', 'descricao', 'DESCRICAO');
				validates_presence_of('Month', 'codigo', 'CODIGO');
				
				
				
				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();
				
				// instacia o objeto da Class principal
				$month = new Month($DATA['Month']);
				
				if($dao->Create($month))
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
		
		public function update($month)
		{
			global $DATA;
			global $MSG;
			
			if($DATA['Month'])
			{
				// campos obrigatoios
				validates_presence_of('Month', 'descricao', 'DESCRICAO');
				validates_presence_of('Month', 'codigo', 'CODIGO');
				
				
				
				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();
				
				
				$month = batch_update($month, $DATA['Month']);
				if($dao->Update($month))
				{
					$MSG->success[] = "Dados Atualizados!";
				}
			}
		}
		
		public function filter()
		{
			$dao  = new DAO();
			$sql  = "SELECT months.id FROM months ";
			$sql .= " WHERE months.deleted_at IS NULL ";
			$page = 1;
			if($_GET)
			{
				$page = @$_GET['page'] ? @$_GET['page'] : $page;
				$sql .= @$_GET['descricao'] ? " AND months.descricao LIKE '%".@$_GET['descricao']."%' " : "";
				$sql .= @$_GET['codigo'] ? " AND months.codigo LIKE '%".@$_GET['codigo']."%' " : "";
			}
				
			$q = mysql_query($sql) or die(mysql_error());
			if (!mysql_num_rows($q)) return false;
			while ($row = mysql_fetch_assoc($q))
			{
				$this->months[] = $dao->Retrieve('Months', $row['id'], true, true);
			}
			return parent::paginate($this->months, $page, $limit);
		}
	}
?>
