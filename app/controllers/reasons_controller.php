<?php
	class Reasons_Controller extends App_Controller
	{
		
		private $reasons = false;
		
		public static function add()
		{
			global $DATA;
			global $MSG;
			
			if($DATA['Reason'])
			{
				// campos obrigatoios
				validates_presence_of('Reason', 'descricao', 'DESCRICAO');
				validates_presence_of('Reason', 'status', 'STATUS');
				
				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();
				
				// instacia o objeto da Class principal
				$reason = new Reason($DATA['Reason']);
				
				if($dao->Create($reason))
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
		
		public function update($reason)
		{
			global $DATA;
			global $MSG;
			
			if($DATA['Reason'])
			{
				// campos obrigatoios
				validates_presence_of('Reason', 'descricao', 'DESCRICAO');
				validates_presence_of('Reason', 'status', 'STATUS');
				
				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();
				
				$reason = batch_update($reason, $DATA['Reason']);
				if($dao->Update($reason))
				{
					$MSG->success[] = "Dados Atualizados!";
				}
			}
		}
		
		public function filter()
		{
			$dao  = new DAO();
			$sql  = "SELECT reasons.id FROM reasons ";
			$sql .= " WHERE reasons.deleted_at IS NULL  ORDER BY reasons.id DESC ";
			$page = 1;
			/*if($_GET)
			{
				$page = @$_GET['page'] ? @$_GET['page'] : $page;
				$sql .= @$_GET['descricao'] ? " AND reasons.descricao LIKE '%".@$_GET['descricao']."%' " : "";
				$sql .= @$_GET['status'] ? " AND reasons.status LIKE '%".@$_GET['status']."%' " : "";
			}
			$sql .= "";*/	
			$q = mysql_query($sql) or die(mysql_error());
			if (!mysql_num_rows($q)) return false;
			while ($row = mysql_fetch_assoc($q))
			{
				$this->reasons[] = $dao->Retrieve('Reasons', $row['id'], true, true);
			}
			return parent::paginate($this->reasons, $page, $limit);
		}
	}
?>
