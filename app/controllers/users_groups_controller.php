<?php
	class Users_groups_Controller extends App_Controller
	{
		
		private $users_groups = false;
		
		public static function add()
		{
			global $DATA;
			global $MSG;
			
			if($DATA['Users_group'])
			{
				// campos obrigatoios
				validates_presence_of('Users_group', 'nome', 'NOME');
				validates_presence_of('Users_group', 'descricao', 'DESCRICAO');
				
				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();
				
				// instacia o objeto da Class principal
				$users_group = new Users_group($DATA['Users_group']);
				
				if($dao->Create($users_group))
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
		
		public function update($users_group)
		{
			global $DATA;
			global $MSG;
			
			if($DATA['Users_group'])
			{
				// campos obrigatoios
				validates_presence_of('Users_group', 'nome', 'NOME');
				validates_presence_of('Users_group', 'descricao', 'DESCRICAO');
				
				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();
				
				
				$users_group = batch_update($users_group, $DATA['Users_group']);
				if($dao->Update($users_group))
				{
					$MSG->success[] = "Dados Atualizados!";
				}
			}
		}
		
		public function filter()
		{
			$dao  = new DAO();
			$sql  = "SELECT users_groups.id FROM users_groups ";
			$sql .= " WHERE users_groups.deleted_at IS NULL ";
			$page = 1;
			if($_GET)
			{
				$page = @$_GET['page'] ? @$_GET['page'] : $page;
				$sql .= @$_GET['nome'] ? " AND users_groups.nome LIKE '%".@$_GET['nome']."%' " : "";
				$sql .= @$_GET['descricao'] ? " AND users_groups.descricao LIKE '%".@$_GET['descricao']."%' " : "";
			}
				
			$q = mysql_query($sql) or die(mysql_error());
			if (!mysql_num_rows($q)) return false;
			while ($row = mysql_fetch_assoc($q))
			{
				$this->users_groups[] = $dao->Retrieve('Users_groups', $row['id'], true, true);
			}
			return parent::paginate($this->users_groups, $page, $limit);
		}
	}
?>
